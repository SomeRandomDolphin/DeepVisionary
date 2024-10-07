<x-app-layout>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-black dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <main role="main" class="bg-black">
                    <section class="jumbotron text-center">
                        <div class="container">
                            <h1>{{ Auth::user()->name }}'s Selected Image</h1>
                        </div>
                    </section>

                    <div class="album py-5 bg-black">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card mb-4 shadow-sm">
                                        <img src="{{ $fileUrl }}" class="bd-placeholder-img card-img-top" width="100%" height="auto" alt="{{ $fileName }}">
                                        <div class="card-body">
                                            <p class="card-text">{{ $fileName }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-secondary">View Full Size</a>
                                                </div>
                                                <small class="text-muted">Displayed at {{ now()->toDateTimeString() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>