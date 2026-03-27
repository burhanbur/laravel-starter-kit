<?php

namespace App\Http\Controllers\Api\Approval;

use App\Http\Controllers\Controller;
use App\Http\Requests\Approval\StoreWorkflowApproverRequest;
use App\Http\Requests\Approval\UpdateWorkflowApproverRequest;
use App\Http\Resources\Approval\WorkflowApproverResource;
use App\Models\WorkflowApprover;
use App\Traits\ApiResponse;
use App\Traits\HasDynamicFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class WorkflowApproverController extends Controller
{
    use ApiResponse, HasDynamicFilters;

    /**
     * @OA\Get(
     *     path="/approval/workflow-approvers",
     *     operationId="getWorkflowApprovers",
     *     tags={"Approval - Workflow Approvers"},
     *     summary="Daftar workflow approvers",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=15, maximum=100)),
     *     @OA\Parameter(name="sort_by", in="query", @OA\Schema(type="string", enum={"id","level","created_at"}, default="level")),
     *     @OA\Parameter(name="sort_order", in="query", @OA\Schema(type="string", enum={"asc","desc"}, default="asc")),
     *     @OA\Parameter(name="filter[workflow_approval_stage_id]", in="query", @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="filter[approval_type_id]", in="query", @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="filter[user_id]", in="query", @OA\Schema(type="string", format="uuid")),
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

            $query = WorkflowApprover::query()
                ->select(['id', 'workflow_approval_stage_id', 'approval_type_id', 'user_id', 'level', 'created_by', 'updated_by', 'created_at', 'updated_at'])
                ->with(['approverType:id,name']);

            $query = $this->applyDynamicFilters($query, $filters, $filterTypes,
                ['id', 'workflow_approval_stage_id', 'approval_type_id', 'user_id', 'level'],
                ['approverType']
            );

            $query->orderBy($sortBy, $sortOrder);

            $cacheKey = 'workflow_approvers_' . md5(json_encode([
                'page'         => $request->input('page', 1),
                'limit'        => $limit,
                'sort_by'      => $sortBy,
                'sort_order'   => $sortOrder,
                'filters'      => $filters,
                'filter_types' => $filterTypes,
            ]));

            $data = Cache::remember($cacheKey, now()->addMinutes(5), fn () => $query->paginate($limit));

            return $this->successResponse(WorkflowApproverResource::collection($data), 'Workflow approvers retrieved successfully');
        } catch (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (Exception $e) {
            Log::error('Failed to retrieve workflow approvers', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return $this->errorResponse('Failed to retrieve workflow approvers', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/approval/workflow-approvers/{id}",
     *     operationId="showWorkflowApprover",
     *     tags={"Approval - Workflow Approvers"},
     *     summary="Detail workflow approver",
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
            $data = WorkflowApprover::with(['stage', 'approverType', 'user', 'delegatedApprovers'])->findOrFail($id);
            return $this->successResponse(new WorkflowApproverResource($data), 'Workflow approver retrieved successfully');
        } catch (Exception $e) {
            Log::error('Failed to retrieve workflow approver', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to retrieve workflow approver', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/approval/workflow-approvers",
     *     operationId="storeWorkflowApprover",
     *     tags={"Approval - Workflow Approvers"},
     *     summary="Tambah workflow approver",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"workflow_approval_stage_id","approval_type_id","level"},
     *             @OA\Property(property="workflow_approval_stage_id", type="string", format="uuid"),
     *             @OA\Property(property="approval_type_id", type="string", format="uuid"),
     *             @OA\Property(property="user_id", type="string", format="uuid", nullable=true),
     *             @OA\Property(property="level", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(StoreWorkflowApproverRequest $request)
    {
        DB::beginTransaction();
        try {
            $record = WorkflowApprover::create(array_merge($request->validated(), [
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]));
            DB::commit();
            Cache::flush();

            return $this->successResponse(
                new WorkflowApproverResource($record->load('approverType:id,name')),
                'Workflow approver berhasil dibuat', 201
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create workflow approver', ['error' => $e->getMessage(), 'request' => $request->all()]);
            return $this->errorResponse('Failed to create workflow approver', 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/approval/workflow-approvers/{id}",
     *     operationId="updateWorkflowApprover",
     *     tags={"Approval - Workflow Approvers"},
     *     summary="Update workflow approver",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="approval_type_id", type="string", format="uuid"),
     *             @OA\Property(property="user_id", type="string", format="uuid", nullable=true),
     *             @OA\Property(property="level", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function update(UpdateWorkflowApproverRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $record = WorkflowApprover::findOrFail($id);
            $record->update(array_merge($request->validated(), ['updated_by' => auth()->id()]));
            DB::commit();
            Cache::flush();

            return $this->successResponse(new WorkflowApproverResource($record->fresh()), 'Workflow approver berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update workflow approver', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to update workflow approver', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/approval/workflow-approvers/{id}",
     *     operationId="destroyWorkflowApprover",
     *     tags={"Approval - Workflow Approvers"},
     *     summary="Hapus workflow approver",
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
            $record = WorkflowApprover::findOrFail($id);
            $record->update(['deleted_by' => auth()->id()]);
            $record->delete();
            DB::commit();
            Cache::flush();

            return $this->successResponse(null, 'Workflow approver berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete workflow approver', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to delete workflow approver', 500);
        }
    }
}
