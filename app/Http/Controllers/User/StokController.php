<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DetailStok;
use App\Models\Stok;
use App\Models\User;
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
            $bulan = $request->bulan;
            $tahun = $request->tahun;

            $stoks = Stok::with('user')->whereUserId(Auth::user()->id)->withCount('detailStoks')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->latest()->get();
            if ($request->input("mode") == "datatable") {
                return DataTables::of($stoks)
                    ->addColumn('aksi', function ($stok) {
                        $detailButton = '<a class="btn btn-sm btn-info d-inline-flex align-items-baseline mr-1" href="/stok/' . $stok->id . '"><i class="fas fa-info-circle mr-1"></i>Detail</a>';
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex align-items-baseline mr-1" onclick="getModal(`createModal`, `/stok/' . $stok->id . '`, [`id`, `tanggal`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex align-items-baseline" onclick="confirmDelete(`/stok/' . $stok->id . '`, `stokTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                        return $stok->status != 1 ? $detailButton . $editButton . $deleteButton : $detailButton . "<div class='mt-2'> Di setujui oleh " . $stok->approval->nama . "</div>";
                    })
                    ->addColumn('status_badge', function ($stok) {
                        return statusBadge($stok->status);
                    })
                    ->addColumn('jenis_badge', function ($stok) {
                        return jenisBadge($stok->jenis);
                    })
                    ->addColumn('tgl', function ($stok) {
                        return formatTanggal($stok->tanggal);
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'tgl', 'status_badge', 'jenis_badge'])
                    ->make(true);
            }

            return $this->successResponse($stoks, 'Data Stok ditemukan.');
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
            'tanggal' => $request->tanggal,
            'user_id' => Auth::user()->id,
        ]);

        return $this->successResponse($stok, 'Data Stok ditambahkan.', 201);
    }

    public function show(Request $request, $id)
    {

        if ($request->ajax()) {
            $stok = Stok::with(['user', 'approval'])->whereUserId(Auth::user()->id)->find($id);
            if ($request->mode == "datatable") {
                $detailStoks = DetailStok::with(['barang', 'stok'])->where('stok_id', $id)->get();
                return DataTables::of($detailStoks)
                    ->addColumn('aksi', function ($detailStok) {
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex align-items-baseline mr-1" onclick="getModal(`createModal`, `/detail-stok/' . $detailStok->id . '`, [`id`, `barang_id`, `qty`, `deskripsi`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex align-items-baseline" onclick="confirmDelete(`/detail-stok/' . $detailStok->id . '`, `detailStokTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';

                        return $detailStok->stok->status == 3 ? $editButton . $deleteButton : statusBadge($detailStok->stok->status);
                    })
                    ->addColumn('nama', function ($detailStok) {
                        return $detailStok->barang->nama;
                    })
                    ->addColumn('quantity', function ($detailStok) {
                        return $detailStok->qty . " " . ($detailStok->barang->unit->nama !== 'Kosong' ? ' ' . $detailStok->barang->unit->nama : '');
                    })
                    ->addIndexColumn()
                    ->rawColumns(['nama', 'aksi', 'quantity'])
                    ->make(true);
            }

            if (!$stok) {
                return $this->errorResponse(null, 'Data Stok tidak ditemukan.', 404);
            }

            return $this->successResponse($stok, 'Data Stok ditemukan.');
        }

        $stok = Stok::with(['user', 'approval'])->findOrFail($id);
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

        $stok = Stok::whereUserId(Auth::user()->id)->find($id);

        if (!$stok) {
            return redirect(route('stok.index'));
        }

        $stok->update($request->only('tanggal'));
        return $this->successResponse($stok, 'Data Stok diubah.', 200);

    }

    public function destroy($id)
    {
        $stok = Stok::whereUserId(Auth::user()->id)->find($id);

        if (!$stok) {
            return $this->errorResponse(null, 'Data Stok tidak ditemukan.', 404);
        }

        $stok->delete();
        return $this->successResponse(null, 'Data Stok dihapus.');
    }

}
