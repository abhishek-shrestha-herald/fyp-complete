<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function homepage(Request $request)
    {
        return view('homepage', [
            'categories' => Category::all(),
            'newArrivals' => Product::inRandomOrder()->limit(4)->get(),
            'recommendedProducts' => Product::inRandomOrder()->limit(8)->get(),
        ]);
    }

    public function listing(Request $request)
    {
        $filter = [];

        if($request->has('category'))
        {
            $filter['category_id'] = $request->category;
        }

        return view('listing', [
            'filter' => $filter
        ]);
    }

    public function wishlist(Request $request)
    {
        return view('wishlist');
    }

    public function orderHistory(Request $request)
    {
        return view('order-history');
    }

    public function cart(Request $request)
    {
        return view('cart');
    }

    public function searchProduct(Request $request)
    {
        if(!$request->has('search'))
        {
            return $this->listing($request);
        }
        $search = $request->get('search');

        $products = Product::search($search)
            ->get();

        return view('search', [
            'products' => $products
        ]);
    }
}
