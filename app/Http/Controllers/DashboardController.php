<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Target;
use App\Models\CashIn;
use App\Models\CashOut;
use App\Models\HistoryTarget;
use App\Models\JenisIn;
use App\Models\JenisOut;

class DashboardController extends Controller
{
    public function landing()
    {
        $title = 'Beranda';
        return view('welcome', compact('title'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Dashboard';
        $targets = Target::where('user_id', auth()->user()->id)->get();
        $historyTargets = HistoryTarget::all();
        $cashIns = CashIn::where('user_id', auth()->user()->id)->with('jenisIn')->get();
        $cashOuts = CashOut::where('user_id', auth()->user()->id)->with('jenisOut')->get();
        $jenisOuts = JenisOut::all();
        $jenisIns = JenisIn::all();
        $totalIncome = $cashIns->sum('jumlah');
        $totalExpense = $cashOuts->sum('jumlah');
        $expenseOfDay = $cashOuts->where('tanggal', now()->format('Y-m-d'));
        // $json = json_encode($expenseOfDay->values());
        $expenseOfDay = $expenseOfDay->values();
        // dd($expenseOfDay);
        // $expenseOfDay = json_decode($expenseOfDay, true);
        $totalTarget = $targets->sum('jumlah_target');
        $totalTercapai = $targets->sum('jumlah_tercapai');
        $sisaTarget = $totalTarget - $totalTercapai;
        $totalIncomeOfWeek = $cashIns->where(
            'tanggal',
            '>=',
            now()->subWeek()
        )->sum('jumlah');
        $totalExpenseOfWeek = $cashOuts->where(
            'tanggal',
            '>=',
            now()->subWeek()
        )->sum('jumlah');

        // Ambil data pemasukan harian
        $dailyIncome = $cashIns->groupBy(function ($date) {
            return \Carbon\Carbon::parse($date->tanggal)->format('D'); // Mengelompokkan berdasarkan hari
        })->map(function ($row) {
            return $row->groupBy('jenis_in_id')->map(function ($group) {
                return $group->sum('jumlah'); // Menghitung total per jenis
            });
        })->toArray();

        // Inisialisasi array untuk setiap hari dalam seminggu
        $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $dailyIncomeInitialized = array_fill_keys($daysOfWeek, []); // Mengisi dengan array kosong

        // Mengisi data pemasukan harian
        foreach ($dailyIncome as $day => $amounts) {
            $dailyIncomeInitialized[$day] = $amounts;
        }

        // Ambil data pengeluaran harian
        $dailyExpense = $cashOuts->groupBy(function ($date) {
            return \Carbon\Carbon::parse($date->tanggal)->format('D'); // Mengelompokkan berdasarkan hari
        })->map(function ($row) {
            return $row->groupBy('jenis_out_id')->map(function ($group) {
                return $group->sum('jumlah'); // Menghitung total per jenis
            });
        })->toArray();

        // Inisialisasi array untuk setiap hari dalam seminggu
        $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $dailyExpenseInitialized = array_fill_keys($daysOfWeek, []); // Mengisi dengan array kosong

        // Mengisi data pengeluaran harian
        foreach ($dailyExpense as $day => $amounts) {
            $dailyExpenseInitialized[$day] = $amounts;
        }

        // dd($dailyExpense);
        // dd($dailyIncome);

        return view('user.index', compact(
            'title',
            'targets',
            'historyTargets',
            'cashIns',
            'cashOuts',
            'jenisOuts',
            'jenisIns',
            'totalIncome',
            'totalExpense',
            'expenseOfDay',
            'totalIncomeOfWeek',
            'totalExpenseOfWeek',
            'dailyIncomeInitialized',
            'dailyExpenseInitialized',
            'historyTargets'
        ));
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
        //
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
