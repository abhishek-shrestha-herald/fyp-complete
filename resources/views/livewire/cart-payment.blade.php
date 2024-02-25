<div>
    <div class="flex justify-between text-gray-800 font-medium py-3 uppercas">
        <p class="font-semibold">Payment Methods</p>
        <p>{{ $paymentProvider }}</p>
    </div>

    <div class="flex items-center mb-4 mt-2">
        <p class="p-2 m-2 border-black border-2 cursor-pointer" wire:click="selectPaymentProvider('esewa')">
            Esewa
        </p>
        <p class="p-2 m-2 border-black border-2 cursor-pointer" wire:click="selectPaymentProvider('khalti')">
            Khalti
        </p>
        {{-- <p class="p-2 m-2 border-black border-2 cursor-pointer" wire:click="selectPaymentProvider('sajilo-pay')">
            Sajilo Pay
        </p> --}}
    </div>

    <a href="/payment/{{ $paymentProvider ?? '' }}/initiate?amount={{ $amount }}" @class([
        'block w-full py-3 px-4 text-center text-white bg-primary border border-primary rounded-md hover:bg-transparent hover:text-primary transition font-medium',
        'hidden' => is_null($paymentProvider),
    ])>
        Place order
    </a>
</div>
