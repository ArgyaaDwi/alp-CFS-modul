@extends('layouts.sales')
@section('content')
    <div class="p-3">
        <h1>{{ $complaint->id }}/{{ $complaint->batch_number }}</h1>
        <h5>{{ $complaint->complaint_title }} / {{$complaint->distributor->company_name}}</h5>
        <td>{{ $complaint->distributor->companyDistributor->distributor_name }}</td>

        <p>{{ $complaint->complaint_description }}</p>
        <p>{{ $complaint->complaint_hopeful_solution }}</p>
        <td>{{ Carbon\Carbon::parse($complaint->created_at)->locale('id')->translatedFormat('l, j F Y H:i:s') }}</td>
        @if ($complaint->supporting_document)
        <button class="btn btn-primary "><a class="text-white" href="{{ asset('storage/' . $complaint->supporting_document) }}" target="_blank">Lihat Dokumen
            Pendukung</a></button><br><br>

        @endif
        <p>Bukti Foto:</p>
        @foreach ($complaint->files as $file)
            @if (Str::endsWith($file->file_path, ['.jpg', '.jpeg', '.png', '.gif']))
                <img src="{{ asset('storage/' . $file->file_path) }}" alt="Bukti Foto" width="150">
            @elseif (Str::endsWith($file->file_path, ['.mp4', '.mov', '.avi']))
                <video width="320" height="240" controls>
                    <source src="{{ asset('storage/' . $file->file_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @endif
        @endforeach

    </div>
@endsection
