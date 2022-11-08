<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 06.11.2022
 * Time: 17:25
 */

use AuthModel\Application;
use AuthModel\Http\Controllers\Auth\ForgotPasswordController;
use AuthModel\Http\Controllers\Auth\LoginController;
use AuthModel\Http\Controllers\Auth\LogoutController;
use AuthModel\Http\Controllers\Auth\RegisterController;
use AuthModel\Http\Controllers\Auth\ResetPasswordController;
use AuthModel\Http\Controllers\Auth\UserController;
use AuthModel\Http\Controllers\Auth\VerificationController;
use AuthModel\Http\Controllers\Settings\PasswordController;
use AuthModel\Http\Controllers\Settings\ProfileController;

return Application::create(function (\AuthModel\Route $Route) {
    $Route->prefixStack('/api')->group([], function (\AuthModel\Route $r) {

        // Для авторизованных пользователей
        $r->post('/logout', [LogoutController::class, 'logout']);
        $r->post('/user', [UserController::class, 'current']);
        $r->post('/settings/profile', [ProfileController::class, 'update']);
        $r->post('/settings/password', [PasswordController::class, 'update']);


        // Для ананимов
        $r->post('/login', [LoginController::class, 'login']);
        $r->post('/register', [RegisterController::class, 'register']);

        $r->post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
        $r->post('/password/reset', [ResetPasswordController::class, 'reset']);

        $r->post('/email/verify/{user}', [VerificationController::class, 'verify']);
        $r->post('/email/resend', [VerificationController::class, 'resend']);

    });
    return $Route;
});
