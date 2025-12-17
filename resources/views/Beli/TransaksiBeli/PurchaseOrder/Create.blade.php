@extends('layouts.appOrderPembelian')

@section('title', 'Maintenance SPPB Pembelian')

@section('content')
    <link href="{{ asset('css/CreatePurchaseOrder.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        .btn-batal {
            background: #EEE;
            border-color: #101010;
            color: #E67E22;
        }

        .btn-batal:hover {
            background: #f18203;
            border-color: #CA6F1E;
            color: #fff;
        }

        .table-detail-compact.dataTable thead>tr>th,
        .table-detail-compact.dataTable tbody>tr>td {
            padding: 2px 6px;
            white-space: nowrap;
            font-size: 0.8rem;
            vertical-align: middle;
        }

        .table-detail-compact.dataTable thead>tr>th {
            border-bottom-width: 1px;
        }

        /* Hilangkan jarak antar head/body scroll wrapper biar seperti grid lama */
        .dataTables_wrapper .dataTables_scrollHead {
            margin-bottom: 0 !important;
        }

        .dataTables_wrapper .dataTables_scrollBody {
            border-top: none !important;
        }

        /* Jarak vertikal antar blok (form ↔ tabel ↔ form bawah) */
        .section-top-form {
            margin-bottom: 1.5rem;
        }

        .section-table {
            margin: 1.5rem 0;
        }

        .section-bottom-form {
            margin-top: 1.5rem;
        }

        #supplier {
            background-color: #f1f3f5 !important;
            color: #6c757d !important;
            border-color: #ced4da !important;
        }


        #supplier option {
            background-color: #f1f3f5 !important;
            color: #6c757d !important;
            -webkit-text-fill-color: #6c757d !important;
        }


        #supplier:disabled {
            color: #ccc;
            opacity: 1;
        }


    </style>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11 RDZMobilePaddingLR0">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @elseif (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif

                <div class="card font-weight-bold">

                    {{-- HEADER + TOMBOL ATAS --}}
                    <div class="card-header">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                            <div>Maintenance SPPB Pembelian</div>
                        </div>
                    </div>

                    <form method="POST" action="{{ url('purchase-order') }}">
                        @csrf

                        <div class="card-body">

                            {{-- FORM ATAS --}}
                            <div class="row mb-3 section-top-form">
                                <div class="col-md-6">
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Nama Divisi</label>
                                        <div class="col-sm-7">
                                            <select name="kd_div" id="kd_div" class="form-control">
                                                <option value="">Pilih Divisi</option>
                                                @foreach ($divisi as $d)
                                                    <option value="{{ $d->Kd_div }}">{{ trim($d->NM_DIV) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- No SPPB --}}
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">No SPPB</label>
                                        <div class="col-sm-7 d-flex">
                                            <select name="no_sppb" id="no_sppb" class="form-control">
                                                <option value="">-- Pilih No SPPB --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Tanggal SPPB</label>
                                        <div class="col-sm-7">
                                            <input type="date" name="tgl_sppb" id="tgl_sppb" class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">No Transaksi</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="no_trans" id="no_trans" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                {{-- KANAN --}}
                                <div class="col-md-6">
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Kd. Barang</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="kd_brg" id="kd_brg" class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Nama Barang</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nama_brg" id="nama_brg" class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Ket. Barang</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="ket_brg" id="ket_brg" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- BARIS KEDUA: Kategori + Qty/Harga --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Kategori Utama</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="kat_utama" id="kat_utama" class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Kategori</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="kategori" id="kategori" class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Sub Kategori</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="sub_kategori" id="sub_kategori"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Ket. Pembelian</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="ket_pembelian" id="ket_pembelian"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Satuan</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="satuan" id="satuan" class="form-control">
                                        </div>
                                    </div>


                                </div>

                                <div class="col-md-6">
                                    {{-- QTY --}}
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Qty</label>
                                        <div class="col-sm-4">
                                            <input type="number" step="0.01" name="qty" id="qty"
                                                class="form-control text-end">
                                        </div>
                                    </div>

                                    {{-- MATA UANG + KURS --}}
                                    <div class="mb-2 row align-items-center">
                                        <label class="col-sm-3 col-form-label">Mata Uang</label>

                                        <div class="col-sm-5">
                                            <select name="mata_uang" id="mata_uang" class="form-control">
                                                <option value="">Pilih Mata Uang</option>
                                                <option value="1">Rupiah</option>
                                                <option value="2">Dollar</option>
                                                <option value="">kosong</option>
                                            </select>
                                        </div>

                                        <label class="col-sm-2 col-form-label text-end text-nowrap">Kurs Rupiah</label>

                                        <div class="col-sm-2">
                                            <input type="text" step="1.0000" name="kurs" id="kurs"
                                                class="form-control text-end" value="0">
                                        </div>
                                    </div>

                                    {{-- HARGA SATUAN --}}
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Harga Satuan</label>
                                        <div class="col-sm-9">
                                            <input type="text" step="0.01" name="hrg_murni" id="hrg_murni"
                                                class="form-control text-end">
                                        </div>
                                    </div>

                                    {{-- DISCOUNT + PPN --}}
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Discount</label>
                                        <div class="col-sm-3">
                                            <input type="number" step="0.01" name="disc" id="disc"
                                                class="form-control text-end">
                                        </div>
                                        <label class="col-sm-1 col-form-label text-center">%</label>


                                        <label class="col-sm-2 col-form-label text-end">PPN (%)</label>
                                        <div class="col-sm-3">
                                            <input type="number" step="0.1" name="ppn" id="ppn"
                                                class="form-control text-end">
                                        </div>

                                       <div class="col-sm-4 d-none" id="dpp_full_wrapper">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox"
                                                    id="dpp_full"
                                                    name="dpp_full"
                                                    value="1">
                                                <label class="form-check-label fw-semibold" for="dpp_full">
                                                    DPP FULL
                                                </label>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- DPP NILAI LAIN --}}
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">DPP Nilai Lain</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="dpp_nilai_lain" id="dpp_nilai_lain"
                                                class="form-control text-end">
                                        </div>
                                    </div>

                                    {{-- HARGA PPN --}}
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Harga PPN</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="hrg_ppn" id="harga_ppn"
                                                class="form-control text-end">
                                        </div>
                                    </div>

                                    {{-- SUBTOTAL HARGA JUAL --}}
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">SubTotal Harga Jual</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="subtotal_harga_jual" id="subtotal_harga_jual"
                                                class="form-control text-end">
                                        </div>
                                    </div>

                                    {{-- TOTAL HARGA --}}
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Total Harga</label>
                                        <div class="col-sm-9">
                                            <input type="text" step="0.01" name="total_harga" id="total_harga"
                                                class="form-control text-end">
                                        </div>
                                    </div>

                                    {{-- JANGKA WAKTU --}}
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Jangka Waktu</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="jangka_waktu" id="jangka_waktu"
                                                class="form-control text-end">
                                        </div>
                                        <label class="col-sm-2 col-form-label">hari</label>
                                    </div>

                                    {{-- PEMBAYARAN --}}
                                    <div class="mb-2 row">
                                        <label class="col-sm-3 col-form-label">Pembayaran</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="pembayaran" id="pembayaran"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-2 row">
                                        <div class="col-sm-12 text-end">
                                            <button type="button" id="btn_tambah_harga" class="btn btn-primary btn-sm">
                                                TAMBAH HARGA
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- TABEL DETAIL ORDER --}}
                            <div class="row section-table">
                                <div class="col-12">
                                    <table id="tbl_detail_order" class="table table-bordered table-striped"
                                        style="width: 100%;" aria-describedby="table_Approve_info">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Pilih</th>
                                                <th>Tgl Order</th>
                                                <th>Quantity</th>
                                                <th>Pemesan</th>
                                                <th>Nama Mesin</th>
                                                <th>Nama Golongan</th>
                                                <th>No Trans</th>
                                                <th>Tgl Datang</th>
                                                <th>Retur</th>
                                                <th>Direktur</th>
                                                <th>Harga Satuan</th>
                                                <th>Disc</th>
                                                <th>DPP Nilai Lain</th>
                                                <th>PPN</th>
                                                <th>Total Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- FORM BAWAH --}}
                            <div class="row mb-3 section-bottom-form">
                                <div class="col-md-3">
                                    <label class="form-label">Tgl. Datang (mm/dd/yyyy)</label>
                                    <input type="date" name="tgl_datang" id="tgl_datang" class="form-control">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Pembelian</label>
                                   <select id="jenis_pembelian" name="jenis_pembelian" class="form-control">
                                        <option value="">Pilih Jenis</option>
                                        @foreach($jenisList as $j)
                                            <option value="{{ $j->NO_JNS }}">{{ $j->KET }}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Supplier</label>
                                    <select name="supplier" id="supplier" class="form-control">
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Alasan Hapus</label>
                                    <input type="text" name="alasan_hapus" id="alasan_hapus" class="form-control">
                                </div>
                            </div>


                            <div class="action-footer">
                                <div class="action-buttons">
                                    <button type="button" id="btn-isi" class="btn btn-outline-secondary btn-sm btn-mode">
                                        ISI
                                    </button>

                                    <button type="button" id="btn-lihat" class="btn btn-outline-secondary btn-sm btn-mode">
                                        LIHAT
                                    </button>

                                    <button type="button" id="btn_proses" class="btn btn-outline-success btn-sm">
                                        PROSES
                                    </button>

                                    <button type="button" id="btn-exit-cancel"
                                        class="btn btn-outline-dark btn-sm"
                                        data-href="{{ url('/Beli') }}">
                                        KELUAR
                                    </button>
                                </div>
                            </div>

                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/OrderPembelian/CreatePurchaseOrder/CreatePurchaseOrder.js') }}"></script>
@endsection
