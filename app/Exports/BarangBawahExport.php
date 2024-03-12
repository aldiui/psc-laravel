<?php

namespace App\Exports;

use App\Models\BarangBawah;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BarangBawahExport implements FromView
{
    public function view(): View
    {
        $barangBawahs = BarangBawah::with('barang.unit', 'barang.kategori')->get();
        return view('admin.barang-bawah.excel', compact('barangBawahs'));
    }
}
