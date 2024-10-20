@extends('layouts.sales')
@push('scripts')
    <script type="text/javascript">
        function previewImages() {
            var previewContainer = document.getElementById('imagePreviewContainer');
            previewContainer.innerHTML = '';
            var files = document.getElementById('images').files;
            if (files) {
                for (let i = 0; i < files.length; i++) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let imagePreview = document.createElement('div');
                        imagePreview.classList.add('image-preview');
                        imagePreview.style.backgroundImage = 'url(' + e.target.result + ')';
                        previewContainer.appendChild(imagePreview);
                    }
                    reader.readAsDataURL(files[i]);
                }
            }
        }
        let fileArray = [];
        function addImages() {
            let files = document.getElementById('images').files;
            let previewContainer = document.getElementById('imagePreviewContainer');
            for (let i = 0; i < files.length; i++) {
                fileArray.push(files[i]);
            }
            previewContainer.innerHTML = '';
            fileArray.forEach((file, index) => {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let imagePreview = document.createElement('div');
                    imagePreview.classList.add('image-preview');
                    imagePreview.style.backgroundImage = 'url(' + e.target.result + ')';
                    imagePreview.style.width = '150px';
                    imagePreview.style.height = '250px';
                    imagePreview.style.margin = '10px';
                    imagePreview.style.backgroundSize = 'contain';
                    imagePreview.style.backgroundPosition = 'center';
                    previewContainer.appendChild(imagePreview);
                }
                reader.readAsDataURL(file);
            });
        }
        function toggleOtherInput() {
            const otherCheckbox = document.getElementById('category_other');
            const otherCategoryContainer = document.getElementById('otherCategoryContainer');
            if (otherCheckbox.checked) {
                otherCategoryContainer.style.display = 'block';
            } else {
                otherCategoryContainer.style.display = 'none';
                document.getElementById('other_category').value = '';
            }
        }
        $(document).ready(function() {
            $('#id_distributor').select2({
                placeholder: ".:: Pilih Distributor ::.",
                allowClear: true
            });
        });
        $(document).ready(function() {
            $('#role_id').select2({
                placeholder: ".:: Pilih Role ::.",
                allowClear: true
            });
        });
    </script>
    <script script script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
@push('styles')
    <style>
        .image-preview {
            display: inline-block;
            width: 150px;
            height: 150px;
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat;
            border: 2px solid #ddd;
            margin-right: 10px;
            margin-bottom: 10px;
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
                    <h4 class="m-0"><b>Buat Aduan</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.sales') }}"><i
                                    class="nav-icon fa-solid fa-house"></i></a></li>
                        <li class="breadcrumb-item "><a href="{{ route('sales.complaint.index') }}">Aduan</a></li>
                        <li class="breadcrumb-item active">Buat Aduan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="card mx-3">
            <div class="card-body">
                <form action="{{ route('sales.complaint.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id_distributor" class="form-label">Nama Distributor</label>
                            <select class="form-control" id="id_distributor" name="distributor_id">
                                <option value="" class="text-center">.:: Pilih Distributor ::.</option>
                                @forelse ($distributors as $item)
                                    <option value="{{ $item->id }}">{{ $item->company_name }}</option>
                                @empty
                                    <option value="">Distributor tidak tersedia</option>
                                @endforelse
                            </select>
                            @error('distributor_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="batch_number" class="form-label">Batch</label>
                            <input type="text" value="{{ old('batch_number') }}" name="batch_number" class="form-control"
                                placeholder="Masukkan Nomor Batch">
                            @error('batch_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori Aduan</label>
                        <div class="d-flex flex-wrap gap-5">
                            @foreach ($categoryComplaints as $category)
                                @if ($category->id != 4)
                                    <div class="form-check me-3">
                                        <input class="form-check-input " type="checkbox" name="complaint_category_ids[]"
                                            id="category_{{ $category->id }}" value="{{ $category->id }}">
                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                            {{ $category->category_name }}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="complaint_category_ids[]"
                                    id="category_other" value="4" onclick="toggleOtherInput()">
                                <label class="form-check-label" for="category_other">Lainnya</label>
                            </div>
                        </div>
                        <i class="fas fa-info-circle"></i> Anda bisa memilih lebih dari 1 kategori
                        @error('complaint_category_ids')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3" id="otherCategoryContainer" style="display: none;">
                        <label for="other_category" class="form-label">Kategori Lainnya</label>
                        <textarea class="form-control" id="other_category" name="other_category_name" rows="3"
                            placeholder="Masukkan kategori lainnya..."></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="complaint_title">Judul Masalah</label>
                            <textarea class="form-control" id="address" name="complaint_title" rows="2"
                                placeholder="Masukkan Deskripsi Masalah">{{ old('complaint_title') }}</textarea>
                            @error('complaint_title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="complaint_description">Deskripsi Masalah</label>
                            <textarea class="form-control" id="address" name="complaint_description" rows="5"
                                placeholder="Masukkan Deskripsi Masalah">{{ old('complaint_description') }}</textarea>
                            @error('complaint_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="complaint_hopeful_solution">Harapan</label>
                            <textarea class="form-control" id="address" name="complaint_hopeful_solution" rows="3"
                                placeholder="Masukkan Harapan Solusi">{{ old('complaint_hopeful_solution') }}</textarea>
                            @error('complaint_hopeful_solution')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="images" class="form-label">Bukti Foto</label>
                        <input class="form-control" type="file" id="images" multiple accept=".jpg,.jpeg,.png"
                            onchange="addImages()">
                        <i class="fas fa-info-circle"></i> (Opsional) Gunakan gambar rasio 1:1 untuk hasil yang maksimal
                        dengan maks ukuran 1MB [JPG, JPEG, PNG].
                    </div>
                    <div class="avatar-preview mb-3" id="imagePreviewContainer"></div> --}}
                    <div class="mb-3">
                        <label for="supporting_document" class="form-label">Dokumen Pendukung (PDF)</label>
                        <input class="form-control" type="file" id="supporting_document" name="supporting_document"
                            accept=".pdf">
                        <i class="fas fa-info-circle"></i> (Opsional) Hanya file PDF yang diperbolehkan.
                        @error('supporting_document')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="files" class="form-label">Bukti Foto</label>
                        <input class="form-control" type="file" id="files" name="files[]" multiple
                            accept="image/*">
                        {{-- <i class="fas fa-info-circle"></i> (Opsional) Gunakan gambar rasio 1:1 untuk hasil yang maksimal
                        dengan maks ukuran 2MB [JPG, JPEG, PNG]. --}}
                    </div>
                    <a href="{{ route('sales.complaint.index') }}" class="btn btn-secondary"><i
                            class="fa-solid fa-chevron-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                </form>
            </div>
        </div>
    </section>
@endsection
