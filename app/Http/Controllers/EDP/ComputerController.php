<?php

namespace App\Http\Controllers\EDP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;
use DB;
use Exception;

class ComputerController extends Controller
{
    public function index()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('EDP');
        $data = DB::connection('ConnEDP')->table('Komputer')->select('*')->get();
        // dd($data);
        return view('EDP.Master.Computer.Index', compact('access', 'data'));
    }

    public function create()
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('EDP');
        $typeos = DB::connection('ConnEDP')->table('Type_OS')->select('*')->get();
        $lokasi = DB::connection('ConnEDP')->table('Lokasi')->select('*')->get();
        // dd($processor, $monitor, $memory, $harddisk, $typeos, $vga);
        return view('EDP.Master.Computer.Create', compact('access', 'lokasi', 'typeos'));
    }

    public function store(Request $request)
    {
        // dd('Masuk Store', $request->all());
        if ($request->jenisStore == 'CreateComputer') {
            DB::connection('ConnEDP')->statement('exec SP_4384_EDP_MaintenanceKomputer
            @Kode = ?,
            @KodeComp = ?,
            @Keterangan = ?,
            @IPAddress = ?,
            @Id_Proc = ?,
            @Id_Memory = ?,
            @Id_HD = ?,
            @Id_OS = ?,
            @Id_VGA = ?,
            @Id_Monitor = ?',
                [
                    2,
                    $request->KodeComputer,
                    $request->NamaUser,
                    $request->ipAddress,
                    $request->Processor,
                    $request->Memory,
                    $request->HardDisk,
                    $request->OperatingSystem,
                    $request->GraphicCard,
                    $request->Monitor,
                ]
            );
            return redirect()->back()->with('success', 'Data Komputer ' . $request->KodeComputer . ' Sudah Ditambahkan!');
        }
    }

    public function show($id)
    {
        if ($id == 'FetchOperatingSystems') {
            $typeos = DB::connection('ConnEDP')->table('Type_OS')->select('*')->get();
            return response()->json($typeos);
        }
        $dataKomputer = DB::connection('ConnEDP')->select('exec SP_4384_EDP_MaintenanceKomputer @Kode = ?, @KodeComp = ?', [1, $id]);
        // $dataKomponen = DB::connection('ConnEDP')->select('exec SP_4384_EDP_MaintenanceKomputer @Kode = ?, @KodeComp = ?', [2, $id]);
        // $data = [$dataKomputer, $dataKomponen];
        return response()->json($dataKomputer);
    }

    public function edit($id)
    {
        $access = (new HakAksesController)->HakAksesFiturMaster('EDP');
        $computer = DB::connection('ConnEDP')->table('Komputer')->select('*')->where('Kode_Comp', '=', $id)->get();
        $lokasi = DB::connection('ConnEDP')->table('Lokasi')->select('*')->get();
        $memory = DB::connection('ConnEDP')->table('Kapasitas_Memory')->select('*')->get();
        $typeos = DB::connection('ConnEDP')->table('Type_OS')->select('*')->get();
        $harddisk = DB::connection('ConnEDP')->table('Kapasitas_HardDisk')->select('*')->get();
        $vga = DB::connection('ConnEDP')->table('Kapasitas_VGA')->select('*')->get();
        $monitor = DB::connection('ConnEDP')->table('Ukuran_Monitor')->select('*')->get();
        // dd(
        //     'masuk edit',
        //     $computer,
        //     $typeos, $lokasi
        // );
        return view('EDP.Master.Computer.Edit', compact('access', 'computer', 'lokasi', 'typeos'));
    }

    public function update(Request $request, $id)
    {
        // dd('masuk update', $request->all());
        DB::connection('ConnEDP')->statement('exec SP_4384_EDP_MaintenanceKomputer
                                                @Kode = ?,
                                                @KodeComp = ?,
                                                @Keterangan = ?,
	                                            @IPAddress = ?,
	                                            @Id_Proc = ?,
	                                            @Id_Memory = ?,
	                                            @Id_HD = ?,
	                                            @Id_OS = ?,
	                                            @Id_VGA = ?,
	                                            @Id_Monitor = ?',
            [
                3,
                $request->KodeComputer,
                $request->NamaUser,
                $request->ipAddress,
                $request->Processor,
                $request->Memory,
                $request->HardDisk,
                $request->OperatingSystem,
                $request->GraphicCard,
                $request->Monitor,
            ]
        );
        return redirect()->back()->with('success', 'Data Komputer ' . $request->KodeComputer . ' Sudah Diperbarui!');
    }

    public function destroy($id)
    {
        // dd('masuk destroy');
        DB::connection('ConnEDP')->table('Komputer')->where('Kode_Comp', '=', $id)->delete();
        // echo "<script type='text/javascript'>alert('Data Berhasil dihapus') ;</script>";
        return redirect('Computer')->with(['success' => 'Data ' . $id . ' berhasil dihapus!']);
    }

    function TambahSWAL(Request $request)
    {
        $typemodal = $request->typemodal;
        // add new OS data to table
        try {
            if ($typemodal == 'AddNewOS') {
                $os = $request->input;
                DB::connection('ConnEDP')->table('Type_OS')->insert([
                    'Sistem_Operas' => $os
                ]);
                return response()->json('success');
            }
            elseif ($typemodal == 'AddNewLocation') {
                $dataInput = $request->input;
                if (strpos($dataInput, '-') == false) {
                    return response()->json("Data Lokasi Tidak Sesuai Format! | Format: ID_Lokasi - Nama Lokasi");
                }
                $location = explode('-', $dataInput);
                DB::connection('ConnEDP')->table('Lokasi')->insert([
                    'Id_Lokasi' => trim($location[0]),
                    'Lokasi' => trim($location[1])
                ]);
                return response()->json('success');
            }
        }
        //catch exception
        catch (Exception $e) {
            return response()->json('Message error: ' . $e->getMessage());
        }
    }
}
