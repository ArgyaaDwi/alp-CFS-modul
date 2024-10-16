@extends('layouts.admin')
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#category_lubricant_id').select2({
                placeholder: ".:: Pilih Kategori ::.",
                allowClear: true
            });
            $('#sub_category_lubricant_id').select2({
                placeholder: ".:: Pilih Sub Kategori ::.",
                allowClear: true
            });
            $('#category_lubricant_id').on('change', function() {
                var categoryId = $(this).val();
                $('#sub_category_lubricant_id').empty().append(
                    '<option value="">.:: Pilih Sub Kategori ::.</option>'
                );
                if (categoryId) {
                    $('#sub_category_lubricant_id').empty().append('<option value="">Memuat...</option>');
                    $.ajax({
                        url: '/get-subcategory/' + categoryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#sub_category_lubricant_id').empty();
                            if (data.length > 0) {
                                $.each(data, function(key, value) {
                                    $('#sub_category_lubricant_id').append(
                                        '<option value="' + value.id + '">' + value
                                        .sub_category_name + '</option>'
                                    );
                                });
                            } else {
                                $('#sub_category_lubricant_id').append(
                                    '<option value="">Sub Kategori tidak tersedia</option>'
                                );
                            }
                            $('#sub_category_lubricant_id').trigger(
                                'change');
                        },
                        error: function(xhr, status, error) {
                            console.log("Error: " + error);
                            $('#sub_category_lubricant_id').empty().append(
                                '<option value="">Terjadi kesalahan, coba lagi</option>'
                            );
                        }
                    });
                } else {
                    $('#sub_category_lubricant_id').empty().append(
                        '<option value="">Pilih Kategori terlebih dahulu</option>'
                    );
                }
            });
            // $('#category_lubricant_id').trigger('change');
        });
    </script>
    <script type="text/javascript">
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(700);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
@push('styles')
    <style>
        .avatar-preview {
            width: 150px;
            height: 200px;
            position: relative;
            border-radius: 5px;
            border: 2px solid #ddd;
            background-color: #f8f9fa;
            margin-top: 15px;
            overflow: hidden;
        }

        #imagePreview {
            width: 100%;
            height: 100%;
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat;
            display: block;
        }

        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
        }

        .select2-container--default .select2-selection--single {
            text-align: center;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-results__option {
            text-align: left;
        }
    </style>
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><b>Edit Produk</b></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"><i
                                    class="nav-icon fa-solid fa-house"></i></a></li>
                        <li class="breadcrumb-item "><a href="{{ route('admin.product.index') }}">Produk</a></li>
                        <li class="breadcrumb-item active">Edit Produk {{ $products->product_name }} </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="card mx-2">
            <div class="card-body">
                <form action="{{ route('admin.product.update', $products->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Nama Produk</label>
                        <input type="text" value="{{ $products->product_name }}" name="product_name" class="form-control"
                            placeholder="Masukkan Nama Produk">
                        @error('product_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category_lubricant_id " class="form-label">Kategori</label>
                            <select class="form-control" id="category_lubricant_id" name="category_lubricant_id">
                                <option value="" class="text-center">.:: Pilih kategori ::.</option>
                                @forelse ($categoryLubricants as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $products->category_lubricant_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->category_name }}</option>
                                @empty
                                    <option value="">Kategori tidak tersedia</option>
                                @endforelse
                            </select>
                            @error('category_lubricant_id ')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="sub_category_lubricant_id " class="form-label">Sub Kategori</label>
                            <select class="form-control" id="sub_category_lubricant_id" name="sub_category_lubricant_id">
                                <option value="" class="text-center">.:: Pilih Sub Kategori ::.</option>
                                @forelse ($subCategoryLubricants as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $products->sub_category_lubricant_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->sub_category_name }}</option>
                                @empty
                                    <option value="">Sub Kategori tidak tersedia</option>
                                @endforelse
                            </select>
                            <small>
                                <i class="fas fa-info-circle"></i> Pilih kategori terlebih dahulu untuk menampilkan sub
                                kategori sesuai dengan kategori
                            </small>
                            @error('sub_category_lubricant_id ')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        {{-- <div class="col-md-6">
                            <label for="sub_category_lubricant_id" class="form-label">Sub Kategori</label>
                            <select class="form-control" id="sub_category_lubricant_id" name="sub_category_lubricant_id">
                                <option value="">.:: Pilih Sub Kategori ::.</option>
                            </select>
                            @error('sub_category_lubricant_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> --}}
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="product_price" class="form-label">Harga Produk</label>
                            <input type="number" value="{{ $products->product_price }}" name="product_price"
                                class="form-control" placeholder="Masukkan Harga Produk">
                            @error('product_price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="product_description">Deskripsi Produk</label>
                            <textarea class="form-control" id="product_description" name="product_description" rows="3"
                                placeholder="Masukkan Deskripsi Produk">{{ $products->product_description }}    </textarea>
                        </div>
                        @error('product_description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="product_image" class="form-label">Gambar Produk</label>
                    </div>
                    <div class="form-group">
                        @if ($products->product_image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/product_image/' . $products->product_image) }}"
                                    alt="Gambar Sampul" style="width: 150px; height: 200px;">
                            </div>
                        @endif
                        <input class="form-control" type="file" id="product_image" name="product_image"
                            accept=".jpg,.jpeg,.png" onchange="previewImage(this)">
                            @error('product_image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        <small></small><i class="fas fa-info-circle"></i> Jika ingin mengganti gambar, pilih gambar baru
                        dengan maks ukuran 2MB [JPG, JPEG, PNG] .
                    </div>
                    <div class="form-group">
                        <div class="avatar-preview mb-1">
                            <div id="imagePreview"></div>
                        </div>
                        <small><span style="color: red">*</span> Preview</small>
                    </div>
                    <a href="{{ route('admin.product.index') }}" class="btn btn-secondary"><i
                            class="fa-solid fa-chevron-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>
                        Simpan</button>
                </form>
            </div>
        </div>
    </section>
@endsection
