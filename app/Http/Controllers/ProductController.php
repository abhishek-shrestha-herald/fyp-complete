<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getSingleProduct(Request $request, Product $product)
    {
        // ddd($product);

        return view('single-product', [
            'product' => $product,
            'relatedProducts' => Product::all()->random(4),
        ]);
    }
}
