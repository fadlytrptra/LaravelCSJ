<?php

namespace App\Http\Controllers\Sales\Transaksi\SuratPesanan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuratPesananDirekturController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        // $data = DB::connection('sqlsrv2')->select('exec SP_1486_SLS_LIST_HEADER_PESANAN_BLMACC @Kode = ?', [2]);
        // return view('Sales.Transaksi.SuratPesanan.AccManager', compact('data'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        //
    }

    //Display the specified resource.
    public function show(cr $cr)
    {
        //
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function update(Request $request)
    {
        //
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
