<?php

namespace App\Exports;

use App\Models\Unit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UnitExport implements FromView
{
    public function view(): View
    {
        $units = Unit::all();
        return view('admin.unit.excel', compact('units'));
    }
}