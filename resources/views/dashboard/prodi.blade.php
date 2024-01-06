@extends('layout.welcome')

@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<div class="card-body">
    <div class="column">
        <!-- Display the selected program name -->
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

        var prodiId = "{{ $selectedProgramId }}"; // Get the selected program ID

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
                var barChart = Highcharts.chart('barChartContainer', {
                    chart: {
                        type: 'column',
                        backgroundColor: 'rgb(247,247,247)'
                    },
                    title: {
                        text: 'Statistik Program Studi'
                    },
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
                        enabled: false // Disable the legend
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
</script>

@endsection