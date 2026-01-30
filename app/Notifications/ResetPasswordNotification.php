<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Facades\Filament;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(public string $token) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = filament()->getPanel('admin')->getResetPasswordUrl($this->token, $notifiable);

        return (new MailMessage)
            ->subject('🔐 Redefinição de Senha - ' . config('app.name'))
            ->view('mail.reset-password', [
                'url'  => $url,
                'user' => $notifiable
            ]);
    }
}
