<?php

namespace App\Http\Controllers\Api\Approval;

use App\Http\Controllers\Controller;
use App\Http\Requests\Approval\StoreApprovalStatusRequest;
use App\Http\Requests\Approval\UpdateApprovalStatusRequest;
use App\Http\Resources\Approval\ApprovalStatusResource;
use App\Models\ApprovalStatus;
use App\Traits\ApiResponse;
use App\Traits\HasDynamicFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class ApprovalStatusController extends Controller
{
    use ApiResponse, HasDynamicFilters;

    /**
     * @OA\Get(
     *     path="/approval/approval-statuses",
     *     operationId="getApprovalStatuses",
     *     tags={"Approval - Approval Statuses"},
     *     summary="Daftar status approval",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=15, maximum=100)),
     *     @OA\Parameter(name="sort_by", in="query", @OA\Schema(type="string", enum={"id","code","name","created_at"}, default="name")),
     *     @OA\Parameter(name="sort_order", in="query", @OA\Schema(type="string", enum={"asc","desc"}, default="asc")),
     *     @OA\Parameter(name="filter[workflow_approval_id]", in="query", @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="filter[code]", in="query", @OA\Schema(type="string", example="PENDING")),
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

            $query = ApprovalStatus::query()
                ->select(['id', 'workflow_approval_id', 'code', 'name', 'description', 'created_by', 'updated_by', 'created_at', 'updated_at']);

            $query = $this->applyDynamicFilters($query, $filters, $filterTypes,
                ['id', 'workflow_approval_id', 'code', 'name'],
                []
            );

            $query->orderBy($sortBy, $sortOrder);

            $cacheKey = 'approval_statuses_' . md5(json_encode([
                'page'         => $request->input('page', 1),
                'limit'        => $limit,
                'sort_by'      => $sortBy,
                'sort_order'   => $sortOrder,
                'filters'      => $filters,
                'filter_types' => $filterTypes,
            ]));

            $data = Cache::remember($cacheKey, now()->addMinutes(5), fn () => $query->paginate($limit));

            return $this->successResponse(ApprovalStatusResource::collection($data), 'Approval statuses retrieved successfully');
        } catch (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (Exception $e) {
            Log::error('Failed to retrieve approval statuses', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return $this->errorResponse('Failed to retrieve approval statuses', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/approval/approval-statuses/{id}",
     *     operationId="showApprovalStatus",
     *     tags={"Approval - Approval Statuses"},
     *     summary="Detail status approval",
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
            $data = ApprovalStatus::findOrFail($id);
            return $this->successResponse(new ApprovalStatusResource($data), 'Approval status retrieved successfully');
        } catch (Exception $e) {
            Log::error('Failed to retrieve approval status', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to retrieve approval status', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/approval/approval-statuses",
     *     operationId="storeApprovalStatus",
     *     tags={"Approval - Approval Statuses"},
     *     summary="Tambah status approval",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"workflow_approval_id","code","name"},
     *             @OA\Property(property="workflow_approval_id", type="string", format="uuid"),
     *             @OA\Property(property="code", type="string", example="PENDING"),
     *             @OA\Property(property="name", type="string", example="Menunggu Persetujuan"),
     *             @OA\Property(property="description", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(StoreApprovalStatusRequest $request)
    {
        DB::beginTransaction();
        try {
            $record = ApprovalStatus::create(array_merge($request->validated(), [
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]));
            DB::commit();
            Cache::flush();

            return $this->successResponse(new ApprovalStatusResource($record), 'Approval status berhasil dibuat', 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create approval status', ['error' => $e->getMessage(), 'request' => $request->all()]);
            return $this->errorResponse('Failed to create approval status', 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/approval/approval-statuses/{id}",
     *     operationId="updateApprovalStatus",
     *     tags={"Approval - Approval Statuses"},
     *     summary="Update status approval",
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
    public function update(UpdateApprovalStatusRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $record = ApprovalStatus::findOrFail($id);
            $record->update(array_merge($request->validated(), ['updated_by' => auth()->id()]));
            DB::commit();
            Cache::flush();

            return $this->successResponse(new ApprovalStatusResource($record->fresh()), 'Approval status berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update approval status', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to update approval status', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/approval/approval-statuses/{id}",
     *     operationId="destroyApprovalStatus",
     *     tags={"Approval - Approval Statuses"},
     *     summary="Hapus status approval",
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
            $record = ApprovalStatus::findOrFail($id);
            $record->update(['deleted_by' => auth()->id()]);
            $record->delete();
            DB::commit();
            Cache::flush();

            return $this->successResponse(null, 'Approval status berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete approval status', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to delete approval status', 500);
        }
    }
}
