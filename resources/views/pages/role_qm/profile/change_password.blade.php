@extends('layouts.qm')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0"><b>Halaman Ganti Password</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.qm') }}"> <i
                                    class="nav-icon fa-solid fa-house"></i>
                            </a></li>
                        <li class="breadcrumb-item"><a href="{{ route('qm.profile') }}"> Halaman Profil
                            </a></li>
                        <li class="breadcrumb-item active">Ganti Password</li>
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
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Password Lama</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" name="name"
                                            placeholder="Masukkan Password Lama">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Password Baru</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" name="name"
                                            placeholder="Masukkan Password Baru">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Konfirmasi Password Baru</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" name="name"
                                            placeholder="Masukkan Konfirmasi Password Baru">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <a href="{{ route('qm.profile') }}" class="btn btn-secondary"><i
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
