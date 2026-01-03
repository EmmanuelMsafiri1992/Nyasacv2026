<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminNewUserNotification extends Notification
{
    use Queueable;

    protected $newUser;

    public function __construct($newUser)
    {
        $this->newUser = $newUser;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New User Registration - ' . config('app.name'))
            ->greeting('New User Registered!')
            ->line('A new user has registered on ' . config('app.name') . '.')
            ->line('**User Details:**')
            ->line('Name: ' . $this->newUser->name)
            ->line('Email: ' . $this->newUser->email)
            ->line('Registered at: ' . $this->newUser->created_at->format('Y-m-d H:i:s'))
            ->action('View Users', url('/settings/users'))
            ->line('Thank you for using ' . config('app.name') . '!');
    }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->newUser->id,
            'user_name' => $this->newUser->name,
            'user_email' => $this->newUser->email,
        ];
    }
}
