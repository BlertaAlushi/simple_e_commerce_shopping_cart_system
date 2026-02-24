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
        $this->setUser();
        $this->setCart();
        if(empty($this->cart)){
            return Inertia::render('Cart', ["user_cart" => null]);

        }
        return Inertia::render('Cart', ["user_cart" => $this->cart]);
    }

    public function addToCart(UpdateCartRequest $request){
        $data = $request->validated();
        $this->cartService->addToCart($data);

        dd(34);

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
            ]);
        }
        $this->setUser();
        $this->setCart();
        if(empty($this->cart)){
            $this->addUserCart();
            $this->setUser();
            $this->setCart();
        }

        $product = Product::find($request->product_id);
        if(empty($product)){
            return response()->json([
                "success" => false,
            ]);
        }


        if($product->stock_quantity < $request->quantity){
            return response()->json([
                "success" => false,
            ]);
        }

        $add_to_cart = CartProduct::updateOrCreate([
                'product_id' => $request->product_id,
                'cart_id'=> $this->cart->id,
                ],
            ['quantity' => $request->quantity]
        );

        if(empty($add_to_cart)) {
            return response()->json([
                "success" => false,
            ]);
        }

        $cart = Cart::find($this->cart->id);
        return response()->json([
            "success" => true,
            "cart_products_quantity" =>count($cart->products),
        ]);
    }

    public function setUser()
    {
         $this->user = Auth::user();
    }

    public function setCart(){
        $this->cart = Cart::with("products")
            ->where("user_id", $this->user->id)
            ->where("is_ordered",false)
            ->first();
    }

    public function addUserCart(){
        $new_cart = new Cart();
        $new_cart->user_id = $this->user->id;
        $new_cart->save();
    }

    public function updateProductQuantity($id,$quantity){
        Product::where("id",$id)->update(['stock_quantity' => $quantity]);
    }

    public function cartProductsCount(){
        $count = 0;
        $this->setUser();
        $this->setCart();
        if(!empty($this->cart)){
            $count = $this->cart->products->count();
        }
        return response()->json([
            'cart_products_count'=>$count,
        ]);
    }

    public function removeFromCart(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>'required|exists:carts_products,id',
            'cart_id'=>'required|exists:carts,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
            ]);
        }
        CartProduct::where('id', $request->id)->delete();
        $cart = Cart::find($request->cart_id);
        return response()->json([
            "success" => true,
            "cart_products_quantity" =>count($cart->products),
        ]);
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
}
