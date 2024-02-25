<!-- wishlist -->
<div class="col-span-9 space-y-4">
    @foreach ($orders as $order)
        @foreach ($order->orderItems as $orderItem)
            <div class="flex items-center justify-between border gap-6 p-4 border-gray-200 rounded">
                <div class="w-28">
                    <x-curator-glider class="w-full" :media="$orderItem->product->coverImage" alt="{{ $orderItem->product->name }} Image" />
                </div>
                <div class="w-1/3">
                    <h2 class="text-gray-800 text-xl font-medium uppercase">{{ $orderItem->product->name }}</h2>
                    <p class="text-gray-500 text-sm">
                        Payment:
                        @if ($order->paymentRecord->status->value == 'completed')
                            <span class="text-green-600">Completed</span>
                        @elseif($order->paymentRecord->status->value == 'failed')
                            <span class="text-red-600">Failed</span>
                        @else
                            <span class="text-yellow-600">{{ $order->paymentRecord->status->getLabel() }}</span>
                        @endif
                    </p>
                </div>
                <div class="text-primary text-lg font-semibold">
                    NRs. {{ $orderItem->unit_price }}
                </div>
            </div>
        @endforeach
    @endforeach
</div>
<!-- ./wishlist -->s
