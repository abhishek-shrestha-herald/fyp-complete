<x-layout.website-layout pageName="Home">

    <!-- banner -->
    <x-homepage.banner/>
    <!-- ./banner -->

    <!-- features -->
    <x-homepage.features/>
    <!-- ./features -->

    <!-- categories -->
    <div class="container py-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">shop by category</h2>
        <div class="grid grid-cols-3 gap-3">

            @foreach ($categories as $category)
                <div class="relative rounded-sm overflow-hidden group">
                    <x-curator-glider class="h-40 object-center object-cover" :media="$category->coverImage"
                        alt="{{ $category->name }} Image" />
                    {{-- <img src="{{ asset('storage/' . $category->cover_image) }}" alt="category 1" class="w-full"> --}}
                    <a href="/shop?category={{ $category->id }}"
                        class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">
                        {{ $category->name }}
                    </a>
                </div>
            @endforeach


        </div>
    </div>
    <!-- ./categories -->

    <!-- new arrival -->
    <div class="container pb-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">top new arrival</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach ($newArrivals as $newArrival)
                <x-product-card :id="$newArrival->id" :name="$newArrival->name" :unitPrice="$newArrival->unit_price" :category="$newArrival->category->name"
                    :coverImage="$newArrival->coverImage" />
            @endforeach


        </div>
    </div>
    <!-- ./new arrival -->

    <!-- ads -->
    <div class="container pb-16">
        <x-homepage.advertisement/>
    </div>
    <!-- ./ads -->

    <!-- product -->
    <div class="container pb-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">recomended for you</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($recommendedProducts as $recommendedProduct)
                <x-product-card :id="$recommendedProduct->id" :name="$recommendedProduct->name" :unitPrice="$recommendedProduct->unit_price" :category="$recommendedProduct->category->name" />
            @endforeach
        </div>
    </div>
    <!-- ./product -->

</x-layout.website-layout>
