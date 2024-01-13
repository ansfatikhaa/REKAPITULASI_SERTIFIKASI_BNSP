@extends('layout.welcome')

@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<div class="card-body">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="year" class="form-label">Tahun:</label>
                    <select id="year" name="year" class="form-select">
                        @php
                        $currentYear = date('Y');
                        for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                        echo "<option value='$i'>$i</option>";
                        }
                        @endphp
                    </select>
                </div>
                <select id="skema" name="skema" class="form-select">
                    <option value="">-- Pilih Skema --</option>
                    <?php

                    use App\Models\rsm_trdetailskema;
                    use App\Models\rsm_msskema;

                    $prodiId = $selectedProgramId;

                    // Retrieve skema data from rsm_msskema table using the model and filter by pro_id
                    $skemaList = rsm_trdetailskema::join('rsm_msskema', 'rsm_trdetailskema.skm_id', '=', 'rsm_msskema.skm_id')
                        ->where('rsm_trdetailskema.pro_id', $prodiId)
                        ->pluck('rsm_msskema.skm_nama', 'rsm_msskema.skm_id')
                        ->toArray();

                    // Display options for skema dropdown
                    foreach ($skemaList as $key => $value) {
                        echo "<option value='$key'>$value</option>";
                    }
                    ?>
                </select>


                <div>
                    <a class="btn btn-primary rounded-pill waves-effect waves-light btn-modal" style="padding: 10px 30px;" id="exportBtn" href="#">
                        Export
                    </a>
                </div>
                <div>
                    <a href="{{ url('dashboard/home') }}" class="btn btn-secondary rounded-pill waves-effect waves-light btn-modal" style="padding: 10px 30px;" id="batalBtn" href="#">
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Column for Highcharts figure -->
            <div class="col-md-9">
                <figure class="highcharts-figure">
                    <div id="barChartContainer"></div>
                </figure>
            </div>
        </div>
    </div>
</div>



<!-- Place this script section within your view file -->
<script>
    
    function updateChart() {
        var selectedYear = document.getElementById('year').value;

        var prodiId = "{{ $selectedProgramId }}";

        fetch(`/getDataProdiForYear/${prodiId}/${selectedYear}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                var categories = {
                    'total_peserta': 'Total Peserta',
                    'kompeten': 'Kompeten',
                    'belum_kompeten': 'Belum Kompeten',
                    'tidak_hadir': 'Tidak Hadir'
                };
                var dataValues = [];
                var colors = ['#7cb5ec', '#434348', '#90ed7d', '#f7a35c']; // Define colors for columns


                // Retrieve data from the server
                Object.keys(categories).forEach((category, index) => {
                    dataValues.push({
                        y: parseInt(data[category]),
                        color: colors[index] // Assign a color from the defined list
                    });
                });

                // Create the chart
                // Create the chart
                var barChart = Highcharts.chart('barChartContainer', {
                    chart: {
                        type: 'column',
                        backgroundColor: 'rgb(247,247,247)'
                    },
                    title: {
                        text: "{{ $selectedProgramName }}"
                    },
                    plotOptions: {
                        column: {
                            // Menambahkan dataLabels untuk menampilkan nilai pada ujung batang
                            dataLabels: {
                                enabled: true,
                                formatter: function() {
                                    return this.y;
                                },
                                inside: true // Agar label berada di dalam batang
                            }
                        }
                    },
                    tooltip: {
                        enabled: false // Mematikan tooltip
                    },
                    // tooltip: {
                    //     formatter: function() {
                    //         var total = dataValues.reduce(function(acc, cur) {
                    //             return acc + cur.y;
                    //         }, 0);
                    //         var percentage = Math.round((this.y / total) * 100);
                    //         return `<b>${this.point.category}</b><br/>${percentage}% (${this.y}/${total})`;
                    //     }
                    // },
                    xAxis: {
                        categories: Object.values(categories),
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah'
                        }
                    },
                    legend: {
                        enabled: false // Menonaktifkan legend
                    },
                    series: [{
                        name: 'Data',
                        data: dataValues
                    }]
                });

            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    // Event listener for dropdown change
    document.getElementById('year').addEventListener('change', updateChart);

    // Render the chart when the page loads
    updateChart();

    document.getElementById('skema').addEventListener('change', function() {
        var selectedSkema = document.getElementById('skema').value;
        window.location.href = `/dashboard/skema/${selectedSkema}`;
    });

    document.getElementById('exportBtn').addEventListener('click', function() {
        var selectedYear = document.getElementById('year').value;
        var prodiId = "{{ $selectedProgramId }}"; // Ganti $selectedProgramId menjadi prodiId
        window.location.href = `/dashboard/prodi/${prodiId}/export/excel?year=${selectedYear}`;
    });
</script>

@endsection