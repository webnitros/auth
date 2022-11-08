<?php
/**
 * Запуск сессии для авторизации
 */

namespace AuthModel\Http\Middleware;

use AuthModel\Http\Controllers\Controller;
use AuthModel\Interfaces\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent as Event;

class StartSession implements Middleware
{
    public function handle(Controller $controller, Request $request, Event $event): void
    {
        $guard = $controller->guard();
        if (!$guard->check()) {
            $guard->startSession();
        }
    }
}
