@extends('layouts.qm')
@push('scripts')
    <script type="text/javascript">
        function showImageModal(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('downloadLink').href = imageUrl;
            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }
    </script>
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 2500);
    </script>
@endpush
@push('styles')
    <style>
        .required:after {
            content: ' *';
            color: red;
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
                    <h4 class="m-0"><b>Detail Feedback</b></h>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.qm') }}"><i
                                    class="fa-solid fa-house"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('qm.complaint.index') }}"
                                style="text-color: black">Feedback</a></li>
                        <li class="breadcrumb-item"><span>{{ $complaint->complaint_ticket }}</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card-body">
            <div class="container-fluid">
                <div class="card-body d-flex flex-column">
                    <div class="row flex-grow-1">
                        <div class="col-12">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">
                                    <h4>{{ $complaint->complaint_ticket }} / {{ $complaint->id }}</h4>
                                </div>
                                <div class="card-body d-flex flex-column pt-3">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info"
                                                role="tab" aria-controls="info" aria-selected="true">Informasi</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="history-tab" data-toggle="tab" href="#history"
                                                role="tab" aria-controls="history" aria-selected="false">Riwayat</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active mx-1" id="info" role="tabpanel"
                                            aria-labelledby="info-tab">
                                            <h5 class="mt-3"><i class="fa-solid fa-building"></i>
                                                {{ $complaint->distributor->company_name }}</h5>
                                            <p class="text-muted text-sm"><b>Main Distributor:
                                                    {{ $complaint->distributor->companyDistributor->distributor_name }}</b>
                                            </p>
                                            <p class="text-muted text-sm"><b>Batch Number:
                                                    {{ $complaint->batch_number }}</b>
                                            </p>
                                            <p>Kategori Aduan: @foreach ($complaint->categories as $category)
                                                    @if ($category->id == 4 && $category->pivot->other_category_name)
                                                        {{ $category->pivot->other_category_name }}
                                                    @else
                                                        {{ $category->category_name }}
                                                        @endif @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                            </p>
                                            <p>Status Aduan: {{ $complaint->currentStatus->status_name }}</p>
                                            <h5>Judul Aduan: {{ $complaint->complaint_title }}</h5>
                                            <label for="complaint_description">Deskripsi</label>
                                            <textarea name="complaint_description" id="complaint_description" cols="30" rows="5" class="form-control"
                                                disabled>{{ $complaint->complaint_description }}</textarea>
                                            <label for="complaint_hopeful_solution">Harapan</label>
                                            <textarea name="complaint_hopeful_solution" id="complaint_hopeful_solution" cols="30" rows="5"
                                                class="form-control" disabled>{{ $complaint->complaint_hopeful_solution }}</textarea>
                                            @if ($complaint->supporting_document)
                                                <button class="btn btn-info my-2"><a class="text-white"
                                                        href="{{ asset('storage/' . $complaint->supporting_document) }}"
                                                        target="_blank"><i class="fa-regular fa-eye"></i> Dokumen
                                                        Pendukung</a></button>
                                            @endif
                                            @if ($complaint->supporting_url)
                                                <p><i class="fa-solid fa-link"></i> URL Pendukung: <a
                                                        href="{{ $complaint->supporting_url }}">{{ $complaint->supporting_url }}</a>
                                                </p>
                                            @endif
                                            <p>Bukti Foto:</p>
                                            @foreach ($complaint->files as $file)
                                                @if (Str::endsWith($file->file_path, ['.jpg', '.jpeg', '.png', '.gif']))
                                                    <img src="{{ asset('storage/' . $file->file_path) }}" alt="Bukti Foto"
                                                        width="150" style="cursor: pointer;"
                                                        onclick="showImageModal('{{ asset('storage/' . $file->file_path) }}')">
                                                @elseif (Str::endsWith($file->file_path, ['.mp4', '.mov', '.avi']))
                                                    <video width="320" height="240" controls>
                                                        <source src="{{ asset('storage/' . $file->file_path) }}"
                                                            type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @endif
                                            @endforeach
                                            <div class="modal fade" id="imageModal" tabindex="-1"
                                                aria-labelledby="imageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="imageModalLabel">Preview
                                                            </h5>
                                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img id="modalImage" src="" alt="Bukti Foto"
                                                                class="img-fluid">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                data-dismiss="modal">Tutup</button>
                                                            <a id="downloadLink" href="#" download
                                                                class="btn btn-primary"><i
                                                                    class="fa-solid fa-download"></i> Download Gambar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-muted text-md mt-2"><b>Aduan Dibuat:
                                                </b>{{ Carbon\Carbon::parse($complaint->created_at)->locale('id')->translatedFormat('l, j F Y H:i:s') }}
                                                / {{ $complaint->user->name }}</p>
                                            <p class="text-muted text-md mt-2"><b>Terakhir Diperbarui:
                                                </b>{{ Carbon\Carbon::parse($complaint->updated_at)->locale('id')->translatedFormat('l, j F Y H:i:s') }}
                                                / {{ $complaint->user->name }}</p>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ route('qm.complaint.index') }}"
                                                    class="btn btn-outline-secondary"><i
                                                        class="fa-solid fa-chevron-left"></i>
                                                    Kembali</a>
                                                @if ($complaint->current_status_id == 1 || $complaint->current_status_id == 10)
                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#exampleModal"><i
                                                            class="fa-regular fa-pen-to-square"></i>
                                                        Update Status</button>
                                                @elseif($complaint->current_status_id == 2)
                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#exampleModal"><i
                                                            class="fa-regular fa-pen-to-square"></i>
                                                        Teruskan ke FGM</button>
                                                @elseif($complaint->current_status_id == 5)
                                                    <form action="{{ route('qm.request.close', $complaint->id) }}"
                                                        method="POST" id="close-form-{{ $complaint->id }}">
                                                        @csrf
                                                        <button type="button" class="btn btn-success"
                                                            data-toggle="modal"
                                                            data-target="#close-modal-{{ $complaint->id }}">
                                                            <i class="fa-regular fa-circle-xmark"></i> Ajukan close aduan
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Perbarui Status
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('qm.update.status', $complaint->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="id_status"
                                                                        class="form-label required">Status</label>
                                                                    <select class="form-control" id="id_status"
                                                                        name="complaint_status_id">
                                                                        <option value="" class="text-center">.::
                                                                            Pilih Status ::.</option>
                                                                        @forelse ($status as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ $complaint->current_status_id == $item->id ? 'selected' : '' }}>
                                                                                {{ $item->status_name }}</option>
                                                                        @empty
                                                                            <option value="">Status tidak tersedia
                                                                            </option>
                                                                        @endforelse
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="message-text"
                                                                        class="col-form-label required">Catatan:</label>
                                                                    <textarea class="form-control" id="message-text" name="notes" placeholder="Masukkan catatan"></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="supporting_document"
                                                                        class="form-label">Dokumen Pendukung (PDF)</label>
                                                                    <input class="form-control" type="file"
                                                                        id="supporting_document"
                                                                        name="supporting_document" accept=".pdf">
                                                                    <small class="text-muted"><i
                                                                            class="fas fa-info-circle"></i> (Opsional)
                                                                        Hanya
                                                                        file PDF yang diperbolehkan.</small>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="supporting_document"
                                                                        class="form-label">URL Pendukung</label>
                                                                    <input class="form-control" type="url"
                                                                        id="supporting_document" name="supporting_url"
                                                                        placeholder="Masukkan URL, contoh: https://example.com">
                                                                    <small class="text-muted"><i
                                                                            class="fas fa-info-circle"></i> (Opsional)
                                                                        Masukkan URL pendukung
                                                                        apabila ada.</small>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-outline-secondary"
                                                                        data-dismiss="modal">Tutup</button>
                                                                    <button type="submit" class="btn btn-primary"><i
                                                                            class="fa-solid fa-floppy-disk"></i>
                                                                        Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="close-modal-{{ $complaint->id }}" tabindex="-1"
                                                aria-labelledby="confirmCloseLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="confirmCloseLabel">Konfirmasi
                                                                Permintaan Close Aduan</h5>
                                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah kamu yakin ingin mengirimkan permintaan close aduan
                                                            dengan ticket
                                                            <span
                                                                class="text-bold">{{ $complaint->complaint_ticket }}</span>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                data-dismiss="modal">Batal</button>
                                                            <button type="button" class="btn btn-success"
                                                                onclick="document.getElementById('close-form-{{ $complaint->id }}').submit();">
                                                                <i class="fa-regular fa-circle-check"></i> Ajukan Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade mx-1" id="history" role="tabpanel"
                                            aria-labelledby="history-tab">
                                            <h5 class="mt-3 mb-3"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat
                                                Aktivitas Aduan</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @forelse ($history as $item)
                                                        <div class="timeline">
                                                            <div>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i>
                                                                        {{ Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('l, j F Y H:i:s') }}</span>
                                                                    <h3 class="timeline-header"><a
                                                                            href="#">{{ $item->user->name }}</a>
                                                                    </h3>
                                                                    <div class="timeline-body">
                                                                        <span class="text-bold ">Status:
                                                                            {{ $item->complaintStatus->status_name }}</span><br>
                                                                        <span>{{ $item->complaintStatus->status_description }}</span><br>
                                                                        <span class=" "><i
                                                                                class="fa-solid fa-pencil"></i> Catatan:
                                                                            <br></span>
                                                                        {{ $item->notes }}
                                                                        @if ($item->supporting_url != null)
                                                                            <p><i class="fa-solid fa-link"></i> URL
                                                                                Pendukung: <a
                                                                                    href="{{ $complaint->supporting_url }}">{{ $complaint->supporting_url }}</a>
                                                                            </p>
                                                                        @endif
                                                                    </div>
                                                                    <div class="timeline-footer">
                                                                        @if ($item->supporting_document != null)
                                                                            <button class="my-2 btn-sm" style="background-color: rgb(23, 71, 185)"><a
                                                                                    class="text-white"
                                                                                    href="{{ asset('storage/' . $item->supporting_document) }}"
                                                                                    target="_blank"><i
                                                                                        class="fa-regular fa-eye"></i>
                                                                                    Dokumen
                                                                                    Pendukung</a></button>
                                                                        @endif
                                                                        {{-- <a class="btn btn-primary btn-sm">Read more</a>
                                                                    <a class="btn btn-danger btn-sm">Delete</a> --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p class="text-center">Tidak ada riwayat aktivitas
                                                    @endforelse
                                                    {{-- @if ($complaint->current_status_id == 1 || $complaint->current_status_id == 10)
                                                        <button type="button" class="btn btn-primary"
                                                            data-toggle="modal" data-target="#exampleModal"><i
                                                                class="fa-regular fa-pen-to-square"></i>
                                                            Update Status</button>
                                                    @endif --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
