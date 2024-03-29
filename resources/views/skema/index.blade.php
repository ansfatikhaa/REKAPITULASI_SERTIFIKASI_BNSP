@extends('layout.welcome')
@section('content')
<style>
    .table,
    .table th,
    .table td {
        font-size: 10px;
        /* Ubah nilai sesuai keinginan Anda */
    }

    .table-container {
        overflow-x: auto;
    }

    .table-responsive {
        width: 100%;
        overflow-y: auto;
        /* Tampilkan scroll hanya jika diperlukan */
        -ms-overflow-style: none;
        /* Hides scrollbar in IE and Edge */
        scrollbar-width: none;
        /* Hides scrollbar in Firefox */
    }

    .table-responsive::-webkit-scrollbar {
        display: none;
        /* Hides scrollbar in Chrome, Safari, and Opera */
    }

    .card-body {
        max-height: calc(100vh - 20px);
        /* Sesuaikan dengan kebutuhan */
        overflow-y: auto;
        /* Tampilkan scroll hanya jika diperlukan */
    }

    /* Atur tinggi tabel */
    .table {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        /* Tampilkan scroll horizontal jika diperlukan */
    }

    /* Atur ukuran tombol */
    .btn-primary {
        padding: 8px 16px;
        /* Sesuaikan padding sesuai kebutuhan */
        font-size: 12px;
        /* Sesuaikan ukuran font sesuai keinginan Anda */
    }

    .form-control {
        padding: px;
        font-size: 14px;
    }
</style>
<div class="row">
    @if (session('successMessage'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        <strong class="alert-message-custom">Sukses!</strong> {{ session('successMessage') }}
        <button type="button" class="btn-close alert-message-custom" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="col-md-12 table-container">
        <form method="GET" action="{{ route('skema.index') }}">
            <div class="row">
                <div class="col-md-2 mb-3">
                    <a class="btn btn-primary rounded-pill waves-effect waves-light" href="{{ route('skema.create') }}">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                </div>
                <div class="col-md-8 mb-3">
                    <input name="search" type="text" id="MainContent_txtCari" class="form-control form-cari" placeholder="Cari" />
                </div>
                <div class="col-md-2 mb-3">
                    <button type="submit" class="btn btn-primary rounded-pill waves-effect waves-light btn-block">
                        Search
                    </button>
                </div>
            </div>
        </form>
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close dismiss-icon" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <b>DATA SKEMA</b>
                </div>

                <div style="display: flex; align-items: center;">
                    <label for="showby" class="form-label" style="margin-right: 10px;">Tampilkan berdasarkan:</label>
                    <select id="showby" name="showby" class="form-select">
                        <option value="skema">Skema</option>
                        <option value="prodi">Prodi</option>
                        <option value="tahun">Tahun</option>
                    </select>
                </div>
            </div>



            <div class="card-body" style="border-radius: 0%; padding:30 30 30 30;">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" style="width: 10%; background-color: #4285f4; color:white; font-weight:bold">No</th>
                                <th class="text-center" scope="col" style="width: 60%; background-color: #4285f4; color:white; font-weight:bold">Nama Skema</th>
                                <th class="text-center" scope="col" style="width: 30%; background-color: #4285f4; color:white; font-weight:bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $item->skm_nama }}</td> <!-- Ubah $item->skm_nama sesuai dengan field di tabel -->
                                <td class="text-center">
                                    <a href="{{ route('skema.edit', $item->skm_id) }}">
                                        <i class="fa-solid fa-pen-to-square" style="margin-right:7px"></i>Edit
                                    </a>
                                    |
                                    <a href="{{ route('skema.detail', $item->skm_id) }}">
                                        <i class="fa-solid fa-eye" style="margin-right:7px"></i>Lihat Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection