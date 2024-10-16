<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ALP Insight | Verifikasi Akun</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
</head>
<body class="d-flex justify-content-center align-items-center py-5" style="background-color: #f4f6f9;">
    <div class="card  rounded-l-full shadow-lg" style="width: 635px;">
        <div class="card-body text-center">
            @if (session('info'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! session('info') !!}
                </div>
            @endif
            <div class="lockscreen-logo mb-1">
                <h3><b>ALP</b> Insight</h3>
            </div>
            <div class="mb-4">
                <img src="{{ asset('images/waiting.png') }}" height="250px" alt="User Image">
            </div>
            <div class="help-block text-center text-bold mb-4 mx-5">
                <h4><strong>Proses Verifikasi Akun sedang Berlangsung</strong></h4>
            </div>
            <div class="text-justify mb-4 mx-5">
                <p>
                    Tim kami akan segera memproses permintaan verifikasi akun Anda.
                    Jangan lupa untuk memeriksa email Anda secara berkala. Kami akan mengirimkan email konfirmasi bahwa
                    akun sudah bisa digunakan.
                    <br>
                    Jika Anda memiliki pertanyaan atau mengalami kendala, jangan ragu untuk menghubungi tim dukungan
                    kami melalui [Alamat Email] atau [Nomor Telepon].
                    <br>
                    Terima kasih.
                    <br><br>
                    Kembali ke halaman <a href="{{ route('login') }}">Login</a>
                </p>
            </div>
        </div>
        <div class="card-footer text-center">
            Copyright &copy; 2024 <b><a href="https://alppetro.co.id/" class="text-black">ALP Petro Industry</a></b>
            All rights reserved
        </div>
    </div>
    <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
    <script src=".{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3500);
    </script>
</body>

</html>
