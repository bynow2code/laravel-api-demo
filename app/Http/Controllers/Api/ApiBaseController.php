<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\BusinessException;
use Illuminate\Routing\Controller;

class ApiBaseController extends Controller
{
    /**
     * success return
     * @param $data
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data = null, $message = 'success')
    {
        return response()->json([
            'code' => 200,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * business err
     * @param $message
     * @param $code
     * @return mixed
     * @throws BusinessException
     */
    protected function error($message = 'Internal Server Error', $code = 500)
    {
        throw new BusinessException($message, $code);
    }
}
