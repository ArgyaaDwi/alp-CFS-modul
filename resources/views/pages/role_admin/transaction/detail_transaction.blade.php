@extends('layouts.admin')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4><b>Detail Transaksi</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard.admin') }}"><i class="fa-solid fa-house"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.transaction.index') }}"
                                style="text-color: black">Transaksi</a></li>

                        <li class="breadcrumb-item"><span>Detail Transaksi</span></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="invoice p-3 mb-3 mx-2 rounded-3">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-center text-bold">
                               .:: Invoice Transaksi ::.
                            </h4>
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="mt-2 col-sm-4 invoice-col">
                            From
                            <address>
                                <strong>PT. ALP Petro Industry</strong><br>
                                <i class="fa-solid fa-location-dot"></i> Jl. Raya Kebonsari Desa No.KM. 1, Legok, Kec.
                                Gempol, Pasuruan, Jawa Timur 67155 <br>
                                <i class="fa-solid fa-phone"></i> (0343) 853308<br>
                                <i class="fa-solid fa-envelope"></i> alppetro@gmail.com
                            </address>
                        </div>
                        <div class="col-sm-4 invoice-col mt-2">
                            To
                            <address>
                                <strong>{{ $transactions->user->name }}</strong><br>
                                <i class="fa-solid fa-building"></i> {{ $transactions->user->distributor->company_name }} / {{ $transactions->user->distributor->company_email }}<br>
                                <i class="fa-solid fa-location-dot"></i> {{ $transactions->user->distributor->company_address }}<br>
                                <i class="fa-solid fa-phone"></i> {{ $transactions->user->no_telephone }}<br>
                                <i class="fa-solid fa-envelope"></i> {{ $transactions->user->email }}

                            </address>
                        </div>

                        <div class="col-sm-4 invoice-col mt-2">
                            <a>Transaction Code:</a> {{ $transactions->transaction_code }}<br>
                            <a>Transaction Date:</a> {{ $transactions->created_at }}<br>
                            <a>Customer: </a> {{ $transactions->customer_company }}<br>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Qty</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Golongan</th>
                                        <th>Harga /unit</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                @forelse ($transactions->detailTransaction as $val)
                                    <tr>
                                        <td>{{ $val->quantity }}</td>
                                        <td>{{ $val->product->product_name }}</td>
                                        <td>{{ $val->product->categoryLubricant->category_name }}</td>
                                        <td>{{ $val->product->subCategoryLubricant->sub_category_name }}</td>
                                        <td>{{ $val->price_unit }}</td>
                                        <td>{{ $val->total_price }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No Data</td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                    <div class="row no-print">
                        <div class="col-12">
                            <h5 class="float-right">Total: Rp{{ $transactions->total_amount }}</h5>
                            <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                                    class="fas fa-print"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
