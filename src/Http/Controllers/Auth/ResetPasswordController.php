<?php

namespace AuthModel\Http\Controllers\Auth;

use AuthModel\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /**
     * Сбрасывааем старый пароль и отправляем ссылку для активации нового пароля введеного сейчас
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $this->validatorResponse($request, [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $response = $this->guard()->forgotPassword();
        if ($response !== true) {
            return $response;
        }

        return new JsonResponse([
            'email' => $request->get('email')
        ], 200);
    }
}
