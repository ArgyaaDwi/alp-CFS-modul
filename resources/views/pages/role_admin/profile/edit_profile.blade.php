@extends('layouts.sales')
@push('scripts')
    <script type="text/javascript">
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
@push('styles')
    <style>
        .avatar-preview {
            width: 150px;
            height: 150px;
            position: relative;
            border-radius: 5px;
            border: 2px solid #ddd;
            background-color: #f8f9fa;
            margin-top: 15px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #imagePreview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
@endpush
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
                    <div class="card card-outline mx-1">
                        <div class="m-4">
                            <form class="form-horizontal" action="{{ route('admin.profile.update', $user->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $user->name }}" autocomplete="on">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_telephone" class="col-sm-2 col-form-label">No. Telepon</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="no_telephone" name="no_telephone"
                                            value="{{ $user->no_telephone }}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="address" name="address" autocomplete="off">{{ $user->address }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label for="profile_picture" class="col-sm-2 col-form-label">Profile</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="file" id="profile_picture" name="profile_pic"
                                            accept=".jpg,.jpeg,.png" onchange="previewImage(this)">
                                        <small class="text-muted"><i class="fas fa-info-circle"></i> (Opsional) Gunakan
                                            gambar rasio 1:1 untuk hasil yang maksimal
                                            dengan maks ukuran 1MB [JPG, JPEG, PNG]</small>
                                        <div class="avatar-preview mb-3">
                                            <div id="imagePreview">
                                                <img src="{{ $user->profile_pic ? asset('storage/profile_pic/' . $user->profile_pic) : asset('path/to/default.jpg') }}"
                                                     alt="Preview">
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
