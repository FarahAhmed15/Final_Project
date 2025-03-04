<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiProductController extends Controller
{
    //
    public function index(){
        $products=Product::all();
        if($products !== null){
            return ProductResource::collection($products);
        }else{
            return response()->json([
                "msg"=>"data not found"
            ],404);
        }

    }
    public function show($id){
        $product=Product::find($id);
        if($product !== null){
            return new ProductResource($product);
        }else{
            return response()->json([
                "msg"=>"product not found"
            ],404);
        }

    }
    public function store(Request $request){
        $errors=Validator::make($request->all(),[
            "name"=>"required|string|max:255",
            "desc"=>"required|string",
            "price"=>"required|numeric",
            "image"=>"required|image|mimes:png,jpg,jpeg",
            "quantity"=>"required|numeric",
        ]);
        if($errors->fails()){
            return response()->json([
                "error"=>$errors->errors()
            ],301);
        }
        $image=Storage::putFile('products', $request->image);
        $product=Product::create([
            "name"=>$request->name,
            "desc"=>$request->desc,
            "price"=>$request->price,
            "image"=>$image,
            "quantity"=>$request->quantity
        ]);
        return response()->json([
            "msg"=>"product created successfully"
        ],201);
    }
    
    public function update($id, Request $request) {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                "msg" => "Product not found"
            ], 404);
        }
    
        
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "desc" => "required|string",
            "price" => "required|numeric",
            "image" => "nullable|image|mimes:png,jpg,jpeg",
            "quantity" => "required|numeric",
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()
            ], 422);
        }
    
        $image = $product->image;
        if ($request->hasFile('image')) {
            Storage::delete($product->image);
            $image = Storage::putFile('products', $request->file('image'));
        }
    
        $product->update([
            "name" => $request->name,
            "desc" => $request->desc,
            "price" => $request->price,
            "image" => $image,
            "quantity" => $request->quantity
        ]);
    
        return response()->json([
            "msg" => "Product updated successfully",
            "product" => $product
        ], 200);
    }
    
    public function delete($id){
        $product=Product::find($id);
        if($product == null){
            return response()->json([
                "msg"=>"product not found"
            ],404);
        }
        if ($product->image) {
            Storage::delete($product->image);
        }
        $product->delete();
        return response()->json([
            "msg"=>"product deleted successfully"
        ],201);
    }
}
