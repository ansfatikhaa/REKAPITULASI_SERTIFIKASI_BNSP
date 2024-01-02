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
        <h5 style="margin: 0;">
            Edit Skema
        </h5>
    </div>
    <form action="{{ route('skema.update', ['skm_id' => $skema->skm_id]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-4 form-group">
                <br>
                <label style="font-weight: bold;" for="skm_nama">Nama Skema<b style="color: red">*</b></label><br>
                <input class="form-control" name="skm_nama" type="text" style="display: inline;" value="{{ $skema->skm_nama }}">
                <span class="text-danger"></span>
                <div class="mb-3"></div>
            </div>
            <input type="hidden" name="skm_id" value="{{ $skema->id }}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection