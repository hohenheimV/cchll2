<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane p-2 fade show active" id="pills-butiran" role="tabpanel" aria-labelledby="pills-butiran-tab">
        <div class="row">
            <div class="col-12 col-sm-4">
                <div class="col-12">
                    <img onerror="this.onerror=null;this.src='{{asset('img/default-150x150.png')}}';"
                    src="{{ $hardscape->gambar_lengkap ? $hardscape->gambar_lengkap : asset('img/default-150x150.png') }}" class="product-image" alt="Gambar Softscape">
                </div>

                <div class="col-12 text-center p-4">
                    <img class="img-thumbnail border border-dark text-center"
                        src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->margin(1)->size(280)->errorCorrection('Q')->generate($hardscape->hardscape_qrcode)) !!} ">
                    <div>Kod Tag : {{ $hardscape->fullKodTag }}</div>
                </div>
            </div>
            <div class="col-12 col-sm-8" id="hardscape">
                <div class="bg-gray py-2 px-3 mb-4">
                    <div class="mb-0 d-flex">
                        <div class="flex-grow-1">
                            <h4 class="mt-0">Tahun : {{ $hardscape->tahun_bina }}</h4>
                            <h5 class="mt-0">No Rujukan : {{  $hardscape->no_rujukan }}</h5>
                        </div>
                        <div>
                            {{ Form::button('<i class="fas fa-edit"></i> Kemaskini', ['data-id'=>$hardscape->id,
                            'data-href'=>''.route('pengurusan.hardscape.edit',$hardscape).'','data-toggle'=>'modal','data-target'=>'#modalHardscapeEdit',
                            'class'=>'btn btn-warning btn-sm my-1','data-dismiss'=>'modal']) }}
                        </div>
                    </div>
                </div>
                <h5><b>Jenis Komponen / Struktur</b> : {{ $hardscape->jenis_komponen }}</h5>
                <h5><b>Nama Struktur</b>: {{ $hardscape->nama_struktur }}</h5>
                <h5><b>Kos Pembinaan</b> : {{ "RM ".$hardscape->kos_pembinaan }}</h5>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="pills-selenggara" role="tabpanel" aria-labelledby="pills-selenggara-tab">
        <ul class="nav nav-pills border-bottom" id="pills-tab" role="tablist">
            @foreach ($hardscape->records as $record)
            <li class="nav-item">
                <a class="rounded-0 nav-link  {{$loop->first ? 'active':''}}" id="pills-{{$record->id}}-tab"
                    data-toggle="pill" href="#pills-{{$record->id}}" role="tab" aria-controls="pills-{{$record->id}}"
                    aria-selected="true">
                    {{$record->tarikh->format('Y')}}
                </a>
            </li>
            @endforeach
        </ul>

        <div class="tab-content" id="pills-tabContent">
            @foreach ($hardscape->records as $record)
            <div class="tab-pane p-2 fade {{$loop->first ? 'show active':''}}" id="pills-{{$record->id}}"
                role="tabpanel" aria-labelledby="pills-{{$record->id}}-tab">
                <div class="mb-0 d-flex">
                    <div class="flex-grow-1">
                        <h3>Tarikh Rekod : {{$record->tarikh->format('d-m-Y g:i A')}}</h3>
                    </div>
                    <div>
                        {{ Form::button('<i class="fas fa-edit"></i> Kemaskini '. $record->tarikh->format('Y'), ['data-id'=>$hardscape->id,
                            'data-href'=>''.route('pengurusan.hardscape.edit',['hardscape'=>$hardscape,'record'=>$record->id]).'','data-toggle'=>'modal','data-target'=>'#modalHardscapeEdit',
                            'class'=>'btn btn-warning btn-sm my-1','data-dismiss'=>'modal']) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <h4>Baik Pulih</h4>
                        <p>{{$record->catatan_baikpulih}}</p>
                        <h4>Selenggara</h4>
                        <p>{{$record->catatan_selenggara}}</p>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <div class="product-image-thumb p-1 mr-1">
                                    <img alt="Gambar gambar baikpulih" src="{{ $record->gambar_baikpulih_satu ? $record->gambar_baikpulih_satu : asset('img/default-150x150.png') }}">
                                </div>
                                <p class="text-center text-capitalize"><small>gambar baik pulih</small></p>
                            </div>
                            <div class="col-4">
                                <div class="product-image-thumb p-1 mr-1">
                                    <img alt="Gambar gambar baikpulih" src="{{ $record->gambar_baikpulih_dua ? $record->gambar_baikpulih_dua : asset('img/default-150x150.png') }}">
                                </div>
                                <p class="text-center text-capitalize"><small>gambar baik pulih</small></p>
                            </div>
                            <div class="col-4">
                                <div class="product-image-thumb p-1 mr-1">
                                    <img alt="Gambar gambar baikpulih" src="{{ $record->gambar_baikpulih_tiga ? $record->gambar_baikpulih_tiga : asset('img/default-150x150.png') }}">
                                </div>
                                <p class="text-center text-capitalize"><small>gambar baik pulih</small></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    </div>
</div>
