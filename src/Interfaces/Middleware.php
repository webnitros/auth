<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 07.11.2022
 * Time: 07:26
 */

namespace AuthModel\Interfaces;


use AuthModel\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent as Event;

interface Middleware
{
    public function handle(Controller $controller, Request $request, Event $event): void;
}
