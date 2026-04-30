@extends('layouts.app')
@section('title', 'Meeting')
@section('content')


<link href="{{ asset('css/meeting.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Ruang Meeting</span>
                    <span style="font-size:18px;"><b>Apabila ingin perubahan atau hal lain, Hubungi Kiki (081330330278)</b></span>

                    @if($isAdmin)
                    <button
                        class="btn btn-primary d-none"
                        data-toggle="modal"
                        data-target="#tambahAdminModal">
                        Tambah Administrator
                    </button>
                    @endif
                </div>

                @if($isAdmin)
                <button
                    class="acs-icon-btn acs-add-btn acs-float"
                    id="button_tambahRoom"
                    data-toggle="modal"
                    data-target="#tambahRoomModal">

                    <div class="acs-add-icon"></div>
                    <div class="acs-btn-txt">Tambah Ruangan</div>
                </button>
                @endif

                <div class="card-body">
                <div class="ml-3 mb-3">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#rekapMeetingModal">
                        Rekap Meeting
                    </button>
                </div>
                    <table id="table_room" class="table table-bordered w-100">
                        <thead class="table-primary">
                            <tr>
                                <th>Ruangan</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Modal Tambah Ruangan --}}
<div class="modal fade" id="tambahRoomModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Ruangan</h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Ruangan</label>
                    <input
                        type="text"
                        id="ruang_meeting"
                        class="form-control"
                        placeholder="Contoh: Ruang Meeting">
                </div>

            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                    id="clear_room">
                    Batal
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="save_room">
                    Simpan
                </button>

            </div>
        </div>
    </div>
</div>


{{-- Modal Tambah Administrator --}}
@if($isAdmin)
<div class="modal fade" id="tambahAdminModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Administrator</h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Pilih Pegawai</label>
                    <select
                        id="nomorUser_adm"
                        class="form-control"
                        required>
                        <option selected disabled>
                            -- Pilih Pegawai --
                        </option>
                        @foreach($pegawai as $p)
                        <option
                            value="{{ $p->NomorUser }}"
                            data-nama="{{ $p->NamaUser }}">
                            {{ $p->NamaUser }} - {{ $p->NomorUser }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal">
                    Batal
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="save_admin">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@endif


{{-- Modal Rekap Data --}}
<div class="modal fade" id="rekapMeetingModal" tabindex="-1">
    <div class="modal-dialog modal-xl" style="max-width:90%;">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Rekap Meeting</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="date" id="rekapTanggal" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                     <div class="col-md-6 pt-2">
                        <strong id="rekapTitle"></strong>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-primary">
                            <tr id="roomHeader"></tr>
                            <tr id="roomSubHeader"></tr>
                        </thead>
                        <tbody id="rekapBody"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>


<script>
    let rooms = @json($rooms);
</script>

<script src="{{ asset('js/meeting.js') }}"></script>

@endsection
