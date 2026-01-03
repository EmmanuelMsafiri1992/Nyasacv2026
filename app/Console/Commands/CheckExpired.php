<?php

namespace App\Console\Commands;

use App\User;
use App\Notifications\SubscriptionExpired;
use Illuminate\Console\Command;

class CheckExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rb:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification about expired subscriptions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereNotNull('package_ends_at')
            ->where('package_ends_at', '<=', now())
            ->get();

        foreach ($users as $user) {
            $user->notify((new SubscriptionExpired())->onQueue('mail'));
            $user->package_ends_at = null;
            $user->save();

            $this->info('Subscription expired for: ' . $user->name);
        }

    }
}
