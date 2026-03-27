<?php

namespace App\Http\Controllers\Api\Approval;

use App\Http\Controllers\Controller;
use App\Http\Requests\Approval\StoreApprovalActionRequest;
use App\Http\Resources\Approval\ApprovalResource;
use App\Models\Approval;
use App\Services\ApprovalService;
use App\Traits\ApiResponse;
use App\Traits\HasDynamicFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class ApprovalController extends Controller
{
    use ApiResponse, HasDynamicFilters;

    /**
     * @OA\Get(
     *     path="/approval/approvals",
     *     operationId="getApprovals",
     *     tags={"Approval - Actions"},
     *     summary="Daftar approval actions",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=15, maximum=100)),
     *     @OA\Parameter(name="sort_by", in="query", @OA\Schema(type="string", enum={"id","level","created_at"}, default="level")),
     *     @OA\Parameter(name="sort_order", in="query", @OA\Schema(type="string", enum={"asc","desc"}, default="asc")),
     *     @OA\Parameter(name="filter[workflow_request_id]", in="query", @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="filter[user_id]", in="query", @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="filter[approval_status_id]", in="query", @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="filter[level]", in="query", @OA\Schema(type="integer")),
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
                'sort_by'     => 'string|in:id,level,created_at',
                'sort_order'  => 'string|in:asc,desc',
                'filter'      => 'array',
                'filter_type' => 'array',
            ]);

            $limit       = $validated['limit'] ?? 15;
            $sortBy      = $validated['sort_by'] ?? 'level';
            $sortOrder   = $validated['sort_order'] ?? 'asc';
            $filters     = $validated['filter'] ?? [];
            $filterTypes = $request->input('filter_type', []);

            $query = Approval::query()
                ->select(['id', 'workflow_request_id', 'workflow_approval_stage_id', 'workflow_approval_id', 'approval_type_id', 'approval_status_id', 'user_id', 'level', 'note', 'acted_at', 'created_at', 'updated_at'])
                ->with([
                    'approvalStatus:id,code,name',
                    'approverType:id,name',
                ]);

            $query = $this->applyDynamicFilters($query, $filters, $filterTypes,
                ['id', 'workflow_request_id', 'user_id', 'approval_status_id', 'level'],
                []
            );

            $query->orderBy($sortBy, $sortOrder);

            $cacheKey = 'approvals_' . md5(json_encode([
                'page'         => $request->input('page', 1),
                'limit'        => $limit,
                'sort_by'      => $sortBy,
                'sort_order'   => $sortOrder,
                'filters'      => $filters,
                'filter_types' => $filterTypes,
            ]));

            $data = Cache::remember($cacheKey, now()->addMinutes(5), fn () => $query->paginate($limit));

            return $this->successResponse(ApprovalResource::collection($data), 'Approvals retrieved successfully');
        } catch (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (Exception $e) {
            Log::error('Failed to retrieve approvals', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return $this->errorResponse('Failed to retrieve approvals', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/approval/approvals/{id}",
     *     operationId="showApproval",
     *     tags={"Approval - Actions"},
     *     summary="Detail approval action",
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
            $data = Approval::with(['workflowRequest', 'workflowApprovalStage', 'approvalStatus', 'approverType', 'user'])->findOrFail($id);
            return $this->successResponse(new ApprovalResource($data), 'Approval retrieved successfully');
        } catch (Exception $e) {
            Log::error('Failed to retrieve approval', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to retrieve approval', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/approval/approvals",
     *     operationId="storeApprovalAction",
     *     tags={"Approval - Actions"},
     *     summary="Proses approval (approve/reject/revision)",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"workflow_request_id","action"},
     *             @OA\Property(property="workflow_request_id", type="string", format="uuid"),
     *             @OA\Property(property="action", type="string", example="APPROVED"),
     *             @OA\Property(property="note", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(StoreApprovalActionRequest $request)
    {
        DB::beginTransaction();
        try {
            $service = new ApprovalService();
            $approval = $service->processApproval(
                $request->workflow_request_id,
                auth()->id(),
                $request->action,
                $request->note
            );
            DB::commit();
            Cache::flush();

            return $this->successResponse(
                new ApprovalResource($approval->load(['approvalStatus', 'approverType'])),
                'Approval berhasil diproses'
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to process approval', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
