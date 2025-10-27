<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller


{

    // display all products
    public function index()
    {
        // paginated the products upon api call
        $products = Product::paginate(15);

        if($products -> count() > 0){
            return ProductResource::collection($products);            
        }

        else{
            return response()->json(['message' => 'No Products available'],200);
        }
    }

    // create a product and save to database
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'product_name' => 'required |string|max:255', 
            'description' => 'required |string|max:255', 
            'price' => 'required |numeric', 
            'product_image_url'=>'required|string'
        ]);

        // handler for product image upload
        $imagePath = null;

        if($request->hasFile('product_image_url')){
            $imagePath = $request->file('product_image_url')->store('products' , 'public');
        } 
        
        // return error if forms are not filled well
        if($validator->fails()){
            return response()->json([
                'message' => 'All Fields are required'
            ],422);
        }

        $product = Product::create([
            'product_name'=> $request->product_name,
            'description'=> $request->description,
            'price'=> $request->price,
            'product_image_url'=>$imagePath,
            // 'product_image_url'=>$request->product_image_url,
            'user_id'=>auth()->id()
        ]);

        return response()->json([
            'message' => 'product stored sucessfully',
            'data' => new ProductResource($product)
        ],201);
        
    }

    // Display the specific product
    public function show(Product $product)
    {
        return $this->authorize(new ProductResource($product));
    }

    // update a specific product details, this can only be done by product owner/user (Auth)
    public function update(Request $request, Product $product)
    {

        $this->authorize('update', $product);
        $validator = Validator::make($request->all(),[
            'product_name' => 'required | string| max:255', 
            'description' => 'required | string| max:255', 
            'price' => 'required |numeric| max:255', 
            'product-image_url'=>'required|string'
        ]);

         // handler for product image upload
         $imagePath = null;
         if($request->hasFile('product-image_url')){
             $imagePath = $request->file('product-image_url')->store('products' , 'public');
         } 

        if($validator->fails()){
            return response()->json([
                'message' => 'All Fields are required'
            ],422);
        }

        $product->update([
            'product_name'=> $request->product_name,
            'description'=> $request->description,
            'price'=> $request->price,
            'product-image_url'=>$imagePath
        ]);

        return response()->json([
            'message' => 'product details updated Sucessfully',
            'data' => new ProductResource($product)
        ],200);
    }

    // delete a specific product from database
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();

        return response()->json([
            'message'=> 'Product deleted successfuly'
        ],200);
    }

}
