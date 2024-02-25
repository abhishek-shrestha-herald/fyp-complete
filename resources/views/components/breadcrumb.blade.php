@props([
    'path' => '',
])

<!-- breadcrumb -->
<div class="container py-4 flex items-center gap-3">
    <a href="/" class="text-primary text-base">
        <i class="fa-solid fa-house"></i>
    </a>



    @foreach (explode('/', $path) as $crumb)
        <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
        <p class="text-gray-600 font-medium">{{ $crumb }}</p>
    @endforeach


</div>
<!-- ./breadcrumb -->
