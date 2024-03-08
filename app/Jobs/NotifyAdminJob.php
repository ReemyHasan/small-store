<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\NotifyAdminNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class NotifyAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $product;
    /**
     * Create a new job instance.
     */
    public function __construct($user, $product)
    {
        $this->product = $product;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = User::where('is_admin',1)->get();
        Notification::send($admins, new NotifyAdminNotification($this->user, $this->product));
    }
}
