<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload Image') }}  
        </h2>
    </x-slot>
    
    <div class="container py-5">

        <header class="text-white text-center">
            <h1 class="display-4">Upload Image</h1>
            <p class="lead mb-0">Click the button below to upload your image here.</p>
            <img src="https://bootstrapious.com/i/snippets/sn-img-upload/image.svg" alt="" width="150" class="mb-4">
        </header>

        <div class="row py-4">
            <div class="col-lg-6 mx-auto">

                <!-- Form for image upload -->
                <form method="POST" action="{{ route('upload.submit') }}" enctype="multipart/form-data">
                    @csrf <!-- CSRF protection -->

                    <!-- Upload image input -->
                    <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                        <input id="upload" type="file" name="image" onchange="readURL(this);" class="form-control border-0">
                        <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose file</label>
                        <div class="input-group-append">
                            <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> 
                                <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                <small class="text-uppercase font-weight-bold text-muted">Choose file</small>
                            </label>
                        </div>
                    </div>

                    <!-- Uploaded image area-->
                    <p class="font-italic text-white text-center">The preview of your uploaded image will be shown in the box below.</p>
                    <div class="image-area mt-4">
                        <img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block">
                    </div>

                    <!-- Submit button -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Load CSS and JS resources -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        #upload {
            opacity: 0;
        }

        #upload-label {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
        }

        .image-area {
            border: 2px dashed rgba(255, 255, 255, 0.7);
            padding: 1rem;
            position: relative;
        }

        .image-area::before {
            content: 'Uploaded image result';
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.8rem;
            z-index: 1;
        }

        .image-area img {
            z-index: 2;
            position: relative;
        }

        body {
            min-height: 100vh;
            background-color: #757f9a;
            background-image: linear-gradient(147deg, #757f9a 0%, #d7dde8 100%);
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imageResult').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(function () {
            $('#upload').on('change', function () {
                readURL(this);
            });
        });

        var input = document.getElementById('upload');
        var infoArea = document.getElementById('upload-label');

        input.addEventListener('change', showFileName);
        function showFileName(event) {
            var input = event.srcElement;
            var fileName = input.files[0].name;
            infoArea.textContent = 'File name: ' + fileName;
        }
    </script>
</x-app-layout>
