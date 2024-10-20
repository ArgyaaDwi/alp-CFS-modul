@extends('layouts.admin')
@push('styles')
    <style>
        .custom-img {
            width: 280px;
            height: 320px;
            object-fit: contain;
        }
    </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4><b>Detail Produk</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"><i
                                    class="fa-solid fa-house"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}"
                                style="text-color: black">Produk</a></li>
                        <li class="breadcrumb-item"><span>{{ $products->product_name }}</span>
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
                                    <div class="card-body d-flex flex-column pt-3">
                                        <div class="row flex-grow-1">
                                            <div class="col-4 text-center">
                                                @if ($products->product_image == null)
                                                    <img src="https://ui-avatars.com/api/?name={{ $products->product_name }}&background=random"
                                                        alt="user-avatar" class="custom-img img-fluid rounded-circle">
                                                @else
                                                    <img src="{{ asset('storage/product_image/' . $products->product_image) }}"
                                                        alt="{{ $products->product_name }}" class="custom-img img-fluid">
                                                @endif
                                            </div>
                                            <div class="col-8">
                                                <h2 class="lead mt-8"><button class="btn btn-warning"
                                                        disabled>{{ $products->product_name }}</button>
                                                    <b>{{ $products->product_code }} / {{ $products->id }}</b>
                                                </h2>
                                                <p class="text-sm">Kategori:
                                                    {{ $products->categoryLubricant->category_name ?? '-' }}</p>
                                                <p class="text-sm">Sub Kategori:
                                                    {{ $products->subCategoryLubricant->sub_category_name ?? '-' }}
                                                </p>
                                                <ul class="ml-4 mb-2 fa-ul text-muted">
                                                    <li class="small"><span class="fa-li"><i
                                                                class="fa-solid fa-money-check-dollar"></i></span>
                                                        <span>Rp{{ $products->product_price ?? '-' }},00</span>
                                                    </li>
                                                    <li class="small"><span class="fa-li"><i
                                                                class="fa-solid fa-star"></i></span>
                                                        <span>{{ $products->average_rating ?? '-' }}</span>
                                                    </li>
                                                </ul>
                                                <p class="text-sm">Deskripsi:
                                                    <br>{{ $products->product_description ?? '-' }}
                                                </p>

                                                <p class="text-muted text-sm"><b>Dibuat:
                                                        {{ $products->created_at }}</b></p>
                                                <p class="text-muted text-sm"><b>Terakhir Diperbarui:
                                                        {{ $products->updated_at }}</b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.product.index') }}" class="btn btn-outline-secondary"><i
                            class="fa-solid fa-chevron-left"></i> Kembali</a>
                    <a href="{{ route('admin.product.edit', $products->id) }}" class="btn btn-primary"><i
                            class="fa-regular fa-pen-to-square"></i> Perbarui Data</a>
                </div>
            </div>
        </div>
    </section>
@endsection
