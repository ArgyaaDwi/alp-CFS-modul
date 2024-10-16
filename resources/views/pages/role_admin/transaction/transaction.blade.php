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
                    <h4 class="m-0"><b>Kelola Transaksi</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"> <i
                                    class="nav-icon fa-solid fa-house"></i>
                            </a></li>
                        <li class="breadcrumb-item active">Transaki</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="card mx-3">
            <div class="card-body table-responsive">
                {{-- <div class="mb-3">
                    <a href="{{ route('admin.product.add') }}" class="btn btn-outline-primary">+ Tambah Transaki</a>
                </div> --}}
                <table class="stripe-responsive" id="myTable">
                    <thead style="border: 1px solid black">
                        <tr>
                            <th>No. </th>
                            {{-- <th>ID</th> --}}
                            <th>Kode Transaksi</th>
                            <th>Total</th>
                            <th>Sales Manager</th>
                            <th>Distributor</th>
                            <th>Customer</th>
                            <th>Kota</th>
                            <th>Tanggal Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $val)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td>{{ $val->id }}</td> --}}
                                <td>{{ $val->transaction_code }}</td>
                                <td>{{ $val->total_amount }}</td>
                                <td>{{ $val->user->name }}</td>
                                <td>{{ $val->user->distributor->company_name }}</td>
                                <td>{{ $val->customer_company }}</td>
                                <td>{{ $val->city->city_name }}</td>
                                <td>{{ $val->created_at }}</td>
                                <td>
                                    <form action="{{ route('admin.transaction.delete', $val->id) }}" method="POST"
                                        id="delete-form-{{ $val->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.transaction.detail', $val->id) }}"
                                                class="btn btn-outline-info">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            @auth

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
                                                    class="text-danger text-bold">{{ $val->transaction_code }}</span> dari
                                                Transaki?
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
                                <td colspan="7" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
