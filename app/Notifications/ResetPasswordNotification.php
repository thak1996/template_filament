<?php

namespace App\Notifications;

use App\Enums\PanelIdEnum;
use App\Enums\PanelRole;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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
        $panelId = method_exists($notifiable, 'hasAnyRole') && $notifiable->hasAnyRole([
            PanelRole::SUPER_ADMIN->value,
            PanelRole::ADMIN->value,
        ])
            ? PanelIdEnum::ADMIN->value
            : PanelIdEnum::CLIENT->value;

        $url = filament()->getPanel($panelId)->getResetPasswordUrl($this->token, $notifiable);

        return (new MailMessage)
            ->subject('🔐 Redefinição de Senha - ' . config('app.name'))
            ->greeting('Olá!')
            ->line('Recebemos uma solicitação para redefinir sua senha.')
            ->action('Redefinir senha', $url)
            ->line('Se você não solicitou a redefinição, nenhuma ação adicional é necessária.');
    }
}
