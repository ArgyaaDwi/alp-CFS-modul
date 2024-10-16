@extends('layouts.admin')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><b>Edit Akun</b></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"><i
                                    class="nav-icon fa-solid fa-house"></i></a></li>
                        <li class="breadcrumb-item "><a href="{{ route('admin.user.index') }}">User</a></li>
                        <li class="breadcrumb-item active">Edit {{ $users->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="card mx-2">
            <div class="card-body">
                <div class="border rounded px-5 py-5 mx-auto shadow-lg">
                    <form action="{{ route('admin.user.update', $users->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" value="{{ $users->name }}" name="name" class="form-control">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="distributor_id" class="form-label">Nama Distributor</label>
                                <select class="form-control" id="distributor_id" name="distributor_id">
                                    <option value="" class="text-center">.:: Pilih Distributor ::.</option>
                                    @forelse ($distributors as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $users->distributor_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->company_name }}</option>
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
                                        <option value="{{ $item->id }}"
                                            {{ $users->role_id == $item->id ? 'selected' : '' }}>{{ $item->role_name }}
                                        </option>
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
                                <input type="email" value="{{ $users->email }}" name="email" class="form-control"
                                    placeholder="Masukkan Email">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="no_telephone" class="form-label">No. Telepon</label>
                                <input type="number" value="{{ $users->no_telephone }}" name="no_telephone"
                                    class="form-control" placeholder="Masukkan No. Telepon">
                                @error('no_telephone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <input type="text" value="{{ $users->address }}" name="address" class="form-control"
                                placeholder="Masukkan Alamat">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="is_verified" class="form-label">Verifikasi</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input ml-1 mt-1" type="radio" name="is_verified"
                                        id="is_verified1" value="1" {{ $users->is_verified == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_verified1">Verified</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input ml-1 mt-1" type="radio" name="is_verified"
                                        id="is_verified2" value="0" {{ $users->is_verified == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_verified2">Unverified</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="is_active" class="form-label">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input ml-1 mt-1" type="radio" name="is_active"
                                        id="is_active1" value="1" {{ $users->is_active == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active1">Aktif</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input ml-1 mt-1" type="radio" name="is_active"
                                        id="is_active2" value="0" {{ $users->is_active == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active2">Tidak Aktif</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" value="{{ $users->password }}" class="form-control"
                                placeholder="Masukkan Password">
                        </div>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary"><i
                                class="fa-solid fa-chevron-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>
                            Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
