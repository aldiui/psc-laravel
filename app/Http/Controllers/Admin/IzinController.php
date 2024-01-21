<?php

namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\Izin;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IzinController extends Controller
{
    use ApiResponder;
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bulan = explode('-',$request->input("bulan"));
            
            $izins = Izin::with('user')->whereMonth('tanggal_mulai', $bulan[1])->whereYear('tanggal_mulai', $bulan[0])->latest()->get();
            if($request->input("mode") == "datatable"){
                return DataTables::of($izins)
                    ->addColumn('aksi', function ($izin) {
                        $confirmButton = '<button class="btn btn-sm btn-primary mr-1" onclick="getModal(`confirmModal`, `/admin/izin/' . $izin->id . '`, [`id`, `tanggal_mulai`, `tanggal_selesai`, `alasan`, `file`, `tipe`])"><i class="fas fa-question-circle mr-1"></i>Konfirmasi</button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`/admin/izin/' . $izin->id . '`, `izinTable`)"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                    
                        return ($izin->status == '0' || $izin->status == '2') ? $confirmButton . $deleteButton : "<span class='badge badge-success px-2 py-1'><i class='far fa-check-circle mr-1'></i> Disetujui</span>" ;
                    })
                    ->addColumn('tanggal', function ($izin) {
                        return ($izin->tanggal_selesai == null ) ? $izin->tanggal_mulai : $izin->tanggal_mulai . ' - ' . $izin->tanggal_selesai;
                    })
                    ->addColumn('status_badge', function ($izin) {
                        $statusIcon = ($izin->status == '0') ? '<i class="far fa-clock mr-1"></i>' : (($izin->status == '1') ? '<i class="far fa-check-circle mr-1"></i>' : '<i class="far fa-times-circle mr-1"></i>');
                        $statusClass = ($izin->status == '0') ? 'badge-warning' : (($izin->status == '1') ? 'badge-success' : 'badge-danger');
                        $statusText = ($izin->status == '0') ? 'Menunggu' : (($izin->status == '1') ? 'Disetujui' : 'Ditolak');
                        return "<span class='badge $statusClass px-2 py-1'>$statusIcon $statusText</span>";
                    })
                    ->addColumn('nama', function ($izin) {
                        return $izin->user->nama;
                    })
                    ->addColumn('img', function ($izin) {
                        return '<img src="/storage/img/karyawan/' . $izin->user->image . '" width="150px" alt="">';
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi','status_badge', 'tanggal','nama','img'])
                    ->make(true);
            }

            return $this->successResponse($izins, 'Data izin ditemukan.'); 
        }
    
        return view('admin.izin.index');
    }

    public function show($id)
    {
        
        $izin = Izin::find($id);

        if(!$izin){
            return $this->errorResponse(null, 'Data Izin tidak ditemukan.', 404);    
        }
        
        return $this->successResponse($izin, 'Data Izin ditemukan.');
    }

    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), ['status' => 'required|in:1,2']);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $izin = Izin::find($id);
        
        if(!$izin){
            return $this->errorResponse(null, 'Data izin tidak ditemukan.', 404);    
        }
        
        $izin->update(['status' => $request->status]);

        return $this->successResponse($izin, 'Data izin diupdate.');
    }

    public function destroy($id)
    {
        $izin = Izin::find($id);

        if(!$izin){
            return $this->errorResponse(null, 'Data izin tidak ditemukan.', 404);    
        }

        if (Storage::exists('public/img/izin/' . $izin->file)) {
            Storage::delete('public/img/izin/' . $izin->file);
        }

        $izin->delete();
        
        return $this->successResponse(null, 'Data izin dihapus.');
    }
    
}
