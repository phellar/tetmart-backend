
@if($recipientType === 'customer')
    <p>Hello {{ $order->customer_name }},</p>
    <p>Your order <strong>{{ $order->Ref }}</strong> has been received!</p>
    <p>Order Details:</p>
@elseif($recipientType === 'vendor')
    <p>Hello {{ $order->vendor->name }},</p>
    <p>You have a new order <strong>{{ $order->Ref }}</strong> to process!</p>
    <p>Customer Details:</p>
    <p>Name: {{ $order->customer_name }}<br>
       Phone: {{ $order->customer_phone }}<br>
       Address: {{ $order->address }}</p>
    <p>Order Details:</p>
@endif

<ul>
    @foreach($order->items as $item)
        <li>{{ $item->quantity }} x {{ $item->product->name }} - ₦{{ $item->price }}</li>
    @endforeach
</ul>

<p>Total: ₦{{ $order->total }}</p>
