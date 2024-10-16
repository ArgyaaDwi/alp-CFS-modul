<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Register</title>
    <style>
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
        }

        .select2-container--default .select2-selection--single {
            text-align: center;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-results__option {
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="border rounded px-5 py-5 mx-auto shadow-lg">
                    <img class="d-block mx-auto" src="{{ asset('images/logoalp.jpg') }}" width="90px" alt="">
                    <h5 class="text-center mt-2 mb-3"><strong>ALP </strong>Insight</h5>
                    <h3 class="text-left"><strong>Buat Akun</strong></h3>
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li><strong>{{ $item }}</strong></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('register.process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="Masukkan Nama Lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="id_distributor" class="form-label">Nama Distributor</label>
                            <select class="form-control" id="id_distributor" name="distributor_id">
                                <option value="" class="text-center">.:: Pilih Distributor ::.</option>
                                @forelse ($distributors as $item)
                                    <option value="{{ $item->id }}">{{ $item->company_name }}</option>
                                @empty
                                    <option value="">Distributor tidak tersedia</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="no_telephone" class="form-label">No. Telepon</label>
                            <input type="number" value="{{ old('no_telephone') }}" name="no_telephone" class="form-control" placeholder="Masukkan No. Telepon">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="Masukkan Email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password Minimal 6 Karakter">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Masukkan Password Kembali">
                        </div>
                        <div class="mb-3 d-grid">
                            <button name="submit" type="submit" class="btn btn-warning p-2"><strong>Daftar</strong></button>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <p class="mb-0 font-weight-bold">Sudah punya akun?</p>
                            <a href="{{ route('login') }}" class="mx-2 text-decoration-none"><strong style="color: rgb(148, 144, 43)">Login</strong></a>
                            <p class="mb-0">sekarang</p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('images/welcome.png') }}" alt="Login Image" class="img-fluid">
            </div>
        </div>
    </div>
    <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5500);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#id_distributor').select2({
                placeholder: ".:: Pilih Distributor ::.",
                allowClear: true
            });
        });
    </script>
</body>

</html>
