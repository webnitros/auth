<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 07.11.2022
 * Time: 07:43
 */

namespace AuthModel\Http\Middleware;


use AuthModel\Http\Controllers\Controller;
use AuthModel\Interfaces\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent as Event;

class Authenticate implements Middleware
{
    public function handle(Controller $controller, Request $request, Event $event): void
    {
        if (!$request->expectsJson()) {
            // Если не авторизован то
            if (!$controller->guard()->check()) {
                redirect('/login');
            }
        } else {
            if (!$controller->guard()->check()) {
                # return new JsonResponse([], 401);
                $event->stopPropagation();
                $action = $event->getController();
                switch ($action[1]) {
                    case 'logout': // Если пользователь не авторизован то возвращаем ему 200 так как уже разлогинен
                        $event->setController(function () {
                            return new JsonResponse([], 200);
                        });
                        break;
                    default:
                        // Возвращаем ответ о том что необходимо авторизоваться для использования этого метода
                        $event->setController(function () {
                            return new JsonResponse([], 401);
                        });
                        break;
                }
            }
        }
    }
}
