<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Target;

class TargetController extends Controller
{
    public function index()
    {
        $title = 'Daftar Target';
        $targets = Target::all();

        if (request()->wantsJson()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data berhasil diambil',
                    'data' => $targets,
                    'metadata' => [
                        'total' => $targets->count(),
                        'request_at' => now()->toDateTimeString()
                    ]
                ],
                200
            );
        }
        return view('user.target.index', compact('title', 'targets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'jumlah_target' => 'required|numeric',
            'media' => 'nullable|array',
            'media.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal_target' => 'required|date',
            'description' => 'nullable|string',
        ]);

        try {
            $mediaPaths = [];
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    try {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $path = $file->move(public_path('target'), $filename); // Simpan media pada folder target
                        $mediaPaths[] = 'target/' . $filename; // Update path media
                    } catch (\Exception $fileException) {
                        return redirect()->back()->with('error', 'Gagal menyimpan file media: ' . $fileException->getMessage());
                    }
                }
            }

            $target = Target::create([
                'user_id' => auth()->user()->id,
                'title' => $request->title,
                'jumlah_target' => $request->jumlah_target,
                'jumlah_tercapai' => 0,
                'sisa_target' => $request->jumlah_target,
                'media' => json_encode($mediaPaths),
                'tanggal_target' => $request->tanggal_target,
                'description' => $request->description,
            ]);

            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Data berhasil ditambahkan',
                        'data' => $target,
                        'metadata' => [
                            'request_at' => now()->toDateTimeString()
                        ]
                    ],
                    200
                );
            }

            return redirect()->back()->with('success', 'Target berhasil ditambahkan.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal menambahkan Target.',
                        'error' => $e->getMessage()
                    ],
                    500
                );
            }

            return redirect()->back()->with('error', 'Gagal menambahkan Target.');
        }
    }

    public function update(Request $request, Target $target)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'jumlah_target' => 'required|numeric',
            'media' => 'nullable|array',
            'media.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal_target' => 'required|date',
            'description' => 'required|string',
        ]);

        try {
            // Ambil media yang sudah ada
            $mediaPaths = json_decode($target->media, true) ?? [];

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
                        $path = $file->move(public_path('target'), $filename); // Simpan media pada folder target
                        $mediaPaths[] = 'target/' . $filename; // Update path media
                    } catch (\Exception $fileException) {
                        return redirect()->back()->with('error', 'Gagal menyimpan file media: ' . $fileException->getMessage());
                    }
                }
            }

            // Hitung sisa target
            $sisa_target = $request->jumlah_target - $target->jumlah_tercapai;

            $target->update([
                'title' => $request->title,
                'jumlah_target' => $request->jumlah_target,
                'sisa_target' => $sisa_target, // Update sisa_target
                'tanggal_target' => $request->tanggal_target,
                'description' => $request->description,
                'media' => json_encode($mediaPaths),
            ]);

            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Data berhasil diubah',
                        'data' => $target,
                        'metadata' => [
                            'request_at' => now()->toDateTimeString()
                        ]
                    ],
                    200
                );
            }
            return redirect()->back()->with('success', 'Target berhasil diubah.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal mengubah Target.',
                        'error' => $e->getMessage()
                    ],
                    500
                );
            }

            return redirect()->back()->with('error', 'Gagal mengubah Target.');
        }
    }

    public function updateMedia(Request $request, Target $target)
    {
        try {
            $mediaPaths = json_decode($target->media, true) ?? [];
            $newMediaPaths = [];

            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->move(public_path('target'), $filename); // Simpan media pada folder target
                    $newMediaPaths[] = 'target/' . $filename; // Update path media
                }
            }

            // Gabungkan media baru dengan media yang sudah ada
            $mediaPaths = array_merge($mediaPaths, $newMediaPaths);

            $target->update([
                'media' => json_encode($mediaPaths),
            ]);

            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Media berhasil diperbarui',
                        'data' => $target,
                        'metadata' => [
                            'request_at' => now()->toDateTimeString()
                        ]
                    ],
                    200
                );
            }
            return redirect()->back()->with('success', 'Media berhasil diperbarui.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal memperbarui media.',
                        'error' => $e->getMessage()
                    ],
                    500
                );
            }

            return redirect()->back()->with('error', 'Gagal memperbarui media.');
        }
    }

    public function destroy(Target $target)
    {
        try {
            $mediaPaths = json_decode($target->media, true) ?? [];
            foreach ($mediaPaths as $existingPath) {
                if (file_exists(public_path($existingPath))) {
                    unlink(public_path($existingPath));
                }
            }

            $target->delete();

            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Data berhasil dihapus',
                        'data' => $target,
                        'metadata' => [
                            'request_at' => now()->toDateTimeString()
                        ]
                    ],
                    200
                );
            }
            return redirect()->back()->with('success', 'Target berhasil dihapus.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal menghapus Target.',
                        'error' => $e->getMessage()
                    ],
                    500
                );
            }

            return redirect()->back()->with('error', 'Gagal menghapus Target.');
        }
    }
}
