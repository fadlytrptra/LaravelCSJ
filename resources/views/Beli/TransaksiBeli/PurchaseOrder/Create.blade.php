@extends('layouts.appOrderPembelian')

@section('title', 'Maintenance SPPB Pembelian')

@section('content')
<link href="{{ asset('css/CreatePurchaseOrder.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

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
                <div class="card-header">Maintenance SPPB Pembelian</div>

                @csrf

                <form method="POST" action="{{ url('purchase-order') }}">
                    <div class="card-body">
                        {{-- BARIS ATAS --}}
                        <div class="row mb-3">
                            {{-- KIRI --}}
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

                                <div class="mb-2 row">
                                    <label class="col-sm-3 col-form-label">No SPPB</label>
                                    <div class="col-sm-7">
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
                                            {{-- opsi diisi via JS dari T_MATAUANG --}}
                                        </select>
                                    </div>

                                    <label class="col-sm-2 col-form-label text-end text-nowrap">Kurs</label>

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

                        {{-- AREA KETERANGAN BESAR --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label">Keterangan Tambahan</label>
                                <textarea name="keterangan_detail" id="keterangan_detail" rows="5" class="form-control"></textarea>
                            </div>
                        </div>

                        {{-- BARIS BAWAH --}}
                        <div class="row mb-3">
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
                                    {{-- diisi via JS dari SP_1273_PRG_LIST_SUPPLIER --}}
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Alasan Hapus</label>
                                <input type="text" name="alasan_hapus" id="alasan_hapus" class="form-control">
                            </div>
                        </div>
                    </div>

                   <div class="card-footer d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary">
                            Lihat Daftar Harga
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Kirim ke Supplier
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>

function loadNoSppbByDivisi() {
    const kdDiv = document.getElementById('kd_div').value;
    const noSppbSelect = document.getElementById('no_sppb');


    noSppbSelect.innerHTML = '<option value="">-- Pilih No SPPB --</option>';

    if (!kdDiv) return;

    fetch("{{ route('purchaseorder.no_sppb') }}?kd_div=" + encodeURIComponent(kdDiv))
        .then(res => res.json())
        .then(data => {
            data.forEach(row => {
                const opt = document.createElement('option');
                opt.value = row.No_sppb;
                opt.textContent = row.No_sppb;
                noSppbSelect.appendChild(opt);
            });
        })
        .catch(err => {
            console.error('Error load No SPPB:', err);
        });
}


function loadDetailSppb() {
    const kdDiv  = document.getElementById('kd_div').value;
    const noSppb = document.getElementById('no_sppb').value;

    if (!kdDiv || !noSppb) return;

    fetch("{{ route('purchaseorder.detail_sppb') }}?kd_div=" + encodeURIComponent(kdDiv) +
          "&no_sppb=" + encodeURIComponent(noSppb))
        .then(res => res.json())
        .then(data => {
            if (!Array.isArray(data) || data.length === 0) {
                console.warn('Detail SPPB kosong');
                return;
            }

            const row = data[0];

            // tanggal
            document.getElementById('tgl_sppb').value   = row.Tgl_sppb ? row.Tgl_sppb.substr(0,10) : '';
            document.getElementById('tgl_datang').value = row.Tgl_dtg  ? row.Tgl_dtg.substr(0,10)  : '';

            // header + barang
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

            // MATA UANG, KURS, DISC, PPN, WAKTU

            const mataUangSelect = document.getElementById('mata_uang');


            if (row.IdMataUang && mataUangSelect) {
                mataUangSelect.value = row.IdMataUang.toString();
            }

            document.getElementById('kurs').value        = (row.Kurs_Rp   ?? '-') === null ? '-' : row.Kurs_Rp;
            document.getElementById('disc').value        = row.hrg_disc   ?? '-';
            document.getElementById('ppn').value         = row.hrg_ppn    ?? '-';
            document.getElementById('jangka_waktu').value= row.Waktu      ?? '-';
        })
        .catch(err => {
            console.error('Error load detail SPPB:', err);
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
                opt.value = row.Id_MataUang;              // id utk disimpan
                opt.textContent = row.Nama_MataUang;      // nama utk ditampilkan
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

// EVENT
document.getElementById('kd_div').addEventListener('change', function () {
    loadNoSppbByDivisi();   // reload daftar SPPB
});

document.getElementById('no_sppb').addEventListener('change', function () {
    loadDetailSppb();
});

// INIT SAAT HALAMAN PERTAMA KALI DIBUKA
document.addEventListener('DOMContentLoaded', function () {
    loadMataUang();
    loadSupplier();
    loadNoSppbByDivisi();   // <-- penting: langsung load No SPPB utk divisi awal (mis. BAHAN)
});
</script>


@endsection
