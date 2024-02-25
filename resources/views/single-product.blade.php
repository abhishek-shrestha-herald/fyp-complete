<x-layout.website-layout pageName="{{ $product->name }}">

    <x-breadcrumb
        path="Product"
    />


    @livewire('single-product', [
        'product' => $product
    ])

    <!-- related product -->
    <div class="container pb-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">Related products</h2>
        <div class="grid grid-cols-4 gap-6">
            @foreach ($relatedProducts as $relatedProduct)
                <x-product-card
                    :id="$relatedProduct->id"
                    :name="$relatedProduct->name"
                    :category="$relatedProduct->category->name"
                    :unitPrice="$relatedProduct->unit_price"
                    :coverImage="$relatedProduct->coverImage"
                />
            @endforeach
        </div>
    </div>
    <!-- ./related product -->

</x-layout.website-layout>
