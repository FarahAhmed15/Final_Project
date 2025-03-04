<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(){
        $products=Product::all();
        return view("User.home",compact('products'));
    }

    public function show($id){
        $product=Product::findorfail($id);
        return view('User.products.show',compact('product'));
    }

    public function addtocart(Request $request, $id) {
        $qty = $request->qty;
        $product = Product::findOrFail($id);
    
        if ($qty > $product->quantity) {
            return redirect()->back()->with('error', 'more than available');
        }
    
        $cart = session()->get('cart', []);
    
        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] + $qty > $product->quantity) {
                return redirect()->back()->with('error', 'more than available quantity!!');
            }
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "price" => $product->price,
                "image" => $product->image,
                "qty" => $qty,
            ];
        }
    
        session()->put('cart', $cart);
    
        return redirect()->back()->with('success', 'add to cart successfully');
    }
    
    public function mycart(){
        $cart=session()->get('cart');
        return view('user.products.mycart',compact('cart'));
    }

    public function makeorder(Request $request){
        $cart = session()->get('cart');
        $user_id = Auth::user()->id;
    
        $order = Order::create([
            "requireDate" => $request->requireDate,
            "user_id" => $user_id,
        ]);
    
        foreach ($cart as $id => $product) {
            $productModel = Product::find($id);
            
            if ($productModel && $productModel->quantity >= $product['qty']) {
                OrderDetails::create([
                    "order_id" => $order->id,
                    "product_id" => $id,
                    "price" => $product['price'],
                    "quantity" => $product['qty'],
                ]);
    
                $productModel->decrement('quantity', $product['qty']);
            } else {
                return redirect()->back();
            }
        }
    
        session()->forget('cart');
    
        return redirect()->back();
    }

    public function addtowishlist(Request $request, $id) {
        $product = Product::findOrFail($id);
        
        $wishlist = session()->get('wishlist', []);
    
        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
        } else {
            $wishlist[$id] = [
                "name" => $product->name,
                "price" => $product->price,
                "image" => $product->image,
            ];
        }
    
        session()->put('wishlist', $wishlist);
        return redirect()->back();
    }
    
    public function mywishlist(){
        $wishlist = session()->get('wishlist', []);
        return view('user.products.wishlist', compact('wishlist'));
    }

    public function addtofav($id) {
        $product = Product::findOrFail($id);
        $user = Auth::user();

        
        $isfav=Favorite::where("user_id",$user->id)->where("product_id",$id)->first();
        if($isfav !==null ){
            $isfav->delete();
            return redirect()->back();
        }else{
            Favorite::create([
                "user_id"=>$user->id,
                "product_id"=>$id,
            ]);
            return redirect()->back();
        }
    }
    
}

