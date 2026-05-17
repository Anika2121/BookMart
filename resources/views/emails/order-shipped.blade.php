@component('mail::message')
# Your Order Has Been Shipped! 🚚

Hi **{{ $order->buyer->name }}**,

Great news! Your order has been shipped and is on its way to you!

@component('mail::panel')
**Shipment Details:**
- **Book:** {{ $order->book->title }}
- **Author:** {{ $order->book->author }}
- **Price:** ৳{{ $order->price }}
- **Status:** Shipped
- **Shipping Address:** {{ $order->shipping_address }}
@endcomponent

@component('mail::button', ['url' => url('/my-orders'), 'color' => 'green'])
Track My Order
@endcomponent

Thank you for shopping with **BookMart**!

Regards,
{{ config('app.name') }}
@endcomponent