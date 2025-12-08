@extends('layouts.appAccounting')
@section('content')
@section('title', 'Maintenance Penagihan')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 RDZMobilePaddingLR0">
            <div class="card">
                <div class="card-header">Tanda Terima Penagihan</div>
                <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                    <div class="form-container col-md-12">
                        <form method="POST" action="{{ url('') }}" id="form_maintenancepenagihan">
                            {{ csrf_field() }}

                            <!-- Supplier Section -->
                            <div class="row mb-3">
                                <div class="col-md-1">
                                    <label for="supplier">Supplier</label>
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <input type="text" id="supplier_1" name="supplier_1" class="form-control"
                                        style="width: 150px; margin-right: 10px;">
                                    <input type="text" id="supplier_2" name="supplier_2" class="form-control"
                                        style="width: 1000px;">
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-default" id="btn_supplier">...</button>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-warning" id="btn_clear" style="width: 100px">Clear</button>
                                </div>
                            </div>

                            <!-- BTTB Belum Tertagih Section -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <h5>BTTB Belum Tertagih</h5>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary" id="btn_display">Display
                                        BTTB</button>
                                </div>
                            </div>

                            <!-- BTTB Table -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table class="table table-bordered" id="table_bttb">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>No. BTTB</th>
                                                <th>No. Surat Jalan</th>
                                                <th>No. PO</th>
                                                <th>SubTotal</th>
                                                <th>PPN %</th>
                                                <th>PPN Price</th>
                                                <th>Total Price</th>
                                                <th>ID. Mata Uang</th>
                                                <th>Mata Uang</th>
                                                <th>Kurs</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <small>*) Double click item yang dipilih untuk melihat detail isi BTTB pada tabel di
                                        bawah.</small>
                                </div>
                            </div>

                            <!-- Detail Isi BTTB Section -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <h5>Detail Isi BTTB</h5>
                                    <table class="table table-bordered" id="table_detail">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>No. BTTB</th>
                                                <th>No. Terima</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Qty Tagih</th>
                                                <th>Unit Price</th>
                                                <th>Sub Total</th>
                                                <th>PPN %</th>
                                                <th>PPN Price</th>
                                                <th>Total Price</th>
                                                <th>ID. Mata Uang</th>
                                                <th>Mata Uang</th>
                                                <th>Kurs</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Input Ke Penagihan Button -->
                            <div class="row mb-3">
                                <div class="col-md-12 text-end">
                                    <button type="button" class="btn btn-success" id="btn_input">Input Ke Penagihan
                                        &gt;&gt;</button>
                                </div>
                            </div>

                            <!-- BTTB Ditagihkan Section -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <h5>BTTB Ditagihkan</h5>
                                </div>
                                <div class="col-md-4">
                                    <label for="id_penagihan" class="form-label">ID Penagihan</label>
                                    <div class="d-flex align-items-center">
                                        <input type="text" id="id_penagihan" name="id_penagihan"
                                            class="form-control">
                                        <button class="input" type="button" id="btn_penagihan"
                                            style="border-radius: 5px; width: 40px; height:35px; cursor: pointer; border: 1px solid black;">...</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggal_penagihan">Tanggal Penagihan</label>
                                    <input type="date" id="tanggal_penagihan" name="tanggal_penagihan"
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="id_penagihan_supplier">ID Penagihan Supplier</label>
                                    <input type="text" id="id_penagihan_supplier" name="id_penagihan_supplier"
                                        class="form-control">
                                </div>
                            </div>

                            <!-- Total Nilai Penagihan -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="subtotal">SubTotal</label>
                                    <input type="text" id="subtotal" name="subtotal" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="ppn_price">PPN Price</label>
                                    <input type="text" id="ppn_price" name="ppn_price" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="total_price">Total Price</label>
                                    <input type="text" id="total_price" name="total_price" class="form-control">
                                </div>
                            </div>

                            <!-- Jenis PPH and PPH Price Section -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="jenis_pph">Jenis PPH</label>
                                    <div class="d-flex align-items-center">
                                        <input type="text" id="idjenis_pph" name="idjenis_pph"
                                            class="form-control" style="width: 80px">
                                        <input type="text" id="jenis_pph" name="jenis_pph" class="form-control"
                                            style="width: 500px">
                                        <button class="input" type="button" id="btn_jnspph"
                                            style="border-radius: 5px; width: 40px; height:35px; cursor: pointer; border: 1px solid black;">...</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="pph_percent">PPH %</label>
                                    <div class="d-flex align-items-center">
                                        <input type="text" id="idpph_percent" name="idpph_percent"
                                            class="form-control" style="width: 80px">
                                        <input type="text" id="pph_percent" name="pph_percent"
                                            class="form-control" style="width: 500px">
                                        <button class="input" type="button" id="btn_pphpersen"
                                            style="border-radius: 5px; width: 40px; height:35px; cursor: pointer; border: 1px solid black;">...</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="pph_price">PPH Price</label>
                                    <input type="text" id="pph_price" name="pph_price" class="form-control">
                                </div>
                                <br>
                                <div class="col-md-4">
                                    <br>
                                    <h5 for="total_np" style="font-weight: bold;">Total Nilai Penagihan</h5>
                                    <div class="d-flex">
                                        <input type="text" id="total_np" name="total_np" class="form-control">
                                        <label for="pph_price" style="visibility: hidden">AAAAAAAAAAAAAAAA</label>
                                        <button type="submit" class="btn btn-success ml-auto"
                                            style="width: 200px;">POST</button>
                                    </div>
                                </div>
                            </div>

                            <!-- BTTB Ditagihkan Table -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table class="table table-bordered" id="table_penagihan">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>No. BTTB</th>
                                                <th>No. Surat Jalan</th>
                                                <th>No. PO</th>
                                                <th>SubTotal</th>
                                                <th>PPN %</th>
                                                <th>PPN Price</th>
                                                <th>Total Price</th>
                                                <th>ID. Mata Uang</th>
                                                <th>Mata Uang</th>
                                                <th>Kurs</th>
                                                <th>No. Faktur Pajak</th>
                                                <th>Tgl Faktur Pajak</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <small>*) Click item yang dipilih untuk melengkapi data atau untuk remove
                                        data.</small>
                                </div>
                            </div>

                            <!-- Update and Remove Buttons -->
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label for="no_bttb">No. BTTB</label>
                                    <input type="text" id="no_bttb" name="no_bttb" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label for="no_suratjalan">No. Surat Jalan</label>
                                    <input type="text" id="no_suratjalan" name="no_suratjalan"
                                        class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label for="no_po">No. PO</label>
                                    <input type="text" id="no_po" name="no_po" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="sub_total">Sub Total</label>
                                    <input type="text" id="sub_total" name="sub_total" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label for="tglFaktur">Tanggal Faktur Pajak</label>
                                    <input type="date" id="tglFaktur" name="tglFaktur" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label for="ppn">PPN</label>
                                    <div class="d-flex align-items-center">
                                        <input type="text" id="ppn_1" name="ppn_1" class="form-control"
                                            style="width: 80px">
                                        <input type="text" id="ppn_2" name="ppn_2" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="total_price_bottom">Total Price</label>
                                    <input type="text" id="total_price_bottom" name="total_price_bottom"
                                        class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label for="kurs">Kurs</label>
                                    <input type="text" id="kurs" name="kurs" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="no_faktur_pajak">No. Faktur Pajak</label>
                                    <input type="text" id="no_faktur_pajak" name="no_faktur_pajak"
                                        class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="no_faktur_pajak" style="visibility: hidden">No. Faktur Pajak</label>
                                    <br>
                                    <button type="button" class="btn btn-primary" id="btn_update">Update
                                        Data</button>
                                    <button type="button" class="btn btn-danger" id="btn_remove">Remove
                                        Data</button>
                                </div>
                            </div>

                            <!-- Post Button -->
                            <div class="row mb-3">
                                <div class="col-md-12 text-end">
                                    {{-- <button type="submit" class="btn btn-success" style="width: 100px">POST</button> --}}
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/Accounting/Hutang/MaintenancePenagihan.js') }}"></script>
@endsection
