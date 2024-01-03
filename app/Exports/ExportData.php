<?php

namespace App\Exports;

use App\Models\rsm_trdetailskema;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
class ExportData implements FromView
{
    /**
    * @return \Illuminate\Contracts\View\View
    */
    private $selectedYear;

    public function __construct($selectedYear)
    {
        $this->selectedYear = $selectedYear;
    }

    public function view(): View
    {
        $data = rsm_trdetailskema::whereYear('dtl_tanggal_mulai', $this->selectedYear)
            ->orderBy('dtl_tanggal_mulai', 'asc')
            ->get();

        return view('dashboard.table', ['data' => $data]);
    }
}
