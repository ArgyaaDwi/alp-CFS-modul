@extends('layouts.qm')
@section('content')
<div class="p-3">
    <h1>Halo {{ $user->name }} ({{ $user->email }}) ini adalah dashboard Quality Manager</h1>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
@endsection
