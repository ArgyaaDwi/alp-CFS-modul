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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                    <h4 class="m-0"><b>Edit Aduan</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.sales') }}"><i
                                    class="nav-icon fa-solid fa-house"></i></a></li>
                        <li class="breadcrumb-item "><a href="{{ route('sales.complaint.index') }}">Aduan</a></li>
                        <li class="breadcrumb-item active">Edit Aduan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="card mx-3">
            <div class="card-body">
                <form action="{{ route('sales.complaint.update', $complaint->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id_distributor" class="form-label">Nama Distributor</label>
                            <select class="form-control" id="id_distributor" name="distributor_id">
                                <option value="" class="text-center">.:: Pilih Distributor ::.</option>
                                @forelse ($distributors as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $complaint->distributor_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->company_name }}</option>
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
                            <input type="text" name="batch_number" class="form-control"
                                value="{{ $complaint->batch_number }}">
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
                                        <input class="form-check-input" type="checkbox" name="complaint_category_ids[]"
                                            id="category_{{ $category->id }}" value="{{ $category->id }}"
                                            {{ in_array($category->id, $selectedCategoryIds) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                            {{ $category->category_name }}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="complaint_category_ids[]"
                                    id="category_other" value="4" onclick="toggleOtherInput()"
                                    {{ in_array(4, $selectedCategoryIds) ? 'checked' : '' }}>
                                <label class="form-check-label" for="category_other">Lainnya</label>
                            </div>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Anda bisa memilih lebih dari 1
                            kategori</small>
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
                            <textarea class="form-control" id="address" name="complaint_title" rows="2">{{ $complaint->complaint_title }}</textarea>
                            @error('complaint_title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="complaint_description">Deskripsi Masalah</label>
                            <textarea class="form-control" id="address" name="complaint_description" rows="5">{{ $complaint->complaint_description }}</textarea>
                            @error('complaint_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="complaint_hopeful_solution">Harapan</label>
                            <textarea class="form-control" id="address" name="complaint_hopeful_solution" rows="3">{{ $complaint->complaint_hopeful_solution }}</textarea>
                            @error('complaint_hopeful_solution')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="supporting_url">URL Pendukung</label>
                            <input type="url" class="form-control" id="supporting_url" name="supporting_url"
                                value="{{ $complaint->supporting_url }}" autocomplete="off">
                            <small class="text-muted"><i class="fas fa-info-circle"></i> (Opsional) Masukkan URL pendukung
                                apabila ada</small></small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="supporting_document" class="form-label">Dokumen Pendukung (PDF)</label>
                        @if ($complaint->supporting_document)
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $complaint->supporting_document) }}" target="_blank">
                                    <i class="fa-regular fa-eye"></i> Lihat Dokumen Pendukung
                                </a>
                            </div>
                        @endif
                        <input class="form-control" type="file" id="supporting_document" name="supporting_document"
                            accept=".pdf">
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Pilih dokumen pendukung baru jika
                            ingin memperbarui</small>
                        @error('supporting_document')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="files" class="form-label">Bukti Foto</label>
                        <input class="form-control" type="file" id="files" name="files[]" multiple
                            accept="image/*">
                        @foreach ($complaint->files as $file)
                            @if (Str::endsWith($file->file_path, ['.jpg', '.jpeg', '.png', '.gif']))
                                <img src="{{ asset('storage/' . $file->file_path) }}" alt="Bukti Foto" width="150"
                                    style="cursor: pointer;"
                                    onclick="showImageModal('{{ asset('storage/' . $file->file_path) }}')">
                            @elseif (Str::endsWith($file->file_path, ['.mp4', '.mov', '.avi']))
                                <video width="320" height="240" controls>
                                    <source src="{{ asset('storage/' . $file->file_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        @endforeach
                    </div>
                    <small class="text-muted"><i class="fas fa-info-circle"></i> Upload gambar baru jika ingin
                        mengganti</small><br><br>
                    <a href="{{ route('sales.complaint.index') }}" class="btn btn-secondary"><i
                            class="fa-solid fa-chevron-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>
                        Simpan</button>
                </form>
            </div>
        </div>
    </section>
@endsection
