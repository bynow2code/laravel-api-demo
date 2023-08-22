<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;

class UserController extends ApiBaseController
{
    /**
     * Normal return
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $list = [
            [
                'id' => 1,
                'name' => 'cqq',
            ]
        ];
        return $this->success($list);
    }

    /**
     * Validation Error
     * @param UserRequest $request
     * @return void
     */
    public function info(UserRequest $request)
    {
    }

    /**
     * throw Exception
     * @param UserRequest $request
     * @return void
     * @throws \Exception
     */
    public function fans(UserRequest $request)
    {
        $this->error('custum err');
    }

    public function search(UserRequest $request)
    {

    }
}
