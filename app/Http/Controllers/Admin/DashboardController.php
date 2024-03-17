<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Stok;
use App\Models\Unit;
use App\Models\User;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\BarangBawah;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
            $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

            $stokMasukGudangAtasData = Stok::with('detailStoks')
                ->where('jenis', 'Masuk Gudang Atas')
                ->where('status', 1)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get([
                    DB::raw('DATE(tanggal) as date'),
                    DB::raw('COUNT(*) as count'),
                ])
                ->pluck('count', 'date');

            $stokMasukGudangBawahData = Stok::with('detailStoks')
                ->where('jenis', 'Masuk Gudang Bawah')
                ->where('status', 1)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get([
                    DB::raw('DATE(tanggal) as date'),
                    DB::raw('COUNT(*) as count'),
                ])
                ->pluck('count', 'date');

            $stokMasukUnitData = Stok::with('detailStoks')
                ->where('jenis', 'Masuk Unit')
                ->where('status', 1)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get([
                    DB::raw('DATE(tanggal) as date'),
                    DB::raw('COUNT(*) as count'),
                ])
                ->pluck('count', 'date');

            $labels = [];
            $stokMasukGudangAtas = [];
            $stokMasukGudangBawah = [];
            $stokMasukUnit = [];

            $dates = Carbon::parse($startDate);
            while ($dates <= $endDate) {
                $dateString = $dates->toDateString();
                $labels[] = formatTanggal($dateString, 'd');
                $stokMasukGudangAtas[] = $stokMasukGudangAtasData[$dateString] ?? 0;
                $stokMasukGudangBawah[] = $stokMasukGudangBawahData[$dateString] ?? 0;
                $stokMasukUnit[] = $stokMasukUnitData[$dateString] ?? 0;
                $dates->addDay();
            }

            return $this->successResponse([
                'labels' => $labels,
                'stokMasukGudangAtas' => $stokMasukGudangAtas,
                'stokMasukGudangBawah' => $stokMasukGudangBawah,
                'stokMasukUnit' => $stokMasukUnit,
            ], 'Data stok ditemukan.');
        }

        $data = [
            'totalUnit' => Unit::count(),
            'totalKategori' => Kategori::count(),
            'totalBarang' => Barang::count(),
            'totalBarangBawah' => BarangBawah::count(),
            'totalKaryawan' => User::count(),
        ];

        return view('admin.dashboard.index', $data);
    }
}
