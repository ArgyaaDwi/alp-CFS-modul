@extends('layouts.sales')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! session('success') !!}
                    </div>
                @endif
                <div class="col-sm-6">
                    <h4 class="m-0"><b>Halaman Profil</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"> <i
                                    class="nav-icon fa-solid fa-house"></i>
                            </a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.profile') }}"> Halaman Profil
                            </a></li>
                        <li class="breadcrumb-item active">Update Profil</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-13 mb-4">
                    <div class="card  card-outline mx-1">
                        <div class="m-4">
                            <form class="form-horizontal" action="{{ route('admin.profile.update', $user->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName" name="name"
                                            value="{{ $user->name }}" autocomplete="on">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">No. Telepon</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName2" name="no_telephone"
                                            value="{{ $user->no_telephone }}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience" name="address" autocomplete="off">{{ $user->address }}</textarea>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 col-form-label">Foto Profile</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="inputSkills" name="profile_pic">
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <a href="{{ route('admin.profile') }}" class="btn btn-secondary"><i
                                                class="fa-solid fa-chevron-left"></i> Kembali</a>
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fa-solid fa-floppy-disk"></i>
                                            Simpan</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
