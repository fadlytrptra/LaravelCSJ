<?php

namespace App\Http\Controllers\Beli;

use Illuminate\Http\Request;
use App\Models\Beli\TransBL;
use App\User;
use Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HakAksesController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = (new HakAksesController)->HakAksesProgram('Beli');
        if($result)
        {
            return view('Beli.Home');
        }
        else
        {
            abort(404);
        }
    }
}
