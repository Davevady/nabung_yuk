<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $title = 'Role';
        return view('role.index', compact('title'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:roles'
            ]);

            if ($validator->fails()) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Validasi gagal',
                        'errors' => $validator->errors()
                    ], 422);
                }
                return redirect()->back()->with('failed', $validator->errors())->withInput();
            }

            DB::beginTransaction();
            try {
                // Buat role baru
                $role = Role::create([
                    'name' => $request->name
                ]);

                DB::commit();

                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Data berhasil disimpan',
                        'data' => $role,
                        'metadata' => [
                            'status_code' => 201,
                            'created_at' => now()->toDateTimeString(),
                        ]
                    ], 201);
                }
                return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan');

            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Error saving role:', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Gagal menyimpan data',
                        'error' => $e->getMessage()
                    ], 500);
                }
                return redirect()->back()->with('failed', 'Gagal menyimpan data' . $e->getMessage());
            }

        } catch (\Exception $e) {
            Log::error('Role store error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat menyimpan data',
                    'error' => $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('failed', 'Terjadi kesalahan saat menyimpan data' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
