<?php

namespace App\Exports;

use App\Models\Izin;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IzinExport implements FromView
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;
        $izins = Izin::with(['user', 'approval'])
            ->where('status', '1')
            ->whereMonth('tanggal_mulai', $this->bulan)
            ->whereYear('tanggal_mulai', $this->tahun)
            ->latest()
            ->get();

        $bulanTahun = Carbon::create($this->tahun, $this->bulan, 1)
            ->locale('id')
            ->settings(['formatFunction' => 'translatedFormat'])
            ->format('F Y');
        return view('admin.izin.excel', compact(['izins', 'bulanTahun']));
    }
}
