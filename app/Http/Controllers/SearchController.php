<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Product::query();

        // Filter by SKU
        if ($request->has('sku')) {
            $query->whereIn('sku', $request->get('sku'));
        }

        // Filter by name (LIKE)
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->get('name') . '%');
        }

        // Filter by price range
        if ($request->has('price.start')) {
            $query->where('price', '>=', $request->get('price.start'));
        }

        if ($request->has('price.end')) {
            $query->where('price', '<=', $request->get('price.end'));
        }

        // Filter by stock range
        if ($request->has('stock.start')) {
            $query->where('stock', '>=', $request->get('stock.start'));
        }

        if ($request->has('stock.end')) {
            $query->where('stock', '<=', $request->get('stock.end'));
        }

        // Filter by category ID
        if ($request->has('category.id')) {
            $query->whereIn('category_id', $request->get('category.id'));
        }

        // Filter by category name
        if ($request->has('category.name')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->whereIn('name', $request->get('category.name'));
            });
        }

        // Execute the query and paginate the results
        $products = $query->paginate(10);

        return response()->json(['data' => $products, 'paging' => $products->toArray()]);
    }
}
