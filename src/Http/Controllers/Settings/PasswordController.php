<?php

namespace AuthModel\Http\Controllers\Settings;

use AuthModel\Http\Controllers\Controller;
use AuthModel\Http\Middleware\Authenticate;
use AuthModel\Http\Middleware\StartSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    protected $middleware = [
        StartSession::class,
        Authenticate::class,
    ];

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $user = $this->guard()->user();

        $this->guard()->update([
            'password' => $request->password,
        ]);

        return $request->wantsJson()
            ? new JsonResponse([
                'id' => $user->id,
                'name' => $user->get('name'),
                'email' => $user->get('email'),
            ], 201)
            : redirect($this->redirectPath());
    }
}
