<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Exports\KaryawanExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    use ApiResponder;
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $karyawans = User::whereNot("id", Auth::user()->id)->get();
            if($request->input("mode") == "datatable"){
                return DataTables::of($karyawans)
                    ->addColumn('aksi', function ($karyawan) {
                        $editButton = '<button class="btn btn-sm btn-warning mr-1" onclick="getModal(`editModal`, `/admin/karyawan/' . $karyawan->id . '`, [`id`, `nama`, `email`, `jabatan`, `no_hp`, `role`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/karyawan/' . $karyawan->id . '`, `karyawanTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                    
                        return $editButton . $deleteButton;
                    })
                    ->addColumn('img', function ($karyawan) {
                        return '<img src="/storage/img/karyawan/' . $karyawan->image . '" width="150px" alt="">';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'img'])
                    ->make(true);
            }

            return $this->successResponse($karyawans, 'Data karyawan ditemukan.'); 
        }
    
        return view('admin.karyawan.index');
    }
    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'jabatan' => 'required',
            'no_hp' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/img/karyawan', $image);
        }

        $karyawan = User::create([
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'jabatan' => $request->input('jabatan'),
            'no_hp' => $request->input('no_hp'),
            'role' => $request->input('role'),
            'image' => $image ?? "default.png",
        ]);

        return $this->successResponse($karyawan, 'Data karyawan ditambahkan.', 201);
    }

    public function show($id)
    {

        if($id =='excel'){
            return Excel::download( new KaryawanExport(), 'Karyawan.xlsx');
        }
        
        $karyawan = User::find($id);

        if(!$karyawan){
            return $this->errorResponse(null, 'Data karyawan tidak ditemukan.', 404);    
        }
        
        return $this->successResponse($karyawan, 'Data karyawan ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $dataValidator = [
            'nama' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
            'email' => 'required|email|unique:users,email,'.$id,
            'jabatan' => 'required',
            'no_hp' => 'required',
            'role' => 'required',
        ];

        if($request->input('password') != null){
            $dataValidator['password'] = 'required|min:8|confirmed';
        }
        
        $validator = Validator::make($request->all(), $dataValidator);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $karyawan = User::find($id);
        
        if(!$karyawan){
            return $this->errorResponse(null, 'Data karyawan tidak ditemukan.', 404);    
        }

        $updateKaryawan = [
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'jabatan' => $request->input('jabatan'),
            'no_hp' => $request->input('no_hp'),
            'role' => $request->input('role'),
        ];

        if ($request->hasFile('image')) {
            if ($karyawan->image != 'default.png' && Storage::exists('public/img/karyawan/' . $karyawan->image)) {
                Storage::delete('public/img/karyawan/' . $karyawan->image);
            }
            $image = $request->file('image')->hashName();
            $request->file('image')->storeAs('public/img/karyawan', $image);
            $updateKaryawan['image'] = $image;
        }


        if($request->input('password') != null){
            $updateKaryawan['password'] = bcrypt($request->input('password'));
        }
        
        $karyawan->update($updateKaryawan);

        return $this->successResponse($karyawan, 'Data karyawan diupdate.');
    }

    public function destroy($id)
    {
        $karyawan = User::find($id);

        if(!$karyawan){
            return $this->errorResponse(null, 'Data karyawan tidak ditemukan.', 404);    
        }

        if ($karyawan->image != 'default.png' && Storage::exists('public/img/karyawan/' . $karyawan->image)) {
            Storage::delete('public/img/karyawan/' . $karyawan->image);
        }

        $karyawan->delete();
        
        return $this->successResponse(null, 'Data karyawan dihapus.');
    }
}