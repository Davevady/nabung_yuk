<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoryTarget;

class HistoryTargetController extends Controller
{
    public function index()
    {
        $title = 'Daftar History Target';
        $historyTargets = HistoryTarget::all();

        if (request()->wantsJson()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data berhasil diambil',
                    'data' => $historyTargets,
                    'metadata' => [
                        'total' => $historyTargets->count(),
                        'request_at' => now()->toDateTimeString()
                    ]
                ],
                200
            );
        }
        return view('user.history_target.index', compact('title', 'historyTargets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'jumlah_target' => 'required|numeric',
            'tanggal_target' => 'required|date',
            'description' => 'nullable|string',
        ]);

        try {
            $historyTarget = HistoryTarget::create([
                'user_id' => auth()->user()->id,
                'title' => $request->title,
                'jumlah_target' => $request->jumlah_target,
                'tanggal_target' => $request->tanggal_target,
                'description' => $request->description,
            ]);

            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Data berhasil ditambahkan',
                        'data' => $historyTarget,
                        'metadata' => [
                            'request_at' => now()->toDateTimeString()
                        ]
                    ],
                    200
                );
            }

            return redirect()->back()->with('success', 'History Target berhasil ditambahkan.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal menambahkan History Target.',
                        'error' => $e->getMessage()
                    ],
                    500
                );
            }

            return redirect()->back()->with('error', 'Gagal menambahkan History Target.');
        }
    }

    public function update(Request $request, HistoryTarget $historyTarget)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'jumlah_target' => 'required|numeric',
            'tanggal_target' => 'required|date',
            'description' => 'nullable|string',
        ]);

        try {
            $historyTarget->update([
                'title' => $request->title,
                'jumlah_target' => $request->jumlah_target,
                'tanggal_target' => $request->tanggal_target,
                'description' => $request->description,
            ]);

            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Data berhasil diubah',
                        'data' => $historyTarget,
                        'metadata' => [
                            'request_at' => now()->toDateTimeString()
                        ]
                    ],
                    200
                );
            }
            return redirect()->back()->with('success', 'History Target berhasil diubah.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal mengubah History Target.',
                        'error' => $e->getMessage()
                    ],
                    500
                );
            }

            return redirect()->back()->with('error', 'Gagal mengubah History Target.');
        }
    }

    public function destroy(HistoryTarget $historyTarget)
    {
        try {
            $historyTarget->delete();

            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Data berhasil dihapus',
                        'data' => $historyTarget,
                        'metadata' => [
                            'request_at' => now()->toDateTimeString()
                        ]
                    ],
                    200
                );
            }
            return redirect()->back()->with('success', 'History Target berhasil dihapus.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal menghapus History Target.',
                        'error' => $e->getMessage()
                    ],
                    500
                );
            }

            return redirect()->back()->with('error', 'Gagal menghapus History Target.');
        }
    }
}
