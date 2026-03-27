<?php

namespace App\Http\Controllers\Api\Approval;

use App\Http\Controllers\Controller;
use App\Http\Requests\Approval\StoreWorkflowRequestRequest;
use App\Http\Resources\Approval\WorkflowRequestResource;
use App\Models\WorkflowRequest;
use App\Services\ApprovalService;
use App\Traits\ApiResponse;
use App\Traits\HasDynamicFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class WorkflowRequestController extends Controller
{
    use ApiResponse, HasDynamicFilters;

    /**
     * @OA\Get(
     *     path="/approval/workflow-requests",
     *     operationId="getWorkflowRequests",
     *     tags={"Approval - Workflow Requests"},
     *     summary="Daftar workflow requests",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=15, maximum=100)),
     *     @OA\Parameter(name="sort_by", in="query", @OA\Schema(type="string", enum={"id","request_source","created_at"}, default="created_at")),
     *     @OA\Parameter(name="sort_order", in="query", @OA\Schema(type="string", enum={"asc","desc"}, default="desc")),
     *     @OA\Parameter(name="filter[request_source]", in="query", @OA\Schema(type="string")),
     *     @OA\Parameter(name="filter[requester_id]", in="query", @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="filter[current_approval_status_id]", in="query", @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function index(Request $request)
    {
        try {
            $validated = $request->validate([
                'page'        => 'integer|min:1',
                'limit'       => 'integer|min:1|max:100',
                'sort_by'     => 'string|in:id,request_source,created_at',
                'sort_order'  => 'string|in:asc,desc',
                'filter'      => 'array',
                'filter_type' => 'array',
            ]);

            $limit       = $validated['limit'] ?? 15;
            $sortBy      = $validated['sort_by'] ?? 'created_at';
            $sortOrder   = $validated['sort_order'] ?? 'desc';
            $filters     = $validated['filter'] ?? [];
            $filterTypes = $request->input('filter_type', []);

            $query = WorkflowRequest::query()
                ->select(['id', 'workflow_approval_id', 'request_source', 'reference_id', 'requester_id', 'current_approval_status_id', 'created_by', 'updated_by', 'created_at', 'updated_at'])
                ->with([
                    'workflowApproval:id,workflow_definition_id,version',
                    'currentApprovalStatus:id,code,name',
                ]);

            $query = $this->applyDynamicFilters($query, $filters, $filterTypes,
                ['id', 'request_source', 'requester_id', 'current_approval_status_id', 'workflow_approval_id'],
                ['workflowApproval', 'currentApprovalStatus']
            );

            $query->orderBy($sortBy, $sortOrder);

            $cacheKey = 'workflow_requests_' . md5(json_encode([
                'page'         => $request->input('page', 1),
                'limit'        => $limit,
                'sort_by'      => $sortBy,
                'sort_order'   => $sortOrder,
                'filters'      => $filters,
                'filter_types' => $filterTypes,
            ]));

            $data = Cache::remember($cacheKey, now()->addMinutes(5), fn () => $query->paginate($limit));

            return $this->successResponse(WorkflowRequestResource::collection($data), 'Workflow requests retrieved successfully');
        } catch (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (Exception $e) {
            Log::error('Failed to retrieve workflow requests', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return $this->errorResponse('Failed to retrieve workflow requests', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/approval/workflow-requests/{id}",
     *     operationId="showWorkflowRequest",
     *     tags={"Approval - Workflow Requests"},
     *     summary="Detail workflow request beserta riwayat approval",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function show($id)
    {
        try {
            $data = WorkflowRequest::with([
                'workflowApproval.workflowDefinition',
                'currentApprovalStatus',
                'requester',
                'approvals.approvalStatus',
                'approvals.approverType',
                'approvalHistories',
            ])->findOrFail($id);
            return $this->successResponse(new WorkflowRequestResource($data), 'Workflow request retrieved successfully');
        } catch (Exception $e) {
            Log::error('Failed to retrieve workflow request', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to retrieve workflow request', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/approval/workflow-requests",
     *     operationId="storeWorkflowRequest",
     *     tags={"Approval - Workflow Requests"},
     *     summary="Submit workflow request baru",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"workflow_approval_id","request_source"},
     *             @OA\Property(property="workflow_approval_id", type="string", format="uuid"),
     *             @OA\Property(property="request_source", type="string", example="LEAVE"),
     *             @OA\Property(property="reference_id", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(StoreWorkflowRequestRequest $request)
    {
        DB::beginTransaction();
        try {
            $service = new ApprovalService();
            $workflowRequest = $service->submitRequest($request->validated());
            DB::commit();
            Cache::flush();

            return $this->successResponse(
                new WorkflowRequestResource($workflowRequest->load(['workflowApproval', 'currentApprovalStatus'])),
                'Workflow request berhasil disubmit',
                201
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to submit workflow request', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
