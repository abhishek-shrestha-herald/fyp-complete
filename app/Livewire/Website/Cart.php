<?php

namespace App\Livewire\Website;

use Jackiedo\Cart\Facades\Cart as CartFacade;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Cart extends Component
{
    use WireToast;

    public function removeCartItem(string $hash)
    {
        CartFacade::name('shopping')->removeItem($hash);

        toast()
            ->success("Removed cart item")
            ->push();

    }

    public function render()
    {
        return view('livewire.website.cart');
    }
}
