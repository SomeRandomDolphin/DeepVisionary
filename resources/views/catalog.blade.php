<x-app-layout>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        crossorigin="anonymous" />

    <div class="container py-5">
        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <!-- Close button -->
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <!-- Close button -->
            </div>
        @endif

        <div class="row">
            <!-- Product Image -->
            <div class="col-md-6">
                <img src="{{ $fileUrl }}" class="img-fluid rounded" alt="{{ $product->title }}">
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <h1 class="text-white mb-3">{{ $product->title }}</h1>
                <p class="text-white lead mb-3">Rp{{ number_format($product->price, 0) }}</p>
                <p class="text-white mb-3">Stock: {{ $product->stock }}</p>
                <p class="text-white mb-4">{{ $product->description }}</p>

                <!-- Add to Cart Button -->
                <form method="POST" action="{{ route('cart.add', ['id' => $product->id]) }}">
                    @csrf
                    <div class="form-group w-50">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg mt-3">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (necessary for the alert dismissal) -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
</x-app-layout>
