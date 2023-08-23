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
    public function fans()
    {
        $this->error('custom err');
    }

    /**
     * s test
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(UserRequest $request)
    {
        $s = $request->input('s', '');
        $stack = [];
        $map = [
            ')' => '(',
            '}' => '{',
            ']' => '[',
        ];

        for ($i = 0; $i < mb_strlen($s); $i++) {
            $char = $s[$i];

            if (in_array($char, ['(', '{', '['])) {
                $stack[] = $char;
            } elseif (in_array($char, [')', '}', ']'])) {
                if (empty($stack) || $stack[count($stack) - 1] != $map[$char]) {
                    break;
                }
                array_pop($stack);
            }
        }

        $check = empty($stack);

        return $this->success(['result' => $check]);
    }
}
