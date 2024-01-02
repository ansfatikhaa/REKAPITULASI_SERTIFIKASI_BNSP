@extends('layout.welcome')
@section('content')
<style>
    /* Gayamu di sini */
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

    .form-group {
        margin-bottom: 15px;
    }

    .card-header {
        background-color: #4285f4;
        color: white;
    }

    .card-header h5 {
        margin: 0;
    }

    label {
        font-weight: bold;
        color: #333;
        /* Warna teks */
    }

    .text-danger {
        color: red;
        /* Warna teks peringatan */
    }

    .btn-primary {
        background-color: #4285f4;
        /* Warna tombol */
        border-color: #4285f4;
        /* Warna border tombol */
    }

    .btn-primary:hover {
        background-color: #2a61e5;
        /* Warna tombol saat dihover */
        border-color: #2a61e5;
        /* Warna border tombol saat dihover */
    }

    input[type="date"],
    input[type="number"],
    select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-top: 6px;
        font-size: 14px;
    }

    /* Ganti warna dropdown di bawah ini */
    .dropdown-items {
        background-color: #f8f9fa;
        /* Ubah warna latar belakang */
        color: #333;
        /* Ubah warna teks */
        border: 1px solid #ccc;
        /* Ubah warna border */
        border-radius: 4px;
        /* Ubah radius border */
        padding: 5px;
        /* Sesuaikan padding jika diperlukan */
    }

    .dropdown-item {
        padding: 8px 12px;
        /* Sesuaikan padding untuk tiap item */
        cursor: pointer;
    }

    .dropdown-item:hover {
        background-color: #e9ecef;
        /* Ubah warna saat dihover */
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

    <div class="col-md-12">

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close dismiss-icon" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card">
            <div class="card-header" style="background-color: #4285f4; color: white;">
                <h5 style="margin: 0;">Tambah Skema</h5>
            </div>
            <div class="card-body" style="border-radius: 0%;">
                <form action="{{ route('skema.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-3 form-group">
                            <br>
                            <label style="font-weight: bold;" for="skema_input">Skema<b style="color: red">*</b></label><br>
                            <input type="text" id="skema_input" name="skema_input" class="form-control" placeholder="Pilih atau ketik nama skema" required>
                            @error('skema_input')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <input type="hidden" id="skema_id_input" name="skema_id">
                            <div id="skema_dropdown" class="dropdown-items" style="display: none;">
                                @foreach($skemas as $skema)
                                <div class="dropdown-item" data-skm-id="{{ $skema->skm_id }}" style="display: none;">{{ $skema->skm_nama }}</div>
                                @endforeach
                            </div>
                            <span class="text-danger"></span>
                            <div class="mb-3"></div>
                        </div>
                        <div class="col-lg-3 form-group">
                            <br>
                            <label style="font-weight: bold;" for="pro_id">Prodi<b style="color: red">*</b></label><br>
                            <select class="form-control" name="pro_id" required>
                                <option value="">Pilih Prodi</option>
                                @foreach($prodis as $prodi)
                                <option value="{{ $prodi->pro_id }}">{{ $prodi->pro_nama }}</option>
                                @endforeach
                            </select>
                            @error('pro_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <span class="text-danger"></span>
                            <div class="mb-3"></div>
                        </div>
                        <div class="col-lg-3 form-group">
                            <br>
                            <label style="font-weight: bold;" for="dtl_tanggal_mulai">Tanggal Mulai<b style="color: red">*</b></label><br>
                            <input class="form-control" name="dtl_tanggal_mulai" type="date" style="display: inline;" required>
                            @error('dtl_tanggal_mulai')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <span class="text-danger"></span>
                            <div class="mb-3"></div>
                        </div>
                        <div class="col-lg-3 form-group">
                            <br>
                            <label style="font-weight: bold;" for="dtl_tanggal_berakhir">Tanggal Berakhir<b style="color: red">*</b></label><br>
                            <input class="form-control" name="dtl_tanggal_berakhir" type="date" style="display: inline;" required>
                            @error('dtl_tanggal_berakhir')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <span class="text-danger"></span>
                            <div class="mb-3"></div>
                        </div>
                        <div class="col-lg-3 form-group">
                            <br>
                            <label style="font-weight: bold;" for="dtl_total_peserta">Total Peserta<b style="color: red">*</b></label><br>
                            <input class="form-control" name="dtl_total_peserta" type="number" style="display: inline;" required>
                            @error('dtl_total_peserta')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <span class="text-danger"></span>
                            <div class="mb-3"></div>
                        </div>
                        <div class="col-lg-3 form-group">
                            <br>
                            <label style="font-weight: bold;" for="dtl_kompeten">Kompeten<b style="color: red">*</b></label><br>
                            <input class="form-control" name="dtl_kompeten" type="number" style="display: inline;" required>
                            @error('dtl_kompeten')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <span class="text-danger"></span>
                            <div class="mb-3"></div>
                        </div>
                        <div class="col-lg-3 form-group">
                            <br>
                            <label style="font-weight: bold;" for="dtl_belum_kompeten">Belum Kompeten<b style="color: red">*</b></label><br>
                            <input class="form-control" name="dtl_belum_kompeten" type="number" style="display: inline;" required>
                            <span class="text-danger"></span>
                            <div class="mb-3"></div>
                        </div>
                        <div class="col-lg-3 form-group">
                            <br>
                            <label style="font-weight: bold;" for="dtl_tidak_hadir">Tidak Hadir<b style="color: red">*</b></label><br>
                            <input class="form-control" name="dtl_tidak_hadir" type="number" style="display: inline;" required>
                            <span class="text-danger"></span>
                            <div class="mb-3"></div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>

            <script>
                document.addEventListener('click', function(event) {
                    const skemaInput = document.getElementById('skema_input');
                    const skemaDropdown = document.getElementById('skema_dropdown');
                    const dropdownItems = document.querySelectorAll('.dropdown-item');

                    const isClickInsideSkema = skemaInput.contains(event.target) || skemaDropdown.contains(event.target);

                    if (!isClickInsideSkema) {
                        skemaDropdown.style.display = 'none';
                    }

                    skemaInput.addEventListener('focus', function() {
                        skemaDropdown.style.display = 'block';
                    });

                    skemaInput.addEventListener('input', function() {
                        const inputText = skemaInput.value.toLowerCase();
                        dropdownItems.forEach(item => {
                            const itemText = item.textContent.toLowerCase();
                            if (itemText.includes(inputText)) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                        skemaDropdown.style.display = 'block';
                    });

                    dropdownItems.forEach(item => {
                        item.addEventListener('click', function() {
                            // Memasukkan nama skema ke input
                            skemaInput.value = item.textContent;
                            // Mengambil ID skema dari data attribute dan menyimpannya ke dalam input tersembunyi
                            const skemaId = item.getAttribute('data-skm-id');
                            document.getElementById('skema_id_input').value = skemaId;

                            // Cetak nilai ID skema ke konsol untuk memastikan bahwa nilai ID terambil dengan benar
                            console.log('ID Skema yang dipilih:', skemaId);

                            // Menyembunyikan dropdown setelah memilih
                            skemaDropdown.style.display = 'none';
                        });
                    });
                });
            </script>
        </div>
    </div>
</div>

@endsection