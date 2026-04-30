<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MeetingController extends Controller
{
    public function index()
    {
        $rooms = DB::connection('ConnEDPKrr')
            ->table('Ruang_Meeting')
            ->select('id','ruang_meeting as nama_ruangan')
            ->get();

        $pegawai = DB::connection('ConnEDPKrr')
            ->table('UserMaster')
            ->select('NomorUser','NamaUser')
            ->orderBy('NamaUser')
            ->get();

        $adminExists = DB::connection('ConnEDPKrr')
            ->table('AdministratorMeeting')
            ->exists();

        $isAdmin = DB::connection('ConnEDPKrr')
            ->table('AdministratorMeeting')
            ->where('nomorUser_adm', auth()->user()->NomorUser)
            ->exists();

        return view('meeting', compact('rooms', 'pegawai', 'adminExists', 'isAdmin'));
    }

    public function show(Request $request, $id)
    {
        $tanggal = $request->tanggal ?? date('Y-m-d');

        $now = Carbon::now('Asia/Jakarta');
        $today = $now->toDateString();
        $nowTime = $now->format('H:i');

        $room = DB::connection('ConnEDPKrr')
            ->table('Ruang_Meeting')
            ->where('id',$id)
            ->first();

        if(!$room){
            $room = (object)[
                'id' => $id,
                'ruang_meeting' => 'Ruangan Tidak Ditemukan'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Update status meeting hanya untuk hari ini
        |--------------------------------------------------------------------------
        */

        if ($tanggal == $today) {

            // sedang digunakan
            DB::connection('ConnEDPKrr')
                ->table('Meeting')
                ->where('ruangan_id', $id)
                ->where('tanggal', $today)
                ->where('status', 'booked')
                ->where('jam_awal', '<=', $nowTime)
                ->where('jam_akhir', '>', $nowTime)
                ->update([
                    'status' => 'digunakan'
                ]);

            // selesai
            DB::connection('ConnEDPKrr')
                ->table('Meeting')
                ->where('ruangan_id', $id)
                ->where('tanggal', $today)
                ->where('status', 'digunakan')
                ->where('jam_akhir', '<', $nowTime)
                ->update([
                    'status' => 'selesai'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil data meeting
        |--------------------------------------------------------------------------
        */

        $meetingsRaw = DB::connection('ConnEDPKrr')
            ->table('Meeting')
            ->leftJoin('UserMaster','Meeting.pemesan','=','UserMaster.NomorUser')
            ->select(
                'Meeting.*',
                'UserMaster.NamaUser'
            )
            ->where('Meeting.ruangan_id',$id)
            ->where('Meeting.tanggal',$tanggal)
            ->whereNotIn('Meeting.status',['selesai','dibatalkan'])
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Pecah meeting menjadi slot jam
        |--------------------------------------------------------------------------
        */

        $meetings = [];

        foreach ($meetingsRaw as $meeting) {

            $start = Carbon::parse($meeting->jam_awal)->hour;
            $end   = Carbon::parse($meeting->jam_akhir)->hour;

            for ($i = $start; $i < $end; $i++) {

                $slot = sprintf('%02d:00', $i);
                $meetings[$slot] = $meeting;

            }
        }

        $timeSlots = $this->generateSlots();
        $isAdmin = $this->isAdmin();

        $rooms = DB::connection('ConnEDPKrr')
            ->table('Ruang_Meeting')
            ->select('id','ruang_meeting')
            ->orderBy('ruang_meeting')
            ->get();

        return view('meeting_schedule', compact(
            'room',
            'rooms',
            'meetings',
            'tanggal',
            'timeSlots',
            'isAdmin'
        ));
    }

    public function generateSlots()
    {
        $slots = [];
        for ($i = 8; $i < 16; $i++) {
            $slots[] = [
                'start' => sprintf('%02d:00',$i),
                'end' => sprintf('%02d:00',$i+1)
            ];
        }
        return $slots;
    }

    public function storeRoom(Request $request)
    {
        if(!$this->isAdmin()){
            return response()->json([
                'error' => 'Akses ditolak'
            ]);
        }

        try {
            DB::connection('ConnEDPKrr')
                ->table('Ruang_Meeting')
                ->insert([
                    'ruang_meeting' => $request->ruang_meeting
                ]);

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);

        }
    }

    public function storeMeeting(Request $request)
    {
        try {
            $start = Carbon::createFromFormat('H:i', $request->start);
            $end   = Carbon::createFromFormat('H:i', $request->end);
            $now = Carbon::now('Asia/Jakarta');
            $today = $now->format('Y-m-d');
            $nowTime = $now->format('H:i');

            $limitStart = Carbon::createFromTime(8,0);
            $limitEnd   = Carbon::createFromTime(16,0);

            // validasi jam kerja
            if ($start < $limitStart || $end > $limitEnd) {
                return response()->json([
                    'error' => 'Meeting hanya boleh antara jam 08:00 sampai 16:00'
                ]);
            }

            // validasi jam akhir harus lebih besar
            if ($end <= $start) {
                return response()->json([
                    'error' => 'Jam akhir harus lebih besar dari jam awal'
                ]);
            }

            // jika tanggal hari ini dan jam meeting sudah lewat
            if ($request->tanggal == $today && $request->end <= $nowTime) {
                return response()->json([
                    'error' => 'Waktu meeting sudah terlewat'
                ]);
            }

            // cek bentrok
            $exists = DB::connection('ConnEDPKrr')
                ->table('Meeting')
                ->where('ruangan_id',$request->room)
                ->where('tanggal',$request->tanggal)
                ->whereNotIn('status',['selesai','dibatalkan'])
                ->where(function($q) use ($request){

                    $q->where('jam_awal','<',$request->end)
                    ->where('jam_akhir','>',$request->start);

                })
                ->exists();

            if($exists){
                return response()->json([
                    'error' => 'Jadwal bertabrakan dengan meeting lain'
                ]);
            }

            DB::connection('ConnEDPKrr')
                ->table('Meeting')
                ->insert([
                    'ruangan_id' => $request->room,
                    'pemesan' => auth()->user()->NomorUser,
                    'tanggal' => $request->tanggal,
                    'jam_awal' => $request->start,
                    'jam_akhir' => $request->end,
                    'deskripsi' => $request->deskripsi,
                    'status' => 'booked'
                ]);

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ]);

        }
    }

    public function updateMeeting(Request $request)
    {
        if(!$this->isAdmin()){
            return response()->json([
                'error' => 'Akses ditolak'
            ]);
        }

        try {

            $meeting = DB::connection('ConnEDPKrr')
                ->table('Meeting')
                ->where('id',$request->id)
                ->first();

            // cek bentrok
            $exists = DB::connection('ConnEDPKrr')
                ->table('Meeting')
                ->where('ruangan_id',$request->room)
                ->where('tanggal',$request->tanggal)
                ->where('id','!=',$request->id)
                ->whereNotIn('status',['selesai','dibatalkan'])
                ->where(function($q) use ($request){

                    $q->where('jam_awal','<',$request->end)
                    ->where('jam_akhir','>',$request->start);

                })
                ->exists();

            if($exists){
                return response()->json([
                    'error' => 'Jadwal bertabrakan dengan meeting lain'
                ]);
            }

            DB::connection('ConnEDPKrr')
                ->table('Meeting')
                ->where('id',$request->id)
                ->update([
                    'ruangan_id' => $request->room,
                    'tanggal' => $request->tanggal,
                    'jam_awal' => $request->start,
                    'jam_akhir' => $request->end,
                    'deskripsi' => $request->deskripsi,
                    'status' => $request->status
                ]);

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ]);

        }
    }

    public function cancelMeeting(Request $request)
    {
        if(!$this->isAdmin()){
            return response()->json([
                'error' => 'Akses ditolak'
            ]);
        }

        try {
            DB::connection('ConnEDPKrr')
                ->table('Meeting')
                ->where('id',$request->id)
                ->update([
                    'status' => 'dibatalkan'
                ]);

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e){

            return response()->json([
                'error' => $e->getMessage()
            ]);

        }
    }

    public function isAdmin()
    {
        return DB::connection('ConnEDPKrr')
            ->table('AdministratorMeeting')
            ->where('nomorUser_adm', auth()->user()->NomorUser)
            ->exists();
    }

    public function storeAdministratorMeeting(Request $request)
    {
        if(!$this->isAdmin()){
            return response()->json([
                'error' => 'Anda tidak memiliki akses'
            ]);
        }

        try{

            $user = DB::connection('ConnEDPKrr')
                ->table('UserMaster')
                ->where('NomorUser',$request->nomorUser)
                ->first();

            if(!$user){
                return response()->json([
                    'error' => 'User tidak ditemukan'
                ]);
            }

            $exists = DB::connection('ConnEDPKrr')
                ->table('AdministratorMeeting')
                ->where('nomorUser_adm',$request->nomorUser)
                ->exists();

            if($exists){
                return response()->json([
                    'error' => 'User sudah menjadi Administrator Meeting'
                ]);
            }

            DB::connection('ConnEDPKrr')
                ->table('AdministratorMeeting')
                ->insert([
                    'nomorUser_adm' => $user->NomorUser,
                ]);

            return response()->json([
                'success' => true
            ]);

        }catch(\Exception $e){

            return response()->json([
                'error' => $e->getMessage()
            ]);

        }
    }

    public function monthlyMeetings(Request $request, $room_id)
    {
        $bulan = $request->bulan ?? date('Y-m');
        $start = Carbon::parse($bulan)->startOfMonth();
        $end   = Carbon::parse($bulan)->endOfMonth();
        $tanggal = Carbon::today()->format('Y-m-d');

        $room = DB::connection('ConnEDPKrr')
            ->table('Ruang_Meeting')
            ->where('id',$room_id)
            ->first();

        $meetings = DB::connection('ConnEDPKrr')
            ->table('Meeting')
            ->leftJoin('UserMaster','Meeting.pemesan','=','UserMaster.NomorUser')
            ->select(
                'Meeting.*',
                'UserMaster.NamaUser',
            )
            ->where('Meeting.ruangan_id',$room_id)
            ->whereBetween('Meeting.tanggal',[$start,$end])
            ->whereNotIn('Meeting.status',['selesai','dibatalkan'])
            ->orderBy('Meeting.tanggal')
            ->get();

        $namaBulan = Carbon::parse($bulan)
            ->locale('id')
            ->translatedFormat('F');

        return view('meeting_monthly', compact(
            'room',
            'meetings',
            'tanggal',
            'bulan',
            'namaBulan'
        ));
    }

    public function rekapMeeting(Request $request)
    {
        $tanggal = $request->tanggal ?? date('Y-m-d');

        $rooms = DB::connection('ConnEDPKrr')
            ->table('Ruang_Meeting')
            ->select('id','ruang_meeting')
            ->orderBy('id')
            ->get();

        $meetings = DB::connection('ConnEDPKrr')
            ->table('Meeting')
            ->leftJoin('UserMaster','Meeting.pemesan','=','UserMaster.NomorUser')
            ->select(
                'Meeting.ruangan_id',
                'Meeting.jam_awal',
                'Meeting.jam_akhir',
                'Meeting.deskripsi',
                'UserMaster.NamaUser'
            )
            ->where('Meeting.tanggal',$tanggal)
            ->whereNotIn('Meeting.status',['selesai','dibatalkan'])
            ->get();

        return response()->json([
            'rooms'=>$rooms,
            'meetings'=>$meetings
        ]);
    }

}
