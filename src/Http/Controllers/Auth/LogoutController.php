<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 19.10.2022
 * Time: 12:21
 */

namespace AuthModel\Http\Controllers\Auth;


use AuthModel\Http\Controllers\Controller;
use AuthModel\Http\Middleware\Authenticate;
use AuthModel\Http\Middleware\StartSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    protected $middleware = [
        StartSession::class,
        Authenticate::class,
    ];

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        return new JsonResponse([
            'token' => ''
        ], 200);
    }


}
