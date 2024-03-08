<?php

namespace App\Console\Commands;

use App\Jobs\sendEmailJob;
use App\Models\Product;
use App\Notifications\ProductStatusNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class deleteRejectedProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-rejected-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deletedProducts = Product::where('is_accepted', 0)->withoutGlobalScopes()->get();
        // Log::error($deletedProducts);
        foreach ($deletedProducts as $product) {
            $user = $product->user;
            $product->delete();
            $user_message = 'product '.$product->name.' was rejected so it is deleted automatically';
            sendEmailJob::dispatch($user,$user_message);
        }
    }
}
