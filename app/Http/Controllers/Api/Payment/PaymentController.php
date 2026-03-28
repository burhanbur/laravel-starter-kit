<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Services\UperpayService;
use App\Services\PaymentService;
use App\Traits\HasDynamicFilters;
use App\Traits\ApiResponse;

use App\Http\Requests\Payment\NotificationRequest;

use ErrorException;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PaymentController extends Controller
{
    use ApiResponse, HasDynamicFilters;

    /**
     * @OA\Post(
     *     path="/payment/notification",
     *     operationId="paymentNotification",
     *     tags={"Payment"},
     *     summary="Terima notifikasi pembayaran dari payment gateway",
     *     description="Endpoint ini dipanggil oleh payment gateway (Uperpay) untuk mengirimkan notifikasi status pembayaran. Autentikasi menggunakan Bearer token dari Uperpay.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"transaction_id", "status", "amount"},
     *             @OA\Property(property="transaction_id", type="string", example="TRX-20260328-001"),
     *             @OA\Property(property="status", type="string", enum={"success","failed","pending"}, example="success"),
     *             @OA\Property(property="amount", type="number", format="float", example=150000),
     *             @OA\Property(property="reference_id", type="string", example="REF-001"),
     *             @OA\Property(property="payment_method", type="string", example="virtual_account")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Notifikasi berhasil diproses",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Notification processed successfully")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized - Bearer token tidak valid"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function notification(NotificationRequest $request)
    {
        $code = 400;
        $response = [];
        $uperpayToken = config('uperpay.token');
        $data = $request->all();

        if (@apache_request_headers()['authorization'] != 'Bearer ' . $uperpayToken) {
            $code = 401;
            $errMessage = 'Unauthorized access';
            Log::error($errMessage);
            return $this->errorResponse($errMessage, $code);
        }

        DB::beginTransaction();

        try {
            $service = new PaymentService;
            $result = $service->processUperpayNotification($data);

            if ($result['success']) {
                $response = $this->successResponse($result, 'Notification processed successfully', 200);
                Log::info('Uperpay notification processed successfully');
            } else {
                throw new Exception('Failed to process Uperpay notification');
            }

            DB::commit();
            return $response;
        } catch (Exception $ex) {
            DB::rollBack();
            $code = 500;
            $errMessage = 'Internal server error: ' . $ex->getMessage();
            Log::error($errMessage);
            return $this->errorResponse($errMessage, $code);
        }
    }
}
