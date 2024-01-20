<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\UnitExport;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    use ApiResponder;
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $units = Unit::all();
            if($request->input("mode") == "datatable"){
                return DataTables::of($units)
                    ->addColumn('aksi', function ($unit) {
                        $editButton = '<button class="btn btn-sm btn-warning mr-1" onclick="getModal(`editModal`, `/admin/unit/' . $unit->id . '`, [`id`, `nama`])"><i class="fas fa-edit mr-1"></i>Edit</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/unit/' . $unit->id . '`, `unitTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                    
                        return $editButton . $deleteButton;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi'])
                    ->make(true);
            }

            return $this->successResponse($units, 'Data unit ditemukan.');
        }
    
        return view('admin.unit.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $unit = Unit::create([
            'nama' => $request->input('nama'),
        ]);

        return $this->successResponse($unit, 'Data unit ditambahkan.', 201);
    }

    public function show($id)
    {
        if($id == 'excel'){
            ob_end_clean();
            ob_start();
            return Excel::download(new UnitExport(), 'Unit.xlsx');    
        }

        if($id == 'pdf'){
            $units = Unit::all();
            $pdf = PDF::loadView('admin.unit.pdf', compact('units'));
    
            $options = [
                'margin_top' => 20,
                'margin_right' => 20,
                'margin_bottom' => 20,
                'margin_left' => 20,
            ];
    
            $pdf->setOptions($options);
            $pdf->setPaper('a4', 'landscape');
    
            $namaFile = 'Unit.pdf';

            ob_end_clean();
            ob_start();
            return $pdf->download($namaFile);
        }
        
        $unit = Unit::find($id);

        if(!$unit){
            return $this->errorResponse(null, 'Data unit tidak ditemukan.', 404);    
        }
        
        return $this->successResponse($unit, 'Data unit ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $unit = Unit::find($id);
        
        if(!$unit){
            return $this->errorResponse(null, 'Data unit tidak ditemukan.', 404);    
        }

        $unit->update([
            'nama' => $request->input('nama')
        ]);

        return $this->successResponse($unit, 'Data unit diupdate.');
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);

        if(!$unit){
            return $this->errorResponse(null, 'Data unit tidak ditemukan.', 404);    
        }

        $unit->delete();
        
        return $this->successResponse(null, 'Data unit dihapus.');
    }
}