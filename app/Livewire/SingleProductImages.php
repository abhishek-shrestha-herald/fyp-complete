<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class SingleProductImages extends Component
{

    public array $images = [
        "/assets/images/products/product1.jpg",
        "/assets/images/products/product2.jpg",
        "/assets/images/products/product3.jpg",
        "/assets/images/products/product4.jpg",
        "/assets/images/products/product5.jpg",
        "/assets/images/products/product6.jpg",
    ];

    public $displayImage = "/assets/images/products/product1.jpg";

    public $productId;

    public function mount(int $productId)
    {
        $this->productId = $productId;
        $product = Product::find($productId);
        $this->displayImage = $product->coverImage?->url;
        $this->images = $product->images?->pluck('url')->toArray() ?? [];
    }

    public function changeImage(string $image)
    {
        if(!in_array($image, $this->images))
        {
            return;
        }
        $this->displayImage = $image;
    }

    public function render()
    {
        return view('livewire.single-product-images');
    }
}
