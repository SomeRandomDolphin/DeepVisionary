<x-app-layout>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-black dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <main role="main" class="bg-black">
                    <section class="jumbotron text-center">
                        <div class="container">
                            <h1>{{ Auth::user()->name }}'s Album</h1>
                            <p>
                                <a href="/upload" class="btn btn-primary my-2">Upload New Image</a>
                            </p>
                        </div>
                    </section>

                    <div class="album py-5 bg-black">
                        <div class="container">
                            <div class="row">
                                @php
                                    $listContent = Storage::disk('supabase')->getAdapter()->listContents('', true);
                                    $files = iterator_to_array($listContent);
                                @endphp

                                @foreach($files as $file)
                                    @if($file instanceof \League\Flysystem\FileAttributes && in_array(strtolower(pathinfo($file->path(), PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                                        <div class="col-md-4">
                                            <div class="card mb-4 shadow-sm">
                                                <img src="{{ Storage::disk('supabase')->url($file->path()) }}" class="bd-placeholder-img card-img-top" width="100%" height="225" alt="{{ basename($file->path()) }}">
                                                <div class="card-body">
                                                    <p class="card-text">{{ basename($file->path()) }}</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="btn-group">
                                                            <a href="{{ Storage::disk('supabase')->url($file->path()) }}" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
                                                            
                                                        </div>
                                                        <small class="text-muted">{{ $file->lastModified() ? \Carbon\Carbon::createFromTimestamp($file->lastModified())->diffForHumans() : 'Unknown' }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>