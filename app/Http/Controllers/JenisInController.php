<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisIn;

class JenisInController extends Controller
{
    public function index()
    {
        $title = 'Jenis Cash In';
        $jenisIns = JenisIn::all();

        if (request()->wantsJson()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data berhasil diambil',
                    'data' => $jenisIns,
                    'metadata' => [
                        'total' => $jenisIns->count(),
                        'request_at' => now()->toDateTimeString()
                    ]
                ],
                200
            );
        }
        return view('user.cash_in.jenis_in.index', compact('title', 'jenisIns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'color' => 'required|string',
            'icon' => 'required|string',
        ]);

        try {
            $jenisIn = JenisIn::create([
                'user_id' => auth()->user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'color' => $request->color,
                'icon' => $request->icon,
            ]);

            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Data berhasil ditambahkan',
                        'data' => $jenisIn,
                        'metadata' => [
                            'request_at' => now()->toDateTimeString()
                        ]
                    ],
                    200
                );
            }

            return redirect()->back()->with('success', 'Jenis Cash In berhasil ditambahkan.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal menambahkan Jenis Cash In.',
                        'error' => $e->getMessage()
                    ],
                    500
                );
            }

            return redirect()->back()->with('error', 'Gagal menambahkan Jenis Cash In.');
        }
    }

    public function update(Request $request, JenisIn $jenisIn)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'color' => 'required|string',
            'icon' => 'required|string',
        ]);

        try {
            $jenisIn->update([
                'title' => $request->title,
                'description' => $request->description,
                'color' => $request->color,
                'icon' => $request->icon,
            ]);

            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Data berhasil diubah',
                        'data' => $jenisIn,
                        'metadata' => [
                            'request_at' => now()->toDateTimeString()
                        ]
                    ],
                    200
                );
            }
            return redirect()->back()->with('success', 'Jenis Cash In berhasil diubah.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal mengubah Jenis Cash In.',
                        'error' => $e->getMessage()
                    ],
                    500
                );
            }

            return redirect()->back()->with('error', 'Gagal mengubah Jenis Cash In.');
        }
    }

    public function destroy(JenisIn $jenisIn)
    {
        try {
            $jenisIn->delete();

            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Data berhasil dihapus',
                        'data' => $jenisIn,
                        'metadata' => [
                            'request_at' => now()->toDateTimeString()
                        ]
                    ],
                    200
                );
            }
            return redirect()->back()->with('success', 'Jenis Cash In berhasil dihapus.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal menghapus Jenis Cash In.',
                        'error' => $e->getMessage()
                    ],
                    500
                );
            }

            return redirect()->back()->with('error', 'Gagal menghapus Jenis Cash In.');
        }
    }
}
