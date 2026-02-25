<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCartRequest;
use App\Jobs\LowStockNotification;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Validator;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService,
    ){}
    public $user, $cart;
    public function index(){
        $cart = $this->cartService->index();
        return Inertia::render('user/Cart', ["cartProducts" => $cart]);
    }

    public function addToCart(UpdateCartRequest $request){
        $data = $request->validated();
        $this->cartService->addToCart($data);
        return response(null, 200);
    }

    public function updateCartProduct(UpdateCartRequest $request, CartProduct $cartProduct){
        $data = $request->validated();
        $this->cartService->updateCart($data,$cartProduct);
        return response(null, 200);
    }

    public function removeFromCart(CartProduct  $cartProduct){
        $cartProduct->delete();
        return redirect()->back();
    }

    public function orderCart(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>'required|exists:carts,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
            ]);
        }

        $cart = Cart::find($request->id);
        $low_quantity_products = [];
        foreach($cart->products as $cart_product){
            if($cart_product->product->stock_quantity < $cart_product->quantity){
                return response()->json([
                    "success" => false,
                ]);
            }
            $remaining_quantity = $cart_product->product->stock_quantity - $cart_product->quantity;
            if($remaining_quantity<50){
                $low_quantity_products[] = $cart_product->product_id;
            }
            $this->updateProductQuantity($cart_product->product_id,$remaining_quantity);
        }

        $cart->is_ordered = true;
        $cart->ordered_at = now();
        $cart->save();

        if(count($low_quantity_products)){
            LowStockNotification::dispatch($low_quantity_products);
        }

        return response()->json([
            "success" => true,
        ]);
    }

    public function checkout(){
        dd(23);
    }
}
