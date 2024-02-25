<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProductListingSidebar extends Component
{
    public Collection $categories;

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.product-listing-sidebar');
    }
}
