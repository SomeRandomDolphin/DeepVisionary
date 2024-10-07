<x-app-layout>
    <div class="container py-5">
        <h1>Your Cart</h1>

        @if(count($cart) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Title</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php $subtotal = $item['price'] * $item['quantity']; @endphp
                        <tr>
                            <td>
                                <img src="{{ Storage::disk('supabase')->url($item['image']) }}" alt="{{ $item['title'] }}" width="50">
                            </td>
                            <td>{{ $item['title'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>${{ number_format($item['price'], 2) }}</td>
                            <td>${{ number_format($subtotal, 2) }}</td>
                        </tr>
                        @php $total += $subtotal; @endphp
                    @endforeach
                </tbody>
            </table>
            <h3>Total: ${{ number_format($total, 2) }}</h3>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
</x-app-layout>
