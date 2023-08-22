<?php

namespace App\Responses;

class ApiResponse
{
    protected static function jsonResponse($success, $data, $message, $statusCode)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public static function success($data = null, $message = 'Success', $statusCode = 200)
    {
        return static::jsonResponse(true, $data, $message, $statusCode);
    }

    public static function error($message = 'Internal Error', $data = null, $statusCode = 500)
    {
        return static::jsonResponse(false, $data, $message, $statusCode);
    }
}
