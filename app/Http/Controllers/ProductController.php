<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = ProductModel::orderBy("id", "desc")->paginate(10);
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $product = ProductModel::create($request->all());
        return response()->json($product);
    }
}
