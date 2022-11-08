<?php

namespace AuthModel\Http\Controllers\Settings;

use AuthModel\Http\Controllers\Controller;
use AuthModel\Http\Middleware\Authenticate;
use AuthModel\Http\Middleware\StartSession;
use AuthModel\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
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
        $user = $this->guard()->user();
        #$user = $request->user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email'
            #'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $result = tap($user)->update($request->only('name', 'email'));

        return $request->wantsJson()
            ? new JsonResponse([
                'id' => $result->id,
                'name' => $result->get('name'),
                'email' => $result->get('email'),
            ], 201)
            : redirect($this->redirectPath());
    }
}
