<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
     public function sendResponse($result, $message,$code = 200)
    {
        $response = [
            'message' => $message,
        ];

        if($result)
        {
            $response['data'] = $result;
        }

       
        return response()->json($response, $code);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['error'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function sendValidationError($field, $error, $code = 422, $errorMessages = [])
    {

        $response = [
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
