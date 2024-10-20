@extends('layouts.admin')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><b>Tambah Sub Kategori</b></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"> <i
                                    class="nav-icon fa-solid fa-house"></i></a></li>
                        <li class="breadcrumb-item "><a href="{{ route('admin.subcategory.index') }}">Sub Kategori</a></li>
                        <li class="breadcrumb-item active">Tambah Sub Kategori</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="card mx-2">
            <div class="card-body">
                <form action="{{ route('admin.subcategory.save') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category_lubricant_id" class="form-label">Kategori</label>
                            <select class="form-control" id="category_lubricant_id" name="category_lubricant_id">
                                <option value="" class="text-center">.:: Pilih Kategori Pelumas ::.</option>
                                @forelse ($categoryLubricants as $item)
                                    <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                @empty
                                    <option value="">Kategori Pelumas tidak tersedia</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sub_category_name" class="form-label">Nama Sub Kategori</label>
                                <input type="text" value="{{ old('sub_category_name') }}" name="sub_category_name"
                                    class="form-control" placeholder="Masukkan Nama Sub Kategori">
                                @error('sub_category_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="sub_category_description">Deskripsi Kategori</label>
                            <textarea class="form-control" id="sub_category_description" name="sub_category_description" rows="3"
                                placeholder="Masukkan Deskripsi Sub Kategori">{{ old('sub_category_description') }}</textarea>
                            @error('sub_category_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <a href="{{ route('admin.subcategory.index') }}" class="btn btn-secondary"><i
                            class="fa-solid fa-chevron-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>
                        Simpan</button>
                </form>
            </div>
        </div>
    </section>
@endsection
