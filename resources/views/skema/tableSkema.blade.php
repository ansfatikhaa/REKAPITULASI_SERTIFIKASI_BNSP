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