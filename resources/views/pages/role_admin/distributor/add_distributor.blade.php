@extends('layouts.admin')
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#company_province_id').select2({
                placeholder: ".:: Pilih Provinsi ::.",
                allowClear: true
            });
        });
        $(document).ready(function() {
            $('#company_city_id').select2({
                placeholder: ".:: Pilih Kota ::.",
                allowClear: true
            });
        });
        $(document).ready(function() {
            $('#company_type_id').select2({
                placeholder: ".:: Pilih Tipe ::.",
                allowClear: true
            });
        });
        $(document).ready(function() {
            $('#main_distributor_id').select2({
                placeholder: ".:: Pilih Main Distributor ::.",
                allowClear: true
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
@push('styles')
    <style>
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
                    <h4 class="m-0"><b>Tambah Distributor</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"> <i
                                    class="nav-icon fa-solid fa-house"></i></a></li>
                        <li class="breadcrumb-item "><a href="{{ route('admin.distributor.index') }}">Distributor</a></li>
                        <li class="breadcrumb-item active">Tambah Distributor</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="card mx-3">
            <div class="card-body">
                <form action="{{ route('admin.distributor.save') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="company_type_id" class="form-label">Tipe Perusahaan</label>
                            <select class="form-control" id="company_type_id" name="company_type_id">
                                <option value="" class="text-center">.:: Pilih Tipe ::.</option>
                                @forelse ($company_type as $item)
                                    <option value="{{ $item->id }}">{{ $item->type_name }}</option>
                                @empty
                                    <option value="">Tipe Perusahaan tidak tersedia</option>
                                @endforelse
                            </select>
                            @error('company_type_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="main_distributor_id" class="form-label">Main Distributor</label>
                            <select class="form-control" id="main_distributor_id" name="company_distributor_id">
                                <option value="" class="text-center">.:: Pilih Tipe ::.</option>
                                @forelse ($distributors as $item)
                                    <option value="{{ $item->id }}">{{ $item->distributor_name }}</option>
                                @empty
                                    <option value="">Main Distributor tidak tersedia</option>
                                @endforelse
                            </select>
                            @error('company_distributor_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="name" class="form-label">Nama Perusahaan</label>
                            <input type="text" value="{{ old('company_name') }}" name="company_name" class="form-control"
                                placeholder="Masukkan Nama Perusahaan">
                            @error('company_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="company_province_id" class="form-label">Provinsi</label>
                            <select class="form-control" id="company_province_id" name="company_province_id">
                                <option value="" class="text-center">.:: Pilih Provinsi ::.</option>
                                @forelse ($company_province as $item)
                                    <option value="{{ $item->id }}">{{ $item->province_name }}</option>
                                @empty
                                    <option value="">Provinsi tidak tersedia</option>
                                @endforelse
                            </select>
                            @error('company_province_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="company_city_id" class="form-label">Kota</label>
                            <select class="form-control" id="company_city_id" name="company_city_id">
                                <option value="" class="text-center">.:: Pilih Kota ::.</option>
                                @forelse ($company_city as $item)
                                    <option value="{{ $item->id }}">{{ $item->city_name }}</option>
                                @empty
                                    <option value="">Kota tidak tersedia</option>
                                @endforelse
                            </select>
                            @error('company_city_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="company_email" class="form-label">Email Perusahaan</label>
                            <input type="email" value="{{ old('company_email') }}" name="company_email"
                                class="form-control" placeholder="Masukkan Email Perusahaan">
                            @error('company_email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="company_phone" class="form-label">Telepon Perusahaan</label>
                            <input type="number" value="{{ old('company_phone') }}" name="company_phone"
                                class="form-control" placeholder="Masukkan No. Telepon Perusahaan">
                            @error('company_phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="company_address">Alamat</label>
                            <textarea class="form-control" id="company_address" name="company_address" rows="3"
                                placeholder="Masukkan Alamat Perusahaan">{{ old('company_address') }}</textarea>
                            @error('company_address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="company_website" class="form-label">Website Perusahaan</label>
                            <input type="text" value="{{ old('company_website') }}" name="company_website"
                                class="form-control" placeholder="Masukkan Website Perusahaan">
                                <small class="text-muted"><i class="fas fa-info-circle"></i> Masukkan URL Website jika ada</small>
                        </div>
                    </div>
                    <a href="{{ route('admin.distributor.index') }}" class="btn btn-secondary"><i
                            class="fa-solid fa-chevron-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>
                        Simpan</button>
                </form>
            </div>
        </div>
    </section>
@endsection
