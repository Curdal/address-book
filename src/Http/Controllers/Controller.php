<?php

namespace Curdal\AddressBook\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Throwable;

class Controller extends BaseController
{
    use ValidatesRequests;

    public function errorResponse(Throwable $e)
    {
        Log::error($e->getMessage()."\r\n".$e->getTraceAsString());

        return response()->json([
            'code' => 500,
            'message' => 'Something went wrong. Please contact support if you need immediate assistance.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
