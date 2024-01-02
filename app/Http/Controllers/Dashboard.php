<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rsm_trdetailskema;
use App\Models\rsm_msprodi;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function index()
    {
        // X
        // Mengambil daftar program studi untuk dropdown
        $prodiList = rsm_msprodi::pluck('pro_nama', 'pro_id');

        // Mendapatkan tahun saat ini
        $currentYear = date('Y');

        // Mengambil data peserta untuk tahun saat ini
        $pesertaData = rsm_trdetailskema::select(
            'pro_id',
            DB::raw('SUM(dtl_total_peserta) as total_peserta')
        )
            ->whereYear('dtl_tanggal_mulai', $currentYear)
            ->groupBy('pro_id')
            ->get();

        // Membuat array data untuk grafik
        $chartData = [];
        foreach ($pesertaData as $item) {
            $chartData[] = [
                'name' => $item->pro_id,
                'y' => $item->total_peserta
            ];
        }

        return view("dashboard.home", compact('prodiList', 'chartData', 'currentYear'));
    }


    public function getDataForYear($year)
    {
        $pesertaData = rsm_trdetailskema::select(
            'pro_id',
            DB::raw('SUM(dtl_total_peserta) as total_peserta')
        )
            ->whereYear('dtl_tanggal_mulai', $year)
            ->groupBy('pro_id')
            ->get();

        $totalPeserta = rsm_trdetailskema::select(DB::raw('SUM(dtl_total_peserta) as total_peserta'))
            ->whereYear('dtl_tanggal_mulai', $year)
            ->first();
        return response()->json($pesertaData);
    }
}
