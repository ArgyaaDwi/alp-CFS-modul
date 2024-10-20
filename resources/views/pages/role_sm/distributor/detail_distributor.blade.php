@extends('layouts.sales')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
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
        </div>
    </section>
@endsection
