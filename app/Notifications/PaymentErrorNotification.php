<?php

namespace App\Notifications;

use App\Models\PaymentRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentErrorNotification extends Notification
{
    use Queueable;

    protected PaymentRecord $record;

    /**
     * Create a new notification instance.
     */
    public function __construct(PaymentRecord $record)
    {
        $this->record = $record;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->error()
            ->subject("Payment Successful")
            ->line('Payment complete successfully.')
            ->line('Code: ' . $this->record->code)
            ->line('Provider: ' . $this->record->provider->getLabel())
            ->line('Amount: NRs ' . $this->record->amount)
            ->action('View Order History', url('/order-history'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
