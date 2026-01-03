<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminSubscriptionNotification extends Notification
{
    use Queueable;

    protected $payment;
    protected $user;

    public function __construct($payment, $user)
    {
        $this->payment = $payment;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $packageTitle = $this->payment->package ? $this->payment->package->title : 'N/A';
        $amount = $this->payment->total ?? 'N/A';
        $currency = config('settings.CURRENCY_SYMBOL', '$');

        return (new MailMessage)
            ->subject('New Subscription Payment - ' . config('app.name'))
            ->greeting('New Subscription Payment Received!')
            ->line('A user has subscribed on ' . config('app.name') . '.')
            ->line('**Payment Details:**')
            ->line('User: ' . $this->user->name . ' (' . $this->user->email . ')')
            ->line('Package: ' . $packageTitle)
            ->line('Amount: ' . $currency . $amount)
            ->line('Payment Gateway: ' . ($this->payment->gateway ?? 'N/A'))
            ->line('Date: ' . $this->payment->created_at->format('Y-m-d H:i:s'))
            ->action('View Payments', url('/settings/payments'))
            ->line('Thank you for using ' . config('app.name') . '!');
    }

    public function toArray($notifiable)
    {
        return [
            'payment_id' => $this->payment->id,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
        ];
    }
}
