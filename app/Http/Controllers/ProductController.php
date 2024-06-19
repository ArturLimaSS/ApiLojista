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
        try {
            ProductModel::create($request->all());
            return response()->json([
                "message" => "Produto cadastrado com sucesso!"
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
