@extends('layout.welcome')

@section('content')
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
@endsection