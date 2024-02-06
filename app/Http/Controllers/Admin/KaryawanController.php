<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KaryawanExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponder;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $karyawans = User::whereNot("id", Auth::user()->id)->get();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($karyawans)
                    ->addColumn('aksi', function ($karyawan) {
                        $editButton = '<button class="btn btn-sm btn-warning mr-1" onclick="getModal(`editModal`, `/admin/karyawan/' . $karyawan->id . '`, [`id`, `nama`, `email`, `jabatan`, `no_hp`, `role`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/karyawan/' . $karyawan->id . '`, `karyawanTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return $editButton . $deleteButton;
                    })
                    ->addColumn('img', function ($karyawan) {
                        return '<img src="' . ($karyawan->image != 'default.png' ? '/storage/img/karyawan/' . $karyawan->image : '/images/default.png') . '" width="100px" alt="">';
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

        if ($id == 'excel') {
            ob_end_clean();
            ob_start();
            return Excel::download(new KaryawanExport(), 'Karyawan.xlsx');
        }

        if ($id == "pdf") {
            $karyawans = User::all();
            $pdf = PDF::loadView('admin.karyawan.pdf', compact('karyawans'));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('a4', 'landscape');

            $namaFile = 'Karyawan.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
        }

        $karyawan = User::find($id);

        if (!$karyawan) {
            return $this->errorResponse(null, 'Data karyawan tidak ditemukan.', 404);
        }

        return $this->successResponse($karyawan, 'Data karyawan ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $dataValidator = [
            'nama' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
            'email' => 'required|email|unique:users,email,' . $id,
            'jabatan' => 'required',
            'no_hp' => 'required',
            'role' => 'required',
        ];

        if ($request->input('password') != null) {
            $dataValidator['password'] = 'required|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $dataValidator);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $karyawan = User::find($id);

        if (!$karyawan) {
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

        if ($request->input('password') != null) {
            $updateKaryawan['password'] = bcrypt($request->input('password'));
        }

        $karyawan->update($updateKaryawan);

        return $this->successResponse($karyawan, 'Data karyawan diubah.');
    }

    public function destroy($id)
    {
        $karyawan = User::find($id);

        if (!$karyawan) {
            return $this->errorResponse(null, 'Data karyawan tidak ditemukan.', 404);
        }

        if ($karyawan->image != 'default.png' && Storage::exists('public/img/karyawan/' . $karyawan->image)) {
            Storage::delete('public/img/karyawan/' . $karyawan->image);
        }

        $karyawan->delete();

        return $this->successResponse(null, 'Data karyawan dihapus.');
    }
}