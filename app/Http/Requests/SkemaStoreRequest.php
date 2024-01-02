<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkemaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ubah menjadi true jika request ini memerlukan otorisasi
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'skema_input' => 'required', // Menyatakan field skm_nama harus unik di tabel rsm_msskema
            'pro_id' => 'required|integer',
            'dtl_tanggal_mulai' => 'required|date',
            'dtl_tanggal_berakhir' => 'required|date',
            'dtl_total_peserta' => 'required|integer',
            'dtl_kompeten' => 'required|integer',
            'dtl_belum_kompeten' => 'required|integer',
            'dtl_tidak_hadir' => 'required|integer',
            // Tambahkan aturan validasi lainnya jika diperlukan
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'skema_input.required' => 'Nama skema diperlukan',
            //'skema_input.unique' => 'Nama skema harus unik',
            'pro_id.required' => 'Pilih Prodi',
            'pro_id.integer' => 'Prodi harus berupa bilangan bulat',
            'dtl_tanggal_mulai.required' => 'Tanggal mulai diperlukan',
            'dtl_tanggal_mulai.date' => 'Tanggal mulai harus dalam format tanggal yang valid',
            'dtl_tanggal_berakhir.required' => 'Tanggal berakhir diperlukan',
            'dtl_tanggal_berakhir.date' => 'Tanggal berakhir harus dalam format tanggal yang valid',
            'dtl_total_peserta.required' => 'Total peserta diperlukan',
            'dtl_total_peserta.integer' => 'Total peserta harus berupa bilangan bulat',
            'dtl_kompeten.required' => 'Jumlah peserta kompeten diperlukan',
            'dtl_kompeten.integer' => 'Jumlah peserta kompeten harus berupa bilangan bulat',
            'dtl_belum_kompeten.required' => 'Jumlah peserta belum kompeten diperlukan',
            'dtl_belum_kompeten.integer' => 'Jumlah peserta belum kompeten harus berupa bilangan bulat',
            'dtl_tidak_hadir.required' => 'Jumlah peserta tidak hadir diperlukan',
            'dtl_tidak_hadir.integer' => 'Jumlah peserta tidak hadir harus berupa bilangan bulat',
            // Tambahkan pesan kesalahan lain sesuai kebutuhan
        ];
    }
}
