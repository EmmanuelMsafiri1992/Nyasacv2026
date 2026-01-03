<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\EmailCampaign;

class MarketingEmail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $campaign;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(EmailCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Replace template variables
        $messageContent = $this->replaceVariables($this->campaign->message, $notifiable);
        $subject = $this->replaceVariables($this->campaign->subject, $notifiable);

        $message = (new MailMessage)
            ->subject($subject)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($messageContent);

        // Set reply-to email if provided
        if ($this->campaign->reply_to_email) {
            $message->replyTo($this->campaign->reply_to_email);
        }

        return $message;
    }

    /**
     * Replace template variables with user data.
     */
    protected function replaceVariables($content, $user)
    {
        $variables = [
            '{name}' => $user->name,
            '{email}' => $user->email,
        ];

        return str_replace(array_keys($variables), array_values($variables), $content);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'campaign_id' => $this->campaign->id,
            'subject' => $this->campaign->subject,
        ];
    }
}
