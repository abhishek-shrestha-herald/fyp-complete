<div>
    <!-- ./sidebar -->
<div class="col-span-1 bg-white px-4 pb-6 shadow rounded overflow-hiddenb hidden md:block">
    <div class="divide-y divide-gray-200 space-y-5">
        <div>
            <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Categories</h3>
            <div class="space-y-2">
                @foreach ($categories as $category)

                <div class="flex items-center">
                    <input type="checkbox" name="cat-1" id="cat-1"
                        class="text-primary focus:ring-0 rounded-sm cursor-pointer">
                    <label for="cat-1" class="text-gray-600 ml-3 cusror-pointer">{{ $category->name }}</label>
                </div>

                @endforeach


            </div>
        </div>

        {{-- <div class="pt-4">
            <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Price</h3>
            <div class="mt-4 flex items-center">
                <input type="text" name="min" id="min"
                    class="w-full border-gray-300 focus:border-primary rounded focus:ring-0 px-3 py-1 text-gray-600 shadow-sm"
                    placeholder="min">
                <span class="mx-3 text-gray-500">-</span>
                <input type="text" name="max" id="max"
                    class="w-full border-gray-300 focus:border-primary rounded focus:ring-0 px-3 py-1 text-gray-600 shadow-sm"
                    placeholder="max">
            </div>
        </div> --}}

    </div>
</div>

</div>
