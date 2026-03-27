<?php

namespace App\Http\Controllers\Api\Approval;

use App\Http\Controllers\Controller;
use App\Http\Requests\Approval\StoreWorkflowApprovalRequest;
use App\Http\Requests\Approval\UpdateWorkflowApprovalRequest;
use App\Http\Resources\Approval\WorkflowApprovalResource;
use App\Models\WorkflowApproval;
use App\Traits\ApiResponse;
use App\Traits\HasDynamicFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class WorkflowApprovalController extends Controller
{
    use ApiResponse, HasDynamicFilters;

    /**
     * @OA\Get(
     *     path="/approval/workflow-approvals",
     *     operationId="getWorkflowApprovals",
     *     tags={"Approval - Workflow Approvals"},
     *     summary="Daftar workflow approvals",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=15, maximum=100)),
     *     @OA\Parameter(name="sort_by", in="query", @OA\Schema(type="string", enum={"id","version","is_active","created_at"}, default="created_at")),
     *     @OA\Parameter(name="sort_order", in="query", @OA\Schema(type="string", enum={"asc","desc"}, default="desc")),
     *     @OA\Parameter(name="filter[workflow_definition_id]", in="query", @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="filter[version]", in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="filter[is_active]", in="query", @OA\Schema(type="integer", enum={0,1})),
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
                'sort_by'     => 'string|in:id,version,is_active,created_at',
                'sort_order'  => 'string|in:asc,desc',
                'filter'      => 'array',
                'filter_type' => 'array',
            ]);

            $limit       = $validated['limit'] ?? 15;
            $sortBy      = $validated['sort_by'] ?? 'created_at';
            $sortOrder   = $validated['sort_order'] ?? 'desc';
            $filters     = $validated['filter'] ?? [];
            $filterTypes = $request->input('filter_type', []);

            $query = WorkflowApproval::query()
                ->select(['id', 'workflow_definition_id', 'version', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'])
                ->with(['workflowDefinition:id,code,name']);

            $query = $this->applyDynamicFilters($query, $filters, $filterTypes,
                ['id', 'workflow_definition_id', 'version', 'is_active'],
                ['workflowDefinition']
            );

            $query->orderBy($sortBy, $sortOrder);

            $cacheKey = 'workflow_approvals_' . md5(json_encode([
                'page'         => $request->input('page', 1),
                'limit'        => $limit,
                'sort_by'      => $sortBy,
                'sort_order'   => $sortOrder,
                'filters'      => $filters,
                'filter_types' => $filterTypes,
            ]));

            $data = Cache::remember($cacheKey, now()->addMinutes(5), fn () => $query->paginate($limit));

            return $this->successResponse(WorkflowApprovalResource::collection($data), 'Workflow approvals retrieved successfully');
        } catch (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (Exception $e) {
            Log::error('Failed to retrieve workflow approvals', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return $this->errorResponse('Failed to retrieve workflow approvals', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/approval/workflow-approvals/{id}",
     *     operationId="showWorkflowApproval",
     *     tags={"Approval - Workflow Approvals"},
     *     summary="Detail workflow approval beserta stages",
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
            $data = WorkflowApproval::with([
                'workflowDefinition:id,code,name',
                'stages.workflowApprovers.approverType:id,name',
                'approvalStatuses:id,workflow_approval_id,code,name',
            ])->findOrFail($id);
            return $this->successResponse(new WorkflowApprovalResource($data), 'Workflow approval retrieved successfully');
        } catch (Exception $e) {
            Log::error('Failed to retrieve workflow approval', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to retrieve workflow approval', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/approval/workflow-approvals",
     *     operationId="storeWorkflowApproval",
     *     tags={"Approval - Workflow Approvals"},
     *     summary="Buat workflow approval baru (versi)",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"workflow_definition_id","version"},
     *             @OA\Property(property="workflow_definition_id", type="string", format="uuid"),
     *             @OA\Property(property="version", type="integer", example=1),
     *             @OA\Property(property="is_active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(StoreWorkflowApprovalRequest $request)
    {
        DB::beginTransaction();
        try {
            $record = WorkflowApproval::create(array_merge($request->validated(), [
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]));
            DB::commit();
            Cache::flush();

            return $this->successResponse(
                new WorkflowApprovalResource($record->load('workflowDefinition:id,code,name')),
                'Workflow approval berhasil dibuat', 201
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create workflow approval', ['error' => $e->getMessage(), 'request' => $request->all()]);
            return $this->errorResponse('Failed to create workflow approval', 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/approval/workflow-approvals/{id}",
     *     operationId="updateWorkflowApproval",
     *     tags={"Approval - Workflow Approvals"},
     *     summary="Update status aktif workflow approval",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(@OA\Property(property="is_active", type="boolean"))
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function update(UpdateWorkflowApprovalRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $record = WorkflowApproval::findOrFail($id);
            $record->update(array_merge($request->validated(), ['updated_by' => auth()->id()]));
            DB::commit();
            Cache::flush();

            return $this->successResponse(new WorkflowApprovalResource($record->fresh()), 'Workflow approval berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update workflow approval', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to update workflow approval', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/approval/workflow-approvals/{id}",
     *     operationId="destroyWorkflowApproval",
     *     tags={"Approval - Workflow Approvals"},
     *     summary="Hapus workflow approval",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $record = WorkflowApproval::findOrFail($id);
            $record->update(['deleted_by' => auth()->id()]);
            $record->delete();
            DB::commit();
            Cache::flush();

            return $this->successResponse(null, 'Workflow approval berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete workflow approval', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to delete workflow approval', 500);
        }
    }
}
