@extends('layouts.admin')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4><b>Detail Karyawan</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"><i
                                    class="fa-solid fa-house"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}"
                                style="text-color: black">User</a></li>
                        <li class="breadcrumb-item"><span>{{ $users->name }}</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card mx-3">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="card-body d-flex flex-column">
                        <div class="row flex-grow-1">
                            <div class="col-12">
                                <div class="card bg-light d-flex flex-fill">
                                    <div class="card-header text-muted border-bottom-0">
                                        <h4>{{ $users->name }}</h4>
                                    </div>
                                    <div class="card-body d-flex flex-column pt-3">
                                        <div class="row flex-grow-1">
                                            <div class="col-7">
                                                <h2 class="lead mt-8">
                                                    <b>{{ $users->name }} /
                                                        {{ $users->id }}</b>
                                                </h2>
                                                @if ($users->is_active == 1)
                                                    <span class="badge badge-pill badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-pill badge-danger">Nonaktif</span>
                                                @endif
                                                @if ($users->distributor_id != null)
                                                    <p class="text-muted text-sm"><b>Role: {{ $users->role->role_name }}
                                                            {{ $users->distributor->distributor_name }}</b>
                                                    </p>
                                                @else
                                                    <p class="text-muted text-sm"><b>Role: {{ $users->role->role_name }}
                                                        </b></p>
                                                @endif
                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                    <li class="small"><span class="fa-li"><i
                                                                class="fa-solid fa-location-dot"></i></i></span>
                                                        <span>{{ $users->address ?? '-' }}</span>
                                                    </li>
                                                    <li class="small"><span class="fa-li"><i
                                                                class="fa-regular fa-envelope"></i></span> Email:
                                                        <span>{{ $users->email ?? '-' }}</span>
                                                    </li>
                                                    <li class="small"><span class="fa-li"><i
                                                                class="fa-solid fa-square-phone"></i></i></span>
                                                        Telepon: <span>{{ $users->no_telephone ?? '-' }}</span></li>
                                                </ul>
                                                <br>
                                                <p class="text-muted text-sm"><b>Bergabung Sejak: {{ $users->created_at }}
                                                    </b>

                                                <p class="text-muted text-sm"><b>Terakhir Diperbarui:
                                                        {{ $users->updated_at }}</b>
                                            </div>
                                            <div class="col-5 text-center">
                                                @if ($users->profile_pic == null)
                                                    <img src="https://ui-avatars.com/api/?name={{ $users->name }}&background=random"
                                                        alt="user-avatar" class="img-circle img-fluid" width="170">
                                                @else
                                                    <img src="{{ asset('storage/profile_pic/' . $users->profile_pic) }}"
                                                        alt="{{ $users->name }}" class="img-circle img-fluid"
                                                        width="170" height="170" style="object-fit: contain">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary"><i
                            class="fa-solid fa-chevron-left"></i> Kembali</a>
                    <a href="{{ route('admin.user.edit', $users->id) }}" class="btn btn-primary"><i
                            class="fa-regular fa-pen-to-square"></i> Perbarui Data</a>
                </div>
            </div>
        </div>
    </section>
@endsection
