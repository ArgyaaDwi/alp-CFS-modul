@extends('layouts.admin')
@push('scripts')
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
        .avatar-preview {
            width: 150px;
            height: 150px;
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
                    <h1 class="m-0"><b>Buat Akun</b></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"><i
                                    class="nav-icon fa-solid fa-house"></i></a></li>
                        <li class="breadcrumb-item "><a href="{{ route('admin.user.index') }}">User</a></li>
                        <li class="breadcrumb-item active">Buat Akun</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="card mx-2">
            <div class="card-body">
                <form action="{{ route('admin.user.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" value="{{ old('name') }}" name="name" class="form-control"
                            placeholder="Masukkan Nama">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
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
                            <i class="fas fa-info-circle"></i> Pilih distributor jika untuk role user.
                        </div>
                        <div class="col-md-6">
                            <label for="role_id" class="form-label">Role</label>
                            <select class="form-control" id="role_id" name="role_id">
                                <option value="" class="text-center">.:: Pilih Role ::.</option>
                                @forelse ($roles as $item)
                                    <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                                @empty
                                    <option value="">Role tidak tersedia</option>
                                @endforelse
                            </select>
                            @error('role_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" value="{{ old('email') }}" name="email" class="form-control"
                                placeholder="Masukkan Email">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="no_telephone" class="form-label">No. Telepon</label>
                            <input type="number" value="{{ old('no_telephone') }}" name="no_telephone"
                                class="form-control" placeholder="Masukkan No. Telepon">
                            @error('no_telephone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Masukkan Password Kembali">
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Masukkan Alamat">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="is_verified" class="form-label">Verifikasi</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input ml-1 mt-1" type="radio" name="is_verified"
                                    id="is_verified1" value="1">
                                <label class="form-check-label" for="is_verified1">Verified</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input ml-1 mt-1" type="radio" name="is_verified"
                                    id="is_verified2" value="0">
                                <label class="form-check-label" for="is_verified2">Unverified</label>
                            </div>
                            @error('is_verified')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="is_active" class="form-label">Status</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input ml-1 mt-1" type="radio" name="is_active"
                                    id="is_active1" value="1">
                                <label class="form-check-label" for="is_active1">Aktif</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input ml-1 mt-1" type="radio" name="is_active"
                                    id="is_active2" value="0">
                                <label class="form-check-label" for="is_active2">Tidak Aktif</label>
                            </div>
                            @error('is_active')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Profile</label>
                        <input class="form-control" type="file" id="profile_picture" name="profile_pic"
                            accept=".jpg,.jpeg,.png" onchange="previewImage(this)">
                        <i class="fas fa-info-circle"></i> (Opsional) Gunakan gambar rasio 1:1 untuk hasil yang maksimal
                        dengan maks ukuran 1MB [JPG, JPEG, PNG] .
                    </div>
                    <div class="avatar-preview mb-3">
                        <div id="imagePreview"></div>
                    </div>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary"><i
                            class="fa-solid fa-chevron-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>
                        Simpan</button>
                </form>
            </div>
        </div>
    </section>
@endsection
