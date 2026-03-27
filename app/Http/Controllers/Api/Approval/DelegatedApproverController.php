<?php

namespace App\Http\Controllers\Api\Approval;

use App\Http\Controllers\Controller;
use App\Http\Requests\Approval\StoreDelegatedApproverRequest;
use App\Http\Requests\Approval\UpdateDelegatedApproverRequest;
use App\Http\Resources\Approval\DelegatedApproverResource;
use App\Models\DelegatedApprover;
use App\Traits\ApiResponse;
use App\Traits\HasDynamicFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class DelegatedApproverController extends Controller
{
    use ApiResponse, HasDynamicFilters;

    /**
     * @OA\Get(
     *     path="/approval/delegated-approvers",
     *     operationId="getDelegatedApprovers",
     *     tags={"Approval - Delegated Approvers"},
     *     summary="Daftar delegated approvers",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=15, maximum=100)),
     *     @OA\Parameter(name="sort_by", in="query", @OA\Schema(type="string", enum={"id","is_active","created_at"}, default="created_at")),
     *     @OA\Parameter(name="sort_order", in="query", @OA\Schema(type="string", enum={"asc","desc"}, default="desc")),
     *     @OA\Parameter(name="filter[workflow_approver_id]", in="query", @OA\Schema(type="string", format="uuid")),
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
                'sort_by'     => 'string|in:id,is_active,created_at',
                'sort_order'  => 'string|in:asc,desc',
                'filter'      => 'array',
                'filter_type' => 'array',
            ]);

            $limit       = $validated['limit'] ?? 15;
            $sortBy      = $validated['sort_by'] ?? 'created_at';
            $sortOrder   = $validated['sort_order'] ?? 'desc';
            $filters     = $validated['filter'] ?? [];
            $filterTypes = $request->input('filter_type', []);

            $query = DelegatedApprover::query()
                ->select(['id', 'workflow_approver_id', 'delegate_user_id', 'is_active', 'start_date', 'end_date', 'created_by', 'updated_by', 'created_at', 'updated_at']);

            $query = $this->applyDynamicFilters($query, $filters, $filterTypes,
                ['id', 'workflow_approver_id', 'delegate_user_id', 'is_active'],
                []
            );

            $query->orderBy($sortBy, $sortOrder);

            $cacheKey = 'delegated_approvers_' . md5(json_encode([
                'page'         => $request->input('page', 1),
                'limit'        => $limit,
                'sort_by'      => $sortBy,
                'sort_order'   => $sortOrder,
                'filters'      => $filters,
                'filter_types' => $filterTypes,
            ]));

            $data = Cache::remember($cacheKey, now()->addMinutes(5), fn () => $query->paginate($limit));

            return $this->successResponse(DelegatedApproverResource::collection($data), 'Delegated approvers retrieved successfully');
        } catch (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (Exception $e) {
            Log::error('Failed to retrieve delegated approvers', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return $this->errorResponse('Failed to retrieve delegated approvers', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/approval/delegated-approvers/{id}",
     *     operationId="showDelegatedApprover",
     *     tags={"Approval - Delegated Approvers"},
     *     summary="Detail delegated approver",
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
            $data = DelegatedApprover::with(['workflowApprover', 'delegateUser'])->findOrFail($id);
            return $this->successResponse(new DelegatedApproverResource($data), 'Delegated approver retrieved successfully');
        } catch (Exception $e) {
            Log::error('Failed to retrieve delegated approver', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to retrieve delegated approver', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/approval/delegated-approvers",
     *     operationId="storeDelegatedApprover",
     *     tags={"Approval - Delegated Approvers"},
     *     summary="Tambah delegated approver",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"workflow_approver_id","delegate_user_id"},
     *             @OA\Property(property="workflow_approver_id", type="string", format="uuid"),
     *             @OA\Property(property="delegate_user_id", type="string", format="uuid"),
     *             @OA\Property(property="is_active", type="boolean", example=true),
     *             @OA\Property(property="start_date", type="string", format="date"),
     *             @OA\Property(property="end_date", type="string", format="date", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(StoreDelegatedApproverRequest $request)
    {
        DB::beginTransaction();
        try {
            $record = DelegatedApprover::create(array_merge($request->validated(), [
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]));
            DB::commit();
            Cache::flush();

            return $this->successResponse(new DelegatedApproverResource($record), 'Delegated approver berhasil dibuat', 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create delegated approver', ['error' => $e->getMessage(), 'request' => $request->all()]);
            return $this->errorResponse('Failed to create delegated approver', 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/approval/delegated-approvers/{id}",
     *     operationId="updateDelegatedApprover",
     *     tags={"Approval - Delegated Approvers"},
     *     summary="Update delegated approver",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="is_active", type="boolean"),
     *             @OA\Property(property="start_date", type="string", format="date"),
     *             @OA\Property(property="end_date", type="string", format="date", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function update(UpdateDelegatedApproverRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $record = DelegatedApprover::findOrFail($id);
            $record->update(array_merge($request->validated(), ['updated_by' => auth()->id()]));
            DB::commit();
            Cache::flush();

            return $this->successResponse(new DelegatedApproverResource($record->fresh()), 'Delegated approver berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update delegated approver', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to update delegated approver', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/approval/delegated-approvers/{id}",
     *     operationId="destroyDelegatedApprover",
     *     tags={"Approval - Delegated Approvers"},
     *     summary="Hapus delegated approver",
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
            $record = DelegatedApprover::findOrFail($id);
            $record->update(['deleted_by' => auth()->id()]);
            $record->delete();
            DB::commit();
            Cache::flush();

            return $this->successResponse(null, 'Delegated approver berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete delegated approver', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to delete delegated approver', 500);
        }
    }
}
