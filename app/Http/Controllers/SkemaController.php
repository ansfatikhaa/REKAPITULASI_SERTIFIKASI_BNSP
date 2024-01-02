<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SkemaStoreRequest;

use App\Models\rsm_msskema;
use App\Models\rsm_msprodi;
use App\Models\rsm_trdetailskema;

class SkemaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $data = rsm_msskema::where('skm_nama', 'like', '%' . $search . '%')->paginate(10);
        } else {
            $data = rsm_msskema::paginate(10);
        }

        return view('skema.index', compact('data'));
    }


    public function edit($skm_id)
    {
        $skema = rsm_msskema::findOrFail($skm_id);
        return view('skema.edit', compact('skema'));
    }

    public function update(Request $request, $skm_id)
    {
        $request->validate([
            'skm_nama' => 'required',
        ]);

        $skema = rsm_msskema::findOrFail($skm_id);
        $skema->skm_nama = $request->input('skm_nama');
        $skema->save();

        return redirect()->route('skema.index')->with('success', 'Skema berhasil diperbarui');
    }

    public function showDetails($skm_id)
    {
        // Mengambil data skema berdasarkan ID yang dipilih
        $skema = rsm_msskema::findOrFail($skm_id);

        // Simpan skm_id ke dalam session
        session(['skm_id' => $skm_id]);

        // Mengirim data detail skema yang sesuai ke view 'detailskema.index'
        return view('detailskema.index', ['data' => $skema->details]);
    }


    public function create()
    {
        $prodis = rsm_msprodi::all();
        $skemas = rsm_msskema::all();
        return view('skema.create', compact('prodis', 'skemas'));
    }

    public function store(SkemaStoreRequest $request)
    {
        try {
            $existingSkema = rsm_msskema::where('skm_nama', $request->skema_input)->firstOrFail();

            // Jika skema sudah ada, simpan detail skema
            rsm_trdetailskema::create([
                'skm_id' => $existingSkema->skm_id,
                'pro_id' => $request->pro_id,
                'dtl_tanggal_mulai' => $request->dtl_tanggal_mulai,
                'dtl_tanggal_berakhir' => $request->dtl_tanggal_berakhir,
                'dtl_total_peserta' => $request->dtl_total_peserta,
                'dtl_kompeten' => $request->dtl_kompeten,
                'dtl_belum_kompeten' => $request->dtl_belum_kompeten,
                'dtl_tidak_hadir' => $request->dtl_tidak_hadir,
            ]);

            return redirect()->route('skema.index')->with('success', 'Detail skema berhasil disimpan!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            // Skema belum ada, buat skema baru dan simpan detail skema
            $skema = rsm_msskema::create([
                'skm_nama' => $request->skema_input,
            ]);

            rsm_trdetailskema::create([
                'skm_id' => $skema->skm_id,
                'pro_id' => $request->pro_id,
                'dtl_tanggal_mulai' => $request->dtl_tanggal_mulai,
                'dtl_tanggal_berakhir' => $request->dtl_tanggal_berakhir,
                'dtl_total_peserta' => $request->dtl_total_peserta,
                'dtl_kompeten' => $request->dtl_kompeten,
                'dtl_belum_kompeten' => $request->dtl_belum_kompeten,
                'dtl_tidak_hadir' => $request->dtl_tidak_hadir,
            ]);

            return redirect()->route('skema.index')->with('success', 'Skema dan detail skema berhasil disimpan!');
        }
    }
}
