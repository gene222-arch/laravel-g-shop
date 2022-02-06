<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Notifications\VerifyEmail;

class EmailVerificationNotification extends VerifyEmail
{
    use Queueable;

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function verificationUrl($notifiable): string
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable);
        }

        $expirationDate = Carbon::now()
            ->addMinutes(Config::get('auth.verification.expire', 60));

        $parameters = [
            'id' => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification())
        ];

        $url = URL::temporarySignedRoute(
            'verification.verify',
            $expirationDate,
            $parameters
        );

        $appUrl = env('APP_URL') . '/api';
        $reactAppUrl = env('REACT_APP_URL');

        return str_replace($appUrl, $reactAppUrl, $url);
    }
}