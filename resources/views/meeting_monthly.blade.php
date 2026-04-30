@extends('layouts.app')
@section('title','Meeting Bulanan')
@section('content')

<style>
    .card:hover{
        transform: translateY(-3px);
        transition: 0.2s;
    }
    .modal-xl{
        max-width: 1200px;
    }
    .meeting-title{
        font-size:18px;
        font-weight:500;
        color:#212529;
    }
    .text-decoration-none:hover{
        text-decoration: none;
    }
    .alert{
        margin-top: 40px;
    }
    .durasi-group .durasi{
        min-width:70px;
        margin-right:6px;
        margin-bottom:6px;
        transition:all .2s ease;
    }

    .durasi-group .durasi:hover{
        transform:translateY(-2px);
    }

    .durasi-group .durasi.active{
        background:#007bff !important;
        color:#fff !important;
        border-color:#007bff !important;
        box-shadow:0 4px 12px rgba(0,123,255,.45);
        transform:scale(1.08);
    }
</style>
<script src="{{ asset('js/meeting_sch.js') }}"></script>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center">
           <a href="{{ route('meeting.index') }}" class="back-icon me-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="24"
                     height="24"
                     fill="#121212"
                     viewBox="0 0 24 24">
                    <path d="M14.29 6.29 8.59 12l5.7 5.71 1.42-1.42-4.3-4.29 4.3-4.29z"></path>
                </svg>
            </a>

            <h4 class="mb-0">
                Meeting {{ $room->ruang_meeting }} Bulan {{ $namaBulan }}
            </h4>
        </div>
        <div class="d-flex gap-2">
            <form method="GET">
                <input
                    type="month"
                    name="bulan"
                    value="{{ request('bulan') ?? date('Y-m') }}"
                    class="form-control"
                    onchange="this.form.submit()"
                >
            </form>

            <button
                class="btn btn-primary btn-book"
                data-room="{{ $room->id }}"
                data-start="08:00"
                data-tanggal="{{ date('Y-m-d') }}"
                data-toggle="modal"
                data-target="#bookingMeetingModal">
                + Tambah Meeting
            </button>
        </div>
    </div>


    <div class="row">
        @forelse($meetings as $meeting)
            <div class="col-md-4 mb-3">
                <a href="/meeting/{{ $room->id }}?tanggal={{ $meeting->tanggal }}"
                    class="text-decoration-none">

                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="meeting-title mb-2">
                                {{ $meeting->deskripsi }}
                            </h6>
                            <p class="text-muted mb-1 d-flex align-items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="18"
                                    height="18"
                                    fill="#3f57e4"
                                    viewBox="0 0 24 24">
                                    <path d="M19 4h-2V2h-2v2H9V2H7v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2M5 20V8h14V6v14z"></path>
                                    <path d="M7 11h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2zm-8 4h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z"></path>
                                </svg>

                                {{ date('d M Y', strtotime($meeting->tanggal)) }}
                            </p>
                            <p class="text-muted mb-1">
                                🕒 {{ date('H:i', strtotime($meeting->jam_awal)) }} -
                                {{ date('H:i', strtotime($meeting->jam_akhir)) }}
                            </p>
                            <p class="text-muted small mb-0">
                                👤 {{ $meeting->NamaUser }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
             @empty
            <div class="col-12">
                <div class="alert alert-secondary text-center">
                    Belum ada meeting pada bulan <b>{{ $namaBulan }}</b>
                </div>
            </div>
        @endforelse
    </div>

</div>

<!--Modal Pesan Ruang Meeting-->
<div class="modal fade" id="bookingMeetingModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pesan Ruang Meeting</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="room_id">

                <div class="form-group">
                    <label>Tanggal</label>
                    <input
                        type="date"
                        id="tanggal"
                        class="form-control"
                        value="{{ $tanggal }}">
                </div>

                <div class="form-group">
                    <label>Pemesan</label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ Auth::user()->NamaUser }}"
                        readonly>
                </div>

                <div class="form-group">
                    <label>Tujuan Meeting</label>
                    <textarea
                    id="deskripsi"
                    class="form-control"
                    placeholder="Masukkan tujuan meeting"></textarea>
                </div>

                <div class="form-group">
                    <label>Jam Awal</label>
                    <input
                        type="time"
                        id="jam_awal"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label>Durasi Rapat</label>
                    <div class="durasi-group">
                        <button type="button" class="btn btn-outline-primary durasi" data-durasi="60">1 Jam</button>
                        <button type="button" class="btn btn-outline-primary durasi" data-durasi="120">2 Jam</button>
                        <button type="button" class="btn btn-outline-primary durasi" data-durasi="180">3 Jam</button>
                        <button type="button" class="btn btn-outline-primary durasi" data-durasi="240">4 Jam</button>
                        <button type="button" class="btn btn-outline-primary durasi" data-durasi="300">5 Jam</button>
                        <button type="button" class="btn btn-outline-primary durasi" data-durasi="360">6 Jam</button>
                        <button type="button" class="btn btn-outline-primary durasi" data-durasi="420">7 Jam</button>
                        <button type="button" class="btn btn-outline-primary durasi" data-durasi="480">8 Jam</button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Jam Akhir</label>
                    <input
                        type="time"
                        id="jam_akhir"
                        class="form-control"
                        readonly>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">
                    Batal
                </button>

                <button class="btn btn-primary" id="save_meeting">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

@endsection
