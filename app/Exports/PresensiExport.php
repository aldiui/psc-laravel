<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PresensiExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $labels = $this->data['labels'];
        $presensiData = $this->data['presensi_data'];

        $bulanTahun = $this->data['bulanTahun'];
        return view('admin.presensi.excel', compact('labels', 'presensiData', 'bulanTahun'));
    }
}
