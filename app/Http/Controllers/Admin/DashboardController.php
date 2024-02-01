<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Stok;
use App\Models\Unit;
use App\Models\User;
use App\Traits\ApiResponder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bulan = $request->input("bulan");
            $tahun = $request->input("tahun");
            $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
            $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

            $stokMasukData = Stok::where('jenis', 'Masuk')->whereBetween('tanggal', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get([
                    DB::raw('DATE(tanggal) as date'),
                    DB::raw('COUNT(*) as count'),
                ])
                ->pluck('count', 'date');

            $stokKeluarData = Stok::where('jenis', 'Keluar')->whereBetween('tanggal', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get([
                    DB::raw('DATE(tanggal) as date'),
                    DB::raw('COUNT(*) as count'),
                ])
                ->pluck('count', 'date');

            $dates = Carbon::parse($startDate);
            $labels = [];
            $stokMasuk = [];
            $stokKeluar = [];

            while ($dates <= $endDate) {
                $dateString = $dates->toDateString();
                $labels[] = formatTanggal($dateString, 'd');
                $stokMasuk[] = $stokMasukData[$dateString] ?? 0;
                $stokKeluar[] = $stokKeluarData[$dateString] ?? 0;
                $dates->addDay();
            }

            return $this->successResponse([
                'labels' => $labels,
                'stokMasuk' => $stokMasuk,
                'stokKeluar' => $stokKeluar,
            ], 'Data stok ditemukan.');
        }

        $data = [
            'totalUnit' => Unit::count(),
            'totalKategori' => Kategori::count(),
            'totalBarang' => Barang::count(),
            'totalKaryawan' => User::count(),
        ];

        return view('admin.dashboard.index', $data);
    }
}