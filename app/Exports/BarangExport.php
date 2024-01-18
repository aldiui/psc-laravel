<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BarangExport implements FromView
{
    public function view(): View
    {
        $barangs = Barang::with('unit', 'kategori')->get();

        return view('admin.barang.excel', compact('barangs'));
    }
}
// tes remote branch