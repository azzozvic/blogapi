<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\controller as controller;
class BaseController extends Controller
{
    public function sendResponse($result ,$message)
    {
        $response=[
           'success'=>true,
           'data'=>$result ,
           'message'=>$message
        ];
         return response()->json( $response, 200);
    }


    public function sendError($error ,$errorMessage=[])
    {
        $response=[
           'success'=>true,
           'message'=>$message
        ];

        if (!empty( $errorMessage)) {
            $response['data']=$errorMessage;
        }
         return response()->json( $response, 404);
    }
}
