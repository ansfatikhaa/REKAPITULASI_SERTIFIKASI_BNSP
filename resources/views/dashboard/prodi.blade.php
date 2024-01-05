@extends('layout.welcome')

@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>


<div class="card-body">
    <div class="column">
        <!-- Tampilkan nama program studi yang dipilih -->
        <h3>{{ $selectedProgramName }}</h3>

        <div class="col-md-2 mb-2">
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

        <!-- Button for triggering the data fetching and chart rendering -->
        <div class="col-md-3 mb-3">
            <a class="btn btn-primary rounded-pill waves-effect waves-light btn-modal" style="padding: 10px 30px;" id="exportBtn" href="#">
                Export
            </a>
        </div>
    </div>

    <!-- Chart container -->
    <figure class="highcharts-figure">
        <div id="barChartContainer"></div>
    </figure>
</div>

<!-- Place this script section within your view file -->
<script>
    function updateChart() {
        var selectedYear = document.getElementById('year').value;
        var selectedProdi = "{{ $prodiData[0]->pro_id }}"; // Use the selected pro_id here

        fetch(`/dashboard/prodi/${selectedProdi}`)
            .then(response => response.json())
            .then(data => {
                var categories = ['Total Peserta', 'Kompeten', 'Belum Kompeten', 'Tidak Hadir'];
                var dataValues = [];
                
                categories.forEach(category => {
                    var sum = 0;
                    data.forEach(item => {
                        sum += parseInt(item[category.toLowerCase()]);
                    });
                    dataValues.push(sum);
                });

                var barChart = Highcharts.chart('barChartContainer', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Statistik Program Studi'
                    },
                    xAxis: {
                        categories: categories,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah'
                        }
                    },
                    series: [{
                        name: 'Program Studi',
                        data: dataValues
                    }]
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    // Event listener for dropdown changes
    document.getElementById('year').addEventListener('change', updateChart);

    // Initial chart rendering on page load
    updateChart();

    // Button click event to export data
    document.getElementById('exportBtn').addEventListener('click', function() {
        var selectedYear = document.getElementById('year').value;
        window.location.href = `/dashboard/export/excel?year=${selectedYear}`;
    });
</script>

@endsection