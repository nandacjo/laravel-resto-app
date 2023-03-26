<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  public function index()
  {
    return view('backend.user.index');
  }

  public function fetchUser(Request $request)
  {
    $users = \App\Models\User::where('id', '<>', auth()->user()->id)->get();

    if ($request->ajax()) {
      return datatables()->of($users)
        ->addIndexColumn()
        ->addColumn('action', function ($user) {
          return '
            <div class="btn-group">
              <button id="btnEditUser" class="btn btn-warning btn-sm" data-id="' . $user->id . '">
                <span class="fas fa-edit"></span>
              </button>
              <button id="btnDelUser" class="btn btn-warning btn-danger" data-id="' . $user->id . '">
                  <span class="fas fa-trash-alt"></span>
              </button>
            </div>
          ';
        })
        ->addColumn('checkbox', function ($user) {
          return '
            <input type="checkbox" name="user_checkbox" id="user_checkbox" data-id="' . $user->id . '" />
            <label for=""></label>
          ';
        })
        ->rawColumns(['action', 'checkbox'])
        ->make(true);
    }
  }

  public function store(Request $request)
  {
    // Membuat validasi apa saja yang diperlikan
    // Jangan lupa import validator dai App\Illuminate\Facades\Validator
    $validation = Validator::make($request->all(), [
      'name' => 'required|string',
      'email' => 'email|required',
      'roles' => 'required',
      'password' => 'required|string'
    ], [
      'name.required' => 'Field Nama Wajib Di Isi',
      'name.string' => 'Field Nama Harus Berupa Alpha Numeric !',
      'email.email' => 'Field Email Harus Valid Contaoh: budi@gmail.com',
      'email.required' => 'Field Email Wajib Di Isi',
      'roles.required' => 'Field Roles Wajib Di Isi',
      'password.required' => 'Field Password Wajib Di Isi',
      'password.string' => 'Field Password Harus Berupa Alpah Numeric',
    ]);

    // Cek validasi dari input yang di masukkan
    if ($validation->fails()) {
      return response()->json([
        'status' => 400,
        'error' => $validation->errors()->toArray(),
      ]);
    } else {
      // Simpan data user ke database
      $dataUser = new \App\Models\User();
      $dataUser->name = $request->get('name');
      $dataUser->email = $request->get('email');
      $dataUser->roles = $request->get('roles');
      $dataUser->password = bcrypt($request->get('password')); //hash password menggunakna bcrypt
      $dataUser->save();

      // Mengembalikan response json dengan status 200
      return response()->json([
        'status' => 200,
        'success' => 'Data User Berhasil di Simpan'
      ]);
    }
  }

  public function edit(Request $request)
  {
    $user = \App\Models\User::findOrFail($request->get('idUser'));
    return response()->json([
      'status' => 200,
      'user' => $user
    ]);
  }

  public function update(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'name' => 'required|string',
      'email' => 'email|required',
      'roles' => 'required',
      'password' => 'nullable|string'
    ], [
      'name.required' => 'Field Nama Wajib Di Isi',
      'name.string' => 'Field Nama Harus Berupa Alpha Numeric !',
      'email.email' => 'Field Email Harus Valid Contaoh: budi@gmail.com',
      'email.required' => 'Field Email Wajib Di Isi',
      'roles.required' => 'Field Roles Wajib Di Isi',
      'password.string' => 'Field Password Harus Berupa Alpah Numeric',
    ]);

    // Cek validasi dari input yang di masukkan
    if ($validation->fails()) {
      return response()->json([
        'status' => 400,
        'error' => $validation->errors()->toArray(),
      ]);
    } else {
      // Simpan data user ke database
      $dataUser =  \App\Models\User::findOrFail($request->get('idUser'));
      $dataUser->name = $request->get('name');
      $dataUser->email = $request->get('email');
      $dataUser->roles = $request->get('roles');
      if ($request->input('password') != '' && $request->input('password') != null) {
        $dataUser->password = bcrypt($request->get('password')); //hash password menggunakna bcrypt
      }
      $dataUser->update();

      // Mengembalikan response json dengan status 200
      return response()->json([
        'status' => 200,
        'success' => 'Data User Dengan Nama ' . $dataUser->name . ' Berhasil Di Perbaharui'
      ]);
    }
  }

  public function destroy(Request $request)
  {
    $dataUser = \App\Models\User::findOrFail($request->get('idUser'));
    $dataUser->delete();

    return response()->json([
      'status' => 200,
      'success' => 'Data User Dengan Nama ' . $dataUser->name . ' Berhasil Di Hapus !'
    ]);
  }

  public function destroySelected(Request $request)
  {
    $idUsers = $request->get('idUsers');
    $query = \App\Models\User::whereIn('id', $idUsers)->delete();

    if ($query) {
      return response()->json([
        'status' => 200,
        'success' => 'Data User Berhasil Di Hapus',
      ]);
    }
  }
}
