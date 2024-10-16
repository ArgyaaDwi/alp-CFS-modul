<h1>Halo {{ $fgm->name }} ({{ $fgm->email }}) ini adalah dashboard FGM</h1>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
