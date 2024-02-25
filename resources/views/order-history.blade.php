<x-layout.website-layout pageName="Order History">

    <x-breadcrumb path="Order History" />

    <!-- wrapper -->
    <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16">

       <x-partials.side-bar/>

        @livewire('order-history')

    </div>
    <!-- ./wrapper -->

</x-layout.website-layout>
