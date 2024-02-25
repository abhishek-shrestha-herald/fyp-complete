<div>
    <!-- product-detail -->
<div class="container grid grid-cols-2 gap-6">

    @livewire('single-product-images', [
        'productId' => $product->id
    ])


    <div>
        <h2 class="text-3xl font-medium uppercase mb-2">
            {{ $product->name }}
        </h2>
        {{-- <x-rating/> --}}
        <div class="space-y-2">
            <p class="text-gray-800 font-semibold space-x-2">
                <span>Availability: </span>
                @if($product->available_quantity <= 0)
                    <span class="text-red-600">Out of Stock</span>
                @elseif($product->available_quantity < 10)
                <span class="text-yellow-600">In Stock</span>
                @else
                <span class="text-green-600">In Stock</span>
                @endif
            </p>
            <p class="space-x-2">
                <span class="text-gray-800 font-semibold">Available Quantity: </span>
                <span class="text-gray-600">{{ $product->available_quantity }}</span>
            </p>
            <p class="space-x-2">
                <span class="text-gray-800 font-semibold">Category: </span>
                <span class="text-gray-600">{{ $product->category->name }}</span>
            </p>
            <p class="space-x-2">
                <span class="text-gray-800 font-semibold">Unit: </span>
                <span class="text-gray-600">{{ $product->unit->name }}</span>
            </p>
        </div>
        <div class="flex items-baseline mb-1 space-x-2 font-roboto mt-4">
            <p class="text-xl text-primary font-semibold">{{ $product->unit_price }}</p>
            {{-- <p class="text-base text-gray-400 line-through">$55.00</p> --}}
        </div>

        {{-- <p class="mt-4 text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos eius eum
            reprehenderit dolore vel mollitia optio consequatur hic asperiores inventore suscipit, velit
            consequuntur, voluptate doloremque iure necessitatibus adipisci magnam porro.</p> --}}

        {{-- Add feature to allow admin to add custom attributes to products like sizes, colors etc --}}
        {{-- <div class="pt-4">
            <h3 class="text-sm text-gray-800 uppercase mb-1">Size</h3>
            <div class="flex items-center gap-2">
                <div class="size-selector">
                    <input type="radio" name="size" id="size-xs" class="hidden">
                    <label for="size-xs"
                        class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">XS</label>
                </div>
                <div class="size-selector">
                    <input type="radio" name="size" id="size-sm" class="hidden">
                    <label for="size-sm"
                        class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">S</label>
                </div>
                <div class="size-selector">
                    <input type="radio" name="size" id="size-m" class="hidden">
                    <label for="size-m"
                        class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">M</label>
                </div>
                <div class="size-selector">
                    <input type="radio" name="size" id="size-l" class="hidden">
                    <label for="size-l"
                        class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">L</label>
                </div>
                <div class="size-selector">
                    <input type="radio" name="size" id="size-xl" class="hidden">
                    <label for="size-xl"
                        class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">XL</label>
                </div>
            </div>
        </div> --}}

        {{-- <div class="pt-4">
            <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Color</h3>
            <div class="flex items-center gap-2">
                <div class="color-selector">
                    <input type="radio" name="color" id="red" class="hidden">
                    <label for="red"
                        class="border border-gray-200 rounded-sm h-6 w-6  cursor-pointer shadow-sm block"
                        style="background-color: #fc3d57;"></label>
                </div>
                <div class="color-selector">
                    <input type="radio" name="color" id="black" class="hidden">
                    <label for="black"
                        class="border border-gray-200 rounded-sm h-6 w-6  cursor-pointer shadow-sm block"
                        style="background-color: #000;"></label>
                </div>
                <div class="color-selector">
                    <input type="radio" name="color" id="white" class="hidden">
                    <label for="white"
                        class="border border-gray-200 rounded-sm h-6 w-6  cursor-pointer shadow-sm block"
                        style="background-color: #fff;"></label>
                </div>

            </div>
        </div> --}}

        {{-- CUstom attributes ends here --}}

        <div class="mt-4">
            <h3 class="text-sm text-gray-800 uppercase mb-1">Quantity</h3>
            <div class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300 w-max">
                <div
                    class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none"
                    wire:click="chageProductQuantityBy(-1)"
                >-</div>
                <div class="h-8 w-8 text-base flex items-center justify-center">{{ $productQuantity }}</div>
                <div class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none" wire:click="chageProductQuantityBy(1)">+</div>
            </div>
        </div>

        <div class="mt-6 flex gap-3 border-b border-gray-200 pb-5 pt-5">
            <a href="javascript:void(0);" wire:click="addToCart"
                class="bg-primary border border-primary text-white px-8 py-2 font-medium rounded uppercase flex items-center gap-2 hover:bg-transparent hover:text-primary transition">
                <i class="fa-solid fa-bag-shopping"></i> Add to cart
            </a>
            <a href="javascript:void(0);" wire:click="addToWishlist"
                class="border border-gray-300 text-gray-600 px-8 py-2 font-medium rounded uppercase flex items-center gap-2 hover:text-primary transition">
                <i class="fa-solid fa-heart"></i> Wishlist
            </a>
        </div>

        {{-- <div class="flex gap-3 mt-4">
            <a href="#"
                class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="#"
                class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                <i class="fa-brands fa-twitter"></i>
            </a>
            <a href="#"
                class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                <i class="fa-brands fa-instagram"></i>
            </a>
        </div> --}}
    </div>
</div>
<!-- ./product-detail -->

<!-- description -->
<div class="container pb-16">
    <h3 class="border-b border-gray-200 font-roboto text-gray-800 pb-3 font-medium">Product details</h3>
    <div class="w-3/5 pt-6">
        {!! $product->description !!}
    </div>
</div>
<!-- ./description -->

</div>
