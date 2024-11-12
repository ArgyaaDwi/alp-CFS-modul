@extends('layouts.sales')
@push('scripts')
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 2500);
    </script>
@endpush
@push('styles')
    <style>
        .profile-picture {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
        }
    </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! session('success') !!}
                    </div>
                @endif
                <div class="col-sm-6">
                    <h4 class="m-0"><b>Halaman Profil</b></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.sales') }}"> <i
                                    class="nav-icon fa-solid fa-house"></i>
                            </a></li>
                        <li class="breadcrumb-item active">Halaman Profil</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-13 mb-4">
                    <div class="card  card-outline mx-1">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-picture"
                                    src="{{ $user->profile_pic ? asset('storage/profile_pic/' . $user->profile_pic) : asset('images/user.jpg') }}"
                                    alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center" style="font-size: 26px">{{ $user->name }}</h3>
                            <p class="text-muted text-center" style="font-size: 18px">{{ $user->role->role_name }}
                                {{ $user->distributor->distributor_name }}</p>
                            <div class="card-body mx-5">
                                <strong style="font-size: 19px"><i class="fas fa-envelope mr-1"></i> Email</strong>
                                <p style="font-size: 19px" class="text-muted">
                                    {{ $user->email }}
                                </p>
                                <strong style="font-size: 19px"><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
                                <p class="text-muted" style="font-size: 19px">{{ $user->address }}</p>
                                <strong style="font-size: 19px"><i class="fas fa-phone mr-1"></i> Phone Number</strong>
                                <p class="text-muted" style="font-size: 19px">{{ $user->no_telephone }}</p>
                            </div>
                            <div class="row mx-5 mb-3 mt-3"
                                style="display: flex; justify-content: center; align-items-center">
                                <div class="col-3">
                                    <a href="{{ route('sales.profile.edit') }}" class="btn btn-primary btn-block p-2"><b><i
                                                class="fa-regular fa-pen-to-square"></i> Update Data</b></a>
                                </div>
                                <div class="col-3 ">
                                    <a href="{{ route('sales.password') }}"
                                        class="p-2 btn btn-outline-secondary btn-block"><b></b><i
                                            class="fa-solid fa-key"></i> Change Password</b></a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
