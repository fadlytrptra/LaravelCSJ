@extends('layouts.app')
@section('title','Jadwal Meeting')
@section('content')

<style>
.back-icon{
    display:flex;
    align-items:center;
    text-decoration:none;
}
.back-icon:hover svg{
    fill:#0d6efd;
}
table td{
    vertical-align:middle;
}
.btn-orange{
    background-color:#fd7e14;
    border-color:#fd7e14;
    color:#fff;
}

.btn-orange:hover{
    background-color:#e96b0c;
    border-color:#e96b0c;
    color:#fff;
}
.modal-xl{
    max-width: 1200px;
}

td[rowspan]{
    vertical-align: middle !important;
    font-weight: 500;
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
            <a href="{{ url('/meeting/monthly/'.$room->id) }}" class="back-icon me-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="24"
                     height="24"
                     fill="#121212"
                     viewBox="0 0 24 24">
                    <path d="M14.29 6.29 8.59 12l5.7 5.71 1.42-1.42-4.3-4.29 4.3-4.29z"></path>
                </svg>
            </a>

            <h4 class="mb-0">
                Jadwal {{ $room->ruang_meeting }}
            </h4>
        </div>

        <div class="d-flex gap-2">
            <form method="GET">
                <input
                type="date"
                name="tanggal"
                value="{{ $tanggal }}"
                class="form-control"
                onchange="this.form.submit()">
            </form>
            <button
                class="btn btn-primary btn-book"
                data-room="{{ $room->id }}"
                data-start="08:00"
                data-tanggal="{{ $tanggal }}"
                data-toggle="modal"
                data-target="#bookingMeetingModal">
                + Tambah Meeting
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0 text-center">
                <thead class="table-primary">
                    <tr>
                        <th width="150">Jam</th>
                        <th>Pemesan</th>
                        <th>Tujuan Meeting</th>
                        <th width="150">Status</th>
                        @if($isAdmin)
                            <th width="250">Action</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @php
                        $printed = [];
                    @endphp

                    @foreach($timeSlots as $slot)
                        @php
                            $meeting = $meetings[$slot['start']] ?? null;
                        @endphp

                        <tr>
                            <td>
                                {{ $slot['start'] }} - {{ $slot['end'] }}
                            </td>

                            @if($meeting)
                                @php
                                    $start = \Carbon\Carbon::parse($meeting->jam_awal);
                                    $end = \Carbon\Carbon::parse($meeting->jam_akhir);
                                    $duration = $start->diffInHours($end);
                                @endphp

                                @if(!in_array($meeting->id, $printed))
                                    <td rowspan="{{ $duration }}" class="align-middle text-center">
                                        <b>{{ $meeting->NamaUser }}</b>
                                    </td>
                                    <td rowspan="{{ $duration }}" class="align-middle text-center">
                                        {{ $meeting->deskripsi }}
                                    </td>
                                    <td rowspan="{{ $duration }}" class="align-middle text-center">
                                        @if($meeting->status == 'digunakan')
                                            <span class="badge bg-success text-white">
                                                SEDANG DIGUNAKAN
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                BOOKED
                                            </span>
                                        @endif
                                    </td>

                                    @if($isAdmin)
                                        <td rowspan="{{ $duration }}" class="align-middle text-center">
                                            <button
                                                class="btn btn-sm btn-orange btn-edit-meeting"
                                                data-id="{{ $meeting->id }}"
                                                data-room="{{ $meeting->ruangan_id }}"
                                                data-tanggal="{{ $meeting->tanggal }}"
                                                data-start="{{ \Carbon\Carbon::parse($meeting->jam_awal)->format('H:i') }}"
                                                data-end="{{ \Carbon\Carbon::parse($meeting->jam_akhir)->format('H:i') }}"
                                                data-status="{{ $meeting->status }}"
                                                data-pemesan="{{ $meeting->pemesan }}"
                                                data-deskripsi="{{ $meeting->deskripsi }}"
                                                data-toggle="modal"
                                                data-target="#editMeetingModal">
                                                EDIT
                                            </button>

                                            <button
                                                class="btn btn-sm btn-danger btn-cancel-meeting"
                                                data-id="{{ $meeting->id }}">
                                                DIBATALKAN
                                            </button>
                                        </td>
                                    @endif
                                    @php
                                        $printed[] = $meeting->id;
                                    @endphp
                                @endif
                            @else
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-secondary text-white">
                                        KOSONG
                                    </span>
                                </td>
                                @if($isAdmin)
                                    <td></td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
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

<!--Modal Edit Ruang Meeting-->
<div class="modal fade" id="editMeetingModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Meeting</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="edit_meeting_id">

                <div class="form-group">
                    <label>Ruangan</label>
                    <select id="edit_room_id" class="form-control">
                        @foreach($rooms as $r)
                            <option value="{{ $r->id }}">
                                {{ $r->ruang_meeting }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" id="edit_tanggal" class="form-control">
                </div>

                <div class="form-group">
                    <label>Jam Awal</label>
                    <input type="time" id="edit_jam_awal" class="form-control">
                </div>

                <div class="form-group">
                    <label>Jam Akhir</label>
                    <input type="time" id="edit_jam_akhir" class="form-control">
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" id="edit_deskripsi" class="form-control">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select id="edit_status" class="form-control">
                        <option value="booked">Booked</option>
                        <option value="digunakan">Sedang Digunakan</option>
                        <option value="selesai">Sudah Selesai</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">
                    Batal
                </button>
                <button class="btn btn-primary" id="update_meeting">
                    Update
                </button>
            </div>

        </div>
    </div>
</div>


@endsection
