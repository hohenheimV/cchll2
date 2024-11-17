@php
$collection = collect([['item' => 'gambar_p', 'label' => 'Gambar Pokok'], ['item' => 'gambar_b', 'label' => 'Gambar Bunga'], ['item' => 'gambar_d', 'label' => 'Gambar Daun'], ['item' => 'gambar_bg', 'label' => 'Gambar Batang'], ['item' => 'gambar_bh', 'label' => 'Gambar Buah']]);
@endphp
<style>
    .gambar {
        display: block;
        padding-top: 56.25%;
        position: relative;
    }

    .gambar>img {
        display: block;
        width: 100%;
        height: 100%;
        max-height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
    }

    .gambar .img-thumbnail {
        height: 350px;
        object-fit: cover;
    }
</style>



<table id="example" class="responsive table table-bordered table-sm mb-3">
    <tr>
        <th class="table-secondary">Maklumat Gambar Tumbuhan</th>
    </tr>
    <tr>
        <td>
            <style>
                .image {
                    display: inline-block;
                    margin: 4px;
                    border: 1px solid #CCCCCC;
                    background-position: center center;
                    background-repeat: no-repeat;
                }

                .image.size-fixed {
                    width: 200px;
                    height: 200px;
                }

                .image.size-fluid {
                    padding-top: 15%;
                    width: 20%;
                }

                .image.scale-fit {
                    background-size: contain;
                }

                .image.scale-fill {
                    background-size: cover;
                }

                .image img {
                    display: none;
                }

                .image a {
                    width: 100%;
                    height: calc(100% - 40px);
                    display: block;
                }

                div.image>.label-gambar,
                a.image>.label-gambar,
                a:hover.image>.label-gambar,
                a:active.image>.label-gambar,
                a:visited.image>.label-gambar {
                    color: white;
                    background: rgba(0, 0, 0, 0.6);
                    width: 100%;
                    text-align: center
                }
            </style>

            @if ($softscape->gambar_p && Storage::disk('public')->exists('assets/softscape/' . $softscape->gambar_p))
                <div class="image size-fixed scale-fill"
                    style="background-image: url({{ asset('storage/assets/softscape/' . $softscape->gambar_p) }});">
                    <div class="label-gambar d-flex">
                        <div class="flex-grow-1 m-2 text-sm">Gambar Pokok</div>
                        @if (!request()->has('tahun') || request()->get('tahun') == date('Y'))
                            <button class="btn btn-sm btn-primary m-1 px-2 py-1" data-toggle="modal"
                                data-target="#gambarModal"
                                data-urlgambar="{{ asset('storage/assets/softscape/' . $softscape->gambar_p) }}"
                                data-tajuk="Gambar Pokok" data-jenis="gambar_p"><span
                                    class="fas fa-upload text-light"></span></button>
                        @endif
                    </div>
                    <a href="{{ asset('storage/assets/softscape/' . $softscape->gambar_p) }}" data-toggle="lightbox"
                        data-title="Gambar Pokok (Kod : {{ $softscape->kod_tag }})" data-gallery="gallery">
                        <img src="{{ asset('storage/assets/softscape/' . $softscape->gambar_p) }}" alt="Gambar Pokok">
                    </a>
                </div>
            @else
                <div class="image size-fixed scale-fill"
                    style="background-image: url({{ asset('img/no-photos.png') }});">
                    <div class="label-gambar d-flex">
                        <div class="flex-grow-1 m-2 text-sm">Gambar Pokok</div>
                        @if (!request()->has('tahun') || request()->get('tahun') == date('Y'))
                            <button class="btn btn-sm btn-primary m-1 px-2 py-1" data-toggle="modal"
                                data-target="#gambarModal" data-urlgambar="{{ asset('img/no-photos.png') }}"
                                data-tajuk="Gambar Pokok" data-jenis="gambar_p"><span
                                    class="fas fa-upload text-light"></span></button>
                        @endif
                    </div>
                    <img src="{{ asset('img/no-photos.png') }}" alt="Gambar Pokok">
                </div>
            @endif

            @if ($softscape->gambar_b && Storage::disk('public')->exists('assets/softscape/' . $softscape->gambar_b))

                <div class="image size-fixed scale-fill"
                    style="background-image: url({{ asset('storage/assets/softscape/' . $softscape->gambar_b) }});">
                    <div class="label-gambar d-flex">
                        <div class="flex-grow-1 m-2 text-sm">Gambar Batang Pokok</div>
                        @if (!request()->has('tahun') || request()->get('tahun') == date('Y'))
                            <button class="btn btn-sm btn-primary m-1 px-2 py-1" data-toggle="modal"
                                data-target="#gambarModal"
                                data-urlgambar="{{ asset('storage/assets/softscape/' . $softscape->gambar_b) }}"
                                data-tajuk="Gambar Batang Pokok" data-jenis="gambar_b"><span
                                    class="fas fa-upload text-light"></span></button>
                        @endif
                    </div>
                    <a href="{{ asset('storage/assets/softscape/' . $softscape->gambar_b) }}" data-toggle="lightbox"
                        data-title="Gambar Batang Pokok (Kod : {{ $softscape->kod_tag }})" data-gallery="gallery">
                        <img src="{{ asset('storage/assets/softscape/' . $softscape->gambar_b) }}"
                            alt="Gambar Batang Pokok">
                    </a>
                </div>
            @else
                <div class="image size-fixed scale-fill"
                    style="background-image: url({{ asset('img/no-photos.png') }});">
                    <div class="label-gambar d-flex">
                        <div class="flex-grow-1 m-2 text-sm">Gambar Batang Pokok</div>
                        @if (!request()->has('tahun') || request()->get('tahun') == date('Y'))
                            <button class="btn btn-sm btn-primary m-1 px-2 py-1" data-toggle="modal"
                                data-target="#gambarModal" data-urlgambar="{{ asset('img/no-photos.png') }}"
                                data-tajuk="Gambar Batang Pokok" data-jenis="gambar_b"><span
                                    class="fas fa-upload text-light"></span></button>
                        @endif
                    </div>
                    <img src="{{ asset('img/no-photos.png') }}" alt="Gambar Buah">
                </div>
            @endif

            @if ($softscape->gambar_d && Storage::disk('public')->exists('assets/softscape/' . $softscape->gambar_d))
                <div class="image size-fixed scale-fill"
                    style="background-image: url({{ asset('storage/assets/softscape/' . $softscape->gambar_d) }});">
                    <div class="label-gambar d-flex">
                        <div class="flex-grow-1 m-2 text-sm">Gambar Daun</div>
                        @if (!request()->has('tahun') || request()->get('tahun') == date('Y'))
                            <button class="btn btn-sm btn-primary m-1 px-2 py-1" data-toggle="modal"
                                data-target="#gambarModal"
                                data-urlgambar="{{ asset('storage/assets/softscape/' . $softscape->gambar_d) }}"
                                data-tajuk="Gambar Daun" data-jenis="gambar_d"><span
                                    class="fas fa-upload text-light"></span></button>
                        @endif
                    </div>
                    <a href="{{ asset('storage/assets/softscape/' . $softscape->gambar_d) }}" data-toggle="lightbox"
                        data-title="Gambar Daun (Kod : {{ $softscape->kod_tag }})" data-gallery="gallery">
                        <img src="{{ asset('storage/assets/softscape/' . $softscape->gambar_d) }}" alt="Gambar Daun">
                    </a>
                </div>
            @else
                <div class="image size-fixed scale-fill"
                    style="background-image: url({{ asset('img/no-photos.png') }});">
                    <div class="label-gambar d-flex">
                        <div class="flex-grow-1 m-2 text-sm">Gambar Daun</div>
                        @if (!request()->has('tahun') || request()->get('tahun') == date('Y'))
                            <button class="btn btn-sm btn-primary m-1 px-2 py-1" data-toggle="modal"
                                data-target="#gambarModal" data-urlgambar="{{ asset('img/no-photos.png') }}"
                                data-tajuk="Gambar Daun" data-jenis="gambar_d"><span
                                    class="fas fa-upload text-light"></span></button>
                        @endif
                    </div>
                    <img src="{{ asset('img/no-photos.png') }}" alt="Gambar Buah">
                </div>
            @endif


            @if ($softscape->gambar_bg && Storage::disk('public')->exists('assets/softscape/' . $softscape->gambar_bg))
                <div class="image size-fixed scale-fill"
                    style="background-image: url({{ asset('storage/assets/softscape/' . $softscape->gambar_bg) }});">
                    <div class="label-gambar d-flex">
                        <div class="flex-grow-1 m-2 text-sm">Gambar Bunga</div>
                        @if (!request()->has('tahun') || request()->get('tahun') == date('Y'))
                            <button class="btn btn-sm btn-primary m-1 px-2 py-1" data-toggle="modal"
                                data-target="#gambarModal"
                                data-urlgambar="{{ asset('storage/assets/softscape/' . $softscape->gambar_bg) }}"
                                data-tajuk="Gambar Bunga" data-jenis="gambar_bg"><span
                                    class="fas fa-upload text-light"></span></button>
                        @endif
                    </div>
                    <a href="{{ asset('storage/assets/softscape/' . $softscape->gambar_bg) }}"
                        data-toggle="lightbox" data-title="Gambar Bunga (Kod : {{ $softscape->kod_tag }})"
                        data-gallery="gallery">
                        <img src="{{ asset('storage/assets/softscape/' . $softscape->gambar_bg) }}"
                            alt="Gambar Bunga">
                    </a>
                </div>
            @else
                <div class="image size-fixed scale-fill"
                    style="background-image: url({{ asset('img/no-photos.png') }});">
                    <div class="label-gambar d-flex">
                        <div class="flex-grow-1 m-2 text-sm">Gambar Bunga</div>
                        @if (!request()->has('tahun') || request()->get('tahun') == date('Y'))
                            <button class="btn btn-sm btn-primary m-1 px-2 py-1" data-toggle="modal"
                                data-target="#gambarModal" data-urlgambar="{{ asset('img/no-photos.png') }}"
                                data-tajuk="Gambar Bunga" data-jenis="gambar_bg"><span
                                    class="fas fa-upload text-light"></span></button>
                        @endif
                    </div>
                    <img src="{{ asset('img/no-photos.png') }}" alt="Gambar Buah">
                </div>
            @endif


            @if ($softscape->gambar_bh && Storage::disk('public')->exists('assets/softscape/' . $softscape->gambar_bh))
                <div class="image size-fixed scale-fill"
                    style="background-image: url({{ asset('storage/assets/softscape/' . $softscape->gambar_bh) }});">
                    <div class="label-gambar d-flex">
                        <div class="flex-grow-1 m-2 text-sm">Gambar Buah</div>
                        @if (!request()->has('tahun') || request()->get('tahun') == date('Y'))
                            <button class="btn btn-sm btn-primary m-1 px-2 py-1" data-toggle="modal"
                                data-target="#gambarModal"
                                data-urlgambar="{{ asset('storage/assets/softscape/' . $softscape->gambar_bh) }}"
                                data-tajuk="Gambar Batang Pokok" data-jenis="gambar_bh"><span
                                    class="fas fa-upload text-light"></span></button>
                        @endif
                    </div>
                    <a href="{{ asset('storage/assets/softscape/' . $softscape->gambar_bh) }}"
                        data-toggle="lightbox" data-title="Gambar Buah(Kod : {{ $softscape->kod_tag }})"
                        data-gallery="gallery">
                        <img src="{{ asset('storage/assets/softscape/' . $softscape->gambar_bh) }}"
                            alt="Gambar Buah">
                    </a>
                </div>
            @else
                <div class="image size-fixed scale-fill"
                    style="background-image: url({{ asset('img/no-photos.png') }});">
                    <div class="label-gambar d-flex">
                        <div class="flex-grow-1 m-2 text-sm">Gambar Buah</div>
                        @if (!request()->has('tahun') || request()->get('tahun') == date('Y'))
                            <button class="btn btn-sm btn-primary m-1 px-2 py-1" data-toggle="modal"
                                data-target="#gambarModal" data-urlgambar="{{ asset('img/no-photos.png') }}"
                                data-tajuk="Gambar Buah" data-jenis="gambar_bh"><span
                                    class="fas fa-upload text-light"></span></button>
                        @endif
                    </div>
                    <img src="{{ asset('img/no-photos.png') }}" alt="Gambar Buah">
                </div>
            @endif


        </td>
    </tr>
</table>

@section('page-css-style')
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{{ asset('plugins/ekko-lightbox/ekko-lightbox.css') }}">
@endsection

@section('page-js-script')
    <script src="{{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
    <script>
        $(document).ready(function() {


            $('#gambarModal').on('show.bs.modal', function(event) {

                var button = $(event.relatedTarget) // Button that triggered the modal
                var tajuk = button.data('tajuk') // Extract info from data-* attributes
                var jenis = button.data('jenis') // Extract info from data-* attributes
                var url = button.data('urlgambar') // Extract info from data-* attributes

                var modal = $(this)
                modal.find('.modal-title').text(tajuk)
                modal.find('.modal-body input[name=\'jenis\']').val(jenis)
                modal.find('.image_preview_container').attr('src', url);


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#image').change(function() {

                    let reader = new FileReader();

                    reader.onload = (e) => {

                        $('#image_preview_container').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]);

                });

                $('#upload_image_form').submit(function(e) {

                    e.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('pengurusan.softscape.gambar', $softscape) }}",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            this.reset();
                            $('#gambarModal').hide();
                            alert('Image has been uploaded successfully');
                            window.location.href =
                                "{{ route('pengurusan.softscape.show', $softscape) }}";

                        },
                        error: function(data) {
                            // console.log(data.responseJSON.errors.image[0]);
                            alert(data.responseJSON.errors.image[0]);
                        }
                    });
                });
            });

            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });
        });
    </script>
@endsection
