<?php

namespace App\Http\Controllers;

use App\Exports\ExportData;
use Illuminate\Http\Request;
use App\Models\rsm_trdetailskema;
use App\Models\rsm_msprodi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Controller
{
    public function index()
    {
        // Xvv
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

        return response()->json($pesertaData);
    }


    public function showProdiChart($prodiId)
    {
        // Fetch the program name based on the pro_id
        $program = rsm_msprodi::findOrFail($prodiId);
        $selectedProgramName = $program->pro_nama;
    
        // Fetch data and calculate totals for the chart
        $prodiData = rsm_trdetailskema::select(
            DB::raw('SUM(dtl_total_peserta) as total_peserta'),
            DB::raw('SUM(dtl_kompeten) as total_kompeten'),
            DB::raw('SUM(dtl_belum_kompeten) as total_belum_kompeten'),
            DB::raw('SUM(dtl_tidak_hadir) as total_tidak_hadir')
        )
            ->where('pro_id', $prodiId)
            ->get();
    
        // Pass $selectedProgramName and $prodiData to the view
        return view("dashboard.prodi", compact('prodiData', 'selectedProgramName'));
    }
    



    public function export_excel(Request $request)
    {
        $selectedYear = $request->input('year'); // Mendapatkan tahun yang dipilih dari dropdown
        return Excel::download(new ExportData($selectedYear), "Data_Sertifikasi_$selectedYear.xlsx");
    }
}
