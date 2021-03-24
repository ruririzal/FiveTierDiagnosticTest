@extends('layouts.backend')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tambah Soal</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('soal.index') }}">Soal</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('soal.store') }}" method="POST">
                        @csrf 
                        <h3>Soal</h3>
                        <div class="form-group row mb-0">
                            <label for="is_aktif" class="col-sm-2 col-form-label">is_aktif</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="is_aktif" value='0'>
                                <input type="checkbox" id="is_aktif" value="1" name="is_aktif" {{ old('is_aktif', '1') == '1' ? 'checked' : ''}} data-bootstrap-switch data-off-color="warning" data-on-color="success" data-on-text="Yes" data-off-text="No">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="teks" class="col-form-label">Teks</label>
                            <textarea class="form-control teks {{ $errors->has('teks') ? 'is-invalid' : '' }}" name="teks">{{ old('teks', '') }}</textarea>
                        </div>
                        <h3 class="mt-5">Jawaban</h3>
                        <table class="table table-bordered table-striped table-hover" id="jawaban_tabel" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Teks</th>
                                    <th>is_benar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $jawaban_teks = old('jawaban_teks', []); @endphp
                                @foreach($jawaban_teks as $key => $item)
                                <tr> 
                                    <td> 
                                        <textarea class="form-control teks" id="jawaban_teks{{ $key }}" name="jawaban_teks[{{ $key }}]">{{ old('jawaban_teks.' . $key, '') }}</textarea>
                                    </td>
                                    <td> 
                                        <input type="hidden" name="is_jawaban_benar[{{ $key }}]" value="0">
                                        <input type="checkbox" value="1" name="is_jawaban_benar[{{ $key }}]" {{ old('is_jawaban_benar.' . $key, '') == '1' ? 'checked' : ''}} data-bootstrap-switch data-off-color="warning" data-on-color="success" data-on-text="Yes" data-off-text="No">
                                    </td> 
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <button type="button" class="btn btn-primary" id="tambah_jawaban">Tambah Jawaban</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <h3 class="mt-5">Alasan Jawaban</h3>
                        <table class="table table-bordered table-striped table-hover" id="alasan_tabel" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Teks</th>
                                    <th>is_benar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $alasan_teks = old('alasan_teks', []); @endphp
                                @foreach($alasan_teks as $key => $item)
                                <tr> 
                                    <td> 
                                        <textarea class="form-control teks" id="alasan_teks{{ $key }}" name="alasan_teks[{{ $key }}]">{{ old('alasan_teks.' . $key, '') }}</textarea>
                                    </td>
                                    <td> 
                                        <input type="hidden" name="is_alasan_benar[{{ $key }}]" value="0">
                                        <input type="checkbox" value="1" name="is_alasan_benar[{{ $key }}]" {{ old('is_alasan_benar.' . $key, '') == '1' ? 'checked' : ''}} data-bootstrap-switch data-off-color="warning" data-on-color="success" data-on-text="Yes" data-off-text="No">
                                    </td> 
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <button type="button" class="btn btn-primary" id="tambah_alasan">Tambah Alasan Jawaban</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="form-group">
                            <a href="{{ route('soal.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-danger ml-5">Kirim</button>
                        </div>
                    </form>
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript">
        function example_image_upload_handler (blobInfo, success, failure, progress) {
            var xhr, formData;

            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ route('store_media') }}');

            xhr.upload.onprogress = function (e) {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = function() {
                var json;
                
                if (xhr.status === 403) {
                    failure('HTTP Error: ' + xhr.status, { remove: true });
                    return;
                }
                
                if (xhr.status < 200 || xhr.status >= 300) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            xhr.onerror = function () {
                failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            formData.append('_token', "{{ csrf_token() }}");

            xhr.send(formData);
        };

        tinymce.init({
            selector: '.teks',
            menubar: 'file edit view insert format tools table help',
            plugins: 'charmap image table hr insertdatetime lists emoticons charmap paste searchreplace',
            relative_urls: false,
            remove_script_host: false,
            automatic_uploads: true,
            protect: [
                /\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
                /\<xsl\:[^>]+\>/g,  // Protect <xsl:...>
                /<\?php.*?\?>/g,  // Protect php code
                /\<scipt>.*?\<\/scipt>/g  // Protect script
            ],
            /* without images_upload_url set, Upload tab won't show up*/
            images_upload_handler: example_image_upload_handler,
        });
        
        $(function(){
            let indexTabelJawabanRow = '{{ count($jawaban_teks) +1 }}';
            $('#tambah_jawaban').on('click',function(){
                $('#jawaban_tabel tbody').append(
                    $('<tr>' + 
                        '<td>' + 
                            '<textarea class="form-control" id="jawaban_teks' + indexTabelJawabanRow + '" name="jawaban_teks[' + indexTabelJawabanRow + ']"></textarea>'+
                        '</td>' +
                        '<td>' + 
                            '<input type="hidden" name="is_jawaban_benar[' + indexTabelJawabanRow + ']" value="0">' +
                            '<input type="checkbox" value="1" name="is_jawaban_benar[' + indexTabelJawabanRow + ']" data-bootstrap-switch data-off-color="warning" data-on-color="success" data-on-text="Yes" data-off-text="No">' +
                        '</td>' + 
                    '</tr>')
                )
                tinymce.init({
                    selector: '#jawaban_teks' + indexTabelJawabanRow,
                    menubar: 'file edit view insert format tools table help',
                    plugins: 'charmap image table hr insertdatetime lists emoticons charmap paste searchreplace',
                    relative_urls: false,
                    remove_script_host: false,
                    automatic_uploads: true,
                    protect: [
                        /\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
                        /\<xsl\:[^>]+\>/g,  // Protect <xsl:...>
                        /<\?php.*?\?>/g,  // Protect php code
                        /\<scipt>.*?\<\/scipt>/g  // Protect script
                    ],
                    /* without images_upload_url set, Upload tab won't show up*/
                    images_upload_handler: example_image_upload_handler,
                });
                $("input[data-bootstrap-switch]").each(function(){
                    $(this).bootstrapSwitch('state', $(this).prop('checked'));
                });
                indexTabelJawabanRow++;
            });
            let indexTabelAlasanRow = '{{ count($alasan_teks) +1 }}';
            $('#tambah_alasan').on('click',function(){
                $('#alasan_tabel tbody').append(
                    $('<tr>' + 
                        '<td>' + 
                            '<textarea class="form-control" id="alasan_teks' + indexTabelAlasanRow + '" name="alasan_teks[' + indexTabelAlasanRow + ']"></textarea>'+
                        '</td>' +
                        '<td>' + 
                            '<input type="hidden" name="is_alasan_benar[' + indexTabelAlasanRow + ']" value="0">' +
                            '<input type="checkbox" value="1" name="is_alasan_benar[' + indexTabelAlasanRow + ']" data-bootstrap-switch data-off-color="warning" data-on-color="success" data-on-text="Yes" data-off-text="No">' +
                        '</td>' + 
                    '</tr>')
                )
                tinymce.init({
                    selector: '#alasan_teks' + indexTabelAlasanRow,
                    menubar: 'file edit view insert format tools table help',
                    plugins: 'charmap image table hr insertdatetime lists emoticons charmap paste searchreplace',
                    relative_urls: false,
                    remove_script_host: false,
                    automatic_uploads: true,
                    protect: [
                        /\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
                        /\<xsl\:[^>]+\>/g,  // Protect <xsl:...>
                        /<\?php.*?\?>/g,  // Protect php code
                        /\<scipt>.*?\<\/scipt>/g  // Protect script
                    ],
                    /* without images_upload_url set, Upload tab won't show up*/
                    images_upload_handler: example_image_upload_handler,
                });
                $("input[data-bootstrap-switch]").each(function(){
                    $(this).bootstrapSwitch('state', $(this).prop('checked'));
                });
                indexTabelAlasanRow++;
            })
        })
    </script>
@endpush