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

    <div>
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close dismiss-icon" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <b>{{ $selectedSkemaName }}</b>
            </div>
            <div class="card-body" style="border-radius: 0%; padding:30 30 30 30;">

                <table class="table table-sm table-hover table-bordered" style="width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col" style="background-color: #4285f4; color:white; font-weight:bold">No</th>
                            <th class="text-center" scope="col" style="background-color: #4285f4; color:white; font-weight:bold">Prodi</th>
                            <th class="text-center" scope="col" style="background-color: #4285f4; color:white; font-weight:bold">Tanggal Mulai</th>
                            <th class="text-center" scope="col" style="background-color: #4285f4; color:white; font-weight:bold">Tanggal Berakhir</th>
                            <th class="text-center" scope="col" style="background-color: #4285f4; color:white; font-weight:bold">Total Peserta</th>
                            <th class="text-center" scope="col" style="background-color: #4285f4; color:white; font-weight:bold">Kompeten</th>
                            <th class="text-center" scope="col" style="background-color: #4285f4; color:white; font-weight:bold">Belum Kompeten</th>
                            <th class="text-center" scope="col" style="background-color: #4285f4; color:white; font-weight:bold">Tidak Hadir</th>
                            <th class="text-center" scope="col" style="background-color: #4285f4; color:white; font-weight:bold">Aksi</th> <!-- Tambah kolom untuk aksi -->

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $item->prodi->pro_nama }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->dtl_tanggal_mulai)->format('Y-m-d') }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->dtl_tanggal_berakhir)->format('Y-m-d') }}</td>
                            <td class="text-center">{{ $item->dtl_total_peserta }}</td>
                            <td class="text-center">{{ $item->dtl_kompeten }}</td>
                            <td class="text-center">{{ $item->dtl_belum_kompeten }}</td>
                            <td class="text-center">{{ $item->dtl_tidak_hadir }}</td>
                            <td class="text-center">
                                <a href="{{ route('detailskema.edit', $item->dtl_id) }}">
                                    <i class="fa-solid fa-pen-to-square" style="margin-right:7px"></i>Edit
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