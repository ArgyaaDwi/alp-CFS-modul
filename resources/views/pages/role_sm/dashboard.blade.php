@extends('layouts.sales')

@section('content')
    <div class="p-4">
        <h1>Halo {{ $user->name }} ({{ $user->email }}) ini adalah dashboard Sales Manager</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
@endsection
