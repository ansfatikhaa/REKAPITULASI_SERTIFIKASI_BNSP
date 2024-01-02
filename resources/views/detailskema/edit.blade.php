@extends('layout.welcome')
@section('content')
<style>
    #map-container {
        position: relative;
    }

    .marker {
        position: absolute;
        width: 15px;
        height: 15px;
        background-color: red;
        border-radius: 50%;
        cursor: pointer;
        user-select: none;
    }
</style>
<div class="card">
    <div class="card-header" style="background-color: #4285f4; color: white;">
        <h5 style="margin: 0;">Edit Skema</h5>
    </div>
    <form action="{{ route('detailskema.update', $detail->dtl_id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Tampilkan data yang akan diubah -->

            <div class="col-lg-3 form-group">
                <br>
                <label style="font-weight: bold;" for="pro_id">Nama Skema<b style="color: red">*</b></label><br>
                <select class="form-control" name="skm_id">
                    <option value="">Pilih Skema</option>
                    @foreach($skemas as $skema)
                    <option value="{{ $skema->skm_id }}" {{ $detail['skm_id'] == $skema->skm_id ? 'selected' : '' }}>
                        {{ $skema->skm_nama }}
                    </option>
                    @endforeach
                </select>
                <span class="text-danger"></span>
                <div class="mb-3"></div>
            </div>
            <div class="col-lg-3 form-group">
                <br>
                <label style="font-weight: bold;" for="pro_id">Prodi<b style="color: red">*</b></label><br>
                <select class="form-control" name="pro_id">
                    <option value="">Pilih Prodi</option>
                    @foreach($prodis as $prodi)
                    <option value="{{ $prodi->pro_id }}" {{ $detail['pro_id'] == $prodi->pro_id ? 'selected' : '' }}>
                        {{ $prodi->pro_nama }}
                    </option>
                    @endforeach

                </select>
                <span class="text-danger"></span>
                <div class="mb-3"></div>
            </div>
            <div class="col-lg-3 form-group">
                <br>
                <label style="font-weight: bold;" for="dtl_tanggal_mulai">Tanggal Mulai<b style="color: red">*</b></label><br>
                <input class="form-control" name="dtl_tanggal_mulai" type="date" value="{{ $detail->dtl_tanggal_mulai ? \Carbon\Carbon::parse($detail->dtl_tanggal_mulai)->format('Y-m-d') : '' }}" style="display: inline;">
                <span class="text-danger"></span>
                <div class="mb-3"></div>
            </div>
            <div class="col-lg-3 form-group">
                <br>
                <label style="font-weight: bold;" for="dtl_tanggal_berakhir">Tanggal Berakhir<b style="color: red">*</b></label><br>
                <input class="form-control" name="dtl_tanggal_berakhir" type="date" value="{{ $detail->dtl_tanggal_berakhir ? \Carbon\Carbon::parse($detail->dtl_tanggal_mulai)->format('Y-m-d') : '' }}" style="display: inline;">
                <span class="text-danger"></span>
                <div class="mb-3"></div>
            </div>
            <div class="col-lg-3 form-group">
                <br>
                <label style="font-weight: bold;" for="dtl_total_peserta">Total Peserta<b style="color: red">*</b></label><br>
                <input class="form-control" name="dtl_total_peserta" type="number" value="{{ $detail->dtl_total_peserta }}" style="display: inline;">
                <span class="text-danger"></span>
                <div class="mb-3"></div>
            </div>
            <div class="col-lg-3 form-group">
                <br>
                <label style="font-weight: bold;" for="dtl_kompeten">Kompeten<b style="color: red">*</b></label><br>
                <input class="form-control" name="dtl_kompeten" type="number" value="{{ $detail->dtl_kompeten }}" style="display: inline;">
                <span class="text-danger"></span>
                <div class="mb-3"></div>
            </div>
            <div class="col-lg-3 form-group">
                <br>
                <label style="font-weight: bold;" for="dtl_belum_kompeten">Belum Kompeten<b style="color: red">*</b></label><br>
                <input class="form-control" name="dtl_belum_kompeten" type="number" value="{{ $detail->dtl_belum_kompeten }}" style="display: inline;">
                <span class="text-danger"></span>
                <div class="mb-3"></div>
            </div>
            <div class="col-lg-3 form-group">
                <br>
                <label style="font-weight: bold;" for="dtl_tidak_hadir">Tidak Hadir<b style="color: red">*</b></label><br>
                <input class="form-control" name="dtl_tidak_hadir" type="number" value="{{ $detail->dtl_tidak_hadir }}" style="display: inline;">
                <span class="text-danger"></span>
                <div class="mb-3"></div>
            </div>

        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection