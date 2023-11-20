<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        try {
            $this->validate($request, [
                'sku' => 'required|unique:products',
                'name' => 'required|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
            ]);

            $product = Product::create([
                'sku' => $request->input('sku'),
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'stock' => $request->input('stock'),
                'category_id' => $request->input('category_id'),
            ]);

            return response()->json(['data' => $product], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        }
    }
}

