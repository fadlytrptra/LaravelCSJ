@extends('layouts.appEDP')
@section('content')
<div>
@include('EDP/Jurnal/modalAddJurnalMaster')
@include('EDP/Jurnal/modalDelJurnal')
@include('EDP/Jurnal/modalDetailJurnal')
@include('EDP/Jurnal/modalDetailJurnalMaster')
@include('EDP/Jurnal/modalInputKelompok')
@include('EDP/Jurnal/modalListKategori')
@include('EDP/Jurnal/modalListKelompok')
@include('EDP/Jurnal/modalAddKelompok')
@include('EDP/Jurnal/modalEditKelompok')
@include('EDP/Jurnal/modalAddKategori')
@include('EDP/Jurnal/modalEditKategori')
</div>
<script src="{{ asset('js/EDP/Jurnal.js') }}"></script>
<script>
    $(document).ready( function () {
    $('.table').DataTable({
        order: [[0, 'desc']],
        searching: false
    });
} );
</script>
<script>
    $(document).ready( function () {
    $('#table_ListOrder').DataTable({
        searching: false,
        order: [[1, 'desc']],

    });


    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    // today1 = mm + '/' + dd + '/' + yyyy;
    today1 = yyyy + '-' + mm + '-' + dd;
    console.log(today1);
    document.getElementById("tglAwal").value=today1;
    document.getElementById("tglAkhir").value=today1;
} );
</script>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 RDZMobilePaddingLR0">
            <div class="card">
                <div class="card-header" >Jurnal Master

                <a class="ListKategori btn btn-secondary btn-sm" href="" style="float:right;margin-right: 1px">List Kategori</a>
                <a class="ListKelompok btn btn-secondary btn-sm" href="" style="float:right;margin-right: 1px">List Kelompok</a>

                </div>
                <div class="card-body RDZOverflow RDZMobilePaddingLR0">
                    @if (\Session::has('danger'))
                    <div class="alert alert-danger">
                        {!! \Session::get('danger') !!}
                    </div>
                    @endif
                    <div class="border-bottom border-dark">
                    <a class="AddJurnal btn btn-primary btn" href="" style="margin-bottom: 1%">Add Jurnal</a>
                        <table class="table table-bordered table-striped" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tgl. Lapor</th>
                                    <th>Pelapor</th>
                                    <th>Kategori</th>
                                    <th>Pelaksana</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $index=>$item)
                                <tr class="RDZDetailTable DetailJurnalMaster" data-id="{{$item->IdJurnal}}">
                                    <td class="RDZPaddingTable">{{$item['Tgl_Lapor']}}</td>
                                    <td class="RDZPaddingTable">{{$item['NamaUser']}}</td>
                                    <td class="RDZPaddingTable">{{$item['Kategori']}}</td>
                                    <td class="RDZPaddingTable">{{$item['Nama_Personil']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                    </div>
                    <br>
                    <div class="form-row align-items-center RDZFilter">
                          <div class="col-auto">
                            <label class="col-form-label">Tgl. Awal</label>
                          </div>
                          <div class="col-auto">
                            <input type="date" class="form-control Filter" id="tglAwal" name="tglAwal">
                          </div>
                          <div class="col-auto">
                            <label class="col-form-label">Tgl. Akhir</label>
                          </div>
                          <div class="col-auto">
                            <input type="date" class="form-control Filter" id="tglAkhir" name="tglAkhir">
                          </div>
                    </div>
                    <br>
                    <div class="tab">
                    @foreach($kelompok as $item)
                    <button class="tablinks" onclick="openTab(event, '{{$item->Kelompok}}')" id="defaultOpen">{{$item->Kelompok}}</button>
                    @endforeach
                    </div>
                    @foreach($kelompok as $item1)
                    <div id="{{$item1->Kelompok}}" class="tabcontent">
                    <h3>{{$item1->Kelompok}}</h3>
                        <table class="table table-bordered table-striped" style="width:100%;" id="Table{{$item1->IdKelompok}}">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tgl. Lapor</th>
                                    <th>Pelapor</th>
                                    <th>Kategori</th>
                                    <th>Pelaksana</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataKelompok as $item2)
                                @if($item1->IdKelompok==$item2->Id_Kelompok)
                                <tr class="RDZDetailTable DetailJurnal" data-id="{{$item2->IdJurnal}}">
                                    <td class="RDZPaddingTable">{{$item2['Tgl_Lapor']}}</td>
                                    <td class="RDZPaddingTable">{{$item2['NamaUser']}}</td>
                                    <td class="RDZPaddingTable">{{$item2['Kategori']}}</td>
                                    <td class="RDZPaddingTable">{{$item2['Nama_Personil']}}</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById("defaultOpen").click();
function openTab(evt, Item) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(Item).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
@endsection
