<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangBawah;
use App\Models\DetailStok;
use App\Models\Notifikasi;
use App\Models\Stok;
use App\Traits\ApiResponder;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if ($request->ajax()) {
            $stoks = Stok::with(['user', 'approval'])->withCount('detailStoks')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->latest()->get();
            if ($request->mode == "datatable") {
                return DataTables::of($stoks)
                    ->addColumn('nama', function ($presensi) {
                        return $presensi->user->nama;
                    })
                    ->addColumn('aksi', function ($stok) {
                        $detailButton = '<a class="btn btn-sm btn-info d-inline-flex  align-items-baseline  mr-1" href="/admin/stok/' . $stok->id . '"><i class="fas fa-info-circle mr-1"></i>Detail</a>';
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex  align-items-baseline  mr-1" onclick="getModal(`createModal`, `/admin/stok/' . $stok->id . '`, [`id`, `tanggal`, `jenis`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline " onclick="confirmDelete(`/admin/stok/' . $stok->id . '`, `stokTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
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
                    ->rawColumns(['aksi', 'status_badge', 'nama', 'tgl', 'jenis_badge'])
                    ->make(true);
            }

            return $this->successResponse($stoks, 'Data Stok ditemukan.');
        }

        if ($request->mode == "pdf") {
            $stoks = Stok::with(['user', 'approval'])->withCount('detailStoks')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->oldest()->get();
            $bulanTahun = Carbon::create($tahun, $bulan, 1)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F Y');

            $pdf = PDF::loadView('admin.stok.pdf', compact('stoks', 'bulanTahun'));

            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];

            $pdf->setOptions($options);
            $pdf->setPaper('legal', 'potrait');

            $namaFile = 'laporan_rekap_stok_' . $bulan . '_' . $tahun . '.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->stream($namaFile);
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
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'user_id' => Auth::user()->id,
        ]);

        return $this->successResponse($stok, 'Data Stok ditambahkan.', 201);
    }

    public function show(Request $request, $id)
    {

        if ($request->ajax()) {
            $stok = Stok::with(['user', 'approval'])->find($id);

            if ($request->mode == "datatable") {
                $detailStoks = DetailStok::with(['barang.unit', 'stok'])->where('stok_id', $id)->get();
                return DataTables::of($detailStoks)
                    ->addColumn('aksi', function ($detailStok) {
                        $editButton = '<button class="btn btn-sm btn-warning d-inline-flex  align-items-baseline  mr-1" onclick="getModal(`createModal`, `/admin/detail-stok/' . $detailStok->id . '`, [`id`, `barang_id`, `qty`, `deskripsi`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger d-inline-flex  align-items-baseline " onclick="confirmDelete(`/admin/detail-stok/' . $detailStok->id . '`, `detailStokTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';

                        return $detailStok->stok->status == 3 || $detailStok->stok->status == 0 ? $editButton . $deleteButton : statusBadge($detailStok->stok->status);
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

        return view('admin.stok.show', compact('stok'));
    }

    public function update(Request $request, $id)
    {
        $cekStatus = $request->status;

        if (isset($cekStatus)) {
            $dataValidator = ['status' => 'required'];
        } else {
            $dataValidator = ['tanggal' => 'required', 'jenis' => 'required'];
        }
        $validator = Validator::make($request->all(), $dataValidator);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $stok = Stok::find($id);

        if (!$stok) {
            return redirect(route('admin.stok.index'));
        }

        if (isset($cekStatus)) {
            $detailStoksCount = $stok->detailStoks()->count();

            if ($detailStoksCount == 0) {
                return $this->errorResponse(null, 'Data Detail Stok tidak ditemukan.', 404);
            }

            if ($cekStatus == 1) {
                $stok->update([
                    'status' => $cekStatus,
                    'approval_id' => Auth::user()->id,
                ]);

                $detailStoks = DetailStok::with('barang')->where('stok_id', $id)->get();
                foreach ($detailStoks as $detailStok) {
                    $barang = $detailStok->barang;
                    if ($stok->jenis == "Masuk Gudang Atas") {
                        $barang->update([
                            'qty' => $barang->qty + $detailStok->qty,
                        ]);
                    } elseif ($stok->jenis == "Masuk Gudang Bawah") {
                        if ($barang->qty >= $detailStok->qty) {
                            $barang->update([
                                'qty' => $barang->qty - $detailStok->qty,
                            ]);
                            $cekStokBarangBawah = BarangBawah::where('barang_id', $detailStok->barang_id)->first();
                            if ($cekStokBarangBawah) {
                                $cekStokBarangBawah->update([
                                    'qty' => $cekStokBarangBawah->qty + $detailStok->qty,
                                ]);
                            }
                        }
                    } elseif ($stok->jenis == "Masuk Unit") {
                        $cekStokBarangBawah = BarangBawah::where('barang_id', $detailStok->barang_id)->first();
                        if ($cekStokBarangBawah && $cekStokBarangBawah->qty >= $detailStok->qty) {
                            $cekStokBarangBawah->update([
                                'qty' => $cekStokBarangBawah->qty - $detailStok->qty,
                            ]);
                        }
                    }
                }

                $notifikasi = Notifikasi::create([
                    'user_id' => Auth::user()->id,
                    'target_id' => $stok->user_id,
                    'title' => 'Stok',
                    'body' => Auth::user()->nama . ' Menyetujui Stok Barang ' . $stok->jenis . ' pada ' . formatTanggal($stok->tanggal),
                    'url' => '/stok/' . $stok->id,
                ]);

                if ($stok->user->fcm_token) {
                    kirimNotifikasi($notifikasi->title, $notifikasi->body, $stok->user->fcm_token);
                }

                return $this->successResponse($stok, 'Data Stok disetujui.', 200);
            } elseif ($cekStatus == 0) {
                $stok->update([
                    'status' => $cekStatus,
                ]);

                return $this->successResponse($stok, 'Data Stok diserahkan.', 200);
            }
        } else {
            $stok->update([
                'tanggal' => $request->tanggal,
                'jenis' => $request->jenis,
            ]);

            return $this->successResponse($stok, 'Data Stok diubah.', 200);
        }

    }

    public function destroy($id)
    {
        $stok = Stok::find($id);

        if (!$stok) {
            return $this->errorResponse(null, 'Data Stok tidak ditemukan.', 404);
        }

        $stok->delete();

        return $this->successResponse(null, 'Data Stok dihapus.');
    }

}
