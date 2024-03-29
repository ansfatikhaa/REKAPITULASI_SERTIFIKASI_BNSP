<?php

namespace App\Http\Controllers;

use App\Exports\ExportData;
use App\Exports\ExportDataProdi;
use Illuminate\Http\Request;
use App\Models\rsm_trdetailskema;
use App\Models\rsm_msprodi;
use App\Models\rsm_msskema;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Controller
{
    public function index()
    {
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

    public function getDataTotalForYear($year)
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

    public function showProdiPage($prodiId)
    {
        // Fetch the program name based on the pro_id
        $program = rsm_msprodi::findOrFail($prodiId);
        $selectedProgramName = $program->pro_nama;

        // Fetch data peserta berdasarkan prodiId dan tahun terkini
        $currentYear = date('Y');
        $pesertaData = rsm_trdetailskema::select(
            DB::raw('SUM(dtl_total_peserta) as total_peserta'),
            DB::raw('SUM(dtl_kompeten) as kompeten'),
            DB::raw('SUM(dtl_belum_kompeten) as belum_kompeten'),
            DB::raw('SUM(dtl_tidak_hadir) as tidak_hadir')
        )
            ->where('pro_id', $prodiId)
            ->whereYear('dtl_tanggal_mulai', $currentYear)
            ->first();

        // Pass $selectedProgramName and $prodiId as separate variables to the view
        return view("dashboard.prodi", [
            'selectedProgramName' => $selectedProgramName,
            'selectedProgramId' => $prodiId, 
            'pesertaData' => $pesertaData,
        ]);
    }



    public function getDataProdiForYear($prodiId, $year)
    {
        $pesertaData = rsm_trdetailskema::select(
            DB::raw('SUM(dtl_total_peserta) as total_peserta'),
            DB::raw('SUM(dtl_kompeten) as kompeten'),
            DB::raw('SUM(dtl_belum_kompeten) as belum_kompeten'),
            DB::raw('SUM(dtl_tidak_hadir) as tidak_hadir')
        )
            ->where('pro_id', $prodiId)
            ->whereYear('dtl_tanggal_mulai', $year)
            ->first();

        return response()->json($pesertaData);
    }

    public function showSkemaPage($skemaId)
    {
        // Fetch the skema name based on the skm_id
        $skema = rsm_msskema::findOrFail($skemaId);
        $selectedSkemaName = $skema->skm_nama;

        $currentYear = date('Y');
        $pesertaData = rsm_trdetailskema::select(
            DB::raw('SUM(dtl_total_peserta) as total_peserta'),
            DB::raw('SUM(dtl_kompeten) as kompeten'),
            DB::raw('SUM(dtl_belum_kompeten) as belum_kompeten'),
            DB::raw('SUM(dtl_tidak_hadir) as tidak_hadir')
        )
            ->where('skm_id', $skemaId)
            ->whereYear('dtl_tanggal_mulai', $currentYear)
            ->first();

        // Pass $selectedProgramName and $skemaId as separate variables to the view
        return view("dashboard.skema", [
            'selectedSkemaName' => $selectedSkemaName,
            'selectedSkemaId' => $skemaId, // Assign $skemaId directly to selectedSkemaId
            'pesertaData' => $pesertaData,
        ]);
    }

    public function getDataSkemaForProdi($skemaId, $date)
    {
        $pesertaData = rsm_trdetailskema::select(
            DB::raw('SUM(dtl_total_peserta) as total_peserta'),
            DB::raw('SUM(dtl_kompeten) as kompeten'),
            DB::raw('SUM(dtl_belum_kompeten) as belum_kompeten'),
            DB::raw('SUM(dtl_tidak_hadir) as tidak_hadir')
        )
            ->where('skm_id', $skemaId)
            ->where('dtl_tanggal_mulai', $date)
            ->first();

        return response()->json($pesertaData);
    }
   



    public function export_excel(Request $request)
    {
        $selectedYear = $request->input('year'); // Mendapatkan tahun yang dipilih dari dropdown
        return Excel::download(new ExportData($selectedYear), "Data_Sertifikasi_$selectedYear.xlsx");
    }

    public function export_excel_prodi($prodiId, Request $request)
    {
        $selectedYear = $request->input('year'); // Mendapatkan tahun yang dipilih dari dropdown

        $filename = "Data_Program_Studi_{$selectedYear}_Prodi_{$prodiId}.xlsx";

        return Excel::download(new ExportDataProdi($prodiId, $selectedYear), $filename);
    }
}
