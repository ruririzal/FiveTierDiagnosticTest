@extends('layouts.backend')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tes</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Tes</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
@section('nomer-soal')
    @if($tes && $tes->waktu_mulai->addMinutes($pengaturan->durasi_menit)->greaterThan(now()) && ! $tes->waktu_selesai)
        <h5 class="text-center" id="menu-soal">Menu Soal</h5>
        <table style="width: 145px;border-collapse:separate;border-spacing:10px;margin:auto">
            <tr>
                <td rowspan="2">No</td>
                <td colspan="5" class="text-center">Tier</td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="text-center">2</td>
                <td class="text-center">3</td>
                <td class="text-center">4</td>
                <td class="text-center">5</td>
            </tr>
            @foreach($soal as $key => $itemSoal)
            <tr>
                <td>
                    {{$key+1}}
                </td>
                <td><a data-tab="soal-tab-{{ $key+1 }}" data-tier="1" class="btn btn-sm btn-default ganti-tab {{ optional($tes->jawaban_siswa->get($itemSoal->id))->jawaban_id ? 'bg-success' : '' }}">-</a></td>
                <td><a data-tab="soal-tab-{{ $key+1 }}" data-tier="2" class="btn btn-sm btn-default ganti-tab {{ in_array(optional($tes->jawaban_siswa->get($itemSoal->id))->is_jawaban_yakin, ['0', '1']) ? 'bg-success' : '' }}">-</a></td>
                <td><a data-tab="soal-tab-{{ $key+1 }}" data-tier="3" class="btn btn-sm btn-default ganti-tab {{ optional($tes->jawaban_siswa->get($itemSoal->id))->alasan_jawaban_soal_id ? 'bg-success' : '' }}">-</a></td>
                <td><a data-tab="soal-tab-{{ $key+1 }}" data-tier="4" class="btn btn-sm btn-default ganti-tab {{ in_array(optional($tes->jawaban_siswa->get($itemSoal->id))->is_alasan_yakin, ['0', '1']) ? 'bg-success' : '' }}">-</a></td>
                <td><a data-tab="soal-tab-{{ $key+1 }}" data-tier="5" class="btn btn-sm btn-default ganti-tab {{ optional($tes->jawaban_siswa->get($itemSoal->id))->tier_five ? 'bg-success' : '' }}">-</a></td>
            </tr>
            @endforeach
        </table>

        <form action="{{ route('selesai_tes_simulasi') }}" method="POST" id="selesai_tes_simulasi_form">
            @csrf
            <button style="margin:auto" class="nav-link bg-secondary btn" id="btn_akhir_tes" type="submit">Akhiri Simulasi</button>
        </form>
    @endif
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="table-responsive">
                @if( ! ($tes->waktu_mulai ?? false))
                    <table style="width: 100%">
                        <tr>
                            <th>Durasi tes : {{ $pengaturan->durasi_menit }} menit</th>
                            <th>Jumlah Soal : {{ $jumlah_soal }}</th>
                        </tr>
                    </table>
                @elseif($tes->waktu_mulai->addMinutes($pengaturan->durasi_menit)->greaterThan(now()) && ! $tes->waktu_selesai)
                    <table style="width: 100%">
                        <tr>
                            <th>Status : Tes Sedang Berlangsung</th>
                            <th>Waktu Mulai Tes : {{ $tes->waktu_mulai }}</th>
                            <th id="sisa_waktu">Sisa Waktu : {{ $tes->waktu_mulai->addMinutes($pengaturan->durasi_menit)->diffAsCarbonInterval() }}</th>
                        </tr>
                    </table>
                @else
                    <p style="text-align: center"><b>Telah melakukan tes</b></p>
                    <table style="width: 100%">
                        <tr>
                            <th style="text-align: right">Waktu Mulai Tes</th>
                            <th>:</th>
                            <th>{{ $tes->waktu_mulai }}</th>
                        </tr>
                        <tr>
                            <th style="text-align: right">Waktu Selesai Tes</th>
                            <th>:</th>
                            <th>{{ $tes->waktu_selesai ?? $tes->waktu_mulai->addMinutes($pengaturan->durasi_menit) }}</th>
                        </tr>
                    </table>
                @endif
            </div>
        </div>
        <div class="card-body">
            @if( ! ($tes->waktu_mulai ?? false) )
                <span class="text-red text-bold">*Tes hanya dapat dilakukan sekali, ketika tes dimulai, menu lain tidak bisa diakses hingga tes diselesaikan!.
                    <br>Uji coba dapat dilakukan pada menu simulasi tes</span>
                <br>
                <a href="{{ route('mulai_tes') }}" class="btn btn-primary btn-sm">Mulai Tes</a>
            @elseif($tes->waktu_mulai->addMinutes($pengaturan->durasi_menit)->greaterThan(now()) && ! $tes->waktu_selesai)
                <div style="padding-top:20px" class="d-lg-none sticky-top float-right">
                    <a href="#menu-soal" class="btn btn-sm btn-info " data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i> Menu Soal</a>
                </div>
                <ul class="nav nav-tabs" style="display: none" id="soalTab" role="tablist">
                    @foreach($soal as $key => $itemSoal)
                        @php
                            $tier_soal_terjawab_semua = (optional($tes->jawaban_siswa->get($itemSoal->id))->jawaban_id ? true : false)
                                && (in_array(optional($tes->jawaban_siswa->get($itemSoal->id))->is_jawaban_yakin, ['0', '1']) ? true : false)
                                && (optional($tes->jawaban_siswa->get($itemSoal->id))->alasan_jawaban_soal_id ? true : false)
                                && (in_array(optional($tes->jawaban_siswa->get($itemSoal->id))->is_alasan_yakin, ['0', '1']) ? true : false)
                                && (optional($tes->jawaban_siswa->get($itemSoal->id))->tier_five ? true : false);
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link soal-tab {{ $tier_soal_terjawab_semua ? 'bg-success' : '' }}" id="soal-tab-{{$key+1}}" data-toggle="tab" href="#soal-{{$key+1}}" role="tab" aria-controls="soal-{{$key+1}}" aria-selected="false">{{$key+1}}</a>
                        </li>
                    @endforeach
                    <li class="nav-item ml-3 mb-2">
                        <form action="{{ route('selesai_tes') }}" method="POST" id="selesai_tes_form">
                            @csrf
                            <button class="nav-link bg-secondary btn" id="btn_akhir_tes" type="submit">Akhiri Tes</button>
                        </form>
                    </li>
                </ul>
                <style>
                    .jawaban_radio{
                        position: relative;
                        height: 20px;
                        margin: 5px;
                    }
                    .tox{
                        width: max-content;
                    }
                    .teks{
                        width: 100%;
                        overflow: auto;
                        height: auto;
                    }
                    label{
                        /* margin:0; */
                    }
                    .hide-xs: {display: block};
                    @media(min-width: 576px){
                        .hide-xs{
                            display: none;
                        }
                    }
                    @media(min-width: 768px){
                    }
                </style>
                <div class="row" style="padding: 0 20px">
                    <div class="col-xs-12">
                        <div class="tab-content">
                            @foreach($soal as $key => $itemSoal)
                                <div class="tab-pane font-weight-bold" data-nomor="{{$key+1}}" id="soal-{{$key+1}}" role="tabpanel" aria-labelledby="soal-{{$key+1}}">
                                    <span class="mr-5">
                                        No Soal : {{ $key+1 }}
                                        <input type="hidden" name="urutan_soal_tes" class="urutan_soal_tes" value="{{ $key+1 }}">
                                    </span>
                                    <div class="teks mt-3 mb-2">{!! $itemSoal->teks !!}</div>
                                    @foreach($itemSoal->jawaban as $itemJawaban)
                                        <label for="jawaban_{{ $itemJawaban->id }}" class="d-flex teks">
                                            <input type="radio" name="jawaban_{{ $itemSoal->id }}" class="jawaban_radio jawaban" data-soal="{{ $itemSoal->id }}" id="jawaban_{{ $itemJawaban->id }}" value="{{ $itemJawaban->id }}" {{ (optional($tes->jawaban_siswa->get($itemSoal->id))->jawaban_id . '' === '' . $itemJawaban->id) ? 'checked' : '' }}>
                                            {!! $itemJawaban->teks !!}
                                        </label>
                                    @endforeach
                                    Tingkat Keyakinan Jawaban :
                                    <div>
                                        <input type="radio" name="is_jawaban_yakin_{{ $itemSoal->id }}" class="is_jawaban_yakin" data-soal="{{ $itemSoal->id }}" id="is_jawaban_yakin_1_{{ $itemSoal->id }}" value="1" {{ (optional($tes->jawaban_siswa->get($itemSoal->id))->is_jawaban_yakin . '' === '1') ? 'checked' : '' }}>
                                        <label for="is_jawaban_yakin_1_{{ $itemSoal->id }}" class="jawaban_radio">Yakin</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="is_jawaban_yakin_{{ $itemSoal->id }}" class="is_jawaban_yakin" data-soal="{{ $itemSoal->id }}" id="is_jawaban_yakin_0_{{ $itemSoal->id }}" value="0" {{ (optional($tes->jawaban_siswa->get($itemSoal->id))->is_jawaban_yakin . '' === '0') ? 'checked' : '' }}>
                                        <label for="is_jawaban_yakin_0_{{ $itemSoal->id }}" class="jawaban_radio">Tidak Yakin</label>
                                    </div>
                                    <div class="teks mt-3 mb-2">Alasan :</div>
                                    @foreach($itemSoal->alasanJawaban as $itemAlasanJawaban)
                                        <label for="alasan_jawaban_{{ $itemAlasanJawaban->id }}" class="d-flex teks">
                                            <input type="radio" class="jawaban_radio alasan_jawaban" data-soal="{{ $itemSoal->id }}" name="alasan_jawaban_{{ $itemSoal->id }}" id="alasan_jawaban_{{ $itemAlasanJawaban->id }}" value="{{ $itemAlasanJawaban->id }}" {{ (optional($tes->jawaban_siswa->get($itemSoal->id))->alasan_jawaban_soal_id . '' === '' . $itemAlasanJawaban->id) ? 'checked' : '' }}>
                                            {!! $itemAlasanJawaban->teks !!}
                                        </label>
                                    @endforeach
                                    Tingkat Keyakinan Alasan :
                                    <div>
                                        <input type="radio" name="is_alasan_yakin_{{ $itemSoal->id }}" class="is_alasan_yakin" data-soal="{{ $itemSoal->id }}" id="is_alasan_yakin_1_{{ $itemSoal->id }}" value="1" {{ (optional($tes->jawaban_siswa->get($itemSoal->id))->is_alasan_yakin . '' === '1') ? 'checked' : '' }}>
                                        <label for="is_alasan_yakin_1_{{ $itemSoal->id }}" class="jawaban_radio">Yakin</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="is_alasan_yakin_{{ $itemSoal->id }}" class="is_alasan_yakin" data-soal="{{ $itemSoal->id }}" id="is_alasan_yakin_0_{{ $itemSoal->id }}" value="0" {{ (optional($tes->jawaban_siswa->get($itemSoal->id))->is_alasan_yakin . '' === '0') ? 'checked' : '' }}>
                                        <label for="is_alasan_yakin_0_{{ $itemSoal->id }}" class="jawaban_radio">Tidak Yakin</label>
                                    </div>
                                    <div class="teks mt-3">Saya menentukan jawaban dan alasan berdasarkan</div>
                                    @foreach(\App\Enums\TierFiveEnums::SEMUA as $itemTierFive)
                                        <div>
                                            <input type="radio" name="tier_five_{{ $itemSoal->id }}" class="tier_five" data-soal="{{ $itemSoal->id }}" id="tier_five_{{ $itemTierFive['id'] }}_{{ $itemSoal->id }}" value="{{ $itemTierFive['id'] }}" {{ (optional($tes->jawaban_siswa->get($itemSoal->id))->tier_five === $itemTierFive['id']) ? 'checked' : '' }}>
                                            <label for="tier_five_{{ $itemTierFive['id'] }}_{{ $itemSoal->id }}" class="jawaban_radio">{{ $itemTierFive['text'] }}</label>
                                        </div>
                                    @endforeach
                                    <br>
                                    @if ($loop->first)
                                        <button class="btn btn-sm btn-primary ganti-tab" data-tab="soal-tab-{{$loop->index + 2}}">Selanjutnya</button>
                                    @elseif ($loop->last)
                                        <button class="btn btn-sm btn-primary ganti-tab" data-tab="soal-tab-{{$loop->index}}">Sebelumnya</button>
                                        <button class="btn btn-sm btn-secondary" id="akhiri_tes">Akhiri Tes</button>
                                        {{-- This is the last iteration --}}
                                    @else
                                        <button class="btn btn-sm btn-primary ganti-tab" data-tab="soal-tab-{{$loop->index}}">Sebelumnya</button>
                                        <button class="btn btn-sm btn-primary ganti-tab" data-tab="soal-tab-{{$loop->index + 2}}">Selanjutnya</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <h4 style="text-align: center"><b>Hasil Anda :</b></h4>
                <style>
                    #hasil tr th:nth-child(2){
                        text-align: center;
                    }
                    #hasil tr th:nth-child(1){
                        text-align: right;
                    }
                </style>
                <table style="width:100%" id="hasil">
                    <tr>
                        <th width = "49%">
                            Total Jawaban Tidak Paham Konsep
                        </th>
                        <th>:</th>
                        <th width = "49%">{{ $tes->rekapTesSiswa->{'jumlah_' . \App\Services\CalculationOfConceptionCriteria::CRITERIA_NU['id']} }}</th>
                    </tr>
                    <tr>
                        <th>
                            No Soal yang Tidak Paham Konsep
                        </th>
                        <th>:</th>
                        <th>{{ $tes->rekapTesSiswa->{'list_' . \App\Services\CalculationOfConceptionCriteria::CRITERIA_NU['id']} }}</th>
                    </tr>
                    <tr>
                        <th>
                            Total Jawaban Miskonsepsi
                        </th>
                        <th>:</th>
                        <th>{{ $tes->rekapTesSiswa->{'jumlah_' . \App\Services\CalculationOfConceptionCriteria::CRITERIA_MC['id']} }}</th>
                    </tr>
                    <tr>
                        <th>
                            No Soal yang Miskonsepsi
                        </th>
                        <th>:</th>
                        <th>{{ $tes->rekapTesSiswa->{'list_' . \App\Services\CalculationOfConceptionCriteria::CRITERIA_MC['id']} }}</th>
                    </tr>
                    <tr>
                        <th>
                            Total Jawaban Paham Konsep
                        </th>
                        <th>:</th>
                        <th>{{ $tes->rekapTesSiswa->{'jumlah_' . \App\Services\CalculationOfConceptionCriteria::CRITERIA_SU['id']} }}</th>
                    </tr>
                    <tr>
                        <th>
                            No Soal yang Paham Konsep
                        </th>
                        <th>:</th>
                        <th>{{ $tes->rekapTesSiswa->{'list_' . \App\Services\CalculationOfConceptionCriteria::CRITERIA_SU['id']} }}</th>
                    </tr>
                    <tr>
                        <th>
                            Total Jawaban Paham Konsep Sebagian
                        </th>
                        <th>:</th>
                        <th>{{ $tes->rekapTesSiswa->{'jumlah_' . \App\Services\CalculationOfConceptionCriteria::CRITERIA_PU['id']} }}</th>
                    </tr>
                    <tr>
                        <th>
                            No Soal yang Paham Konsep Sebagian
                        </th>
                        <th>:</th>
                        <th>{{ $tes->rekapTesSiswa->{'list_' . \App\Services\CalculationOfConceptionCriteria::CRITERIA_PU['id']} }}</th>
                    </tr>
                </table>
            @endif

        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        @if( $tes )
            @if($tes->waktu_mulai->addMinutes($pengaturan->durasi_menit)->greaterThan(now()) && ! $tes->waktu_selesai)
                $('a[href="#menu-soal"]').on('click', function(){
                    $(window).scrollTop($('#menu-soal').offset().top);
                });

                function secondsToHms(d) {
                    d = Number(d);
                    var h = Math.floor(d / 3600);
                    var m = Math.floor(d % 3600 / 60);
                    var s = Math.floor(d % 3600 % 60);

                    var hDisplay = h > 0 ? h + (h == 1 ? " Jam " : " Jam ") : "";
                    var mDisplay = m > 0 ? m + (m == 1 ? " Menit " : " Menit ") : "";
                    var sDisplay = s > 0 ? s + (s == 1 ? " Detik" : " Detik") : "";
                    return hDisplay + mDisplay + sDisplay;
                }

                let sisa_waktu = {{ $tes->waktu_mulai->addMinutes($pengaturan->durasi_menit)->diffInSeconds() }};

                setInterval(function(){
                    let text = secondsToHms(sisa_waktu--);
                    if(text == 0){
                        $('#selesai_tes_form').append('<input type="hidden" name="force" value="1">').submit()

                    }
                    document.getElementById("sisa_waktu").innerText = "Sisa Waktu : " + text;
                }, 1000)
                $('#akhiri_tes').on('click', function(){
                    $('#btn_akhir_tes').trigger('click');
                })
                $('.ganti-tab').on('click', function(){
                    $('#' + $(this).data('tab')).trigger('click');
                    $('#sidebar-overlay').trigger('click');
                    $(window).scrollTop($('.card-header').offset().top);
               })
                $(document).on('change', '.jawaban, .is_jawaban_yakin, .alasan_jawaban, .is_alasan_yakin, .tier_five', function(e){
                    let input = $(e.target);
                    let tab_pane = input.closest('.tab-pane');
                    let urutan_soal_tes = $('.urutan_soal_tes', tab_pane).val();
                    let jawaban = $('.jawaban:checked', tab_pane).val();
                    let is_jawaban_yakin = $('.is_jawaban_yakin:checked', tab_pane).val();
                    let alasan_jawaban = $('.alasan_jawaban:checked', tab_pane).val();
                    let is_alasan_yakin = $('.is_alasan_yakin:checked', tab_pane).val();
                    let tier_five = $('.tier_five:checked', tab_pane).val();

                    let arr = {};
                    arr.urutan_soal_tes = urutan_soal_tes;
                    arr.tes_id = '{{ $tes->id }}';
                    arr.soal_id = input.data('soal');
                    arr.siswa_id = '{{ auth()->id() }}';
                    if(typeof jawaban != "undefined"){
                        arr.jawaban_id = jawaban;
                    }
                    if(typeof is_jawaban_yakin != "undefined"){
                        arr.is_jawaban_yakin = is_jawaban_yakin;
                    }
                    if(typeof alasan_jawaban != "undefined"){
                        arr.alasan_jawaban_soal_id = alasan_jawaban;
                    }
                    if(typeof is_alasan_yakin != "undefined"){
                        arr.is_alasan_yakin = is_alasan_yakin;
                    }
                    if(typeof tier_five != "undefined"){
                        arr.tier_five = tier_five;
                    }
                    console.log(input, arr, is_jawaban_yakin, alasan_jawaban, is_alasan_yakin, tier_five)

                    let cancel = false;
                    for(let i in arr){
                        if(typeof arr[i] == "undefined"){
                            cancel = true;
                            return;
                        }
                    };

                    if(cancel) return;

                    $.ajax({
                            headers: {
                                'x-csrf-token': _token
                        },
                        type: 'POST',
                        url: "{{ route('simpan_jawaban') }}",
                        data: arr,
                        dataType : 'json'
                    })
                    .done(function(response) {
                        console.log(response.jawaban_siswa);
                        if(response.status == 'success'){
                            // new Noty({text: 'Jawaban pada soal nomor ' + tab_pane.data('nomor') + ' <b>Berhasil Disimpan</b><br>' + response.belum_dijawab + ' soal belum dijawab', type: 'success',}).show();
                            //update color list
                            if(response.jawaban_siswa.tier_1 != null){
                                $('.ganti-tab[data-tab="soal-tab-'+ urutan_soal_tes +'"][data-tier="1"]').addClass('bg-success');
                            }
                            if(response.jawaban_siswa.tier_2 != null){
                                $('.ganti-tab[data-tab="soal-tab-'+ urutan_soal_tes +'"][data-tier="2"]').addClass('bg-success');
                            }
                            if(response.jawaban_siswa.tier_3 != null){
                                $('.ganti-tab[data-tab="soal-tab-'+ urutan_soal_tes +'"][data-tier="3"]').addClass('bg-success');
                            }
                            if(response.jawaban_siswa.tier_4 != null){
                                $('.ganti-tab[data-tab="soal-tab-'+ urutan_soal_tes +'"][data-tier="4"]').addClass('bg-success');
                            }
                            if(response.jawaban_siswa.tier_5 != null){
                                $('.ganti-tab[data-tab="soal-tab-'+ urutan_soal_tes +'"][data-tier="5"]').addClass('bg-success');
                            }
                            if((response.jawaban_siswa.tier_1 != null)
                                && (response.jawaban_siswa.tier_2 != null)
                                && (response.jawaban_siswa.tier_3 != null)
                                && (response.jawaban_siswa.tier_4 != null)
                                && (response.jawaban_siswa.tier_5 != null))
                            {
                                $('#soal-tab-' + tab_pane.data('nomor')).addClass('bg-success');
                            }
                        }else{
                            // new Noty({text: 'Jawaban pada soal nomor ' + tab_pane.data('nomor') + ' <b>Gagal Disimpan</b><br>' + response.belum_dijawab + ' soal belum dijawab', type: 'error',}).show();
                        }

                        //refresh halaman jika ada soal yg belum dijawab dan belum tampil
                        if($('.nav-link.bg-success', document).length == $('.soal-tab').length && response.belum_dijawab > 0){
                            window.location.reload(1);
                        }

                    }).fail(function(xhr,status,error){
                        console.log(xhr)
                        new Noty({text: error, type: 'error',}).show();
                    });
                });
            @else
            @endif
        @endif

    </script>
    <script>
        $(function () {
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                e.target // newly activated tab
                e.relatedTarget // previous active tab
                console.log(e.target.getAttribute('aria-controls'));
                // tinymce.init({
                //     selector: '#' + e.target.getAttribute('aria-controls') + ' .teks',
                //     readonly: true,
                //     menubar: '',
                //     preview_styles: true,
                //     toolbar: '',
                //     plugins: 'autoresize',
                //     relative_urls: false,
                //     remove_script_host: false,
                //     autoresize_bottom_margin: 0,
                //     toolbar_mode: 'scrolling'
                // })
            })
            $('#soalTab li:first a').tab('show');
        })
    </script>
@endpush