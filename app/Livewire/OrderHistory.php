<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;

class OrderHistory extends Component
{

    public Collection $orders;

    public function mount()
    {
        $this->orders = auth('farmer')->user()->orders;
    }

    public function render()
    {
        return view('livewire.order-history');
    }
}
