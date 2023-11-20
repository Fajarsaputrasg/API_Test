<?php


namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|max:255',
            ]);

            $category = Category::create([
                'name' => $request->input('name'),
            ]);

            return response()->json(['data' => $category], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        }
    }
}
