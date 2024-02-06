<?php

namespace App\Exports;

use App\Models\Tim;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TimExport implements FromView
{
    public function view(): View
    {
        $tims = Tim::withCount('detailTims')->get();
        return view('admin.tim.excel', compact('tims'));
    }
}
