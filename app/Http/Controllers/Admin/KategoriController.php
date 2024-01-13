<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $kategori = Kategori::all();
            return DataTables::of($kategori)
                ->addIndexColumn()
                ->make(true);
        }

        return view("admin.kategori.view", ["title" => "Kategori" ]);
    }
}