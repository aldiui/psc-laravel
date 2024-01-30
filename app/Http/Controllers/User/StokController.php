<?php

namespace App\Http\Controllers\User;

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

            $stoks = Stok::where('user_id', Auth::user()->id)->withCount('detailStoks')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->latest()->get();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($stoks)
                    ->addColumn('aksi', function ($stok) {
                        $detailButton = '<a class="btn btn-sm btn-info mr-1" href="/stok/' . $stok->id . '"><i class="fas fa-info-circle mr-1"></i>Detail</a>';
                        $editButton = '<button class="btn btn-sm btn-warning mr-1" onclick="getModal(`editModal`, `/stok/' . $stok->id . '`, [`id`, `tanggal`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/stok/' . $stok->id . '`, `stokTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';

                        return $detailButton . $editButton . $deleteButton;
                    })
                    ->addColumn('status_badge', function ($stok) {
                        return statusBadge($stok->status);
                    })
                    ->addColumn('tgl', function ($stok) {
                        return formatTanggal($stok->tanggal);
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'tgl', 'status_badge'])
                    ->make(true);
            }

            return $this->successResponse($stoks, 'Data stok ditemukan.');
        }
        return view('user.stok.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $stok = Stok::create([
            'tanggal' => $request->input('tanggal'),
            'user_id' => Auth::user()->id,
        ]);

        return $this->successResponse($stok, 'Data Stok ditambahkan.', 201);
    }

    public function show(Request $request, $id)
    {
        $stok = Stok::with('user')->find($id);

        if ($request->ajax()) {
            if ($request->input("mode") == "datatable") {
                $detailStoks = DetailStok::with(['barang', 'stok'])->where('stok_id', $id)->get();
                return DataTables::of($detailStoks)
                    ->addColumn('aksi', function ($detailStok) {
                        $editButton = '<button class="btn btn-sm btn-warning mr-1" onclick="getSelectEdit(), getModal(`editModal`, `/detail-stok/' . $detailStok->id . '`, [`id`, `barang_id`, `qty`, `deskripsi`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/detail-stok/' . $detailStok->id . '`, `detailStokTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';

                        return $detailStok->stok->status != 1 ? $editButton . $deleteButton : statusBadge($detailStok->stok->status);
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

        return view('user.stok.show', compact('stok'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $stok = Stok::find($id);

        if (!$stok) {
            return redirect(route('stok.index'));
        }

        $stok->update([
            'tanggal' => $request->input('tanggal'),
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
