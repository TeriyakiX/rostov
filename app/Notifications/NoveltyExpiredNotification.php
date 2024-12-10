<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NoveltyExpiredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Срок действия новинки истёк')
            ->line('Срок действия новинки для товара "' . $this->product->title . '" истёк.')
            ->line('Пожалуйста, обновите информацию или снимите статус новинки.')
            ->action('Перейти к товару', url('/admin/entity/products/' . $this->product->id . '/edit'))
            ->line('Если вы не хотите получать такие уведомления, вы можете настроить их в админке.');
    }

    public function toArray($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'message' => 'Срок действия новинки для товара "' . $this->product->title . '" истёк.',
            'action' => 'Перейдите в админку для изменений.',
        ];
    }
}
