<?php

namespace AuthModel\Http\Controllers\Auth;

use AuthModel\Helpers\UrlGenerator;
use AuthModel\Http\Controllers\Controller;
use AuthModel\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VerificationController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse|void
     */
    public function verify(Request $request)
    {

        /* @var UrlGenerator $url */
        $url = app('url');
        if (!$url->hasValidSignature($request)) {
            return new JsonResponse([
                'status' => 'The verification link is invalid.',
            ], 400);
        }


        $response = $this->guard()->getUserIsId($request->get('user'));
        if ($response !== true) {
            return $response;
        }

        if ($this->guard()->hasVerifiedEmail()) {
            return new JsonResponse([
                'status' => 'Емаил адрес уже подвержден?',
            ], 400);
        }

        $this->guard()->markEmailAsVerified();

        return new JsonResponse([
            'status' => 'Email адрес подтвержден',
        ]);
    }

    /**
     * Resend the email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(Request $request)
    {

        $this->validate($request, ['email' => 'required|email']);


        $user = $this->guard()->getUserIsEmail($request->email);
        if (is_null($user)) {
            return new JsonResponse([
                'errors' => [
                    'email' => ['We can\'t find a user with that e-mail address.'],
                ]
            ], 422);
        }

        if ($this->guard()->hasVerifiedEmail()) {
            return new JsonResponse([
                'email' => ['Вы уже подтвердили свой email адрес'],
            ]);
        }

        $this->sendEmailVerificationNotification();

        return new JsonResponse([
            'status' => 'Уведомление отправлено на email',
        ]);

    }


    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $Url = app('url');
        $appUrl = 'site_url';

        $url = $Url->temporarySignedRoute(
            'verification.verify', Carbon::now()->addMinutes(60), ['user' => $this->guard()->user()->id]
        );
        $full = $appUrl . $url;
        return $full;
    }

}
