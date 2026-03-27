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
