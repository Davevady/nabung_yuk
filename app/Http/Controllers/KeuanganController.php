<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashIn;
use App\Models\CashOut;
use App\Models\HistoryTarget;
use App\Models\Target;
use App\Models\JenisIn;
use App\Models\JenisOut;

class KeuanganController extends Controller
{
    public function index()
    {
        try {
            $title = 'Keuangan';
            $cashIns = CashIn::with('user', 'jenisIn')->get();
            $cashOuts = CashOut::with('user', 'jenisOut')->get();
            $jenisIns = JenisIn::with('user')->get();
            $jenisOuts = JenisOut::with('user')->get();
            // $targets = Target::where('tanggal_target', '>=', now())->get();
            $targets = Target::with('user')->get();

            return view('user.keuangan.index', compact('title', 'cashIns', 'cashOuts', 'targets'));
        } catch (\Exception $e) {
            // Anda dapat menambahkan logika penanganan kesalahan di sini, seperti mencatat kesalahan
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data. Silakan coba lagi.');
        }
    }

    public function verifikasiTarget(Request $request, $id)
    {
        try {
            $target = Target::findOrFail($id);
            $request->validate([
                'inputAngka' => 'required|numeric',
            ]);

            $target->jumlah_tercapai += $request->inputAngka;
            $target->sisa_target = $target->jumlah_target - $target->jumlah_tercapai;
            $target->save();

            // Menyimpan data ke HistoryTarget
            HistoryTarget::create([
                'target_id' => $target->id,
                'jumlah_tercapai' => $request->inputAngka,
                'tanggal_tercapai' => now(),
                'description' => 'Update jumlah tercapai',
            ]);

            return redirect()->back()->with('success', 'Angka berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan angka. Silakan coba lagi.');
        }
    }
}
