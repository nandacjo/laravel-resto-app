<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function index()
  {
    return view('auth.login');
  }

  public function store(Request $request)
  {
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      $cek = \App\Models\User::where('id', Auth::user()->id)->firstOrFail();
      if ($cek->roles != "admin") {
        return response()->json([
          'status' => 405,
          'error' => 'Anda Tidak Memiliki Hak Akses Sebagai Admin',
        ]);
      } else {
        return response()->json([
          'status' => 200,
          'success' => 'Anda Berhasil Masuk',
        ]);
      }
    } else {
      return response()->json([
        'status' => 400,
        'error' => 'Pastikan Anda Memasukkan Email Dan Password Dengan Valid',
      ]);
    }
  }

  public function logout()
  {
    Auth::logout();
    return redirect()->route('login.index');
  }
}