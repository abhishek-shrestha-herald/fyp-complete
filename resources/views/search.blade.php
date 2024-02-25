<x-layout.website-layout pageName="Search Results">

    <x-breadcrumb path="Search Results" />

    <!-- shop wrapper -->
    <div class="container grid md:grid-cols-4 grid-cols-2 gap-6 pt-4 pb-16 items-start">
        <!-- sidebar -->
        <!-- drawer init and toggle -->

        @livewire('product-listing-sidebar')

        <!-- products -->
        <div class="col-span-3">
            {{-- <div class="flex items-center mb-4">
                <select name="sort" id="sort"
                    class="w-44 text-sm text-gray-600 py-3 px-4 border-gray-300 shadow-sm rounded focus:ring-primary focus:border-primary"
                    wire:model="currentSortingTypeString" wire:change="changeSortingType">
                    @foreach ($allSortingTypes as $sortingType)
                        <option value="{{ $sortingType->value }}">{{ $sortingType->getLabel() }}</option>
                    @endforeach
                </select>
            </div> --}}

            <div class="grid md:grid-cols-3 grid-cols-2 gap-6">

                @foreach ($products as $product)
                    <x-product-card :id="$product->id" :name="$product->name" :unitPrice="$product->unit_price" :category="$product->category->name"
                        :coverImage="$product->coverImage" />
                @endforeach

            </div>
        </div>

        <!-- ./products -->
    </div>
    <!-- ./shop wrapper -->


</x-layout.website-layout>
