@extends('layouts.app')
@section('content')
@section('title', 'Edit SP Lokal')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/permohonan-s-p.css') }}" rel="stylesheet">
    @php
        $header_pesanan_encode = json_encode($header_pesanan);
        $header_pesanan_array = json_decode($header_pesanan_encode, true);
        $detail_pesanan_encode = json_encode($detail_pesanan);
        $detail_pesanan_array = json_decode($detail_pesanan_encode, true);
        // print($detail_pesanan_encode);
    @endphp
    <div class="col-md-10 RDZMobilePaddingLR0">
        <div class="permohonan-s-p-container">
            <form class="permohonan-s-p-form" id="form_suratPesanan" method="POST"
                action="{{ route('suratpesanan.update', $header_pesanan_array[0]['IDSuratPesanan']) }}">
                {{ csrf_field() }}
                <legend>Edit Permohonan Surat Pesanan</legend>
                <div class="permohonan-s-p-container01">
                    <div class="permohonan-s-p-container02"> <span class="permohonan-s-p-text">Tgl
                            Pesan</span>{{-- <span
                            class="permohonan-s-p-text01">Jenis SP</span> --}} <span permohonan-s-p-text03>Nomor SP</span> <span
                            class="permohonan-s-p-text02">Customer</span> <span class="permohonan-s-p-text03">No. PO</span>
                        <span class="permohonan-s-p-text04">Tgl. PO</span> <span class="permohonan-s-p-text05">No.
                            PI</span>
                    </div>
                    <div class="permohonan-s-p-container03">
                        <div class="permohonan-s-p-container04"> <input type="date" id="tgl_pesan" name="tgl_pesan"
                                placeholder="placeholder" class="permohonan-s-p-textinput input"
                                value="{{ substr($header_pesanan_array[0]['Tgl_Pesan'], 0, 10) }}" />
                            {{-- <div class="permohonan-s-p-textinput01"> </div> <input type="text" placeholder="Jenis SP" class="permohonan-s-p-textinput01 input" /> <button class="permohonan-s-p-button button">...</button> --}}
                            <select name="jenis_sp" id="jenis_sp" class="form-control">
                                <option disabled selected value>-- Pilih Jenis SP --</option>
                                @foreach ($jenis_sp as $data)
                                    <option value="{{ $data->IDJnsSuratPesanan }}"
                                        {{ $header_pesanan_array[0]['IDJnsSuratPesanan'] == $data->IDJnsSuratPesanan ? 'selected' : '' }}>
                                        {{ $data->JnsSuratPesanan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="permohonan-s-p-container05" style="margin: 1%"> {{-- <input type="text" placeholder="No SP" class="permohonan-s-p-textinput02 input" /> <button class="permohonan-s-p-button01 button"> Lihat data </button> --}}
                            {{-- <input type="text" name="jenis_sp" list="data_jenis_sp" id="jenis_sp" placeholder="Jenis SP" class="permohonan-s-p-textinput01 input" /> <datalist id="data_jenis_sp"> @foreach ($jenis_sp as $data) <option value="{{ $data->IDJnsSuratPesanan }} - {{ $data->JnsSuratPesanan }}"></option> @endforeach </datalist> --}}
                            <input type="text" placeholder="Nomor SP" class="permohonan-s-p-textinput04 input"
                                id="no_sp" name="no_sp" readonly
                                value={{ $header_pesanan_array[0]['IDSuratPesanan'] }} />
                        </div>
                        <div class="permohonan-s-p-container06"> <select name="list_customer" id="list_customer"
                                class="form-control">
                                <option disabled selected value>-- Pilih Customer --</option>
                                @foreach ($list_customer as $data)
                                    @php
                                        $companyName = trim(substr($data->jnscust, strpos($data->jnscust, '-') + 1));
                                    @endphp
                                    <option value="{{ $data->IDCUST }}"
                                        {{ $header_pesanan_array[0]['IDCust'] == $data->IDCUST ? 'selected' : '' }}>
                                        {{ $companyName }}</option>
                                @endforeach
                            </select> {{-- <input type="text" name="list_customer" list="data_customer" id="list_customer" class="permohonan-s-p-textinput03 input" placeholder="Nama Customer" /> <datalist id="data_customer"> @foreach ($list_customer as $data) <option value="{{ $data->IDCust }} - {{ $data->NamaCust }}"></option> @endforeach </datalist> --}} {{-- <input type="text" placeholder="Nama Customer" class="permohonan-s-p-textinput03 input" /> <button class="permohonan-s-p-button02 button">...</button> --}} </div>
                        <div class="permohonan-s-p-container07"> <input type="text" placeholder="Nomor PO"
                                class="permohonan-s-p-textinput04 input" id="no_po" name="no_po"
                                value={{ $header_pesanan_array[0]['NO_PO'] }} /> </div>
                        <div class="permohonan-s-p-container08"> <input type="date" id="tgl_po" name="tgl_po"
                                placeholder="placeholder" class="permohonan-s-p-textinput05 input"
                                value={{ substr($header_pesanan_array[0]['Tgl_PO'], 0, 10) }} /> </div>
                        <div class="permohonan-s-p-container09"> <input type="text" placeholder="Nomor PI"
                                class="permohonan-s-p-textinput06 input" id="no_pi" name="no_pi"
                                value="{{ $header_pesanan_array[0]['NO_PI'] }}" /> </div>
                    </div>
                    <div class="permohonan-s-p-container10"> <span class="permohonan-s-p-text06">Sales</span> <span
                            class="permohonan-s-p-text07">Mata Uang</span> <span class="permohonan-s-p-text08">Jns
                            Bayar</span> <span class="permohonan-s-p-text09">Syarat Bayar</span> <span
                            class="permohonan-s-p-text10">Keterangan</span> </div>
                    <div class="permohonan-s-p-container11">
                        <div class="permohonan-s-p-container12"> <select name="list_sales" id="list_sales"
                                class="form-control">
                                <option disabled selected value>-- Pilih Sales --</option>
                                @foreach ($list_sales as $data)
                                    <option value="{{ $data->IDSales }}"
                                        {{ $header_pesanan_array[0]['IDSales'] == $data->IDSales ? 'selected' : '' }}>
                                        {{ $data->NamaSales }}</option>
                                @endforeach
                            </select> {{-- <input type="text" placeholder="Nama Sales" class="permohonan-s-p-textinput07 input" name="list_sales" id="list_sales" list="data_sales" /> <datalist id="data_sales"> @foreach ($list_sales as $data) <option value="{{ $data->IDSales }} - {{ $data->NamaSales }}"></option> @endforeach </datalist> --}} {{-- <button class="permohonan-s-p-button03 button">...</button> --}} </div>
                        <div class="permohonan-s-p-container13"> <input type="text" placeholder="Mata Uang"
                                class="permohonan-s-p-textinput08 input" id="mata_uang" name="mata_uang"
                                value="{{ $header_pesanan_array[0]['IDMataUang'] }}" /> </div>
                        <div class="permohonan-s-p-container14"> <select name="jenis_bayar" id="jenis_bayar"
                                class="form-control">
                                <option disabled selected value>-- Pilih Jenis Bayar --</option>
                                @foreach ($jenis_bayar as $data)
                                    <option value="{{ $data->IdPembayaran }}"
                                        {{ $header_pesanan_array[0]['IDPembayaran'] == $data->IdPembayaran ? 'selected' : '' }}>
                                        {{ $data->NamaPembayaran }}</option>
                                @endforeach
                            </select> {{-- <input type="text" placeholder="Jenis Bayar" class="permohonan-s-p-textinput09 input" name="jenis_bayar" id="jenis_bayar" list="data_jenisbayar" /> <datalist id="data_jenisbayar"> @foreach ($jenis_bayar as $data) <option value="{{ $data->IdPembayaran }} - {{ $data->NamaPembayaran }}"></option> @endforeach </datalist> <button class="permohonan-s-p-button04 button">...</button> --}} </div>
                        <div class="permohonan-s-p-container15"> <input type="text"
                                class="permohonan-s-p-textinput10 input" id="syarat_bayar" name="syarat_bayar"
                                placeholder="0" value="{{ $header_pesanan_array[0]['SyaratBayar'] }}" /> <span
                                class="permohonan-s-p-text11"> <span>Hari</span> <br /> </span>
                            <span class="permohonan-s-p-text14"> <span>Faktur PJK:</span> <br /> </span> <input
                                type="radio" class="permohonan-s-p-radiobutton" id="faktur_pjk" name="faktur_pjk"
                                value="0" required <?php if ($header_pesanan_array[0]['JnsFakturPjk'] == 0) {
                                    echo 'checked';
                                } ?> /> <span class="permohonan-s-p-text17">
                                <span>Biasa</span>
                                <br /> </span> <input type="radio" class="permohonan-s-p-radiobutton1" id="faktur_pjk"
                                name="faktur_pjk" value="1" <?php if ($header_pesanan_array[0]['JnsFakturPjk'] == 1) {
                                    echo 'checked';
                                } ?> /> <span
                                class="permohonan-s-p-text20">
                                <span>Sederhana</span> <br />
                            </span>
                        </div>
                        <div class="permohonan-s-p-container16"> <input type="text" id="keterangan" name="keterangan"
                                placeholder="Keterangan" class="permohonan-s-p-textinput11 input"
                                value="{{ $header_pesanan_array[0]['Ket'] }}" /> </div>
                        {{-- <input type="hidden" name="id_pesanan" value="{{ $detail_pesanan_array[0]['IDPesanan'] }}"> --}}
                    </div>
                </div>
                <div class="permohonan-s-p-container17">
                    {{-- <ul class="list">
                        <li class="list-item"><span>Ini adalah</span></li>
                        <li class="list-item"><span>LIST VIEW</span></li>
                        <li class="list-item"><span>Untuk List barang</span></li>
                    </ul> --}}
                    <table class="permohonan-s-p-table" id="list_view" name="list_view">
                        <thead class="thead-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Kode Barang</th>
                                <th>Jns SP</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Harga Satuan</th>
                                <th>Rencana Kirim</th>
                                <th>IDPesanan</th>
                                <th>PPN</th>
                                {{-- <th>Index</th> --}}
                                <th>B.Karung</th>
                                <th>In.Karung</th>
                                <th>Bi.Karung</th>
                                <th>B.Inner</th>
                                <th>In.Inner</th>
                                <th>Bi.Inner</th>
                                <th>B.Lami</th>
                                <th>In.Lami</th>
                                <th>Bi.Lami</th>
                                <th>B.Kertas</th>
                                <th>In.Kertas</th>
                                <th>Bi.Kertas</th>
                                <th>Bi.Lain2</th>
                                <th>BS.Total</th>
                                <th>Total Cost</th>
                                <th>B.KarungMTR</th>
                                <th>B.InnerMTR</th>
                                <th>B.LamiMTR</th>
                                <th>B.KertasMTR</th>
                                <th>BS.TotalMTR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                foreach ($detail_pesanan_array as $row) {
                                    $i = 0;
                                    echo '<tr class="acs-tr-hover">';
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['NamaBarang'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['IDBarang'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['IDJnsBarang'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['Qty'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['Satuan'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['HargaSatuan'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['TglRencanaKirim'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['IDPesanan'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['PPN'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['BERAT_KARUNG'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    if ($row['INDEX_KARUNG'] === null) {
                                        echo '<input type="text" readonly="true" value="0" class="acs-input-table" name="barang' . $i . '[]">';
                                    } else {
                                        echo '<input type="text" readonly="true" value="' . $row['INDEX_KARUNG'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    }
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['HARGA_KARUNG'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['BERAT_INNER'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    if ($row['INDEX_INNER'] === null) {
                                        echo '<input type="text" readonly="true" value="0" class="acs-input-table" name="barang' . $i . '[]">';
                                    } else {
                                        echo '<input type="text" readonly="true" value="' . $row['INDEX_INNER'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    }
                                    // echo '<input type="text" readonly="true" value="' . $row['INDEX_INNER'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['HARGA_INNER'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['BERAT_LAMI'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    if ($row['INDEX_LAMI'] === null) {
                                        echo '<input type="text" readonly="true" value="0" class="acs-input-table" name="barang' . $i . '[]">';
                                    } else {
                                        echo '<input type="text" readonly="true" value="' . $row['INDEX_LAMI'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    }
                                    // echo '<input type="text" readonly="true" value="' . $row['INDEX_LAMI'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['HARGA_LAMI'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['BERAT_CONDUCTIVE'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    if ($row['INDEX_KERTAS'] === null) {
                                        echo '<input type="text" readonly="true" value="0" class="acs-input-table" name="barang' . $i . '[]">';
                                    } else {
                                        echo '<input type="text" readonly="true" value="' . $row['INDEX_KERTAS'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    }
                                    // echo '<input type="text" readonly="true" value="' . $row['INDEX_KERTAS'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['HARGA_KERTAS'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    if ($row['HARGA_LAIN2'] === null) {
                                        echo '<input type="text" readonly="true" value="0" class="acs-input-table" name="barang' . $i . '[]">';
                                    } else {
                                        echo '<input type="text" readonly="true" value="' . $row['HARGA_LAIN2'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    }
                                    // echo '<input type="text" readonly="true" value="' . $row['HARGA_LAIN2'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['BERAT_TOTAL'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['HARGA_TOTAL'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['BERAT_KARUNG3'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['BERAT_INNER3'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['BERAT_LAMI3'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['BERAT_KERTAS3'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    $i++;
                                    echo '<td class="acs-tr-hover">';
                                    echo '<input type="text" readonly="true" value="' . $row['BERAT_TOTAL3'] . '" class="acs-input-table" name="barang' . $i . '[]">';
                                    echo '</td>';
                                    // echo '<td class="acs-tr-hover">' . $row['IDSuratPesanan'] . '</td>';
                                    // echo '<td class="acs-tr-hover">' . $row['IDBarang'] . '</td>';
                                    // echo '<td class="acs-tr-hover">' . $row['NamaBarang'] . '</td>';
                                    // echo '<td class="acs-tr-hover">' . $row['IDJnsBarang'] . '</td>';
                                    // echo '<td class="acs-tr-hover">' . $row['NamaJnsBrg'] . '</td>';
                                    // echo '<td class="acs-tr-hover">' . $row['SaldoAwal'] . '</td>';
                                    // echo '<td class="acs-tr-hover">' . $row['Qty'] . '</td>';
                                    // echo '<td class="acs-tr-hover">' . $row['Satuan'] . '</td>';
                                    echo '</tr>';
                                }
                            @endphp
                        </tbody>
                    </table>
                </div>
                <div class="permohonan-s-p-container18">
                    <div class="permohonan-s-p-container19"> <span>Jenis Brg</span> <span>Kat. Utama</span>
                        <span>Kategori</span> <span>Sub Kategori</span> <span>Nama Brg</span> <span>Kode Brg</span>
                    </div>
                    <div class="permohonan-s-p-container20">
                        <div class="permohonan-s-p-container21"> <select name="jenis_brg" id="jenis_brg"
                                class="form-control">
                                <option disabled selected value>-- Pilih Jenis Barang --</option>
                                @foreach ($jenis_brg as $data)
                                    <option value="{{ $data->IDJnsBrg }}">{{ $data->NamaJnsBrg }}</option>
                                @endforeach
                            </select> {{-- <input type="text" placeholder="Jenis Barang" class="permohonan-s-p-textinput12 input" name="jenis_brg" id="jenis_brg" list="data_jenisbarang" /> <button class="permohonan-s-p-button05 button">...</button> <datalist id="data_jenisbarang"> @foreach ($jenis_brg as $data) <option value="{{ $data->IDJnsBrg }} - {{ $data->NamaJnsBrg }}"></option> @endforeach </datalist> --}} </div>
                        <div class="permohonan-s-p-container22"> {{-- <input type="text" placeholder="Kategori Utama" class="permohonan-s-p-textinput13 input" name="kategori_utama" id="kategori_utama" list="data_kategoriutama" /> <button class="permohonan-s-p-button06 button">...</button> <datalist id="data_kategoriutama"> @foreach ($kategori_utama as $data) <option value="{{ $data->no_kat_utama }} - {{ $data->nama_kat_utama }}"></option> @endforeach </datalist> --}} <select name="kategori_utama"
                                id="kategori_utama" class="form-control">
                                <option disabled selected value>-- Pilih Kategori Utama --</option>
                                @foreach ($kategori_utama as $data)
                                    <option value="{{ $data->no_kat_utama }}">{{ $data->nama_kat_utama }}</option>
                                @endforeach
                            </select> </div>
                        <div class="permohonan-s-p-container23"> {{-- <input type="text" placeholder="Kategori" class="permohonan-s-p-textinput14 input" /> --}} {{-- <button class="permohonan-s-p-button07 button">...</button> --}} <select
                                name="kategori" id="kategori" class="form-control"></select> {{-- <datalist id="data_kategori"></datalist> --}}
                        </div>
                        <div class="permohonan-s-p-container24"> {{-- <input type="text" placeholder="Sub Kategori" class="permohonan-s-p-textinput15 input" /> --}} <select name="sub_kategori"
                                id="sub_kategori" class="form-control"></select> {{-- <button class="permohonan-s-p-button08 button">...</button> --}}
                            {{-- <datalist id="data_subkategori"></datalist> --}} </div>
                        <div class="permohonan-s-p-container25"> {{-- <input type="text" placeholder="Nama Barang" class="permohonan-s-p-textinput16 input" /> --}} <select name="nama_barang"
                                id="nama_barang" class="form-control"></select> {{-- <button class="permohonan-s-p-button09 button">...</button> --}}
                            {{-- <datalist id="data_namabarang"></datalist> --}} </div>
                        <div class="permohonan-s-p-container26"> <input type="text" id="kode_barang"
                                placeholder="Kode Barang" class="permohonan-s-p-textinput17 input" value=""
                                readonly /> <span id="enter_kodeBarang" style="display: none">Tekan Enter</span> </div>
                    </div>
                    <div class="permohonan-s-p-container27"> <span>Qty Pesan</span> <span>Harga Satuan</span> <span>P P
                            N</span> </div>
                    <div class="permohonan-s-p-container28">
                        <div class="permohonan-s-p-container29"> <input type="text" placeholder="Qty Pesan"
                                class="permohonan-s-p-textinput18 input" id="qty_pesan" /> </div>
                        <div class="permohonan-s-p-container30"> <input type="text" placeholder="Harga Satuan"
                                class="permohonan-s-p-textinput19 input" id="harga_satuan" /> </div>
                        <div class="permohonan-s-p-container31"> <input type="text" placeholder="P P N"
                                class="permohonan-s-p-textinput20 input" id="ppn" readonly /> </div>
                    </div>
                    <div class="permohonan-s-p-container32"> <span>Satuan Jual</span> <span
                            class="permohonan-s-p-span1">Sat Gudang</span> <span>Rencana Kirim</span> </div>
                    <div class="permohonan-s-p-container33">
                        <div class="permohonan-s-p-container34"> <select name="satuan_jual" id="satuan_jual"
                                class="form-control">
                                <option disabled selected value>-- Pilih Satuan Jual --</option>
                                @foreach ($list_satuan as $data)
                                    <option value="{{ $data->No_satuan }}">{{ $data->Nama_satuan }}</option>
                                @endforeach
                            </select> {{-- <input type="text" placeholder="Satuan Jual" class="permohonan-s-p-textinput21 input" /> --}} {{-- <button class="permohonan-s-p-button10 button">...</button> --}} </div>
                        <div class="permohonan-s-p-container35"> <input type="text" placeholder="Satuan Primer"
                                class="permohonan-s-p-textinput22 input" id="satuan_primer" readonly /> <input
                                type="text" placeholder="Satuan Sekunder" class="permohonan-s-p-textinput23 input"
                                id="satuan_sekunder" readonly /> <input type="text" placeholder="Satuan Tritier"
                                class="permohonan-s-p-textinput24 input" id="satuan_tritier" readonly /> </div>
                        <div class="permohonan-s-p-container36"> <input type="date" placeholder="Rencana Kirim"
                                class="permohonan-s-p-textinput25 input" id="rencana_kirim" /> </div>
                    </div>
                    <div class="permohonan-s-p-container37">
                        <button class="permohonan-s-p-button11 button" id="add_button">Add</button>
                        <button class="permohonan-s-p-button12 button" id="update_button">Update</button>
                        <button class="permohonan-s-p-button13 button" id="delete_button">Delete</button>
                    </div>
                </div>
                <div id="berat_standard"> <span> <span>Berat Standart (KGM) - Index Harga</span> <br /> </span>
                    <div class="permohonan-s-p-container38">
                        <div class="permohonan-s-p-container39"> <span>Berat Karung:</span> <span>Berat Inner:</span>
                            <span>Berat Lami:</span> <span>Berat Kertas:</span> <span class="permohonan-s-p-text45">BS
                                Total:</span>
                        </div>
                        <div class="permohonan-s-p-container40">
                            <div class="permohonan-s-p-container41"> <input type="text" placeholder="Berat Karung"
                                    class="permohonan-s-p-textinput26 input" id="berat_karung" readonly /> </div>
                            <div class="permohonan-s-p-container42"> <input type="text" placeholder="Berat Inner"
                                    class="permohonan-s-p-textinput27 input" id="berat_inner" readonly /> </div>
                            <div class="permohonan-s-p-container43"> <input type="text" placeholder="Berat Lami"
                                    class="permohonan-s-p-textinput28 input" id="berat_lami" readonly /> </div>
                            <div class="permohonan-s-p-container44"> <input type="text" placeholder="Berat Kertas"
                                    class="permohonan-s-p-textinput29 input" id="berat_kertas" readonly /> </div>
                            <div class="permohonan-s-p-container45"> <input type="text" placeholder="BS Total"
                                    class="permohonan-s-p-textinput30 input" id="berat_standardTotal" readonly /> </div>
                        </div>
                        <div class="permohonan-s-p-container46"> <span>X</span> <span>X</span> <span>X</span>
                            <span>X</span>
                        </div>
                        <div class="permohonan-s-p-container47"> <span>Index Karung</span> <span>Index Inner</span>
                            <span>Index Lami</span> <span>Index Kertas</span>
                        </div>
                        <div class="permohonan-s-p-container48">
                            <div class="permohonan-s-p-container49"> <input type="text" placeholder="Index Karung"
                                    class="permohonan-s-p-textinput31 input" id="index_karung" readonly /> </div>
                            <div class="permohonan-s-p-container50"> <input type="text" placeholder="Index Inner"
                                    class="permohonan-s-p-textinput32 input" id="index_inner" readonly /> </div>
                            <div class="permohonan-s-p-container51"> <input type="text" placeholder="Index Lami"
                                    class="permohonan-s-p-textinput33 input" id="index_lami" readonly /> </div>
                            <div class="permohonan-s-p-container52"> <input type="text" placeholder="Index Kertas"
                                    class="permohonan-s-p-textinput34 input" id="index_kertas" readonly /> </div>
                        </div>
                        <div class="permohonan-s-p-container53"> <span>=</span> <span>=</span> <span>=</span>
                            <span>=</span> <span class="permohonan-s-p-text58">Biaya Lain2:</span> <span
                                class="permohonan-s-p-text59">Total Cost:</span>
                        </div>
                        <div class="permohonan-s-p-container54">
                            <div class="permohonan-s-p-container55"> <input type="text"
                                    placeholder="Berat Index Karung" class="permohonan-s-p-textinput35 input"
                                    id="berat_indexKarung" readonly /> </div>
                            <div class="permohonan-s-p-container56"> <input type="text"
                                    placeholder="Berat Index Inner" class="permohonan-s-p-textinput36 input"
                                    id="berat_indexInner" readonly /> </div>
                            <div class="permohonan-s-p-container57"> <input type="text" placeholder="Berat Index Lami"
                                    class="permohonan-s-p-textinput37 input" id="berat_indexLami" readonly /> </div>
                            <div class="permohonan-s-p-container58"> <input type="text"
                                    placeholder="Berat Index Kertas" class="permohonan-s-p-textinput38 input"
                                    id="berat_indexKertas" readonly /> </div>
                            <div class="permohonan-s-p-container59"> <input type="text" placeholder="Biaya Lain2"
                                    class="permohonan-s-p-textinput39 input" id="biaya_lain" readonly /> </div>
                            <div class="permohonan-s-p-container60"> <input type="text" placeholder="Total Cost"
                                    class="permohonan-s-p-textinput40 input" id="total_cost" readonly /> </div>
                        </div>
                    </div>
                    <div id="berat_standardMeter" style="display: none"> <span> <span>Berat Standard (MTR)</span> <br />
                        </span>
                        <div class="permohonan-s-p-container62">
                            <div class="permohonan-s-p-container63"> <span>Berat Karung:</span> <span>Berat Inner:</span>
                                <span>Berat Lami:</span> <span>Berat Kertas:</span> <span class="permohonan-s-p-text67">BS
                                    Total:</span>
                            </div>
                            <div class="permohonan-s-p-container64">
                                <div class="permohonan-s-p-container65"> <input type="text" placeholder="Berat Karung"
                                        class="permohonan-s-p-textinput41 input" id="berat_karungMeter" /> </div>
                                <div class="permohonan-s-p-container66"> <input type="text" placeholder="Berat Inner"
                                        class="permohonan-s-p-textinput42 input" id="berat_innerMeter" /> </div>
                                <div class="permohonan-s-p-container67"> <input type="text" placeholder="Berat Lami"
                                        class="permohonan-s-p-textinput43 input" id="berat_lamiMeter" /> </div>
                                <div class="permohonan-s-p-container68"> <input type="text" placeholder="Berat Kertas"
                                        class="permohonan-s-p-textinput44 input" id="berat_kertasMeter" /> </div>
                                <div class="permohonan-s-p-container69"> <input type="text" placeholder="BS Total"
                                        class="permohonan-s-p-textinput45 input" id="berat_standardTotalMeter" /> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="permohonan-s-p-container61"> <button id="submit_button"
                        class="permohonan-s-p-button14 button">
                        <span>Submit</span></button>
                </div>
            </form>
        </div>
        <script type="text/javascript" src="{{ asset('js/Sales/permohonan-s-p edit.js') }}"></script>
    </div>
@endsection
