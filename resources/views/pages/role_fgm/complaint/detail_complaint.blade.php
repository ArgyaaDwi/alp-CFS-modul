@extends('layouts.fgm')
@push('scripts')
    <script type="text/javascript">
        function showImageModal(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('downloadLink').href = imageUrl;
            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }
    </script>
@endpush
@push('styles')
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><b>Detail Feedback</b></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.fgm') }}"><i
                                    class="fa-solid fa-house"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('fgm.complaint.index') }}"
                                style="text-color: black">Feedback</a></li>
                        <li class="breadcrumb-item"><span>{{ $complaint->id }}</span>
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
                                    <h4>{{ $complaint->batch_number }} / {{ $complaint->id }}</h4>
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
                                            <p>Status Aduan: {{$complaint->currentStatus->status_name}}</p>
                                            <h5>Judul Aduan: {{ $complaint->complaint_title }}</h5>
                                            <label for="">Deskripsi</label>
                                            <textarea name="" id="" cols="30" rows="5" class="form-control" disabled>{{ $complaint->complaint_description }}</textarea>
                                            <label for="">Harapan</label>
                                            <textarea name="" id="" cols="30" rows="5" class="form-control" disabled>{{ $complaint->complaint_hopeful_solution }}</textarea>
                                            @if ($complaint->supporting_document)
                                                <button class="btn btn-info my-2"><a class="text-white"
                                                        href="{{ asset('storage/' . $complaint->supporting_document) }}"
                                                        target="_blank"><i class="fa-regular fa-eye"></i> Dokumen
                                                        Pendukung</a></button>
                                            @endif
                                            <p>Bukti Foto:</p>
                                            @foreach ($complaint->files as $file)
                                                @if (Str::endsWith($file->file_path, ['.jpg', '.jpeg', '.png', '.gif']))
                                                    <!-- Thumbnail yang bisa diklik -->
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
                                                                class="btn btn-primary"><i class="fa-solid fa-download"></i>
                                                                Download Gambar</a>
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
                                            <a href="{{ route('fgm.complaint.index') }}"
                                                class="btn btn-outline-secondary"><i class="fa-solid fa-chevron-left"></i>
                                                Kembali</a>
                                            {{-- <a href="" class="btn btn-primary"><i
                                                    class="fa-regular fa-pen-to-square"></i> Perbarui Data</a> --}}
                                            @if ( $complaint->current_status_id == 4)
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#exampleModal"><i
                                                        class="fa-regular fa-pen-to-square"></i>
                                                    Update Status</button>
                                            @endif
                                            <!-- Modal -->
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
                                                                    <label for="id_distributor"
                                                                        class="form-label">Status</label>
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
                                                                        class="col-form-label">Catatan:</label>
                                                                    <textarea class="form-control" id="message-text" name="notes"></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="supporting_document"
                                                                        class="form-label">Dokumen Pendukung (PDF)</label>
                                                                    <input class="form-control" type="file"
                                                                        id="supporting_document"
                                                                        name="supporting_document" accept=".pdf">
                                                                    <i class="fas fa-info-circle"></i> (Opsional) Hanya
                                                                    file PDF yang diperbolehkan.
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary"
                                                                        data-dismiss="modal">Tutup</button>
                                                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                                                                </div>
                                                            </form>
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
                                                                        <span class=""><i
                                                                                class="fa-solid fa-pencil"></i> Catatan:
                                                                            <br></span>
                                                                        {{ $item->notes }}
                                                                    </div>
                                                                    <div class="timeline-footer">
                                                                        @if ($item->supporting_document != null)
                                                                            <button class="btn btn-primary my-2 btn-sm"><a
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
