<?php

namespace App\Http\Controllers\Api\Approval;

use App\Http\Controllers\Controller;
use App\Http\Resources\Approval\ApprovalHistoryResource;
use App\Models\ApprovalHistory;
use App\Traits\ApiResponse;
use App\Traits\HasDynamicFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class ApprovalHistoryController extends Controller
{
    use ApiResponse, HasDynamicFilters;

    /**
     * @OA\Get(
     *     path="/approval/approval-histories",
     *     operationId="getApprovalHistories",
     *     tags={"Approval - History"},
     *     summary="Daftar riwayat approval",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=15, maximum=100)),
     *     @OA\Parameter(name="sort_by", in="query", @OA\Schema(type="string", enum={"id","action","created_at"}, default="created_at")),
     *     @OA\Parameter(name="sort_order", in="query", @OA\Schema(type="string", enum={"asc","desc"}, default="desc")),
     *     @OA\Parameter(name="filter[workflow_request_id]", in="query", @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="filter[user_id]", in="query", @OA\Schema(type="string", format="uuid")),
     *     @OA\Parameter(name="filter[action]", in="query", @OA\Schema(type="string", example="APPROVED")),
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
                'sort_by'     => 'string|in:id,action,created_at',
                'sort_order'  => 'string|in:asc,desc',
                'filter'      => 'array',
                'filter_type' => 'array',
            ]);

            $limit       = $validated['limit'] ?? 15;
            $sortBy      = $validated['sort_by'] ?? 'created_at';
            $sortOrder   = $validated['sort_order'] ?? 'desc';
            $filters     = $validated['filter'] ?? [];
            $filterTypes = $request->input('filter_type', []);

            $query = ApprovalHistory::query()
                ->select(['id', 'workflow_request_id', 'approval_id', 'user_id', 'action', 'note', 'created_at', 'updated_at']);

            $query = $this->applyDynamicFilters($query, $filters, $filterTypes,
                ['id', 'workflow_request_id', 'approval_id', 'user_id', 'action'],
                []
            );

            $query->orderBy($sortBy, $sortOrder);

            $cacheKey = 'approval_histories_' . md5(json_encode([
                'page'         => $request->input('page', 1),
                'limit'        => $limit,
                'sort_by'      => $sortBy,
                'sort_order'   => $sortOrder,
                'filters'      => $filters,
                'filter_types' => $filterTypes,
            ]));

            $data = Cache::remember($cacheKey, now()->addMinutes(5), fn () => $query->paginate($limit));

            return $this->successResponse(ApprovalHistoryResource::collection($data), 'Approval histories retrieved successfully');
        } catch (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (Exception $e) {
            Log::error('Failed to retrieve approval histories', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return $this->errorResponse('Failed to retrieve approval histories', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/approval/approval-histories/{id}",
     *     operationId="showApprovalHistory",
     *     tags={"Approval - History"},
     *     summary="Detail riwayat approval",
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
            $data = ApprovalHistory::with(['workflowRequest', 'approval', 'user'])->findOrFail($id);
            return $this->successResponse(new ApprovalHistoryResource($data), 'Approval history retrieved successfully');
        } catch (Exception $e) {
            Log::error('Failed to retrieve approval history', ['id' => $id, 'error' => $e->getMessage()]);
            return $this->errorResponse('Failed to retrieve approval history', 500);
        }
    }
}
