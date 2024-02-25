<x-layout.website-layout pageName="Wishlist">

    <x-breadcrumb path="Wishlist" />

    <!-- wrapper -->
    <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16">

       <x-partials.side-bar/>

        @livewire('wishlist')

    </div>
    <!-- ./wrapper -->

</x-layout.website-layout>
