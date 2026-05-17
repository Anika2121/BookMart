@component('mail::message')
# Order Placed Successfully! 🎉

Hi **{{ $order->buyer->name }}**,

Your order has been placed successfully on **BookMart**!

@component('mail::panel')
**Order Details:**
- **Book:** {{ $order->book->title }}
- **Author:** {{ $order->book->author }}
- **Price:** ৳{{ $order->price }}
- **Status:** {{ ucfirst($order->status) }}
- **Shipping Address:** {{ $order->shipping_address }}
@endcomponent

@component('mail::button', ['url' => url('/my-orders'), 'color' => 'blue'])
View My Orders
@endcomponent

Thank you for shopping with **BookMart**!

Regards,
{{ config('app.name') }}
@endcomponent