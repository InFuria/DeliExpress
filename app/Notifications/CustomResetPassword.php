<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;

class CustomResetPassword extends ResetPasswordBase
{
    use Queueable;

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('auth.passwords.reset_solicitude', ['user' => $notifiable, 'url' => route('password.reset', $this->token)])
            ->from('ladyblazzer@gmail.com', 'DeliExpress')
            ->subject('DeliExpress - Recuperar contraseña');
    }
}
