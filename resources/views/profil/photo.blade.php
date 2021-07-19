<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href={{ asset("css/bootstrap.min.css") }}>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <title>CRUD Laravel | {{ $title }}</title>
    <link rel="shortcut icon" href={{ asset("favicon.ico") }} type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
</head>

<body>
    @include('partials.navbar')

    <!-- Logout Confirm -->
    <div class="modal fade" id="logout" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yakin ingin keluar akun?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span>Sesi pada akun ini akan diakhiri.</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="{{ route('logout') }}" class="btn btn-danger">Keluar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="py-4 d-flex align-items-center">
            <a href="/admin/profil" class="text-primary px-2 py-0 fs-2"><i class="bi bi-arrow-left-short"></i></a>
            <h2>{{ $title }}</h2>
        </div>

        @if (session('pesan'))
        <div class="alert alert-danger mx-5 alert-dismissible fade show" role="alert">
            <i class="bi bi-x-lg"></i>
            {{ session('pesan') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card mb-3 border-0">
            <div class="row g-0">
                <div class="col">
                    <div class="card-body">
                        <form class="px-4" action="{{ route('edit_photo_process') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="image" class="form-label">Upload Foto</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    name="image" class="image" id="upload_image"
                                    accept="image/png, image/jpeg, image/jpg">
                                @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <input type="hidden" name="image_c">

                            <button type="submit" class="btn btn-primary mb-5">Submit</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset(Auth::user()->image) }}" class="img-fluid rounded border" id="image-admin">
                </div>
            </div>
        </div>

        {{-- CROP PHOTO MODAL --}}
        <div class="modal fade" id="modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg mb-4" style="max-width: 1000px !important;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Crop Photo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn-x"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <img id="image" src="" style="width: 100%">
                            </div>
                            <div class="col-md-4 d-flex flex-column align-items-center">
                                <h6>Preview</h6>
                                <div class="preview" style="height: 250px; width: 250px; overflow: hidden;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btn-cancel"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="crop">Crop</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/cropperjs"></script>
    <script src="https://unpkg.com/dropzone"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>

    <script>
        let $modal = $('#modal');
        let image = document.getElementById('image');
        let cropper;

        $('#btn-cancel').click(() => {
            cropper.destroy();
            cropper = null;
            $('#upload_image').val('');
        });

        $('#btn-x').click(() => {
            cropper.destroy();
            cropper = null;
            $('#upload_image').val('');
        });
    
        $('#upload_image').change(function(event) {
            let files = event.target.files;
            let done = function(url) {
                image.src = url;
                $modal.modal('show');
            }

            if(files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function(event) {
                    done(reader.result);
                }
                reader.readAsDataURL(files[0]);
            }
        });

        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $("#crop").click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 1080,
                height: 1080,
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                let reader = new FileReader();
                reader.readAsDataURL(blob); 
                reader.onloadend = function() {
                    let base64data = reader.result;
                    $("#image-admin").attr("src", base64data);
                    $('input[name="image_c"]').val(base64data);
                    $modal.modal('hide');
                }
            });
        });

    </script>
</body>

</html>