<?php

namespace App\Exports;

use App\Models\Izin;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IzinExport implements FromView
{
    public function view(): View
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;
        $izins = Izin::with(['user', 'approval'])->where('status', '1')->whereMonth('tanggal_mulai', $bulan)->whereYear('tanggal_mulai', $tahun)->latest()->get();
        $bulanTahun = Carbon::create($tahun, $bulan, 1)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F Y');
        return view('admin.izin.excel', compact(['izins', 'bulanTahun']));
    }
}