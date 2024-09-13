<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    public function index(){
        $products = Product::paginate(5); // Change the number to control how many products per page
        return response()->json($products);
    }

    public function store(Request $request){
        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ];
    
        // Create a Validator instance and validate the request
        $validator = Validator::make($request->all(), $rules);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Get the validated data
        $validatedData = $validator->validated();
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/images', $imageName);
            $validatedData['image'] = str_replace('public/', '', $imagePath);
        }

        
    
        // Create a new product with the validated data
        $product = Product::create($validatedData);
        $notification = array(
            'message' => 'Item Added successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    

    public function show($id)
{
    $product = Product::find($id);

    if (!$product) {
        abort(404, 'Product not found.');
    }

    return view('View', compact('product'));
}

    // Show the edit form
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('edit-product', compact('product'));
    }

    public function update(Request $request , Product $product){
        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ];

        // Create a Validator instance and validate the request
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get the validated data
        $validatedData = $validator->validated();

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Get the file from the request
            $image = $request->file('image');
            
            // Generate a unique filename
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Move the file to the specified directory
            $imagePath = $image->storeAs('public/images', $imageName);
            
            // Store the relative path to the image
            $validatedData['image'] = str_replace('public/', '', $imagePath);

            // Optionally, delete the old image file if it's not being used anymore
            if ($product->image && file_exists(storage_path('app/public/images/' . $product->image))) {
                unlink(storage_path('app/public/images/' . $product->image));
            }
        }

        // Update the product with the validated data
        $product->update($validatedData);

        // Return a success response with the updated product
        return response()->json([
            'message' => 'Product updated successfully',
            'product' => new ProductResource($product)
        ], 200);
    
    }

    public function destroy(Product $product){
        // Optional: Delete the associated image file if it exists
        if ($product->image && file_exists(storage_path('app/public/images/' . $product->image))) {
            unlink(storage_path('app/public/images/' . $product->image));
        }

        // Delete the product from the database
        $product->delete();

        // Return a success response
        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
