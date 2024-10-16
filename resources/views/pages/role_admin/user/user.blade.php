@extends('layouts.admin')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 2500);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 mx-0">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! session('success') !!}
                    </div>
                @elseif (session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {!! session('info') !!}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {!! session('error') !!}
                    </div>
                @endif

                <div class="col-sm-6">
                    <h4 class="m-0"><b>Kelola User</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"> <i
                                    class="nav-icon fa-solid fa-house"></i>
                            </a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="card mx-3">
            <div class="card-body table-responsive">
                <div class="mb-3">
                    <a href="{{ route('admin.user.add') }}" class="btn btn-outline-primary">+ Tambah User</a>
                </div>
                <table class="stripe-responsive" id="myTable">
                    <thead style="border: 1px solid black">
                        <tr>
                            <th>No. </th>
                            {{-- <th>ID</th> --}}
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Verifikasi</th>
                            <th>Distributor</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $val)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td>{{ $val->id }}</td> --}}
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->email }}</td>
                                <td>{{ $val->role ? $val->role->role_name : 'Role tidak ditemukan' }}</td>
                                <td>
                                    @if ($val->is_verified == 1)
                                        <button type="button" disabled
                                            class="btn btn-outline-success btn-sm">Verified</button>
                                    @else
                                        <form action="{{ route('admin.distributor.verification', $val->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-outline-warning btn-sm">Waiting (Click to
                                                Verify)</button>
                                        </form>
                                    @endif
                                </td>
                                <td>{{ $val->distributor ? $val->distributor->company_name : '-' }}</td>
                                <td>
                                    {!! $val->is_active == 1
                                        ? '<button type="button" disabled class="btn btn-outline-success btn-sm">Active</button>'
                                        : '<button type="button" disabled class="btn btn-outline-danger btn-sm">Inactive</button>' !!}

                                    <div class="dropdown d-inline">
                                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="background-color: rgb(58, 91, 123)">
                                            <i class="fa-solid fa-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <form action="{{ route('admin.distributor.updateStatus', $val->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" name="status" value="1"
                                                        class="dropdown-item">Set Active</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.distributor.updateStatus', $val->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" name="status" value="0"
                                                        class="dropdown-item">Set Inactive</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                </td>
                                <td>
                                    <form action="{{ route('admin.user.delete', $val->id) }}" method="POST"
                                        id="delete-form-{{ $val->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.user.detail', $val->id) }}"
                                                class="btn btn-outline-info">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            @auth
                                                <a href="{{ route('admin.user.edit', $val->id) }}"
                                                    class="btn btn-warning mx-1">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#confirmDeleteModal-{{ $val->id }}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            @endauth
                                        </div>
                                    </form>
                                </td>
                                <div class="modal fade" id="confirmDeleteModal-{{ $val->id }}" tabindex="-1"
                                    aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteLabel">Konfirmasi Penghapusan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah kamu yakin ingin menghapus <span
                                                    class="text-danger text-bold">{{ $val->name }}</span> dari user?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="document.getElementById('delete-form-{{ $val->id }}').submit();">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
