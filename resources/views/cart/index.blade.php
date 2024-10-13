<x-app-layout>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" crossorigin="anonymous" />

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-sm">
                    <div class="card-header text-white bg-dark">
                        <h4 class="mb-0">Your Cart</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                    <tr>
                                        <td class="align-middle  ">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ Storage::disk('supabase')->url($item['image']) }}" alt="{{ $item['title'] }}" width="50" class="img-thumbnail mr-3">
                                                <div>{{ $item['title'] }}</div>
                                            </div>
                                        </td>
                                        <td class="align-middle">Rp{{ number_format($item['price'], 0) }}</td>
                                        <td class="align-middle">
                                            <!-- Update Quantity Form -->
                                            <form action="{{ route('cart.update', ['id' => $id]) }}" method="POST" class="form-inline">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group">
                                                    <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $item['quantity'] }}" min="1" max="{{ $productStocks[$id] ?? 0 }}">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="align-middle">Rp{{ number_format($item['price'] * $item['quantity'], 0) }}</td>
                                        <td class="align-middle">
                                            <!-- Remove Item Form -->
                                            <form action="{{ route('cart.remove', ['id' => $id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Button at the bottom to continue to checkout -->
        <div class="row mt-4">
            <div class="col-md-8 offset-md-2">
                <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg btn-block">Continue to Checkout</a>
            </div>
        </div>
    </div>
</x-app-layout>
