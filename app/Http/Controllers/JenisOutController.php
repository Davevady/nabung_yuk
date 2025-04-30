<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisOut;

class JenisOutController extends Controller
{
    public function index()
    {
        $title = 'Jenis Cash Out';
        $jenisOuts = JenisOut::all();

        if (request()->wantsJson()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data berhasil diambil',
                    'data' => $jenisOuts,
                    'metadata' => [
                        'total' => $jenisOuts->count(),
                        'request_at' => now()->toDateTimeString()
                    ]
                ],
                200
            );
        }

        return view('user.cash_out.jenis_out.index', compact('title', 'jenisOuts'));
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
            $jenisOut = JenisOut::create([
                'user_id' => auth()->user()->id,
                'icon' => $request->icon,
                'color' => $request->color,
                'title' => $request->title,
                'description' => $request->description,
            ]);

            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Data berhasil ditambahkan',
                        'data' => $jenisOut,
                        'metadata' => [
                            'request_at' => now()->toDateTimeString()
                        ]
                    ],
                    200
                );
            }

            return redirect()->back()->with('success', 'Jenis Cash Out berhasil ditambahkan.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal menambahkan Jenis Cash Out.',
                        'error' => $e->getMessage()
                    ],
                    500
                );
            }
            return redirect()->back()->with('error', 'Gagal menambahkan Jenis Cash Out.');
        }
    }

    public function update(Request $request, JenisOut $jenisOut)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string',
            'color' => 'required|string',
        ]);

        try {
            $jenisOut->update([
                'title' => $request->title,
                'description' => $request->description,
                'icon' => $request->icon,
                'color' => $request->color,
            ]);

            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Data berhasil diubah',
                        'data' => $jenisOut,
                        'metadata' => [
                            'request_at' => now()->toDateTimeString()
                        ]
                    ],
                    200
                );
            }

            return redirect()->back()->with('success', 'Jenis Cash Out berhasil diubah.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal mengubah Jenis Cash Out.',
                        'error' => $e->getMessage()
                    ],
                    500
                );
            }

            return redirect()->back()->with('error', 'Gagal mengubah Jenis Cash Out.');
        }
    }

    public function destroy(JenisOut $jenisOut)
    {
        try {
            $jenisOut->delete();

            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Data berhasil dihapus',
                        'data' => $jenisOut,
                        'metadata' => [
                            'request_at' => now()->toDateTimeString()
                        ]
                    ],
                    200
                );
            }

            return redirect()->back()->with('success', 'Jenis Cash Out berhasil dihapus.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal menghapus Jenis Cash Out.',
                        'error' => $e->getMessage()
                    ],
                    500
                );
            }

            return redirect()->back()->with('error', 'Gagal menghapus Jenis Cash Out.');
        }
    }
}
