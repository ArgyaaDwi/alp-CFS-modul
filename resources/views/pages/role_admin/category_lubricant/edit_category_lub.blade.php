@extends('layouts.admin')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0"><b>Edit Kategori</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"> <i
                                    class="nav-icon fa-solid fa-house"></i></a></li>
                        <li class="breadcrumb-item "><a href="{{ route('admin.category.index') }}">Kategori</a></li>
                        <li class="breadcrumb-item active">Edit {{ $categories->category_name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="card mx-3">
            <div class="card-body">
                <form action="{{ route('admin.category.update', $categories->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="category_name" class="form-label">Nama Kategori</label>
                            <input type="text" value="{{ $categories->category_name }}" name="category_name"
                                class="form-control" placeholder="Masukkan Nama Kategori">
                            @error('category_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="category_description">Deskripsi Kategori</label>
                            <textarea class="form-control" id="company_address" name="category_description" rows="3"
                                placeholder="Masukkan Deskripsi Kategori">{{ $categories->category_description }}</textarea>
                            @error('category_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <a href="{{ route('admin.category.index') }}" class="btn btn-secondary"><i
                            class="fa-solid fa-chevron-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>
                        Simpan</button>
                </form>
            </div>
        </div>
    </section>
@endsection
