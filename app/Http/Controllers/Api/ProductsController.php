<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all products
        $product = Product::all();
        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        try {
            $product = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'price' => 'required|numeric',
                'qty' => 'required|integer',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            // check if validation fails
            if ($product->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $product->errors()
                ], 422);
            }

            // Save image to database
            if ($request->hasFile('image')) {
                $image_path = $request->file('image')->store('product/image', 'public'); // Store in storage/app/public/images
                $image_url = asset('storage/' . $image_path); // Convert to URL
            } else {
                $image_url = null;
            }

            // create product
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'qty' => $request->qty,
                'image' => $image_url,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Product creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get product by id
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Product retrieved successfully',
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validate request
        try {
            $product = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'price' => 'required|numeric',
                'qty' => 'required|integer',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            // check if validation fails
            if ($product->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $product->errors()
                ], 422);
            }

            // get product by id
            $product = Product::find($id);
            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found',
                ], 404);
            }

            // Save image to database
            if ($request->hasFile('image')) {
                $image_path = $request->file('image')->store('product/image', 'public'); // Store in storage/app/public/images
                $image_url = asset('storage/' . $image_path); // Convert to URL
            } else {
                $image_url = $product->image;
            }

            // update product
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'qty' => $request->qty,
                'image' => $image_url,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully',
                'data' => $product
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Product update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete product by id
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }
        // delete product
        $product->delete();
        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully',
        ], 200);

    }
}
