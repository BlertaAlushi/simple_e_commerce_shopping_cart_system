<?php

namespace App\Console\Commands;

use App\Mail\DailySalesReport;
use App\Models\CartProduct;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Mail;

class SendDailySalesReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjobs:send-daily-sales-report';

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
        $today = Carbon::today();
        $dailySales = $products = CartProduct::select(
            'products.name as name',
            DB::raw('SUM(carts_products.quantity) as quantity'),
            DB::raw('MAX(products.price) as price'),
            DB::raw('MAX(products.currency) as currency'),
            DB::raw('SUM(carts_products.quantity * products.price) as totalprice')
        )
            ->join('carts', 'carts_products.cart_id', '=', 'carts.id')
            ->join('products', 'carts_products.product_id', '=', 'products.id')
            ->where('carts.is_ordered', true)
            ->whereDate('carts.ordered_at', Carbon::today())
            ->groupBy('products.id', 'products.name')
            ->get();

        $email = "admin@test.com";
        $admin = User::where('admin', true)->first();
        if(!empty($admin)){
            $email = $admin->email;
        }
        Mail::to($email)->send(new DailySalesReport($dailySales));
    }
}
