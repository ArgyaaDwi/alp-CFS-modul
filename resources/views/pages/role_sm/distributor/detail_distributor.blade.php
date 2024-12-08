@extends('layouts.sales')
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
            }, 4500);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4><b>Detail Distributor</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.sales') }}"><i
                                    class="fa-solid fa-house"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('sales.distributor.index') }}"
                                style="text-color: black">Distributor</a></li>
                        <li class="breadcrumb-item"><span>{{ $distributors->company_name }}</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card mx-3">
            <div class="card-header">
                <h4>{{ $distributors->company_name }}</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title text-bold">Tipe Perusahaan: {{ $distributors->companyType->type_name }}
                </h5>
                <h6 class="card-text">Main Distributor: {{ $distributors->companyDistributor->distributor_name }}</h6>
                <h6 class="card-text">Provinsi: {{ $distributors->companyProvince->province_name }}</h6>
                <h6 class="card-text">Kota: {{ $distributors->companyCity->city_name }}</h6>
                <ul class="ml-4 mb-3 fa-ul text-muted">
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-location-dot"></i></span>
                        <span>{{ $distributors->company_address ?? '-' }}</span>
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-regular fa-envelope"></i></span>
                        Email: <span>{{ $distributors->company_email ?? '-' }}</span>
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-square-phone"></i></span>
                        Telepon: <span>{{ $distributors->company_phone ?? '-' }}</span>
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-link"></i></span>
                        Website: <a
                            href="{{ $distributors->company_website ?? '-' }}">{{ $distributors->company_website ?? '-' }}</a>
                    </li>
                </ul>
                <a href="{{ route('sales.distributor.index') }}" class="btn btn-outline-secondary"><i
                        class="fa-solid fa-chevron-left"></i> Kembali</a>
                <a href="{{ route('sales.distributor.edit', $distributors->id) }}" class="btn btn-primary"><i
                        class="fa-regular fa-pen-to-square"></i> Perbarui Data</a>
            </div>
            <h4 class="mx-3">Daftar Feedback</h4>
            <div class="m-3 table-responsive">
                <table class="cell-border" id="myTable">
                    <thead style="border: 1px solid black">
                        <tr>
                            <th>No. </th>
                            <th>CFS Ticket</th>
                            <th>Distributor</th>
                            <th>Main Distributor</th>
                            <th>Kategori</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><button type="button" disabled
                                    class="btn btn-outline-danger btn-sm">CFS/2/ALP/2024</button></td>
                            <td>PT. Mencari Cinta Sejati</td>
                            <td>Gani Distribusi Lubrindo</td>
                            <td>
                                Pengiriman
                            </td>
                            <td>Udin</td>
                            <td>Selasa, 12 Maret 2023
                            </td>
                            <td>Open</td>
                            <td>
                                <form action="" method="POST" id="delete-form-">
                                    @csrf
                                    @method('DELETE')
                                    <div class="d-flex gap-2">
                                        <a href="" class="btn btn-outline-info">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        @auth
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmDeleteModal-">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        @endauth
                                    </div>
                                </form>
                            </td>
                            <div class="modal fade" id="confirmDeleteModal-" tabindex="-1"
                                aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteLabel">Konfirmasi Penghapusan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah kamu yakin ingin menghapus aduan dengan ticket <span
                                                class="text-danger text-bold">1</span> dari
                                            Aduan?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="document.getElementById('delete-form-').submit();">
                                                <i class="fa-solid fa-trash-can"></i>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
