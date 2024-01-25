<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailStok;
use App\Models\Stok;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bulan = $request->input("bulan");
            $tahun = $request->input("tahun");

            $stoks = Stok::with('user')->withCount('detailStoks')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->latest()->get();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($stoks)
                    ->addColumn('nama', function ($presensi) {
                        return $presensi->user->nama;
                    })
                    ->addColumn('aksi', function ($stok) {
                        $detailButton = '<a class="btn btn-sm btn-info mr-1" href="/admin/stok/' . $stok->id . '"><i class="fas fa-info-circle mr-1"></i>Detail</a>';
                        $editButton = '<button class="btn btn-sm btn-warning mr-1" onclick="getModal(`editModal`, `/admin/stok/' . $stok->id . '`, [`id`, `tanggal`, `jenis`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/stok/' . $stok->id . '`, `stokTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';

                        return $detailButton . $editButton . $deleteButton;
                    })
                    // ->addColumn('status_badge', function ($stok) {
                    //     return statusBadge($stok->status);
                    // })
                    ->addColumn('status_badge', function ($stok) {
                        $statusIcon = ($stok->status == '0') ? '<i class="far fa-clock mr-1"></i>' : (($stok->status == '1') ? '<i class="far fa-check-circle mr-1"></i>' : '<i class="far fa-times-circle mr-1"></i>');
                        $statusClass = ($stok->status == '0') ? 'badge-warning' : (($stok->status == '1') ? 'badge-success' : 'badge-danger');
                        $statusText = ($stok->status == '0') ? 'Menunggu' : (($stok->status == '1') ? 'Disetujui' : 'Ditolak');
                        return "<span class='badge $statusClass'>$statusIcon $statusText</span>";
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'status_badge', 'nama'])
                    ->make(true);
            }

            return $this->successResponse($stoks, 'Data stok ditemukan.');
        }
        return view('admin.stok.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'jenis' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $stok = Stok::create([
            'tanggal' => $request->input('tanggal'),
            'jenis' => $request->input('jenis'),
            'user_id' => Auth::user()->id,
        ]);

        return $this->successResponse($stok, 'Data Stok ditambahkan.', 201);
    }

    public function show(Request $request, $id)
    {
        $stok = Stok::with('user')->find($id);

        if ($request->ajax()) {
            if ($request->input("mode") == "datatable") {
                $detailStoks = DetailStok::with('barang')->where('stok_id', $id)->get();
                return DataTables::of($detailStoks)
                    ->addColumn('aksi', function ($detailStok) {
                        $editButton = '<button class="btn btn-sm btn-warning mr-1" onclick="getSelectEdit(), getModal(`editModal`, `/admin/detail-stok/' . $detailStok->id . '`, [`id`, `barang_id`, `qty`, `deskripsi`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/detail-stok/' . $detailStok->id . '`, `detailStokTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';

                        return $editButton . $deleteButton;
                    })
                    ->addColumn('nama', function ($detailStok) {
                        return $detailStok->barang->nama;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['nama', 'aksi'])
                    ->make(true);
            }

            if (!$stok) {
                return $this->errorResponse(null, 'Data stok tidak ditemukan.', 404);
            }

            return $this->successResponse($stok, 'Data stok ditemukan.');
        }

        return view('admin.stok.show', compact('stok'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'jenis' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $stok = Stok::find($id);

        if (!$stok) {
            return redirect(route('admin.stok.index'));
        }

        $stok->update([
            'tanggal' => $request->input('tanggal'),
            'jenis' => $request->input('jenis'),
        ]);

        return $this->successResponse($stok, 'Data Stok diupdate.', 200);
    }

    public function destroy($id)
    {
        $stok = Stok::find($id);

        if (!$stok) {
            return $this->errorResponse(null, 'Data stok tidak ditemukan.', 404);
        }

        $stok->delete();

        return $this->successResponse(null, 'Data stok dihapus.');
    }

}
