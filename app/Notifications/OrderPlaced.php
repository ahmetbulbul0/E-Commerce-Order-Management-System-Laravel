<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlaced extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Order $order)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your order has been received')
            ->line('Thank you for your order!')
            ->line('Order ID: ' . $this->order->id)
            ->line('Total: ' . number_format($this->order->total_amount, 2))
            ->line('Status: ' . $this->order->status)
            ->line('We will notify you when it ships.');
    }
}


