<x-layout.website-layout pageName="Products">

    <x-breadcrumb path="Shop" />

    @livewire('website.listing-page', [
        'productFilters' => $filter
    ])

</x-layout.website-layout>
