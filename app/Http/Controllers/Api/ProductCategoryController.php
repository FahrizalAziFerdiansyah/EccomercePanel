<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $query = ProductCategory::all();

        return response([
            'success' => true,
            'data' => $query
        ], 201);
    }
}
