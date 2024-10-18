@extends('layouts.fgm')
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
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 mx-0">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! session('success') !!}
                    </div>
                @endif
                <div class="col-sm-6">
                    <h4 class="m-0"><b>Kelola Aduan</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.fgm') }}"> <i
                                    class="nav-icon fa-solid fa-house"></i>
                            </a></li>
                        <li class="breadcrumb-item active">Aduan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="card mx-3">
            <div class="card-body table-responsive">
                <table class="stripe-responsive" id="myTable">
                    <thead style="border: 1px solid black">
                        <tr>
                            <th>No. </th>
                            <th>Distributor</th>
                            <th>Kategori</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($complaints as $val)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $val->distributor->company_name }}</td>
                                <td>
                                    @foreach ($val->categories as $category)
                                        @if ($category->id == 4 && $category->pivot->other_category_name)
                                            {{ $category->pivot->other_category_name }}
                                        @else
                                            {{ $category->category_name }}
                                        @endif
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $val->user->name }}</td>
                                <td>{{ Carbon\Carbon::parse($val->created_at)->locale('id')->translatedFormat('l, j F Y H:i:s') }}
                                </td>
                                <td>{{ $val->currentStatus->status_name ?? 'Tidak ada status' }}</td>
                                <td>
                                    @if ($val->current_status_id == 4)
                                    <button type="button" disabled class="btn btn-outline-success btn-sm">Perlu Tindakan</button>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('sales.complaint.delete', $val->id) }}" method="POST"
                                        id="delete-form-{{ $val->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('fgm.complaint.detail', $val->id) }}"
                                                class="btn btn-outline-info">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            @auth
                                                {{-- <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#confirmDeleteModal-{{ $val->id }}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button> --}}
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
                                                Apakah kamu yakin ingin menghapus aduan dengan ticket <span
                                                    class="text-danger text-bold">{{ $val->batch_number }}</span> dari
                                                Aduan?
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
