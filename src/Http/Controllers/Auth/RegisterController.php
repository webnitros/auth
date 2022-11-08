<?php

namespace AuthModel\Http\Controllers\Auth;

use AuthModel\Http\Controllers\Controller;
use AuthModel\ValidatorFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{


    /**
     * @param Request $request
     * @return bool|JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register(Request $request)
    {
        $response = $this->validatorResponse($request, [
            'name' => 'required|max:255',
            'email' => 'required|email:filter|max:255',
            #'email' => 'required|email:filter|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        if ($response !== true) {
            return $response;
        }

        // Регистрируем пользователя
        $user = $this->guard()->create($request->all());

        // Авторизируем его на фронтенде
        $this->guard()->login($user);

        // Отвечаем данными которые зарегистрировали
        return new JsonResponse([
            'id' => $user->get('id'),
            'name' => $user->get('name'),
            'email' => $user->get('email'),
        ], 201);
    }


}
