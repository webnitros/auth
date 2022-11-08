<?php

namespace AuthModel\Http\Controllers\Auth;

use AuthModel\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{

    /**
     * Автоматически сброс пароля и отправка на email
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validatorResponse($request, [
            'email' => 'required|email'
        ]);

        $response = $this->guard()->sendResetLinkEmail();
        if ($response !== true) {
            return $response;
        }

        return new JsonResponse([
            'email' => $request->get('email')
        ], 200);
    }

}
