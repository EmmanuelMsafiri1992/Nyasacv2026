<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminUserVerifiedNotification extends Notification
{
    use Queueable;

    protected $verifiedUser;

    public function __construct($verifiedUser)
    {
        $this->verifiedUser = $verifiedUser;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('User Email Verified - ' . config('app.name'))
            ->greeting('User Verified Their Email!')
            ->line('A user has verified their email on ' . config('app.name') . '.')
            ->line('**User Details:**')
            ->line('Name: ' . $this->verifiedUser->name)
            ->line('Email: ' . $this->verifiedUser->email)
            ->line('Verified at: ' . $this->verifiedUser->email_verified_at->format('Y-m-d H:i:s'))
            ->action('View Users', url('/settings/users'))
            ->line('This user is now fully active!');
    }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->verifiedUser->id,
            'user_name' => $this->verifiedUser->name,
            'user_email' => $this->verifiedUser->email,
        ];
    }
}
