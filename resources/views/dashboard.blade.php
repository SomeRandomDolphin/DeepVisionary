<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        crossorigin="anonymous" />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-black dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
                <main role="main" class="bg-black">
                    <section class="jumbotron text-center">
                        <div class="container">
                            <h1>{{ Auth::user()->name }}'s Products</h1>
                            <p>
                                <a href="{{ route('product.create') }}" class="btn btn-primary my-2">Upload New Product</a>
                            </p>
                        </div>
                    </section>

                    <div class="album py-5 bg-black">
                        <div class="container">
                            <div class="row">
                                @foreach($products as $product)
                                    <div class="col-md-4">
                                        <div class="card mb-4 shadow-sm">
                                            <img src="{{ Storage::disk('supabase')->url($product->image_path) }}" class="bd-placeholder-img card-img-top" width="100%" height="225" alt="{{ $product->title }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $product->title }}</h5>
                                                <p class="card-text">${{ number_format($product->price, 2) }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="btn-group">
                                                    <a href="{{ route('catalog.show', ['id' => $product->id]) }}" class="btn btn-sm btn-outline-secondary">Selengkapnya</a>
                                                    </div>
                                                    <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                                                </div>
                                                <small class="text-muted">9 mins</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>
