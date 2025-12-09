<?php

namespace App\Http\Controllers\EDP;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\Controller;

class PerbaikanUjiCobaFiturController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('EDP');
        return view('EDP.Perbaikan.UjiCobaFitur', compact('access'));
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
