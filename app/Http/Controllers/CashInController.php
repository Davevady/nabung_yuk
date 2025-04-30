<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashIn;
use App\Models\JenisIn;
use Illuminate\Support\Facades\Log;

class CashInController extends Controller
{
    public function index()
    {
        $title = 'Cash In';
        $cashIns = CashIn::with('jenisIn')->get();
        $jenisIns = JenisIn::all();
        return view('user.cash_in.index', compact('title', 'cashIns', 'jenisIns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'media' => 'nullable|array',
            'media.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        // Menghapus format rupiah jika ada
        $jumlah = preg_replace('/[^0-9]/', '', $request->jumlah);

        try {
            // Menyimpan media
            $mediaPaths = [];
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    try {
                        $path = $file->move(public_path('cash-in'), $file->getClientOriginalName()); // Simpan di folder 'public/cash-in'
                        $mediaPaths[] = 'cash-in/' . $file->getClientOriginalName(); // Simpan path ke array
                    } catch (\Exception $fileException) {
                        Log::error('Gagal menyimpan file media: ' . $fileException->getMessage());
                        return redirect()->back()->with('error', 'Gagal menyimpan file media: ' . $fileException->getMessage());
                    }
                }
            }

            CashIn::create([
                'user_id' => auth()->user()->id,
                'jenis_in_id' => $request->jenis_in_id,
                'title' => $request->title,
                'jumlah' => $jumlah, // Gunakan jumlah yang sudah dibersihkan
                'media' => json_encode($mediaPaths), // Simpan path media dalam format JSON
                'description' => $request->description,
            ]);

            return redirect()->back()->with('success', 'Cash In berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan Cash In: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan Cash In: ' . $e->getMessage());
        }
    }

    public function update(Request $request, CashIn $cashIn)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'media' => 'nullable|array',
            'media.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        // Menghapus format rupiah jika ada
        $jumlah = preg_replace('/[^0-9]/', '', $request->jumlah);

        try {
            // Ambil media yang sudah ada
            $mediaPaths = json_decode($cashIn->media, true) ?? []; // Inisialisasi dengan media yang sudah ada

            // Hapus media sebelumnya jika ada media baru
            if ($request->hasFile('media')) {
                foreach ($mediaPaths as $existingPath) {
                    if (file_exists(public_path($existingPath))) {
                        unlink(public_path($existingPath));
                    }
                }
                // Reset mediaPaths jika ada media baru
                $mediaPaths = [];
            }

            // Simpan media baru jika ada
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    try {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $path = $file->move(public_path('cash-in'), $filename); // Simpan di folder 'public/cash-in'
                        $mediaPaths[] = 'cash-in/' . $filename; // Simpan path ke array
                    } catch (\Exception $fileException) {
                        return redirect()->back()->with('error', 'Gagal menyimpan file media: ' . $fileException->getMessage());
                    }
                }
            }

            $cashIn->update([
                'title' => $request->title,
                'jumlah' => $jumlah, // Gunakan jumlah yang sudah dibersihkan
                'media' => json_encode($mediaPaths), // Simpan path media dalam format JSON
                'description' => $request->description,
            ]);

            return redirect()->back()->with('success', 'Cash In berhasil diubah.');
        } catch (\Exception $e) {
            Log::error('Gagal mengubah Cash In: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengubah Cash In: ' . $e->getMessage());
        }
    }

    public function updateMedia(Request $request, CashIn $cashIn)
    {
        $request->validate([
            'media' => 'nullable|array',
            'media.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $mediaPaths = json_decode($cashIn->media, true) ?? []; // Ambil media yang sudah ada

            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    try {
                        $path = $file->move(public_path('cash-in'), $file->getClientOriginalName()); // Simpan di folder 'public/cash-in'
                        $mediaPaths[] = 'cash-in/' . $file->getClientOriginalName(); // Tambahkan path baru ke array
                    } catch (\Exception $fileException) {
                        Log::error('Gagal menyimpan file media: ' . $fileException->getMessage());
                        return redirect()->back()->with('error', 'Gagal menyimpan file media: ' . $fileException->getMessage());
                    }
                }
            }

            $cashIn->update([
                'media' => json_encode($mediaPaths), // Simpan path media baru dalam format JSON
            ]);

            return redirect()->back()->with('success', 'Media berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan media: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan media: ' . $e->getMessage());
        }
    }

    public function destroy(CashIn $cashIn)
    {
        try {
            $cashIn->delete();
            return redirect()->back()->with('success', 'Cash In berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus Cash In: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus Cash In: ' . $e->getMessage());
        }
    }

    public function destroyMedia(Request $request, CashIn $cashIn)
    {
        $request->validate([
            'media' => 'required|string',
        ]);

        try {
            $mediaPaths = json_decode($cashIn->media, true) ?? []; // Ambil media yang sudah ada
            $mediaToDelete = $request->input('media'); // Media yang akan dihapus

            // Cek apakah media yang akan dihapus ada dalam array
            if (($key = array_search($mediaToDelete, $mediaPaths)) !== false) {
                // Hapus file dari server
                if (file_exists(public_path($mediaToDelete))) {
                    unlink(public_path($mediaToDelete)); // Hapus file dari server
                }
                unset($mediaPaths[$key]); // Hapus dari array
            }

            $cashIn->update([
                'media' => json_encode(array_values($mediaPaths)), // Simpan kembali media yang tersisa
            ]);

            return response()->json([
                'success' => 'Media berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal menghapus media: ' . $e->getMessage());
            return response()->json([
                'error' => 'Gagal menghapus media: ' . $e->getMessage()
            ], 500);
        }
    }
}