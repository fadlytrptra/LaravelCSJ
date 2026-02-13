<?php

namespace App\Http\Controllers\EDP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DB;

class IsOnlineController extends Controller
{
    //Display a listing of the resource.
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('EDP');
        $pegawai = DB::connection('ConnEDP')
        ->table('UserMaster')
        ->select(
            'NomorUser',
                     'NamaUser',
                     'IsOnline'
            )
            ->orderBy('NamaUser', 'asc')->get();
        // dd($pegawai);
        return view('EDP.Master.MaintenanceIsOnline', compact('access', 'pegawai'));
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {

    }

    //Display the specified resource.
    public function show($id)
    {
        //
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        //
    }

    //Update the specified resource in storage.
    public function updateIsOnline(Request $request)
    {
        $request->validate([
            'NomorUser' => 'required'
        ]);

        $isOnline = $request->has('IsOnline') ? 1 : 0;

        DB::connection('ConnEDP')
            ->table('UserMaster')
            ->where('NomorUser', $request->NomorUser)
            ->update([
                'IsOnline' => $isOnline
            ]);

        return redirect()->back()->with('success', 'Status Is Online berhasil diupdate');
    }

    public function filterIPAddress(Request $request) {

    }


    //Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
