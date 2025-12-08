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

/* ---------- TABEL DETAIL: KOMPAK + 1 BARIS HEADER ---------- */
.table-detail-compact.dataTable thead > tr > th,
.table-detail-compact.dataTable tbody > tr > td {
    padding: 2px 6px;
    white-space: nowrap;
    font-size: 0.8rem;
    vertical-align: middle;
}

.table-detail-compact.dataTable thead > tr > th {
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

                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" id="btn-isi" class="btn btn-outline-secondary btn-sm btn-mode">
                                ISI
                            </button>

                            <button type="button" id="btn-lihat" class="btn btn-outline-secondary btn-sm btn-mode">
                                LIHAT
                            </button>

                            <button type="button" class="btn btn-outline-success btn-sm">
                                PROSES
                            </button>

                            {{-- tombol ini dinamis: KELUAR (mode awal) / BATAL (saat ISI/LIHAT) --}}
                            <button type="button" id="btn-exit-cancel" class="btn btn-outline-dark btn-sm">
                                KELUAR
                            </button>
                        </div>
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
                                        <select name="no_sppb" id="no_sppb" class="form-control" disabled>
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
                                        <input type="text" name="sub_kategori" id="sub_kategori" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Ket. Pembelian</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="ket_pembelian" id="ket_pembelian" class="form-control">
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
                                        <input type="number" step="0.01" name="qty" id="qty" class="form-control text-end">
                                    </div>
                                </div>

                                {{-- MATA UANG + KURS --}}
                                <div class="mb-2 row align-items-center">
                                    <label class="col-sm-3 col-form-label">Mata Uang</label>

                                    <div class="col-sm-5">
                                        <select name="mata_uang" id="mata_uang" class="form-control">
                                            <option value="">Pilih Mata Uang</option>
                                        </select>
                                    </div>

                                    <label class="col-sm-2 col-form-label text-end text-nowrap">Kurs Rupiah</label>

                                    <div class="col-sm-2">
                                        <input type="text" step="1.0000" name="kurs" id="kurs" class="form-control text-end" value="0">
                                    </div>
                                </div>

                                {{-- HARGA SATUAN --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Harga Satuan</label>
                                    <div class="col-sm-9">
                                        <input type="text" step="0.01" name="harga_satuan" id="harga_satuan" class="form-control text-end">
                                    </div>
                                </div>

                                {{-- DISCOUNT + PPN --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Discount</label>
                                    <div class="col-sm-3">
                                        <input type="text" step="0.01" name="disc" id="disc" class="form-control text-end">
                                    </div>
                                    <label class="col-sm-1 col-form-label text-center">%</label>

                                    <label class="col-sm-2 col-form-label text-end">PPN (%)</label>
                                    <div class="col-sm-3">
                                        <input type="text" step="0.1" name="ppn" id="ppn" class="form-control text-end">
                                    </div>
                                </div>

                                {{-- DPP NILAI LAIN --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">DPP Nilai Lain</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="dpp_nilai_lain" id="dpp_nilai_lain" class="form-control text-end">
                                    </div>
                                </div>

                                {{-- HARGA PPN --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Harga PPN</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="harga_ppn" id="harga_ppn" class="form-control text-end">
                                    </div>
                                </div>

                                {{-- SUBTOTAL HARGA JUAL --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">SubTotal Harga Jual</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="subtotal_harga_jual" id="subtotal_harga_jual" class="form-control text-end">
                                    </div>
                                </div>

                                {{-- TOTAL HARGA --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Total Harga</label>
                                    <div class="col-sm-9">
                                        <input type="text" step="0.01" name="total_harga" id="total_harga" class="form-control text-end">
                                    </div>
                                </div>

                                {{-- JANGKA WAKTU --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Jangka Waktu</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="jangka_waktu" id="jangka_waktu" class="form-control text-end">
                                    </div>
                                    <label class="col-sm-2 col-form-label">hari</label>
                                </div>

                                {{-- PEMBAYARAN --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">Pembayaran</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="pembayaran" id="pembayaran" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <div class="col-sm-12 text-end">
                                        <button type="button" class="btn btn-primary btn-sm">
                                            Tambah Harga
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- TABEL DETAIL ORDER --}}
                        <div class="row section-table">
                            <div class="col-12">
                                <table id="tbl-detail-order"
                                       class="table table-bordered table-striped table-sm w-100 table-detail-compact">
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
                                        {{-- Data diisi via DataTables --}}
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
                                <select name="jenis_pembelian" id="jenis_pembelian" class="form-control">
                                    <option value="">- Pilih -</option>
                                    <option value="import">Import</option>
                                    <option value="import">Import Facility</option>
                                    <option value="local">Lokal</option>
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
                    </div>

                    {{-- FOOTER --}}
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex justify-content-start gap-2 mb-2">
                                    <button type="button" class="btn btn-outline-primary">CETAK SPPB</button>
                                    <button type="button" class="btn btn-batal">BATAL SPPB</button>
                                    <button type="button" class="btn btn-outline-danger">HAPUS SPPB</button>
                                </div>
                            </div>

                            <div class="col-md-4 d-flex justify-content-end">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-secondary">
                                        Lihat Daftar Harga
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
let detailTable = null;
let mode = "";   // "", "ISI", "LIHAT"

// --- UTILITAS CLEAR FORM + TABLE ---
function clearDetailSppb() {
    document.getElementById('tgl_sppb').value   = '';
    document.getElementById('tgl_datang').value = '';
    document.getElementById('no_trans').value   = '';
    document.getElementById('kd_brg').value     = '';
    document.getElementById('nama_brg').value   = '';
    document.getElementById('ket_brg').value    = '';
    document.getElementById('kat_utama').value  = '';
    document.getElementById('kategori').value   = '';
    document.getElementById('sub_kategori').value  = '';
    document.getElementById('ket_pembelian').value  = '';
    document.getElementById('satuan').value     = '';
    document.getElementById('qty').value        = '';
    document.getElementById('kurs').value       = '0';
    document.getElementById('disc').value       = '';
    document.getElementById('ppn').value        = '';
    document.getElementById('dpp_nilai_lain').value = '';
    document.getElementById('harga_ppn').value = '';
    document.getElementById('subtotal_harga_jual').value = '';
    document.getElementById('jangka_waktu').value = '';
    document.getElementById('total_harga').value   = '';
    document.getElementById('pembayaran').value    = '';

    const ketDetail = document.getElementById('keterangan_detail');
    if (ketDetail) {
        ketDetail.value = '';
    }

    const noSppbSelect = document.getElementById('no_sppb');
    if (noSppbSelect) {
        noSppbSelect.innerHTML = '<option value="">-- Pilih No SPPB --</option>';
    }

    if (detailTable) {
        detailTable.clear().draw();
    }
}

// ================== MODE ISI ==================
function loadDataByDivisiIsi() {
    const kdDiv = document.getElementById('kd_div').value;

    if (!kdDiv || mode !== 'ISI') {
        if (detailTable) detailTable.clear().draw();
        return;
    }

    fetch("{{ route('purchaseorder.detail_sppb') }}"
        + "?kd_div=" + encodeURIComponent(kdDiv)
        + "&no_sppb=")
        .then(res => res.json())
        .then(data => {
            if (!detailTable) return;

            detailTable.clear();

            if (Array.isArray(data) && data.length > 0) {

                data.forEach((item) => {

                    const checkboxHtml = `
                        <input type="checkbox"
                            class="row-select-isi"
                            data-no-trans="${item.No_trans ?? ''}"
                            data-kd-brg="${item.Kd_brg ?? ''}"
                            data-nama-brg="${(item.NAMA_BRG ?? '').replace(/"/g,'&quot;')}"
                            data-ket-brg="${(item.KET ?? '').replace(/"/g,'&quot;')}"
                            data-kat-utama="${(item.nama ?? '').replace(/"/g,'&quot;')}"
                            data-kategori="${(item.nama_kategori ?? '').replace(/"/g,'&quot;')}"
                            data-sub-kategori="${(item.nama_sub_kategori ?? '').replace(/"/g,'&quot;')}"
                            data-ket-pembelian="${(item.keterangan ?? '').replace(/"/g,'&quot;')}"
                            data-satuan="${(item.Nama_satuan ?? '').replace(/"/g,'&quot;')}"
                            data-qty="${item.Qty ?? ''}"
                            data-tgl-sppb="${item.Tgl_sppb ? item.Tgl_sppb.substr(0,10) : ''}"
                            data-no-sppb="${item.No_sppb ?? ''}"
                            data-tgl-datang="${item.Tgl_dtg ? item.Tgl_dtg.substr(0,10) : ''}"
                            data-id-mata-uang="${item.IdMataUang ?? ''}"
                            data-kurs="${item.Kurs_Rp ?? ''}"
                            data-harga-satuan="${item.HargaSatuan ?? ''}"
                            data-disc="${item.Disc_trm ?? item.Disc ?? ''}"
                            data-ppn="${item.Ppn_trm ?? item.HargaPpn ?? ''}"
                            data-no-sup="${item.No_sup ?? item.NO_SUP ?? ''}"
                            data-dpp-nilai-lain="${item.DppNilaiLain ?? ''}"
                            data-harga-ppn="${item.HargaPpn ?? ''}"
                            data-subtotal-harga="${item.SubTotalHargaJual ?? ''}"
                            data-total-harga="${item.TotalHarga ?? ''}"
                            data-waktu="${item.Waktu ?? ''}"
                            data-pembayaran="${item.Pembayaran ?? item.PersetujuanBayar ?? ''}"
                        />
                    `;

                    const show = (field) => {
                        if (!Object.prototype.hasOwnProperty.call(item, field)) return '';
                        const val = item[field];
                        return (val === null || val === '') ? '-' : val;
                    };

                    detailTable.row.add([
                        checkboxHtml,
                        item.hasOwnProperty('Tgl_order')
                            ? (item.Tgl_order ? item.Tgl_order.substr(0,10) : '-')
                            : '',
                        show('Qty'),
                        show('Pemesan'),
                        show('NamaMesin'),
                        show('NamaGolongan'),
                        show('No_trans'),
                        item.hasOwnProperty('Tgl_dtg')
                            ? (item.Tgl_dtg ? item.Tgl_dtg.substr(0,10) : '-')
                            : '',
                        show('Retur'),
                        show('Direktur'),
                        show('HargaSatuan'),
                        show('Disc'),
                        show('DppNilaiLain'),
                        show('Ppn'),
                        show('TotalHarga')
                    ]);
                });
            }

            detailTable.draw();
        })
        .catch(err => {
            console.error('Error load data by divisi (ISI):', err);
        });
}

// ================== MODE LIHAT ==================
function loadNoSppbByDivisi() {
    const kdDiv = document.getElementById('kd_div').value;
    const noSppbSelect = document.getElementById('no_sppb');

    if (!noSppbSelect) return;

    noSppbSelect.innerHTML = '<option value="">-- Pilih No SPPB --</option>';

    if (!kdDiv || mode !== 'LIHAT') {
        return;
    }

    fetch("{{ route('purchaseorder.no_sppb') }}?kd_div=" + encodeURIComponent(kdDiv))
        .then(res => res.json())
        .then(data => {
            data.forEach(row => {
                const val = row.No_sppb || row.NO_SPPB || '';
                if (!val) return;

                const opt = document.createElement('option');
                opt.value = val;
                opt.textContent = val;
                noSppbSelect.appendChild(opt);
            });
        })
        .catch(err => {
            console.error('Error load no_sppb:', err);
        });
}

function loadDetailSppbSingle() {
    const kdDiv  = document.getElementById('kd_div').value;
    const noSppb = document.getElementById('no_sppb').value.trim();

    if (!kdDiv) {
        alert('Silakan pilih Nama Divisi terlebih dahulu.');
        return;
    }

    if (!noSppb) {
        alert('Silakan pilih No SPPB.');
        return;
    }

    fetch("{{ route('purchaseorder.detail_sppb') }}?kd_div=" + encodeURIComponent(kdDiv) +
          "&no_sppb=" + encodeURIComponent(noSppb))
        .then(res => res.json())
        .then(data => {
            clearDetailSppb();

            if (!Array.isArray(data) || data.length === 0) {
                alert('Data SPPB tidak tersedia.');
                return;
            }

            const row = data[0];

            document.getElementById('tgl_sppb').value   = row.Tgl_sppb ? row.Tgl_sppb.substr(0,10) : '';
            document.getElementById('tgl_datang').value = row.Tgl_dtg  ? row.Tgl_dtg.substr(0,10)  : '';

            document.getElementById('no_trans').value      = row.No_trans        ?? '';
            document.getElementById('kd_brg').value        = row.Kd_brg          ?? '';
            document.getElementById('nama_brg').value      = row.NAMA_BRG        ?? '';
            document.getElementById('ket_brg').value       = row.KET             ?? '';
            document.getElementById('kat_utama').value     = row.nama            ?? '';
            document.getElementById('kategori').value      = row.nama_kategori   ?? '';
            document.getElementById('sub_kategori').value  = row.nama_sub_kategori ?? '';
            document.getElementById('ket_pembelian').value = row.keterangan      ?? '';
            document.getElementById('satuan').value        = row.Nama_satuan     ?? '';
            document.getElementById('qty').value           = row.Qty             ?? '';

            const mataUangSelect = document.getElementById('mata_uang');
            if (row.IdMataUang && mataUangSelect) {
                mataUangSelect.value = row.IdMataUang.toString();
            }

            document.getElementById('kurs').value          = row.Kurs_Rp   ?? '0';
            document.getElementById('harga_satuan').value  = row.HargaSatuan ?? '';
            document.getElementById('disc').value          = row.Disc_trm ?? row.hrg_disc ?? row.Disc ?? '';
            document.getElementById('ppn').value           = row.Ppn_trm  ?? row.hrg_ppn  ?? row.Ppn  ?? '';
            document.getElementById('dpp_nilai_lain').value= row.DppNilaiLain ?? '';
            document.getElementById('harga_ppn').value     = row.HargaPpn ?? '';
            document.getElementById('subtotal_harga_jual').value = row.SubTotalHargaJual ?? '';
            document.getElementById('jangka_waktu').value = row.Waktu ?? '';
            document.getElementById('total_harga').value  = row.TotalHarga ?? '';

            const bayarInput = document.getElementById('pembayaran');
            bayarInput.value = row.Pembayaran ?? row.PersetujuanBayar ?? '';

            // kalau DB tidak punya pembayaran → hitung dari jangka waktu
            if (!bayarInput.value) {
                applyPembayaranFromJangkaWaktu();
            }



            const supplierSelect = document.getElementById('supplier');
            if (supplierSelect) {
                const supVal = row.No_sup ?? row.NO_SUP ?? row.IdSup ?? '';
                if (supVal !== '') {
                    supplierSelect.value = supVal.toString();
                }
            }

            if (detailTable) {
                detailTable.clear();

                data.forEach((item, index) => {
                    detailTable.row.add([
                        index + 1,
                        item.Tgl_sppb ? item.Tgl_sppb.substr(0,10) : '',
                        item.Qty ?? '',
                        item.Pemesan ?? '',
                        item.NamaMesin ?? '',
                        item.NamaGolongan ?? '',
                        item.No_trans ?? '',
                        item.Tgl_dtg ? item.Tgl_dtg.substr(0,10) : '',
                        item.Retur ?? '',
                        item.Direktur ?? '',
                        item.HargaSatuan ?? '',
                        item.Disc ?? '',
                        item.DppNilaiLain ?? '',
                        item.Ppn ?? '',
                        item.TotalHarga ?? ''
                    ]);
                });

                detailTable.draw();
            }
        })
        .catch(err => {
            console.error('Error load detail SPPB (LIHAT):', err);
            alert('Terjadi kesalahan saat mengambil data SPPB.');
        });
}

// --- REFERENSI ---
function loadMataUang() {
    const sel = document.getElementById('mata_uang');
    if (!sel) return;

    fetch("{{ route('purchaseorder.mata_uang') }}")
        .then(res => res.json())
        .then(data => {
            sel.innerHTML = '<option value="">Pilih Mata Uang</option>';
            data.forEach(row => {
                const opt = document.createElement('option');
                opt.value = row.Id_MataUang;
                opt.textContent = row.Nama_MataUang;
                sel.appendChild(opt);
            });
        })
        .catch(err => console.error('Error load mata uang:', err));
}

function loadSupplier() {
    const sel = document.getElementById('supplier');
    if (!sel) return;

    fetch("{{ route('purchaseorder.supplier') }}")
        .then(res => res.json())
        .then(data => {
            sel.innerHTML = '<option value="">Pilih Supplier</option>';
            data.forEach(row => {
                const opt = document.createElement('option');
                opt.value = row.NO_SUP ?? row.IdSup ?? '';
                opt.textContent = (row.NM_SUP || '').trim();
                sel.appendChild(opt);
            });
        })
        .catch(err => console.error('Error load supplier:', err));
}

// --- MODE HANDLER ---
function applyMode() {
    const isIsi   = (mode === "ISI");
    const isLihat = (mode === "LIHAT");

    // FIELD YANG BOLEH DI-EDIT DI ISI
    const allowedIsi = [
        'kd_div',
        'tgl_sppb',
        'mata_uang',
        'kurs',
        'harga_satuan',
        'disc',
        'ppn',
        'dpp_nilai_lain',
        'harga_ppn',
        'subtotal_harga_jual',
        'total_harga',
        'jangka_waktu',
        'pembayaran',
        'tgl_datang',
        'jenis_pembelian', // Pembelian
        'supplier',
        'alasan_hapus'
    ];

    // LIHAT: sama seperti ISI + boleh pilih No SPPB
    const allowedLihat = allowedIsi.concat(['no_sppb']);

    document.querySelectorAll("form input, form select, form textarea")
        .forEach(el => {
            if (el.type === 'hidden') {
                el.disabled = false;
                return;
            }

            if (isIsi) {
                el.disabled = !allowedIsi.includes(el.id);
            } else if (isLihat) {
                el.disabled = !allowedLihat.includes(el.id);
            } else {
                // mode awal: hanya pilih divisi
                el.disabled = (el.id !== 'kd_div');
            }
        });

    // tombol mode
    if (isIsi || isLihat) {
        document.getElementById("btn-isi").disabled   = true;
        document.getElementById("btn-lihat").disabled = true;
    } else {
        document.getElementById("btn-isi").disabled   = false;
        document.getElementById("btn-lihat").disabled = false;
    }

    document.getElementById("btn-isi").classList.toggle("btn-primary", isIsi);
    document.getElementById("btn-lihat").classList.toggle("btn-primary", isLihat);
    document.getElementById("btn-isi").classList.toggle("btn-outline-secondary", !isIsi);
    document.getElementById("btn-lihat").classList.toggle("btn-outline-secondary", !isLihat);

    const btnExitCancel = document.getElementById('btn-exit-cancel');
    if (btnExitCancel) {
        btnExitCancel.textContent = (isIsi || isLihat) ? 'BATAL' : 'KELUAR';
    }

    if (isIsi) {
        loadDataByDivisiIsi();
    } else if (isLihat) {
        loadNoSppbByDivisi();
    } else {
        clearDetailSppb();
    }
}


// setiap kali mode BERUBAH, selalu clear form + tabel dulu
function setMode(newMode) {
    mode = newMode;
    clearDetailSppb();
    applyMode();
}

// --- Auto set Pembayaran dari Jangka Waktu ---
function applyPembayaranFromJangkaWaktu() {
    const jw  = document.getElementById('jangka_waktu');
    const byr = document.getElementById('pembayaran');
    if (!jw || !byr) return;

    const n = parseInt(jw.value || '0', 10);
    if (isNaN(n)) {
        byr.value = '';
        return;
    }

    if (n === 0) {
        byr.value = 'KREDIT';
    } else if (n > 0) {
        byr.value = 'TRANSFER';
    } else {
        byr.value = '';
    }
}


// --- INIT ---
document.addEventListener('DOMContentLoaded', function () {
    loadMataUang();
    loadSupplier();

    if (window.jQuery && $.fn.DataTable) {
        detailTable = $('#tbl-detail-order').DataTable({
            paging: true,
            pageLength: 10,
            lengthMenu: [10,25,50,100],
            searching: false,
            info: true,
            ordering: false,
            scrollX: true,
            autoWidth: false,
            language: {
                emptyTable: "Tidak ada data detail."
            }
        });

        // EVENT CHECKBOX ISI
        $('#tbl-detail-order tbody').on('change', '.row-select-isi', function () {
            if (mode !== 'ISI') return;

            // hanya satu baris yang boleh terpilih
            $('#tbl-detail-order tbody .row-select-isi').not(this).prop('checked', false);

            if (!this.checked) {
                document.getElementById('no_trans').value              = '';
                document.getElementById('kd_brg').value                = '';
                document.getElementById('nama_brg').value              = '';
                document.getElementById('ket_brg').value               = '';
                document.getElementById('kat_utama').value             = '';
                document.getElementById('kategori').value              = '';
                document.getElementById('sub_kategori').value          = '';
                document.getElementById('ket_pembelian').value         = '';
                document.getElementById('satuan').value                = '';
                document.getElementById('qty').value                   = '';
                document.getElementById('harga_satuan').value          = '';
                document.getElementById('dpp_nilai_lain').value        = '';
                document.getElementById('harga_ppn').value             = '';
                document.getElementById('subtotal_harga_jual').value   = '';
                document.getElementById('total_harga').value           = '';
                return;
            }

            const d = this.dataset;

            document.getElementById('no_trans').value      = d.noTrans || '';
            document.getElementById('kd_brg').value        = d.kdBrg || '';
            document.getElementById('nama_brg').value      = d.namaBrg || '';
            document.getElementById('ket_brg').value       = d.ketBrg || '';
            document.getElementById('kat_utama').value     = d.katUtama || '';
            document.getElementById('kategori').value      = d.kategori || '';
            document.getElementById('sub_kategori').value  = d.subKategori || '';
            document.getElementById('ket_pembelian').value = d.ketPembelian || '';
            document.getElementById('satuan').value        = d.satuan || '';
            document.getElementById('qty').value           = d.qty || '';
            document.getElementById('jangka_waktu').value = d.waktu || '';
            document.getElementById('pembayaran').value  = d.pembayaran || '';


            if (d.tglDatang) {
                document.getElementById('tgl_datang').value = d.tglDatang;
            }

            if (d.tglSppb) {
                document.getElementById('tgl_sppb').value = d.tglSppb;
            }

            if (d.noSppb) {
                const noSppbSelect = document.getElementById('no_sppb');
                let opt = Array.from(noSppbSelect.options).find(o => o.value === d.noSppb);
                if (!opt) {
                    opt = new Option(d.noSppb, d.noSppb, true, true);
                    noSppbSelect.appendChild(opt);
                } else {
                    noSppbSelect.value = d.noSppb;
                }
            }

            const mataUangSelect = document.getElementById('mata_uang');
            if (mataUangSelect) {
                mataUangSelect.value = d.idMataUang || '';
            }

            if (!d.pembayaran) {
                applyPembayaranFromJangkaWaktu();
            }

            document.getElementById('kurs').value         = d.kurs || '0';
            document.getElementById('harga_satuan').value = d.hargaSatuan || '';
            document.getElementById('disc').value         = d.disc || '';
            document.getElementById('ppn').value          = d.ppn || '';

            // 🔹 DPP & Harga PPN dari DB
            document.getElementById('dpp_nilai_lain').value = d.dppNilaiLain || '';
            document.getElementById('harga_ppn').value      = d.hargaPpn || '';


            // subtotal  = Qty * Harga
            const qtyVal   = parseFloat(d.qty || '0');
            const hrgVal   = parseFloat(d.hargaSatuan || '0');
            const subtotal = qtyVal * hrgVal;

            const discPct = parseFloat(d.disc || '0');
            const ppnPct  = parseFloat(d.ppn  || '0');


            let hargaDisc;
            if (ppnPct > 0) {
                hargaDisc =subtotal - (subtotal * discPct / 100);
            } else {

                hargaDisc = subtotal;
            }

            const cbDppEl    = document.getElementById('cbDPP');
            const cbDppValue = cbDppEl ? cbDppEl.value : '0';

            let dppNilaiLain;
            if (ppnPct === 12 && cbDppValue === '0') {
                dppNilaiLain = hargaDisc * 11 / 12;
            } else {
                dppNilaiLain = hargaDisc;
            }

            // === HARGA PPN ===
            const hargaPpn = dppNilaiLain * (ppnPct / 100);

            // === TOTAL HARGA (TextNilaiTrans) ===
            const totalHarga = hargaDisc + hargaPpn;



            document.getElementById('subtotal_harga_jual').value =
                isFinite(hargaDisc) ? hargaDisc.toFixed(4) : '';

            document.getElementById('dpp_nilai_lain').value =
                isFinite(dppNilaiLain) ? dppNilaiLain.toFixed(4) : '';

            document.getElementById('harga_ppn').value =
                isFinite(hargaPpn) ? hargaPpn.toFixed(4) : '';

            document.getElementById('total_harga').value =
                isFinite(totalHarga) ? totalHarga.toFixed(4) : '';






            const supplierSelect = document.getElementById('supplier');
            if (supplierSelect && d.noSup) {
                supplierSelect.value = d.noSup;
            }
        });
    }

    const btnIsi        = document.getElementById('btn-isi');
    const btnLihat      = document.getElementById('btn-lihat');
    const btnExitCancel = document.getElementById('btn-exit-cancel');

    if (btnIsi) {
        btnIsi.addEventListener('click', function () {
            setMode('ISI');
        });
    }

    if (btnLihat) {
        btnLihat.addEventListener('click', function () {
            setMode('LIHAT');
        });
    }

    if (btnExitCancel) {
        btnExitCancel.addEventListener('click', function () {
            if (mode === "") {
                window.location.href = "{{ url('/Beli') }}";
            } else {
                setMode("");
            }
        });
    }

    const kdDiv = document.getElementById('kd_div');
    if (kdDiv) {
        kdDiv.addEventListener('change', function () {
            if (mode === 'ISI') {
                loadDataByDivisiIsi();
            } else if (mode === 'LIHAT') {
                loadNoSppbByDivisi();
            }
        });
    }

    const noSppbSelect = document.getElementById('no_sppb');
    if (noSppbSelect) {
        noSppbSelect.addEventListener('change', function () {
            if (mode === 'LIHAT' && this.value) {
                loadDetailSppbSingle();
            }
        });
    }

    const jwInput = document.getElementById('jangka_waktu');
    if (jwInput) {
        jwInput.addEventListener('change', applyPembayaranFromJangkaWaktu);
        jwInput.addEventListener('blur', applyPembayaranFromJangkaWaktu);
    }

    setMode("");
});


</script>

@endsection
