<?php

namespace App\Http\Controllers;

use App\Enums\Currency;
use App\Enums\OrderStatus;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Http\Requests\Epayment\InitiateEsewaPaymentRequest;
use App\Http\Requests\Epayment\InitiateKhaltiPaymentRequest;
use App\Http\Requests\Epayment\InitiateSajiloPayPaymentRequest;
use App\Http\Requests\Epayment\ValidateEsewaPaymentRequest;
use App\Http\Requests\Epayment\ValidateKhaltiPaymentRequest;
use App\Http\Requests\Epayment\ValidateSajiloPayPaymentRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentRecord;
use App\Models\Product;
use App\Notifications\OrderPlacedNotification;
use App\Notifications\PaymentCompleteNotification;
use App\Notifications\PaymentErrorNotification;
use App\Payments\EsewaPayment;
use App\Payments\KhaltiPayment;
use App\Payments\SajiloPayPayment;
use Illuminate\Http\Request;
use Jackiedo\Cart\Facades\Cart;

class PaymentController extends Controller
{
    public function initiateEsewaPayment(InitiateEsewaPaymentRequest $request)
    {

        $order = Order::create([
            'farmer_id' => auth('farmer')->user()->id,
            'total' => Cart::name('shopping')->getTotal(),
            'currency' > Currency::NPR,
            'status' => OrderStatus::INITIATED,
        ]);

        foreach (Cart::name('shopping')->getItems() as $hash => $item) {
            $product = Product::find($item->getId());

            if (is_null($product)) {
                continue;
            }
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'unit_price' => $product->unit_price,
                'quantity' => $item->getQuantity(),
                'total_price' => $product->unit_price * $item->getQuantity(),
                'currency' => Currency::NPR,
                'unit_id' => $product->unit_id,
            ]);

            $product->available_quantity -= $item->getQuantity();
            $product->save();
        }

        $paymentRecord = PaymentRecord::create([
            'user_id' => auth('farmer')->user()->id,
            'order_id' => $order->id,
            'provider' => PaymentProvider::ESEWA,
            'currency' => Currency::NPR,
            'amount' => $request->get('amount'),
            'status' => PaymentStatus::PENDING,
            'details' => $request->all(),
            'transferred_to_wallet' => false,
            'initiate_response' => [],
            'redirect_response' => [],
            'validate_response' => [],
        ]);

        $payment = (new EsewaPayment())
            ->payment($paymentRecord)
            ->setUp($request->all())
            ->initiate();

        $farmer = auth('farmer')->user();

        $farmer->notify(new OrderPlacedNotification($order));

        return redirect($payment->redirectUrl());
    }

    public function validateEsewaPayment(ValidateEsewaPaymentRequest $request)
    {
        $validated = $request->validated();
        $paymentRecord = (PaymentProvider::ESEWA)
            ->resolvePaymentCodeFromValidationResponse($validated);

        $paymentRecord->redirect_response = $validated;

        $paymentRecord->save();

        $payment = (new EsewaPayment())
            ->payment($paymentRecord);

        $validation = $payment->validate($validated);

        if ($validation) {
            $paymentRecord->status = PaymentStatus::COMPLETED;
            $paymentRecord->save();

            Cart::name('shopping')->clearItems();

            $farmer = auth('farmer')->user();
            $farmer->notify(new PaymentCompleteNotification($paymentRecord));

            toast()->success('Payment completed! Order placed successfully.')
                ->pushOnNextPage();
            return redirect('/');
        }
        $paymentRecord->status = PaymentStatus::FAILED;
        $paymentRecord->save();

        $farmer = auth('farmer')->user();
        $farmer->notify(new PaymentErrorNotification($paymentRecord));
        toast()->danger('Payment failed! Order not placed.')
            ->pushOnNextPage();
        return redirect('/');
    }

    public function initiateKhaltiPayment(InitiateKhaltiPaymentRequest $request)
    {

        $order = Order::create([
            'farmer_id' => auth('farmer')->user()->id,
            'total' => Cart::name('shopping')->getTotal(),
            'currency' > Currency::NPR,
            'status' => OrderStatus::INITIATED,
        ]);

        foreach (Cart::name('shopping')->getItems() as $hash => $item) {
            $product = Product::find($item->getId());
            if (is_null($product)) {
                continue;
            }
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'unit_price' => $product->unit_price,
                'quantity' => $item->getQuantity(),
                'total_price' => $product->unit_price * $item->getQuantity(),
                'currency' => Currency::NPR,
                'unit_id' => $product->unit_id,
            ]);
            $product->available_quantity -= $item->getQuantity();
            $product->save();
        }

        $paymentRecord = PaymentRecord::create([
            'user_id' => auth('farmer')->user()->id,
            'order_id' => $order->id,
            'provider' => PaymentProvider::KHALTI,
            'currency' => Currency::NPR,
            'amount' => $request->get('amount'),
            'status' => PaymentStatus::PENDING,
            'details' => $request->all(),
            'transferred_to_wallet' => false,
            'initiate_response' => [],
            'redirect_response' => [],
            'validate_response' => [],
        ]);

        $payment = (new KhaltiPayment())
            ->payment($paymentRecord)
            ->setUp($request->all())
            ->initiate();

        $farmer = auth('farmer')->user();

        $farmer->notify(new OrderPlacedNotification($order));

        return redirect($payment->redirectUrl());
    }

    public function validateKhaltiPayment(ValidateKhaltiPaymentRequest $request)
    {
        $validated = $request->validated();
        $paymentRecord = (PaymentProvider::KHALTI)
            ->resolvePaymentCodeFromValidationResponse($validated);

        $paymentRecord->redirect_response = $validated;

        $paymentRecord->save();

        $payment = (new KhaltiPayment())
            ->payment($paymentRecord);

        $validation = $payment->validate($validated);

        if ($validation) {
            $paymentRecord->status = PaymentStatus::COMPLETED;
            $paymentRecord->save();
            Cart::name('shopping')->clearItems();

            $farmer = auth('farmer')->user();
            $farmer->notify(new PaymentCompleteNotification($paymentRecord));

            toast()->success('Payment completed! Order placed successfully.')
                ->pushOnNextPage();
            return redirect('/');
        }

        $paymentRecord->status = PaymentStatus::FAILED;
        $paymentRecord->save();

        $farmer = auth('farmer')->user();
        $farmer->notify(new PaymentErrorNotification($paymentRecord));

        toast()->danger('Payment failed! Order not placed.')
            ->pushOnNextPage();
        return redirect('/');
    }

    public function initiateSajiloPayPayment(InitiateSajiloPayPaymentRequest $request)
    {

        $order = Order::create([
            'farmer_id' => auth('farmer')->user()->id,
            'total' => Cart::name('shopping')->getTotal(),
            'currency' > Currency::NPR,
            'status' => OrderStatus::INITIATED,
        ]);

        foreach (Cart::name('shopping')->getItems() as $hash => $item) {
            $product = Product::find($item->getId());
            if (is_null($product)) {
                continue;
            }
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'unit_price' => $product->unit_price,
                'quantity' => $item->getQuantity(),
                'total_price' => $product->unit_price * $item->getQuantity(),
                'currency' => Currency::NPR,
                'unit_id' => $product->unit_id,
            ]);
            $product->available_quantity -= $item->getQuantity();
            $product->save();
        }

        $paymentRecord = PaymentRecord::create([
            'user_id' => auth('farmer')->user()->id,
            'order_id' => $order->id,
            'provider' => PaymentProvider::SAJILO_PAY,
            'currency' => Currency::NPR,
            'amount' => $request->get('amount'),
            'status' => PaymentStatus::PENDING,
            'details' => $request->all(),
            'transferred_to_wallet' => false,
            'initiate_response' => [],
            'redirect_response' => [],
            'validate_response' => [],
        ]);

        $payment = (new SajiloPayPayment())
            ->payment($paymentRecord)
            ->setUp($request->all())
            ->initiate();

        $farmer = auth('farmer')->user();

        $farmer->notify(new OrderPlacedNotification($order));

        return redirect($payment->redirectUrl());
    }

    public function validateSajiloPayPayment(ValidateSajiloPayPaymentRequest $request)
    {
        $validated = $request->validated();
        $paymentRecord = (PaymentProvider::SAJILO_PAY)
            ->resolvePaymentCodeFromValidationResponse($validated);

        $paymentRecord->redirect_response = $validated;

        $paymentRecord->save();

        $payment = (new SajiloPayPayment())
            ->payment($paymentRecord);

        $validation = $payment->validate($validated);

        if ($validation) {
            $paymentRecord->status = PaymentStatus::COMPLETED;
            $paymentRecord->save();
            Cart::name('shopping')->clearItems();
            $farmer = auth('farmer')->user();
            $farmer->notify(new PaymentCompleteNotification($paymentRecord));
            toast()->success('Payment completed! Order placed successfully.')
                ->pushOnNextPage();
            return redirect('/');
        }

        $paymentRecord->status = PaymentStatus::FAILED;
        $paymentRecord->save();

        $farmer = auth('farmer')->user();
        $farmer->notify(new PaymentErrorNotification($paymentRecord));

        toast()->danger('Payment failed! Order not placed.')
            ->pushOnNextPage();
        return redirect('/');
    }
}
