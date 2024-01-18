<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KaryawanExport implements FromView
{
    public function view(): View
    {
        $karyawans = User::all() ;
        return view('admin.karyawan.excel', compact('karyawans'));
    }
}