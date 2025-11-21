<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Services\UperpayService;
use App\Services\PaymentService;
use App\Traits\ApiResponse;

use Exception;

class PaymentController extends Controller
{
    use ApiResponse;

    public function notification(Request $request)
    {
        $code = 400;
        $endpoint = URL::current();
        $response = [];
        $ruleMessages = [];
        $uperpayToken = config('uperpay.token');

        $rules = [
            'virtual_account' => 'required',
            'customer_name' => 'required',
            'trx_id' => 'required',
            'trx_amount' => 'required',
            'payment_amount' => 'required',
            'datetime_payment' => 'required',
        ];

        $data = $request->all();
        $validate = Validator::make($data, $rules, $ruleMessages);

        if ($validate->fails()) {
            $errMessage = $validate->errors()->first();
            Log::error($errMessage);
            return $this->errorResponse($errMessage, 422);
        }

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