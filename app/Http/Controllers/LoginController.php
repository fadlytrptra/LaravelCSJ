<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::guest()) {
            return view('auth.login');
        } else {
            return redirect('/home');
        }
    }

    public function login(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $messages = [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $currentTime = Carbon::now();
        $currentTime->setTimezone('Asia/Bangkok');
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'NomorUser' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        // Cek apakah user aktif sebelum melakukan login
        $user = DB::connection('ConnEDP')
            ->table('UserMaster')
            ->where('NomorUser', $request->input('username'))
            ->first();

        if ($user && $user->IsActive == 0) {
            return redirect()->route('login')->withInput()->withErrors(['error' => 'Akun Anda tidak aktif.']);
        }

        //cek ip
        if ($user) {
            $ipUser = $request->ip();

            if ($user->IsOnline == 0) {
                $allowedIPAddress = [
                    '192.168.10.',
                    '192.168.11.',
                    '192.168.12.',
                    '192.168.13.',
                    '192.168.60.',
                    '192.168.100.',
                    '192.168.101.',
                    '127.0.0.1',
                ];

                $isAllowed = false;
                foreach ($allowedIPAddress as $prefix) {
                    if (str_starts_with($ipUser, $prefix)) {
                        $isAllowed = true;
                        break;
                    }
                }

                if (!$isAllowed) {
                    return redirect()->route('login')
                        ->withInput()
                        ->withErrors(['error' => 'Tidak Memiliki Akses Online terhadap Website']);
                }
            }
        }

        Auth::attempt($data);
        if (Auth::check()) {
            // Ambil IP publik user
            $ipUser = $request->ip();

            // ganti dengan menggunakan database UserMaster
            DB::connection('ConnEDP')->table('UserMaster')
                ->where('NomorUser', $request->input('username'))
                ->update([
                    'LastLogIn' => $currentTime,
                    'IPAddress' => $ipUser,
                    ]);

            return redirect()->route('home');

        } else {
            return redirect()->route('login')->withInput()->withErrors([
                'error' => 'Username atau Password tidak ditemukan!'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
    public function Register(Request $request)
    {
        // dd($request->all());
        $input = $request->input;
        $command = $request->typeCommand;
        if ($command == 'GetNomorKartu') {
            try {
                $result = DB::connection('ConnEDP')->table('UserMaster')
                    ->select('*')
                    ->where('NomorUser', $input)
                    ->get();
                if ($result->isNotEmpty()) {
                    $result = DB::connection('ConnEDP')->table('UserMaster')
                        ->select('*')
                        ->where('NomorUser', $input)
                        ->whereNotNull('password')
                        ->get();
                    if ($result->isNotEmpty()) {
                        return response()->json(['error' => 'User ' . $input . ' sudah memiliki password, Silahkan hubungi EDP untuk reset password'], 403);
                    } else {
                        return 'OK';
                    }
                } else {
                    // If no user data found, return appropriate response
                    return response()->json(['error' => 'User not found'], 404);
                }
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Database query failed'], 500);
            }
        } else if ($command == 'SetPassword') {
            try {
                $user = $request->user;
                $result = DB::connection('ConnEDP')->table('UserMaster')
                    ->where('NomorUser', $user)
                    ->update(['password' => Hash::make($input)]);
                if ($result) {
                    return response()->json('success');
                } else {
                    // If no user data found, return appropriate response
                    return response()->json(['error' => 'Error']);
                }
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Database query failed'], 500);
            }
        } else {
            // If typeCommand is not recognized, return appropriate response
            return response()->json(['error' => 'Invalid typeCommand'], 400);
        }
    }
}
