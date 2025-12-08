@extends('layouts.appAccounting')
@section('content')
@section('title', 'Update PIB')

<div class="container-fluid">
    <div class="row justify-content-center">
        <script>
            let successMessage = '';
            let errorMessage = '';
        </script>
        @if (Session::has('success'))
            <script>
                successMessage = "{{ Session::get('success') }}";
            </script>
        @elseif (Session::has('error'))
            <script>
                errorMessage = "{{ Session::get('error') }}";
            </script>
        @endif
        <div class="col-md-7 RDZMobilePaddingLR0">
            <div class="card">
                <div class="card-header">Update PIB</div>
                <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                    <div class="form-container col-md-12">
                        <form method="POST" action="">
                            @csrf
                            <!-- Form fields go here -->
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="id">Supplier</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="sp1" id="sp1" class="form-control"
                                            style="width: 100%">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="sp2" id="sp2" class="form-control"
                                            style="width: 100%">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn" type="button" id="btn_supplier">...</button>
                                    </div>
                                </div>
                                <p></p>
                                <div class="row align-items-center">
                                    <div class="col-md-2" style="padding-left: 15px; white-space: nowrap;">
                                        <label for="id">ID Penagihan</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" id="idpenagihan" name="idtagihan" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn" type="button" id="btn_penagihan">...</button>
                                    </div>
                                    <div class="col-md-1" style="max-width: 100px;">
                                        <label for="id">Tanggal</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" id="tanggal" name="tanggal" class="form-control">
                                    </div>
                                </div>
                                <p></p>
                                <div class="mb-3">
                                    <input id="btn_update" name="update" value="Update" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-modal-content {
        width: 200%;
        /* atau nilai lain sesuai kebutuhanmu */
        max-width: 200%;
        margin: 0 auto;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content"
            style="width: 300%; max-width: 300%; margin: 0 auto; position: relative; left: 50%; transform: translateX(-50%);">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Pemberitahuan Import Barang</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="importForm">
                    <div class="form-group row">
                        <label for="no_pengajuan" class="col-sm-2 col-form-label">No. Pengajuan</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="no_pengajuan" name="no_pengajuan">
                        </div>
                        <label for="id_penagihan" class="col-sm-2 col-form-label">Id. Penagihan</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="id_penagihan" name="id_penagihan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nilai" class="col-sm-2 col-form-label">Nilai</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="nilai" name="nilai" value="0">
                        </div>
                        <label for="id_pib" class="col-sm-2 col-form-label">Id. PIB</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="id_pib" name="id_pib">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_pajak" class="col-sm-2 col-form-label">No. Pajak</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="no_pajak" name="no_pajak">
                        </div>
                        <label for="tgl_pib" class="col-sm-2 col-form-label">Tgl. PIB</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="tgl_pib" name="tgl_pib">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_kontrak" class="col-sm-2 col-form-label">No. Kontrak</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="no_kontrak" name="no_kontrak">
                        </div>
                        <label for="tgl_kontrak" class="col-sm-2 col-form-label">Tgl. Kontrak</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="tgl_kontrak" name="tgl_kontrak">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_invoice" class="col-sm-2 col-form-label">No. Invoice</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="no_invoice" name="no_invoice">
                        </div>
                        <label for="tgl_invoice" class="col-sm-2 col-form-label">Tgl. Invoice</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="tgl_invoice" name="tgl_invoice">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_skbm" class="col-sm-2 col-form-label">No. SKBM</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="no_skbm" name="no_skbm">
                        </div>
                        <label for="tgl_skbm" class="col-sm-2 col-form-label">Tgl. SKBM</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="tgl_skbm" name="tgl_skbm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_skpph" class="col-sm-2 col-form-label">No. SKPPH</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="no_skpph" name="no_skpph">
                        </div>
                        <label for="tgl_skpph" class="col-sm-2 col-form-label">Tgl. SKPPH</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="tgl_skpph" name="tgl_skpph">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_spppb_bc" class="col-sm-2 col-form-label">No. SPPPB BC</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="no_spppb_bc" name="no_spppb_bc">
                        </div>
                        <label for="tgl_spppb_bc" class="col-sm-2 col-form-label">Tgl. SPPPB BC</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="tgl_spppb_bc" name="tgl_spppb_bc">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="TIdTT" name="TIdTT">
                    <input type="hidden" id="TIdPIB" name="TIdPIB">
                    <input type="hidden" id="TPengajuan" name="TPengajuan">
                    <input type="hidden" id="TNilai" name="TNilai">
                    <input type="hidden" id="TNoPajak" name="TNoPajak">
                    <input type="hidden" id="txtKontrak" name="txtKontrak">
                    <input type="hidden" id="dtpKontrak" name="dtpKontrak">
                    <input type="hidden" id="txtInvoice" name="txtInvoice">
                    <input type="hidden" id="dtpInvoice" name="dtpInvoice">
                    <input type="hidden" id="txtSKBM" name="txtSKBM">
                    <input type="hidden" id="dtpSKBM" name="dtpSKBM">
                    <input type="hidden" id="txtSKPPH" name="txtSKPPH">
                    <input type="hidden" id="dtpSKPPH" name="dtpSKPPH">
                    <input type="hidden" id="txtSPPBBC" name="txtSPPBBC">
                    <input type="hidden" id="dtpSPPBBC" name="dtpSPPBBC">
                    <div class="table-responsive">
                        <table class="table mt-3" style="width: max-content" id="tableupdate">
                            <thead class="table-dark" style="white-space: nowrap">
                                <tr>
                                    <th>No. Pengajuan</th>
                                    <th>Nilai</th>
                                    <th>No. Pajak / PIB</th>
                                    <th>Tgl PIB</th>
                                    <th>No. Kontrak</th>
                                    <th>Status Order</th>
                                    <th>Tgl Kontrak</th>
                                    <th>No. Invoice</th>
                                    <th>Tgl Invoice</th>
                                    <th>No. SKBM</th>
                                    <th>Tgl SKBM</th>
                                    <th>No. SKPPH</th>
                                    <th>Tgl SKPPH</th>
                                    <th>No. SPPB BC</th>
                                    <th>Tgl SPPB BC</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="modal-footer-left">
                        <button id="btn_proses" class="btn btn-primary">Proses</button>
                        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/Accounting/Hutang/UpdatePIB.js') }}"></script>
@endsection
