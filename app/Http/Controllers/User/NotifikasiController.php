<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    use ApiResponder;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $notifikasis = Notifikasi::whereMonth('created_at', date('m'))->whereTargetId(Auth::user()->id)->latest()->get();
            return view('user.notifikasi.index', compact('notifikasis'));
        }
    }

    public function update(Request $request, $id)
    {
        $notifikasi = Notifikasi::find($id);

        if (!$notifikasi) {
            return $this->errorResponse(null, 'Data Notifikasi tidak ditemukan.', 404);
        }

        $notifikasi->update(['status' => '1']);
        return $this->successResponse(null, 'Notifikasi diterima.');
    }
}
