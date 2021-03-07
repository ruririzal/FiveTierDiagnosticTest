@extends('layouts.backend')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Siswa</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Siswa</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <a href="{{ route('download_tes')}}" class="btn btn-sm btn-success mb-3" target="_blank">Download Tes</a>
                {{ $all_siswa->withQueryString()->links() }}
                <table class="table table-bordered table-striped table-hover datatable" style="width: 100%">
                    <thead>
                        <tr>
                            <th width="10" rowspan="2">&nbsp;</th>
                            <th rowspan="2">Email</th>
                            <th rowspan="2">Nama</th>
                            <th rowspan="2">Kelas</th>
                            <th rowspan="2">Waktu Tes</th>
                            <th rowspan="2">Tidak Dijawab</th>
                            @foreach(\App\Services\CalculationOfConceptionCriteria::ALL_CRITERIA as $item)
                                @if($item['id'] == \App\Services\CalculationOfConceptionCriteria::CRITERIA_MC['id'])
                                    <th colspan="{{ count(\App\Enums\TierFiveEnums::SEMUA) + 1 }}">{{ $item['text'] }}</th>
                                @else
                                    <th rowspan="2">{{ $item['text'] }}</th>
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            @foreach(\App\Enums\TierFiveEnums::SEMUA as $item)
                                <th>{{ strtoupper(\App\Services\CalculationOfConceptionCriteria::CRITERIA_MC['id'] . '-' . $item['conception_code']) }}</th>
                            @endforeach
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($all_siswa as $key => $itemSiswa)
                            <tr data-entry-id="{{ $itemSiswa->id }}">
                                <td>{{ $itemSiswa->id }}</td>
                                <td>{{ $itemSiswa->email }}</td>
                                <td>{{ $itemSiswa->name }}</td>
                                <td>{{ $itemSiswa->kelas }}</td>
                                @if($itemSiswa->tes)
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="{{ $itemSiswa->tes->waktu_mulai . ' s.d ' . $itemSiswa->tes->waktu_selesai }}">
                                            Cek
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="{{ $itemSiswa->tes->id }}">Hapus</button>
                                    </td>
                                    <td>{{ optional($itemSiswa->tes->rekapTesSiswa)->jumlah_tidak_dijawab }}</td>
                                @else
                                    <td></td>
                                    <td></td>
                                @endif
                                @foreach(\App\Services\CalculationOfConceptionCriteria::ALL_CRITERIA as $item)
                                    @if($item['id'] == \App\Services\CalculationOfConceptionCriteria::CRITERIA_MC['id'])
                                        @foreach(\App\Enums\TierFiveEnums::SEMUA_CAMELCASE() as $tier_five)
                                            @if($itemSiswa->tes)
                                                <td>{{ optional($itemSiswa->tes->rekapTesSiswa)->{'jumlah_' . $item['id'] . '_' . $tier_five} }}</td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if($itemSiswa->tes)
                                        <td>{{ optional($itemSiswa->tes->rekapTesSiswa)->{'jumlah_' . $item['id']} }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 6 + count(\App\Services\CalculationOfConceptionCriteria::ALL_CRITERIA) + count(\App\Enums\TierFiveEnums::SEMUA) }}">Tidak ada siswa</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $all_siswa->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $(document).on('click', '.deleteBtn', function(e){
                if(confirm('Hapus data ini?')){
                    let form = $('<form></form>');
                    $('body').append(form);
                    form.attr('action', "{{ url('siswa') }}/" + $(e.target).closest('.deleteBtn').data('id'))
                    form.attr('method', "POST")
                    form.append(`@method('DELETE')`)
                    form.append(`@csrf`)
                    form.submit()
                }
            })
        })
</script>
@endpush
