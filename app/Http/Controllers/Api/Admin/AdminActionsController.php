<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\sendEmailJob;
use App\Models\Product;
use App\Models\User;
use App\Notifications\ProductStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AdminActionsController extends Controller
{
    // public function my_notification()
    // {
    //     $notification = "no new notificatios";
    //     if (!empty(Auth::user()->notifications)) {
    //         $notification = Auth::user()->notifications;
    //         Auth::user()->unreadNotifications->markAsRead();
    //     }
    //     return response()->json([
    //         "your notifications" => $notification
    //     ]);
    // }
    public function evaluate_product(Request $request, $id)
    {
        $this->authorize('update','App\Models\Product');
        return DB::transaction(function () use ($request, $id) {
            $product = Product::where('id', $id)->first();
            $status = $request->get('is_accepted');
            $product->update(['is_accepted' => $status]);
            $user_message = $product->name . ' ' . ($product->is_accepted ? 'accepted' : 'rejected') . ' by ' . Auth::user()->name;
            // Notification::send([$product->user], new ProductStatusNotification($user_message));
            $user = $product->user;
            sendEmailJob::dispatch($user,$user_message);

            return response()->json(
                [
                    "product_status" => $product->is_accepted ? "accepted" : "rejected",
                    "message" => "product status updated"
                ],
                202
            );
        });

    }
}
