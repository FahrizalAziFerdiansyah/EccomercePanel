<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('product_category');
        if ($request->product_category_id) {
            $query->where('product_category_id', $request->product_category_id);
        }
        return response([
            'success' => true,
            'data' => $query->paginate(10)
        ], 201);
    }

    public function collections(Request $request)
    {
        $product_collections = ProductCollection::with('product')->where('user_id', $request->user_id);
        if ($request->pagination) {
            $product_collections = $product_collections->paginate(10);
        } else {
            $product_collections = $product_collections->get();
        }

        return response([
            'success' => true,
            'data' => $product_collections
        ], 201);
    }

    public function addCollection(Request $request)
    {
        $product_collection = ProductCollection::where('product_id', $request->product_id)->where('user_id', $request->user_id)->first();
        if ($product_collection) {
            $product_collection->delete();
            return response([
                'success' => true,
                'message' => 'Product remove from your collection'
            ], 201);
        } else {
            $data = [
                'product_id' => $request->product_id,
                'user_id' => $request->user_id,
            ];
            ProductCollection::create($data);
            return response([
                'success' => true,
                'message' => 'Product add to collection'
            ], 201);
        }
    }

    public function show(Request $request)
    {
        $product = Product::find($request->id)->load('product_category');
        return response([
            'success' => true,
            'data' => $product
        ], 201);
    }
}
