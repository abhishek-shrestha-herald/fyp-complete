<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Collection;
use Jackiedo\Cart\Facades\Cart;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Wishlist extends Component
{
    use WireToast;

    public Collection $products;

    public function mount()
    {
        $productIds = auth('farmer')->user()->wishlist;

        $this->products = collect();

        if (count($productIds) > 0) {
            $this->products = Product::whereIn(
                'id',
                $productIds
            )->get();
        }
    }

    public function removeFromWishlist($productId)
    {
        $product = Product::find($productId);
        if (is_null($product)) {
            toast()
                ->danger("Failed to identify product")
                ->push();
            return;
        }

        auth('farmer')->user()->removeFromWishList($product);

        $this->mount();

        toast()
            ->success("Product removed from wishlist")
            ->push();
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if (is_null($product)) {
            toast()
                ->danger("Failed to identify product")
                ->push();
            return;
        }

        $oldItem = array_values(
            Cart::name('shopping')
                ->getItems([
                    'id' => $product->id
                ])
        );

        if (count($oldItem) == 0) {
            Cart::name('shopping')
                ->addItem([
                    'model' => $product,
                    'quantity' => 1,
                    'options' => [],
                ]);
        } else {
            $cartItem = $oldItem[count($oldItem) - 1];

            Cart::name('shopping')
                ->updateItem(
                    $cartItem->getHash(),
                    [
                        'quantity' => $cartItem->getQuantity() + 1
                    ]
                );
        }

        toast()->success("Product added to cart.")
            ->push();
    }

    public function render()
    {
        return view('livewire.wishlist');
    }
}
