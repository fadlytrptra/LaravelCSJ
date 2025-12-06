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
    padding: 2px 6px;        /* header & body tipis */
    white-space: nowrap;     /* supaya tidak turun baris, jadi 1 baris dan bisa di-scroll */
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
                            <button type="button" class="btn btn-outline-secondary btn-sm">
                                ISI
                            </button>

                            <button type="button" class="btn btn-outline-secondary btn-sm">
                                LIHAT
                            </button>

                            <button type="button" class="btn btn-outline-success btn-sm">
                                PROSES
                            </button>

                            <button type="button" class="btn btn-outline-dark btn-sm"
                                    onclick="window.location.href='{{ url('/Beli') }}'">
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

                                {{-- No SPPB: INPUT (tetap disabled) --}}
                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">No SPPB</label>
                                    <div class="col-sm-7 d-flex">
                                        <input type="text"
                                               name="no_sppb"
                                               id="no_sppb"
                                               class="form-control"
                                               placeholder="-"
                                               disabled>
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
                                            <th>No</th>
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
                                    <option value="local">Lokal</option>
                                    <option value="import">Import</option>
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

                    {{-- FOOTER (tanpa ISI/LIHAT/PROSES/KELUAR) --}}
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
    document.getElementById('jangka_waktu').value = '';
    document.getElementById('total_harga').value   = '';
    document.getElementById('pembayaran').value    = '';
    if (document.getElementById('keterangan_detail')) {
        document.getElementById('keterangan_detail').value = '';
    }

    if (detailTable) {
        detailTable.clear().draw();
    }
}

function loadDetailSppb() {
    const kdDiv  = document.getElementById('kd_div').value;
    const noSppb = document.getElementById('no_sppb').value.trim(); // diisi dari proses lain

    if (!kdDiv) {
        alert('Silakan pilih Nama Divisi terlebih dahulu.');
        return;
    }

    if (!noSppb) {
        alert('No SPPB masih kosong.');
        return;
    }

    fetch("{{ route('purchaseorder.detail_sppb') }}?kd_div=" + encodeURIComponent(kdDiv) +
          "&no_sppb=" + encodeURIComponent(noSppb))
        .then(res => res.json())
        .then(data => {
            if (!Array.isArray(data) || data.length === 0) {
                clearDetailSppb();
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

            document.getElementById('kurs').value         = row.Kurs_Rp   ?? '0';
            document.getElementById('disc').value         = row.hrg_disc  ?? '';
            document.getElementById('ppn').value          = row.hrg_ppn   ?? '';
            document.getElementById('jangka_waktu').value = row.Waktu     ?? '';

            // Isi tabel detail
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
            console.error('Error load detail SPPB:', err);
            alert('Terjadi kesalahan saat mengambil data SPPB.');
        });
}

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

document.addEventListener('DOMContentLoaded', function () {
    loadMataUang();
    loadSupplier();

    // DataTable kompak + scroll horizontal + tanpa icon sorting
    if (window.jQuery && $.fn.DataTable) {
        detailTable = $('#tbl-detail-order').DataTable({
            paging: false,
            searching: false,
            info: false,
            ordering: false,      // mirip grid lama, tanpa ikon sort
            scrollX: true,
            autoWidth: false,
            language: {
                emptyTable: "Tidak ada data detail."
            }
        });
    }
});
</script>

@endsection
