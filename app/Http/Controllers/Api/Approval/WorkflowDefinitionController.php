<?php

namespace App\Http\Controllers\Api\Approval;

use App\Http\Controllers\Controller;
use App\Http\Requests\Approval\StoreWorkflowDefinitionRequest;
use App\Http\Requests\Approval\UpdateWorkflowDefinitionRequest;
use App\Http\Resources\Approval\WorkflowDefinitionResource;
use App\Models\WorkflowDefinition;
use App\Traits\ApiResponse;
use App\Traits\HasDynamicFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class WorkflowDefinitionController extends Controller
{
    use ApiResponse, HasDynamicFilters;

    /**
     * @OA\Get(
     *     path="/approval/workflow-definitions",
     *     operationId="getWorkflowDefinitions",
     *     tags={"Approval - Workflow Definitions"},
     *     summary="Daftar workflow definitions",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=15, maximum=100)),
     *     @OA\Parameter(name="sort_by", in="query", @OA\Schema(type="string", enum={"id","code","name","created_at"}, default="name")),
     *     @OA\Parameter(name="sort_order", in="query", @OA\Schema(type="string", enum={"asc","desc"}, default="asc")),
     *     @OA\Parameter(name="filter[code]", in="query", @OA\Schema(type="string")),
     *     @OA\Parameter(name="filter[name]", in="query", @OA\Schema(type="string")),
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
                'sort_by'     => 'string|in:id,code,name,created_at',
                'sort_order'  => 'string|in:asc,desc',
                'filter'      => 'array',
                'filter_type' => 'array',
            ]);

            $limit       = $validated['limit'] ?? 15;
            $sortBy      = $validated['sort_by'] ?? 'name';
            $sortOrder   = $validated['sort_order'] ?? 'asc';
            $filters     = $validated['filter'] ?? [];
            $filterTypes = $request->input('filter_type', []);

            $query = WorkflowDefinition::query()
                ->select(['id', 'code', 'name', 'description', 'created_by', 'updated_by', 'created_at', 'updated_at']);

            $query = $this->applyDynamicFilters($query, $filters, $filterTypes,
                ['id', 'code', 'name'],
                []
            );

            $query->orderBy($sortBy, $sortOrder);

            $cacheKey = 'workflow_definitions_' . md5(json_encode([
                'page'         => $request->input('page', 1),
                'limit'        => $limit,
                'sort_by'      => $sortBy,
                'sort_order'   => $sortOrder,
                'filters'      => $filters,
                'filter_types' => $filterTypes,
            ]));

            $data = Cache::remember($cacheKey, now()->addMinutes(5), fn () => $query->paginate($limit));

            return $this->successResponse(WorkflowDefinitionResource::collection($data), 'Workflow definitions retrieved successfully');
        } catch (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (Exception $e) {
            Log::error('Failed to retrieve workflow definitions', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return $this->errorResponse('Failed to retrieve workflow definitions', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/approval/workflow-definitions/{id}",
     *     operationId="showWorkflowDefinition",
     *     tags={"Approval - Workflow Definitions"},
     *     summary="Detail workflow definition",
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
            $data = WorkflowDefinition::with(['workflowApprovals'])->findOrFail($id);
            return $this->successResponse(new WorkflowDefinitionResource($data), 'Workflow definition retrieved successfully');
        } catch (Exception $e) {
            Log::error('Failed to retrieve workflow definition', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to retrieve workflow definition', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/approval/workflow-definitions",
     *     operationId="storeWorkflowDefinition",
     *     tags={"Approval - Workflow Definitions"},
     *     summary="Buat workflow definition baru",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"code","name"},
     *             @OA\Property(property="code", type="string", example="LEAVE_APPROVAL"),
     *             @OA\Property(property="name", type="string", example="Approval Cuti"),
     *             @OA\Property(property="description", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(StoreWorkflowDefinitionRequest $request)
    {
        DB::beginTransaction();
        try {
            $record = WorkflowDefinition::create(array_merge($request->validated(), [
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]));
            DB::commit();
            Cache::flush();

            return $this->successResponse(new WorkflowDefinitionResource($record), 'Workflow definition berhasil dibuat', 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create workflow definition', ['error' => $e->getMessage(), 'request' => $request->all()]);
            return $this->errorResponse('Failed to create workflow definition', 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/approval/workflow-definitions/{id}",
     *     operationId="updateWorkflowDefinition",
     *     tags={"Approval - Workflow Definitions"},
     *     summary="Update workflow definition",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="string"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function update(UpdateWorkflowDefinitionRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $record = WorkflowDefinition::findOrFail($id);
            $record->update(array_merge($request->validated(), ['updated_by' => auth()->id()]));
            DB::commit();
            Cache::flush();

            return $this->successResponse(new WorkflowDefinitionResource($record->fresh()), 'Workflow definition berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update workflow definition', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to update workflow definition', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/approval/workflow-definitions/{id}",
     *     operationId="destroyWorkflowDefinition",
     *     tags={"Approval - Workflow Definitions"},
     *     summary="Hapus workflow definition",
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
            $record = WorkflowDefinition::findOrFail($id);
            $record->update(['deleted_by' => auth()->id()]);
            $record->delete();
            DB::commit();
            Cache::flush();

            return $this->successResponse(null, 'Workflow definition berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete workflow definition', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to delete workflow definition', 500);
        }
    }
}
