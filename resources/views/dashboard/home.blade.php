@extends('layout.welcome')

@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<!-- Bagian tampilan konten -->
<div class="card-body">
    <div class="column">
        <!-- Dropdown for selecting year -->
        <div class="col-md-2 mb-2">
            <label for="year" class="form-label">Tahun:</label>
            <select id="year" name="year" class="form-select">
                <?php
                $currentYear = date('Y');
                for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <label for="prodi" class="form-label">Program Studi:</label>
            <select id="prodi" name="prodi" class="form-select">
                <option value="">-- Pilih Prodi --</option>
                <?php
                // Retrieve program study data from rsm_prodi table
                use App\Models\rsm_msprodi;

                $prodiList = rsm_msprodi::pluck('pro_nama', 'pro_id');

                // Display options for program study dropdown
                foreach ($prodiList as $key => $value) {
                    echo "<option value='$key'>$value</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-3 mb-3">
            <a class="btn btn-primary rounded-pill waves-effect waves-light btn-modal" style="padding: 10px 30px;" id="exportBtn" href="#">
                Export
            </a>
        </div>
    </div>

    <figure class="highcharts-figure">
        <div id="container"></div>
    </figure>
</div>

<script>
    function updateChart() {
        // Mendapatkan nilai tahun yang dipilih dari dropdown
        var selectedYear = document.getElementById('year').value;
        // Mengambil data dari URL '/getDataTotalForYear/' + selectedYear menggunakan Fetch API
        // kemudian mengolah data JSON yang diperoleh
        fetch('/getDataTotalForYear/' + selectedYear)
            .then(response => response.json())
            .then(data => {
                const colorsByProdi = {
                    '1': '#FED921',
                    '2': '#0D8127',
                    '3': '#0F0D81',
                    '4': '#52B6FF',
                    '5': '#FF3D00',
                    '6': '#B1541F',
                    '7': '#810D0D',
                    '8': '#8C52FF',
                };

                const prodiNames = {
                    1: 'Pembuatan Peralatan dan Perkakas Produksi',
                    2: 'Teknik Produksi dan Proses Manufaktur',
                    3: 'Manajemen Informatika',
                    4: 'Mesin Otomotif',
                    5: 'Mekatronika',
                    6: 'Teknologi Konstruksi Bangunan Gedung',
                    7: 'Teknologi Rekayasa Pemeliharaan Alat Berat',
                    8: 'Teknologi Rekayasa Logistik',
                };

                const abbreviationByProdi = {
                    1: 'P4',
                    2: 'TPM',
                    3: 'MI',
                    4: 'MO',
                    5: 'MK',
                    6: 'TKBG',
                    7: 'TRPAB',
                    8: 'TRL'
                };

                var chartData = data.map(item => ({
                    name: abbreviationByProdi[item.pro_id] || 'Prodi ' + item.pro_id,
                    y: parseInt(item.total_peserta),
                    year: selectedYear,
                    color: colorsByProdi[item.pro_id] || '#CCCCCC' // Gunakan warna default jika tidak ada warna khusus
                }));
                // Konfigurasi grafik Highcharts
                var chart = Highcharts.chart('container', {
                    chart: {
                        type: 'pie',
                        backgroundColor: 'rgb(247,247,247)'
                    },
                    title: {
                        text: "Keseluruhan Peserta Sertifikasi Berdasarkan Program Studi"
                    },
                    subtitle: {
                        text: '',
                        align: 'center'
                    },
                    accessibility: {
                        enabled: true // Set accessibility enabled to true
                    },
                    plotOptions: {
                        series: {
                            borderRadius: 5,
                            allowPointSelect: true,
                            innerSize: '50%',
                            showInLegend: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                formatter: function() {
                                    return '<b>' + this.point.name + '<br>' + this.percentage.toFixed(1) + '%';
                                },
                                distance: -30,
                                color: 'white'
                            },

                        }
                    },
                    exporting: {
                        enabled: true, // Aktifkan modul ekspor
                        buttons: {
                            contextButton: {
                                menuItems: [
                                    'viewFullscreen',
                                    'printChart',
                                    'separator',
                                    'downloadPNG',
                                    'downloadJPEG',
                                    'downloadPDF',
                                    'downloadSVG'
                                ]
                            }
                        }
                    },
                    legend: {
                        // Legend di bawah grafik menggunakan prodiNames sebagai teks
                        labelFormatter: function() {
                            return prodiNames[this.name.split(' ')[1]] || this.name;
                        }
                    },
                    series: [{
                        name: "Jumlah Peserta",
                        colorByPoint: true,
                        data: chartData

                    }]
                });

                var centerY = chart.plotHeight / 2;

                // Menambahkan keterangan tahun pada bagian tengah chart pie
                chart.setSubtitle({
                    text: '<span style="font-size: 24px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">' + selectedYear + '</span>',
                    verticalAlign: 'middle',
                    y: centerY - 100
                });

            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }
    // Menambahkan event listener untuk meng-update grafik saat dropdown tahun diubah
    document.getElementById('year').addEventListener('change', updateChart);

    // Inisialisasi grafik pada tahun pertama kali tampil
    updateChart();

    document.getElementById('exportBtn').addEventListener('click', function() {
        var selectedYear = document.getElementById('year').value;
        window.location.href = '/dashboard/export/excel?year=' + selectedYear;
    });

    document.getElementById('prodi').addEventListener('change', function() {
        var selectedProdi = document.getElementById('prodi').value;
        window.location.href = `/dashboard/prodi/${selectedProdi}`;
    });
</script>

@endsection