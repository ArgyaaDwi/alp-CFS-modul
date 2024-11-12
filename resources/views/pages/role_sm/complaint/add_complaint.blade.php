@extends('layouts.sales')
@push('styles')
    <style>
        .required::after {
            content: ' *';
            color: red;
        }
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
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {!! session('error') !!}
                    </div>
                @endif
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
                            <label for="id_distributor" class="form-label required">Nama Distributor</label>
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
                            <label for="batch_number" class="form-label required">Batch</label>
                            <input type="text" id="batch_number" value="{{ old('batch_number') }}" name="batch_number"
                                class="form-control" placeholder="Masukkan Nomor Batch">
                            @error('batch_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Kategori Aduan</label>
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
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Anda bisa memilih lebih dari 1
                            kategori</small>
                        @error('complaint_category_ids')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3" id="otherCategoryContainer" style="display: none;">
                        <label for="other_category" class="form-label required">Kategori Lainnya</label>
                        <textarea class="form-control" id="other_category" name="other_category_name" rows="3"
                            placeholder="Masukkan kategori lainnya..."></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="complaint_title" class="form-label required">Judul Masalah</label>
                            <textarea class="form-control " id="complaint_title" name="complaint_title" rows="2"
                                placeholder="Masukkan Deskripsi Masalah" autocomplete="off">{{ old('complaint_title') }}</textarea>
                            @error('complaint_title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="complaint_description" class="form-label required">Deskripsi Masalah</label>
                            <textarea class="form-control" id="complaint_description" name="complaint_description" rows="5"
                                placeholder="Masukkan Deskripsi Masalah" autocomplete="off">{{ old('complaint_description') }}</textarea>
                            @error('complaint_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="complaint_hopeful_solution" class="form-label required">Harapan</label>
                            <textarea class="form-control" id="complaint_hopeful_solution" name="complaint_hopeful_solution" rows="3"
                                placeholder="Masukkan Harapan Solusi" autocomplete="off">{{ old('complaint_hopeful_solution') }}</textarea>
                            @error('complaint_hopeful_solution')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="supporting_url">URL Pendukung</label>
                            <input type="url" class="form-control" id="supporting_url" name="supporting_url"
                                placeholder="Masukkan URL, contoh: https://example.com" autocomplete="on">
                            <small class="text-muted"><i class="fas fa-info-circle"></i> (Opsional) Masukkan URL pendukung
                                apabila ada</small></small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="supporting_document" class="form-label required">Dokumen Pendukung (PDF)</label>
                        <input class="form-control" type="file" id="supporting_document" name="supporting_document"
                            accept=".pdf">
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Hanya file PDF yang
                            diperbolehkan</small>
                        @error('supporting_document')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="files" class="form-label required">Bukti Foto</label>
                        <input class="form-control" type="file" id="files" name="files[]" multiple
                            accept="image/*">
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Anda bisa input banyak gambar lalu
                            drop ke form</small>
                        @error('files')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                    <a href="{{ route('sales.complaint.index') }}" class="btn btn-secondary"><i
                            class="fa-solid fa-chevron-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>
                        Simpan</button>
                </form>
                {{-- <form action="{{ route('sales.complaint.save') }}" method="POST" enctype="multipart/form-data"
                    id="complaintForm" class="needs-validation" novalidate>
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id_distributor" class="form-label required">Nama Distributor</label>
                            <select class="form-control @error('distributor_id') is-invalid @enderror" id="id_distributor"
                                name="distributor_id" required aria-describedby="distributorHelp">
                                <option value="" class="text-center">.:: Pilih Distributor ::.</option>
                                @forelse ($distributors as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('distributor_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->company_name }}
                                    </option>
                                @empty
                                    <option value="">Distributor tidak tersedia</option>
                                @endforelse
                            </select>
                            <div id="distributorHelp" class="form-text">Pilih distributor terkait komplain</div>
                            @error('distributor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="batch_number" class="form-label required">Batch</label>
                            <input type="text" id="batch_number" value="{{ old('batch_number') }}" name="batch_number"
                                class="form-control @error('batch_number') is-invalid @enderror"
                                placeholder="Masukkan Nomor Batch" required minlength="3">
                            @error('batch_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Kategori Aduan</label>
                        <div class="d-flex flex-wrap gap-5">
                            @foreach ($categoryComplaints as $category)
                                @if ($category->id != 4)
                                    <div class="form-check me-3">
                                        <input class="form-check-input category-checkbox" type="checkbox"
                                            name="complaint_category_ids[]" id="category_{{ $category->id }}"
                                            value="{{ $category->id }}"
                                            {{ in_array($category->id, old('complaint_category_ids', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                            {{ $category->category_name }}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                            <div class="form-check">
                                <input class="form-check-input category-checkbox" type="checkbox"
                                    name="complaint_category_ids[]" id="category_other" value="4"
                                    {{ in_array(4, old('complaint_category_ids', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="category_other">Lainnya</label>
                            </div>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Anda bisa memilih lebih dari 1
                            kategori</small>
                        @error('complaint_category_ids')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="otherCategoryContainer" style="display: none;">
                        <label for="other_category" class="form-label">Kategori Lainnya</label>
                        <textarea class="form-control @error('other_category_name') is-invalid @enderror" id="other_category"
                            name="other_category_name" rows="3" placeholder="Masukkan kategori lainnya...">{{ old('other_category_name') }}</textarea>
                        @error('other_category_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="complaint_title" class="form-label required">Judul Masalah</label>
                        <textarea class="form-control @error('complaint_title') is-invalid @enderror" id="complaint_title"
                            name="complaint_title" rows="2" placeholder="Masukkan Judul Masalah" required minlength="10">{{ old('complaint_title') }}</textarea>
                        @error('complaint_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="complaint_description" class="form-label required">Deskripsi Masalah</label>
                        <textarea class="form-control @error('complaint_description') is-invalid @enderror" id="complaint_description"
                            name="complaint_description" rows="5" placeholder="Masukkan Deskripsi Masalah" required minlength="20">{{ old('complaint_description') }}</textarea>
                        @error('complaint_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="complaint_hopeful_solution" class="form-label required">Harapan</label>
                        <textarea class="form-control @error('complaint_hopeful_solution') is-invalid @enderror"
                            id="complaint_hopeful_solution" name="complaint_hopeful_solution" rows="3"
                            placeholder="Masukkan Harapan Solusi" required minlength="10">{{ old('complaint_hopeful_solution') }}</textarea>
                        @error('complaint_hopeful_solution')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="supporting_url" class="form-label">URL Pendukung</label>
                        <input type="url" class="form-control @error('supporting_url') is-invalid @enderror"
                            id="supporting_url" name="supporting_url" value="{{ old('supporting_url') }}"
                            placeholder="Masukkan URL, contoh: https://example.com" pattern="https?://.+">
                        <small class="text-muted"><i class="fas fa-info-circle"></i> (Opsional) Masukkan URL pendukung
                            apabila ada</small>
                        @error('supporting_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="supporting_document" class="form-label">Dokumen Pendukung (PDF)</label>
                        <input class="form-control @error('supporting_document') is-invalid @enderror" type="file"
                            id="supporting_document" name="supporting_document" accept=".pdf">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Hanya file PDF yang diperbolehkan (Maks. 2MB)
                        </small>
                        @error('supporting_document')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="files" class="form-label">Bukti Foto/Video</label>
                        <input class="form-control @error('files') is-invalid @enderror" type="file" id="files"
                            name="files[]" multiple accept="image/*,video/*">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Maksimal 5 file (Maks. 10MB per file)
                        </small>
                        <div id="preview" class="mt-2 d-flex flex-wrap gap-2"></div>
                        @error('files')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('sales.complaint.index') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-chevron-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan
                        </button>
                    </div>
                </form> --}}
            </div>
        </div>
    </section>
@endsection
