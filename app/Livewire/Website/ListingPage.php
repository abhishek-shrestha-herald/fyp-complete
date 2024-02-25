<?php

namespace App\Livewire\Website;

use App\Enums\ListingPageSortingType;
use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Component;

class ListingPage extends Component
{

    public Collection $products;

    public array $productFilters = [];
    public array $productOrdering = [];

    public ListingPageSortingType $currentSortingType;
    public string $currentSortingTypeString;
    public array $allSortingTypes;

    /**
     * Product Ordering FOrmat:
     * [
     *      'price' => 'asc',
     *      'price' => 'desc',
     * ]
     */

    public function mount($productFilters = [], $productOrdering = [])
    {
        $this->productFilters = $productFilters;
        $this->productOrdering = $productOrdering;
        $this->allSortingTypes = ListingPageSortingType::cases();
        $this->currentSortingType = ListingPageSortingType::DEFAULT;
        $this->currentSortingTypeString = ListingPageSortingType::DEFAULT->value;
        $this->products = $this->getProducts();
    }

    protected function getProducts(): Collection
    {
        $query = Product::query();

        if (count($this->productFilters) != 0) {
            foreach ($this->productFilters as $key => $value) {
                $query = $query->where($key, $value);
            }
        }
        $orderings = array_merge(
            $this->productOrdering,
            $this->currentSortingType->productOrdering()
        );

        if(count($orderings) != 0){
            foreach ($orderings as $key => $value) {
                $query = $query->orderBy($key, $value);
            }
        }

        return $query->get();
    }

    public function changeSortingType()
    {
        $this->currentSortingType = ListingPageSortingType::tryFrom($this->currentSortingTypeString) ?? ListingPageSortingType::DEFAULT;
        $this->products = $this->getProducts();
    }

    public function render()
    {
        // ddd($this->productFilters);
        return view('livewire.website.listing-page');
    }
}
