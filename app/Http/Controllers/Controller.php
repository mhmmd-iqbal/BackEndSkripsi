<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function apiRespond(string $message = '', $data = [], int $http_code = 200) {
        if( $http_code !== 200 ) {
            return response()->json([
                'message'   => $message,
            ], $http_code);
        }
        
        return response()->json([
            'message'   => $message,
            'result'    => $data,
        ], $http_code);
    }
}
