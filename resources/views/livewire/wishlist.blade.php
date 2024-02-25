    <!-- wishlist -->
    <div class="col-span-9 space-y-4">
        @foreach ($products as $product)
            <div class="flex items-center justify-between border gap-6 p-4 border-gray-200 rounded">
                <div class="w-28">
                    <x-curator-glider class="w-full" :media="$product->coverImage" alt="{{ $product->name }} Image" />
                </div>
                <div class="w-1/3">
                    <h2 class="text-gray-800 text-xl font-medium uppercase">{{ $product->name }}</h2>
                    <p class="text-gray-500 text-sm">
                        Availability:
                        @if ($product->available_quantity <= 0)
                            <span class="text-red-600">Out of Stock</span>
                        @elseif($product->available_quantity < 10)
                            <span class="text-yellow-600">In Stock</span>
                        @else
                            <span class="text-green-600">In Stock</span>
                        @endif
                    </p>
                </div>
                <div class="text-primary text-lg font-semibold">
                    NRs. {{ $product->unit_price }}
                </div>
                <a href="javascript:void(0);" wire:click="addToCart({{ $product->id }})"
                    class="px-6 py-2 text-center text-sm text-white bg-primary border border-primary rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium">add
                    to cart</a>

                <button class="text-gray-600 cursor-pointer hover:text-primary" wire:click="removeFromWishlist({{ $product->id }})">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        @endforeach
    </div>
    <!-- ./wishlist -->s
