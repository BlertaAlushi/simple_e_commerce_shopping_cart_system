<?php

namespace App\Jobs;

use App\Mail\LowStockMail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class LowStockNotification implements ShouldQueue
{
    use Queueable;
    public $products_ids;

    /**
     * Create a new job instance.
     */
    public function __construct($products)
    {
        $this->products_ids = $products;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $products = Product::whereIn('id', $this->products_ids)->get();
        $email = "admin@test.com";
        $admin = User::where('admin', true)->first();
        if(!empty($admin)){
            $email = $admin->email;
        }
        Mail::to($email)->send(new LowStockMail($products));
    }
}
