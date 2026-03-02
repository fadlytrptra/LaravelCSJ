@extends('layouts.appOrderPembelian')
@section('content')
@section('title', 'Create SPPB')
@include('Beli/Transaksi/CreateSPPB/modalTambahSPPB')
<style>
    #sppb_tableOrderPembelian tr {
        cursor: pointer;
    }

    .swal-button-wrapper {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }

    .swal-btn {
        padding: 10px 22px;
        border-radius: 6px;
        border: none;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        color: white;
        min-width: 140px;
    }

    /* Download Button */
    .swal-btn-download {
        background-color: #0fe07f;
    }

    .swal-btn-download:hover {
        background-color: #1bad69;
        transform: translateY(-2px);

    }

    /* Delete Button */
    .swal-btn-delete {
        background-color: #dc3545;
    }

    .swal-btn-delete:hover {
        background-color: #bb2d3b;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
    }
</style>
<input type="hidden" name="idUser" id="idUser" value={{ $user_id }}>
<input type="hidden" name="no_trans_revisi" id="no_trans_revisi" value="{{ $noTransRevisi ?? '' }}">
<input type="hidden" id="no_sppb_revisi" value="{{ $noSppbRevisi ?? '' }}">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            <button class="acs-icon-btn acs-add-btn acs-float" data-bs-toggle="modal" data-bs-target="#modalSPPB"
                data-typeForm="tambah" id="buttonTambahSPPB">
                <div class="acs-add-icon"></div>
                <div class="acs-btn-txt">Tambah SPPB</div>
            </button>
            <div class="card">
                <div class="card-header">Create SPPB</div>
                <div class="card-body">
                    <table id="table_sppb" class="table table-bordered table-striped" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Nomor SPPB</th>
                                <th>Nama Supplier</th>
                                <th>Tanggal SPPB</th>
                                <th>Actions</th>
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
<input type="file"
       id="hiddenAttachFile"
       accept=".jpg,.jpeg,.png,.pdf"
       style="display:none;">

<script src="{{ asset('js/OrderPembelian/CreateSPPB/CreateSPPB.js') }}"></script>
@endsection
