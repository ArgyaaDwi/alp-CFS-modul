@extends('layouts.fgm')
@section('content')
    @push('scripts')
        <script>
            var donutData = {
                labels: ['Kualitas', 'Kuantitas', 'Pengiriman', 'Lainnya'],
                datasets: [{
                    data: [40, 20, 30, 10],
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
                }]
            };
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            var pieData = donutData;
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            };
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            });
            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData = {
                labels: [
                    'Open',
                    'Closed',

                ],
                datasets: [{
                    data: [700, 500],
                    backgroundColor: ['#00a65a', '#f56954', ],
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })
        </script>
    @endpush
@section('content')
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-12">
                <div class="card p-4 d-flex flex-row align-items-center">
                    <div class="col-md-9">
                        <h3 class="text-bold">Halo, {{ $user->name }}</h3>
                        <p class="card-text mr-5" style="text-align: justify">Selamat datang di modul feedback <span
                                style="font-weight: bold">ALP Insight</span> untuk role Factory General Manager. Mari
                            bersama tingkatkan kualitas produk dan layanan dari PT. ALP Petro Industry,
                            setiap feedback dari distributor menjadi langkah penting dalam proses perbaikan. Suara Konsumen,
                            solusi bersama.
                            Jadikan
                            setiap masukan sebagai peluang untuk tumbuh dan berkembang. Bersama, kita bangun masa ekosistem
                            yang
                            lebih baik.
                        </p>
                        <a href="#" class="btn btn-outline-info"><i class="fa-regular fa-eye"></i> Petunjuk
                            penggunaan</a>
                    </div>
                    <div class="col-md-3 d-flex justify-content-end">
                        <img src="{{ asset('images/fgm.jpg') }}" alt="Logo" class="img-fluid" style="max-width: 110%;">
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">User</span>
                        <span class="info-box-number">10</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-building"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Likes</span>
                        <span class="info-box-number">41,410</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-comments"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sales</span>
                        <span class="info-box-number">760</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">New Members</span>
                        <span class="info-box-number">2,000</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-dark card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Status</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="donutChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-dark card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Feedback berdasarkan kategori</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
