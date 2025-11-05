<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginNotification;

class SendLoginEmail
{
    //     public function handle(Login $event)
    //     {
    //         Mail::mailer('mailgun') // usa Mailgun
    //             ->to($event->user->email)
    //             ->send(new LoginNotification($event->user));
    //     }
    //     protected $listen = [
    //         \Illuminate\Auth\Events\Login::class => [
    //             \App\Listeners\SendLoginEmail::class,
    //         ],
    //     ];
}
