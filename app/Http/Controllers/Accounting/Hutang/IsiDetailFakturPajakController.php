<?php

namespace App\Http\Controllers\Accounting\Hutang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IsiDetailFakturPajakController extends Controller
{
    public function handleFormSubmission(Request $request)
    {
        // Proses data yang dikirim dari modal di sini
        // Contoh: Simpan data ke database atau lakukan tindakan lain

        // Setelah data diproses, Anda dapat mengarahkan pengguna ke halaman lain jika diperlukan.
        // Misalnya, kembalikan ke halaman utama:
        return redirect()->route('home');
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
    public function show($cr)
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
