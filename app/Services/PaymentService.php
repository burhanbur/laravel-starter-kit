<?php 

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

use App\Models\User;

use Exception;

class PaymentService
{
    public function processUperpayNotification($data)
    {
        return [];
    }
}