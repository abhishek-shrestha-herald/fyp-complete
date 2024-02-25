<!-- navbar -->
<nav class="bg-primary">
    <div class="container flex">
        <div class="px-4 py-4 md:flex items-center cursor-pointer relative group hidden">
        </div>

        <div class="flex items-center justify-between flex-grow md:pl-12 py-5">
            <div class="flex items-center space-x-6 capitalize">
                <a href="/" class="text-gray-200 hover:text-white transition">Home</a>
                <a href="/shop" class="text-gray-200 hover:text-white transition">Shop</a>
                {{-- <a href="#" class="text-gray-200 hover:text-white transition">About us</a> --}}
                {{-- <a href="#" class="text-gray-200 hover:text-white transition">Contact us</a> --}}
            </div>
            @if(!auth()->guard('farmer')->user())
            <div>
                <a href="/login" class="text-gray-200 hover:text-white transition">Login</a> |
            <a href="/register" class="flex-none text-gray-200 hover:text-white transition">Register</a>
            </div>
            @else
            <a href="#" class="text-gray-200 hover:text-white transition">{{ auth()->guard('farmer')->user()->name }}</a>
            @endif

        </div>
    </div>
</nav>
<!-- ./navbar -->
