@extends('layouts.backend')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ trans('global.settings') }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">{{ trans('global.settings') }}</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Profil</a></li>
                        <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Ganti Password</a></li>
                        @if(\Auth::user()->is_admin)
                            <li class="nav-item"><a class="nav-link" href="#durasi-tes" data-toggle="tab">Durasi Tes</a></li>
                        @endif
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal" action="{{ route('update_profile') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', \Auth::user()->name) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email', \Auth::user()->email) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Kelas" value="{{ old('kelas', \Auth::user()->kelas) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="password">
                            <form class="form-horizontal" action="{{ route('update_password') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">{{ trans('global.login_password_confirmation') }}</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password_confirmation" class="form-control" required placeholder="{{ trans('global.login_password_confirmation') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if(\Auth::user()->is_admin)
                            <div class="tab-pane" id="durasi-tes">
                                <form class="form-horizontal" action="{{ route('update_durasi_tes') }}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="durasi_menit" class="col-sm-2 col-form-label">Durasi Tes (Menit)</label>
                                        <div class="col-sm-10">
                                            <input type="number" min="0" max="3600" name="durasi_menit" class="form-control {{ $errors->has('durasi_menit') ? ' is-invalid' : '' }}" required value="{{ old('durasi_menit', $pengaturan->durasi_menit ?? 0) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="durasi_menit" class="col-sm-2 col-form-label">Durasi Simulasi (Menit)</label>
                                        <div class="col-sm-10">
                                            <input type="number" min="0" max="3600" name="durasi_menit_simulasi" class="form-control {{ $errors->has('durasi_menit_simulasi') ? ' is-invalid' : '' }}" required value="{{ old('durasi_menit_simulasi', $pengaturan->durasi_menit_simulasi ?? 0) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Kirim</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                        <!-- /.tab-pane -->
                    </div>
                <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>
@endsection
