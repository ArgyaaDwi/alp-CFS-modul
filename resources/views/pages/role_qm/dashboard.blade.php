<h1>Halo {{ $qm->name }} ({{ $qm->email }}) ini adalah dashboard Quality Manager</h1>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
