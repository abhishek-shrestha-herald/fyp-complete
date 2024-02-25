<?php

namespace App\Livewire;

use App\Models\Product;
use Jackiedo\Cart\Facades\Cart;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class SingleProduct extends Component
{
    use WireToast;

    public Product $product;
    public int $productQuantity = 1;

    public function chageProductQuantityBy(int $value)
    {
        $this->productQuantity += $value;

        if ($this->productQuantity <= 0 || $this->productQuantity > $this->product->available_quantity) {
            $this->productQuantity -= $value;
        }
    }

    public function addToCart()
    {
        if (is_null(auth('farmer')->user())) {
            toast()->danger("Please login to use cart.")
                ->push();
            return;
        }
        $oldItem = array_values(
            Cart::name('shopping')
                ->getItems([
                    'id' => $this->product->id
                ])
        );

        if (count($oldItem) == 0) {
            Cart::name('shopping')
                ->addItem([
                    'model' => $this->product,
                    'quantity' => $this->productQuantity,
                    'options' => [],
                ]);
        } else {
            $cartItem = $oldItem[count($oldItem) - 1];

            Cart::name('shopping')
                ->updateItem(
                    $cartItem->getHash(),
                    [
                        'quantity' => $cartItem->getQuantity() + $this->productQuantity
                    ]
                );
        }

        toast()->success("Product added to cart.")
            ->push();
    }

    public function addToWishlist(): void
    {
        if (is_null(auth('farmer')->user())) {
            toast()->danger("Please login to use wishlist.")
                ->push();
            return;
        }
        $addedToWishlist = auth()->guard('farmer')->user()?->addToWishList($this->product);

        if ($addedToWishlist) {
            toast()->success("Product added to wishlist.")
                ->push();
        } else {
            toast()->danger("Failed to add product to wishlist.")
                ->push();
        }
    }

    public function render()
    {
        return view('livewire.single-product');
    }
}
