<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Login</title>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('images/login.png') }}" alt="Login Image" class="img-fluid">
            </div>
            <div class="col-md-6">
                <div class="border rounded px-5 py-5 shadow-lg">
                    <img class="d-block mx-auto" src="{{ asset('images/logoalp.jpg') }}" width="90px" alt="">
                    <h5 class="text-center mt-2 mb-3"><strong>ALP </strong>Insight</h5>
                    <h3 class="text-left "><strong >Selamat Datang</strong></h3>
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li><strong>{{ $item }}</strong></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="Masukkan Email Anda">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
                        </div>
                        <div class="mb-3 d-grid">
                            <button name="submit" type="submit" class="p-2 btn btn-warning"><strong>Login</strong></button>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <p class="mb-0 font-weight-bold">Belum punya akun?</p>
                            <a href="{{ route('register') }}"
                                class="mx-2 text-decoration-none"><strong style="color: rgb(148, 144, 43)">Daftar</strong></a>
                            <p class="mb-0">sekarang</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 3500);
        });
    </script>
</body>

</html>
