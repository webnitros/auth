<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 19.10.2022
 * Time: 12:21
 */

namespace AuthModel\Http\Controllers\Auth;


use AuthModel\Http\Controllers\Controller;
use AuthModel\Http\Middleware\StartSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $middleware = [
        StartSession::class,
    ];

    public function login(Request $request)
    {
        $email = $request->get('email');
        return new JsonResponse([
            'token' => 'sssssss',
            'expires_in' => $email,
            'token_type' => 'bearer'
        ], 200);
    }

}
