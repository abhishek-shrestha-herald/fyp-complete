<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ListingPageSortingType: string implements HasLabel
{
    case DEFAULT = 'default';
    case PRICE_LOW_TO_HIGH = 'price-low-to-high';
    case PRICE_HIGH_TO_LOW = 'price-high-to-low';
    case LATEST_PRODUCT = 'latest-product';

    public function getLabel(): ?string
    {
        return match($this){
            self::DEFAULT => 'Default',
            self::PRICE_LOW_TO_HIGH => 'Price Low to High',
            self::PRICE_HIGH_TO_LOW => 'Price High to Low',
            self::LATEST_PRODUCT => 'Latest Product',
        };
    }

    public function productOrdering(): array
    {
        return match($this){
            self::DEFAULT => [],
            self::PRICE_HIGH_TO_LOW => [
                'unit_price' => 'desc'
            ],
            self::PRICE_LOW_TO_HIGH => [
                'unit_price' => 'asc'
            ],
            self::LATEST_PRODUCT => [
                'created_at' => 'desc'
            ],
        };
    }
}
