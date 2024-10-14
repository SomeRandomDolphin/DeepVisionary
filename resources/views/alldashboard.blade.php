<x-app-layout>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        crossorigin="anonymous" />
    
        <style>
        /* Custom dark mode styles matching Breeze */
        body.dark-mode {
            background-color: #0f172a; /* Very dark blue */
            color: #e2e8f0;
        }

        body.dark-mode .bg-white {
            background-color: #1e293b !important; /* Dark blue-gray */
        }

        body.dark-mode .card {
            background-color: #2a3b53; /* Slightly lighter than the dashboard background */
            border: 1px solid #4b5563; /* Medium gray border */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        body.dark-mode .card-body {
            color: #e2e8f0;
        }

        body.dark-mode .jumbotron {
            background-color: #1e293b;
            color: #e2e8f0;
        }

        body.dark-mode .text-muted {
            color: #94a3b8 !important;
        }

        body.dark-mode .btn-outline-secondary {
            color: #e2e8f0;
            border-color: #475569;
        }

        body.dark-mode .btn-outline-secondary:hover {
            background-color: #334155;
        }

        body.dark-mode .form-control {
            background-color: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }

        body.dark-mode .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        body.dark-mode .btn-primary:hover {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        /* Additional styles to match Breeze */
        body.dark-mode .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        body.dark-mode .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <main role="main">
                    <section class="jumbotron text-center">
                        <div class="container">
                            <h1 class="pb-3">All Products</h1>
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="form-inline justify-content-center" action="{{ route('alldashboard') }}" method="GET">
                                        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ request('search') }}">
                                        <select class="form-control mr-sm-2" name="category">
                                            <option value="all">All Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                    {{ $category }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="album pb-5 bg-white">
                        <div class="container">
                            <div class="row">
                                @foreach($products as $product)
                                    <div class="col-md-4">
                                        <div class="card mb-4 shadow-sm">
                                            <img src="{{ Storage::disk('supabase')->url($product->image_path) }}"
                                                class="bd-placeholder-img card-img-top" width="100%" height="225"
                                                alt="{{ $product->title }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $product->title }}</h5>
                                                <p class="card-text">Rp{{ number_format($product->price, 0) }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="btn-group">
                                                        <a href="{{ route('catalog.show', ['id' => $product->id]) }}"
                                                            class="btn btn-sm btn-outline-secondary">Selengkapnya</a>
                                                    </div>
                                                    <small class="text-muted">Stock: {{ $product->stock }}</small>
                                                </div>
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

    <script>
        // Check if dark mode is enabled
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.body.classList.add('dark-mode');
        }

        // Listen for changes to the prefers-color-scheme media query
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (e.matches) {
                document.body.classList.add('dark-mode');
            } else {
                document.body.classList.remove('dark-mode');
            }
        });
    </script>
</x-app-layout>