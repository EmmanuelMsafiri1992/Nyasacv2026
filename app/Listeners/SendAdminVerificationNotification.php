<?php

namespace App\Listeners;

use App\Notifications\AdminUserVerifiedNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Notification;

class SendAdminVerificationNotification
{
    public function handle(Verified $event)
    {
        // Notify admin about user verification
        Notification::route('mail', 'info@nyasacv.com')
            ->notify(new AdminUserVerifiedNotification($event->user));
    }
}
