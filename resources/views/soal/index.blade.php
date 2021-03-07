@extends('layouts.backend')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Soal</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Soal</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('soal.create') }}" class="btn btn-primary">Tambah</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{ $all_soal->withQueryString()->links() }}
                <table class=" table table-bordered table-striped table-hover datatable" style="width: 100%">
                    <thead>
                        <tr>
                            <th width="10">&nbsp;</th>
                            <th>Text</th>
                            <th>Jumlah Jawaban</th>
                            <th>is_aktif</th>
                            <th class="no-print" style="width:100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($all_soal as $key => $item)
                            <tr data-entry-id="{{ $item->id }}">
                                <td>{{ $item->id }}</td>
                                <td>{{ Str::limit($item->teks ?? '', 20) }} ...</td>
                                <td>{{ $item->jawaban_count }}</td>
                                <td>{{ $item->is_aktif ? 'Ya' : 'Tidak' }}</td>
                                <td class="no-print">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('soal.edit', $item->id) }}">Ubah</a>
                                            <a class="dropdown-item deleteBtn" href="#" data-id="{{ $item->id }}">Hapus</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Tidak ada soal</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $all_soal->withQueryString()->links() }}
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
                    form.attr('action', "{{ url('soal') }}/" + $(e.target).closest('.deleteBtn').data('id'))
                    form.attr('method', "POST")
                    form.append(`@method('DELETE')`)
                    form.append(`@csrf`)
                    form.submit()
                }
            })
        })
    </script>
@endpush
