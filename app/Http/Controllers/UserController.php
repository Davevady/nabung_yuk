<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        $title = 'Masuk';
        return view('auth.login', compact('title'));
    }

    public function authLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    public function register()
    {
        $title = 'Daftar';
        return view('auth.register', compact('title'));
    }

    public function authRegister(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Cek email yang sudah terdaftar
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return redirect()->back()->withErrors(['email' => 'Email sudah terdaftar'])->withInput();
            }

            // Buat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 1
            ]);

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');

        } catch (\Exception $e) {
            Log::error('Error saat registrasi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing')->with('success', 'Berhasil logout!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role_id' => 'required|exists:roles,id',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
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

            // Cek email yang sudah terdaftar
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Email sudah terdaftar',
                        'errors' => ['email' => ['Email ini sudah digunakan']]
                    ], 422);
                }
                return redirect()->back()->with('failed', 'Email sudah terdaftar')->withInput();
            }

            DB::beginTransaction();
            try {
                // Buat user baru
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->role_id = $request->role_id;

                // Upload Photo
                if ($request->hasFile('photo')) {
                    $photoFile = $request->file('photo');
                    $photoFileName = time() . '_' . $photoFile->getClientOriginalName();
                    $photoPath = $photoFile->storeAs('public/userPhotos', $photoFileName);
                    $user->photo = str_replace('public/', '', $photoPath);
                }

                $user->save();

                DB::commit();

                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Data berhasil disimpan',
                        'data' => $user,
                        'metadata' => [
                            'status_code' => 201,
                            'created_at' => now()->toDateTimeString(),
                        ]
                    ], 201);
                }
                return redirect()->back()->with('success', 'Data berhasil disimpan');

            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Error saving user:', [
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
            Log::error('User store error:', [
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
