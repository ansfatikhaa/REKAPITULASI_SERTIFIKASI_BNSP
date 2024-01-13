<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\rsm_msuser;

class Login extends Controller
{
    function index()
    {
        return view('login/login');
    }

    public function loginPost(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $user = rsm_msuser::where('usr_username', '=', $request->input('username'))->first();

        $data = DB::connection('mysql')->table('rsm_msuser')->where('usr_username', $username)->first();

        if ($data) {
            if (Hash::check($password, $data->usr_password)) {
                session([
                    'usr_nama' => $data->usr_nama,
                    'usr_username' => $data->usr_username,
                    'usr_role' => $data->usr_role,
                    'login' => true
                ]);
                return redirect('dashboard/home')->with('alert-success', 'Login Berhasil!');
            } else {
                return redirect('login/login')->with('alert', '!!Username atau Password anda salah!');
            }
        } else {
            return redirect('login/welcome')->with('alert', '!Username atau Password anda salah!');
        }
    }

    public function logout()
    {
        // Proses logout
        auth()->logout();

        // Redirect ke halaman login
        return redirect('/login');
    }

    
    
}
