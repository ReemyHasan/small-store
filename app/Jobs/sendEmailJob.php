<?php

namespace App\Jobs;

use App\Models\Product;
use App\Notifications\ProductStatusNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class sendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $user_message;

    public function __construct($user, $user_message)
    {
        $this->user = $user;
        $this->user_message = $user_message;
    }

    public function handle(): void
    {

        Notification::send([$this->user], new ProductStatusNotification($this->user_message));
    }
}
