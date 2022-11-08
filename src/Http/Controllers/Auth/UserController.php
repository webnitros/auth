<?php

namespace AuthModel\Http\Controllers\Auth;

use AuthModel\Http\Controllers\Controller;
use AuthModel\Http\Middleware\Authenticate;
use AuthModel\Http\Middleware\StartSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function DeepCopy\deep_copy;

class UserController extends Controller
{
    protected $middleware = [
        StartSession::class,
        Authenticate::class,
    ];

    public function current(Request $request)
    {
        return new JsonResponse($this->guard()->user()->toArray(), 200);
    }
}
