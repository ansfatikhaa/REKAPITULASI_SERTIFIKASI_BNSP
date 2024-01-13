<?php

namespace App\Exports;

use App\Models\rsm_trdetailskema;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportDataProdi implements FromView
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    private $prodiId;
    private $selectedYear;

    public function __construct($prodiId, $selectedYear)
    {
        $this->prodiId = $prodiId;
        $this->selectedYear = $selectedYear;
    }

    public function view(): View
    {
        $data = rsm_trdetailskema::whereYear('dtl_tanggal_mulai', $this->selectedYear)
            ->where('pro_id', $this->prodiId)
            ->get();

        return view('dashboard.table', ['data' => $data]);
    }
}
