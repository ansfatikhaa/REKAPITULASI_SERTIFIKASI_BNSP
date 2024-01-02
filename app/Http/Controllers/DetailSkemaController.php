<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rsm_trdetailskema;
use App\Models\rsm_msprodi;
use App\Models\rsm_msskema;

class DetailSkemaController extends Controller
{
    public function edit($dtl_id)
    {
        $detail = rsm_trdetailskema::findOrFail($dtl_id);
        $prodis = rsm_msprodi::all();
        $skemas = rsm_msskema::all();
        return view('detailskema.edit', compact('detail', 'prodis','skemas'));
    }

    public function update(Request $request, $dtl_id)
    {
        $request->validate([
            'skm_id' => 'required|integer',
            'pro_id' => 'required|integer',
            'dtl_tanggal_mulai' => 'required|date',
            'dtl_tanggal_berakhir' => 'required|date',
            'dtl_total_peserta' => 'required|integer',
            'dtl_kompeten' => 'required|integer',
            'dtl_belum_kompeten' => 'required|integer',
            'dtl_tidak_hadir' => 'required|integer',
        ]);

        $skema = rsm_trdetailskema::findOrFail($dtl_id);
        $skema->skm_id = $request->input('skm_id');
        $skema->pro_id = $request->input('pro_id');
        $skema->dtl_tanggal_mulai = $request->input('dtl_tanggal_mulai');
        $skema->dtl_tanggal_berakhir = $request->input('dtl_tanggal_berakhir');
        $skema->dtl_total_peserta = $request->input('dtl_total_peserta');
        $skema->dtl_kompeten = $request->input('dtl_kompeten');
        $skema->dtl_belum_kompeten = $request->input('dtl_belum_kompeten');
        $skema->dtl_tidak_hadir = $request->input('dtl_tidak_hadir');

        $skema->save();
        $skm_id = session('skm_id');

        return redirect()->route('skema.detail', ['skm_id' => $skm_id])->with('success', 'Detail skema berhasil disimpan');
    }
}