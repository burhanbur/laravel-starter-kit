<?php

namespace App\Http\Controllers\Api\Approval;

use App\Http\Controllers\Controller;
use App\Http\Requests\Approval\StoreApproverTypeRequest;
use App\Http\Requests\Approval\UpdateApproverTypeRequest;
use App\Http\Resources\Approval\ApproverTypeResource;
use App\Models\ApproverType;
use App\Traits\ApiResponse;
use App\Traits\HasDynamicFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class ApproverTypeController extends Controller
{
    use ApiResponse, HasDynamicFilters;

    /**
     * @OA\Get(
     *     path="/approval/approver-types",
     *     operationId="getApproverTypes",
     *     tags={"Approval - Approver Types"},
     *     summary="Daftar tipe approver",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=15, maximum=100)),
     *     @OA\Parameter(name="sort_by", in="query", @OA\Schema(type="string", enum={"id","name","created_at"}, default="name")),
     *     @OA\Parameter(name="sort_order", in="query", @OA\Schema(type="string", enum={"asc","desc"}, default="asc")),
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
                'sort_by'     => 'string|in:id,name,created_at',
                'sort_order'  => 'string|in:asc,desc',
                'filter'      => 'array',
                'filter_type' => 'array',
            ]);

            $limit       = $validated['limit'] ?? 15;
            $sortBy      = $validated['sort_by'] ?? 'name';
            $sortOrder   = $validated['sort_order'] ?? 'asc';
            $filters     = $validated['filter'] ?? [];
            $filterTypes = $request->input('filter_type', []);

            $query = ApproverType::query()
                ->select(['id', 'name', 'description', 'created_by', 'updated_by', 'created_at', 'updated_at']);

            $query = $this->applyDynamicFilters($query, $filters, $filterTypes,
                ['id', 'name'],
                []
            );

            $query->orderBy($sortBy, $sortOrder);

            $cacheKey = 'approver_types_' . md5(json_encode([
                'page'         => $request->input('page', 1),
                'limit'        => $limit,
                'sort_by'      => $sortBy,
                'sort_order'   => $sortOrder,
                'filters'      => $filters,
                'filter_types' => $filterTypes,
            ]));

            $data = Cache::remember($cacheKey, now()->addMinutes(5), fn () => $query->paginate($limit));

            return $this->successResponse(ApproverTypeResource::collection($data), 'Approver types retrieved successfully');
        } catch (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (Exception $e) {
            Log::error('Failed to retrieve approver types', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return $this->errorResponse('Failed to retrieve approver types', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/approval/approver-types/{id}",
     *     operationId="showApproverType",
     *     tags={"Approval - Approver Types"},
     *     summary="Detail tipe approver",
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
            $data = ApproverType::findOrFail($id);
            return $this->successResponse(new ApproverTypeResource($data), 'Approver type retrieved successfully');
        } catch (Exception $e) {
            Log::error('Failed to retrieve approver type', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to retrieve approver type', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/approval/approver-types",
     *     operationId="storeApproverType",
     *     tags={"Approval - Approver Types"},
     *     summary="Tambah tipe approver baru",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="User"),
     *             @OA\Property(property="description", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(StoreApproverTypeRequest $request)
    {
        DB::beginTransaction();
        try {
            $record = ApproverType::create(array_merge($request->validated(), [
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]));
            DB::commit();
            Cache::flush();

            return $this->successResponse(new ApproverTypeResource($record), 'Tipe approver berhasil dibuat', 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create approver type', ['error' => $e->getMessage(), 'request' => $request->all()]);
            return $this->errorResponse('Failed to create approver type', 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/approval/approver-types/{id}",
     *     operationId="updateApproverType",
     *     tags={"Approval - Approver Types"},
     *     summary="Update tipe approver",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function update(UpdateApproverTypeRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $record = ApproverType::findOrFail($id);
            $record->update(array_merge($request->validated(), ['updated_by' => auth()->id()]));
            DB::commit();
            Cache::flush();

            return $this->successResponse(new ApproverTypeResource($record->fresh()), 'Tipe approver berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update approver type', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to update approver type', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/approval/approver-types/{id}",
     *     operationId="destroyApproverType",
     *     tags={"Approval - Approver Types"},
     *     summary="Hapus tipe approver",
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
            $record = ApproverType::findOrFail($id);
            $record->update(['deleted_by' => auth()->id()]);
            $record->delete();
            DB::commit();
            Cache::flush();

            return $this->successResponse(null, 'Tipe approver berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete approver type', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to delete approver type', 500);
        }
    }
}
