<div>
    <img src="{{ $displayImage }}" alt="product" class="w-full">
    <div class="grid grid-cols-5 gap-4 mt-4">
        @foreach ($images as $image)
            <img src="{{ $image }}" alt="product2" wire:click="changeImage('{{ $image }}')" @class([
                'w-full cursor-pointer border',
                'border-primary' => $image == $displayImage,
            ])>
        @endforeach

    </div>
</div>
