<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
  public function index()
  {
    $data['title'] = 'Category';
    $data['heading'] = 'Halaman Category';
    $data['subheading'] = 'Category';
    return view('backend.category.index', compact('data'));
  }

  public function fetchCategory(Request $request)
  {
    $dataCategory = \App\Models\Category::get();

    if ($request->ajax()) {
      return datatables()->of($dataCategory)
        ->addIndexColumn()
        ->addColumn('action', function ($category) {
          return '
            <div class="btn-group">
              <button id="btnEditCategory" class="btn btn-warning btn-sm" data-id="' . $category->id . '">
                <span class="fas fa-edit"></span>
              </button>
              <button id="btnDelCategory" class="btn btn-warning btn-danger" data-id="' . $category->id . '">
                  <span class="fas fa-trash-alt"></span>
              </button>
            </div>
          ';
        })
        ->addColumn('checkbox', function ($category) {
          return '
            <input type="checkbox" name="category_checkbox" id="category_checkbox" data-id="' . $category->id . '" />
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
    ], [
      'name.required' => 'Field Nama Kategori Wajib Di Isi',
      'name.string' => 'Field Nama Kategori Harus Berupa Alpha Numeric !',
    ]);

    // Cek validasi dari input yang di masukkan
    if ($validation->fails()) {
      return response()->json([
        'status' => 400,
        'error' => $validation->errors()->toArray(),
      ]);
    } else {
      // Simpan data user ke database
      $dataCategory = new \App\Models\Category();
      $dataCategory->name = $request->input('name');
      $dataCategory->slug = Str::slug($request->input('name'));
      $dataCategory->save();

      // Mengembalikan response json dengan status 200
      return response()->json([
        'status' => 200,
        'success' => 'Data User Berhasil di Simpan'
      ]);
    }
  }

  public function edit(Request $request)
  {
    $category = \App\Models\Category::findOrFail($request->get('idCategory'));
    return response()->json([
      'status' => 200,
      'category' => $category
    ]);
  }

  public function update(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'name' => 'required|string',
    ], [
      'name.required' => 'Field Nama Wajib Di Isi',
      'name.string' => 'Field Nama Harus Berupa Alpha Numeric !',
    ]);

    // Cek validasi dari input yang di masukkan
    if ($validation->fails()) {
      return response()->json([
        'status' => 400,
        'error' => $validation->errors()->toArray(),
      ]);
    } else {
      // Simpan data category ke database
      $dataCategory =  \App\Models\Category::findOrFail($request->get('idCategory'));
      $dataCategory->name = $request->get('name');
      $dataCategory->slug = Str::slug($request->input('name'));
      $dataCategory->update();

      // Mengembalikan response json dengan status 200
      return response()->json([
        'status' => 200,
        'success' => 'Data Kategori Dengan Nama ' . $dataCategory->name . ' Berhasil Di Perbaharui'
      ]);
    }
  }


  public function destroy(Request $request)
  {
    $dataCategory = \App\Models\Category::findOrFail($request->get('idCategory'));
    $dataCategory->delete();

    return response()->json([
      'status' => 200,
      'success' => 'Data Kategori Dengan Nama ' . $dataCategory->name . ' Berhasil Di Pindahkan Ke Tong Sampah !'
    ]);
  }

  public function trashCategory()
  {
    $data['title'] = 'Trash Category';
    $data['heading'] = 'Halaman Trash Category';
    $data['subheading'] = 'Trash Category';
    return view('backend.category.index', compact('data'));
  }

  public function fetchTrashCategory(Request $request)
  {
    $dataCategory = \App\Models\Category::onlyTrashed();

    if ($request->ajax()) {
      return datatables()->of($dataCategory)
        ->addIndexColumn()
        ->addColumn('action', function ($category) {
          return '
            <div class="btn-group">
              <button id="btnRestoreCategory" class="btn btn-secondary btn-sm" data-id="' . $category->id . '">
                <span class="fas fa-retweet"></span>
              </button>
              <button id="btnForceDelCategory" class="btn btn-warning btn-danger" data-id="' . $category->id . '">
                  <span class="fas fa-trash-alt"></span>
              </button>
            </div>
          ';
        })
        ->addColumn('checkbox', function ($category) {
          return '
            <input type="checkbox" name="category_trash_checkbox" id="category_trash_checkbox" data-id="' . $category->id . '" />
            <label for=""></label>
          ';
        })
        ->rawColumns(['action', 'checkbox'])
        ->make(true);
    }
  }

  public function destroySelected(Request $request)
  {
    $idCategory = $request->get('idCategory');
    $query = \App\Models\Category::whereIn('id', $idCategory)->delete();

    if ($query) {
      return response()->json([
        'status' => 200,
        'success' => 'Data User Berhasil Di Hapus',
      ]);
    }
  }

  public function restore(Request $request)
  {
    $dataCategory = \App\Models\Category::withTrashed()->findOrFail($request->get('idCategory'));
    $dataCategory->restore();

    return response()->json([
      'status' => 200,
      'message' => 'Data Kategori Berhasil Di Restore',
    ]);
  }
}
