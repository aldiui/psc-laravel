<?php

namespace App\Exports;

use App\Models\Kategori;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KategoriExport implements FromView
{
    public function view(): View
    {
        $kategoris = Kategori::all();
        return view('admin.kategori.excel', compact('kategoris'));
    }
}