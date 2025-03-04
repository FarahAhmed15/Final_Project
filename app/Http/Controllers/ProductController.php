<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(){
        $products=Product::paginate(2);
        return view('Admin.products.index',compact('products'));
    }
    public function create(){
        return view('Admin.products.create');
    }
    public function store(Request $request){
        $data=$request->validate([
            "name"=>"required|string|max:255",
            "desc"=>"required|string",
            "price"=>"required|numeric",
            "image"=>"required|image|mimes:png,jpg,jpeg",
            "quantity"=>"required|numeric",
        ]);
        $data['image']=Storage::putFile('products', $request->image);
        $product=Product::create($data);
        return redirect()->route('create.products')->with("success","Product Inserted Successfully");
    }
    public function edit($id){
        $product=Product::findorfail($id);
        return view("Admin.products.edit",compact("product"));
    }
    public function update($id, Request $request){
        $product = Product::findOrFail($id);
        $data=$request->validate([
            "name"=> "string|required|max:200",
            "desc"=> "string|required",
            "price"=>"required|numeric",
            "image"=>"required|image|mimes:png,jpg,jpeg",
            "quantity"=>"required|numeric",
        ]);
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete($product->image);
            }
            $data['image'] = Storage::putFile('products', $request->image);
        }
    
        $product->update($data);
        return redirect()->route('edit.products',$product->id)->with("success","Product updated Successfully");
    }
    public function delete($id){
        $product=Product::findorfail($id);
        Storage::delete($product->image);
        $product->delete();
        return redirect()->route('all.products')->with("success","Product Deleted Successfully");
    }
}
