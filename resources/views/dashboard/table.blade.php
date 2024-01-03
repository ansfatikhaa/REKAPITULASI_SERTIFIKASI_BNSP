<table class="table table-sm table-hover table-bordered" style="width:100%;">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Skema</th>
            <th>Nama Prodi</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Berakhir</th>
            <th>Total Peserta</th>
            <th>Kompeten</th>
            <th>Belum Kompeten</th>
            <th>Tidak Hadir</th>
            <!-- Tambahkan cell lain yang sesuai dengan atribut dari rsm_trdetailskema -->
        </tr>
    </thead>
    <tbody>
        @php 
            $no=1;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->skema->skm_nama }}</td>
                <td>{{ $item->prodi->pro_nama }}</td>
                <td>{{ $item->dtl_tanggal_mulai }}</td>
                <td>{{ $item->dtl_tanggal_berakhir }}</td>
                <td>{{ $item->dtl_total_peserta }}</td>
                <td>{{ $item->dtl_kompeten }}</td>
                <td>{{ $item->dtl_belum_kompeten }}</td>
                <td>{{ $item->dtl_tidak_hadir }}</td>
                <!-- Tambahkan cell lain yang sesuai dengan atribut dari rsm_trdetailskema -->
            </tr>
        @endforeach
    </tbody>
</table>
