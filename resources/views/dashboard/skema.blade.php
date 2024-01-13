@extends('layout.welcome')

@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<!-- Bagian tampilan konten -->
<div class="card-body">
    <div class="column">
        <h3>{{ $selectedSkemaName }}</h3>

        <div class="col-md-2 mb-2">
            <label for="tanggal" class="form-label">Tanggal Mulai:</label>
            <select id="tanggal" name="tanggal" class="form-select">
                <?php
                // Retrieve skema data from rsm_skema table
                use App\Models\rsm_trdetailskema;
                use Carbon\Carbon;

                $skemaId = $selectedSkemaId;

                $tanggalList = rsm_trdetailskema::join('rsm_msprodi', 'rsm_trdetailskema.pro_id', '=', 'rsm_msprodi.pro_id')
                    ->where('rsm_trdetailskema.skm_id', $skemaId)
                    ->pluck('rsm_trdetailskema.dtl_tanggal_mulai','rsm_trdetailskema.dtl_tanggal_mulai')
                    ->map(function ($date) {
                        // Format the date as dd-mm-yyyy
                        return Carbon::parse($date)->format('d-m-Y');
                    })
                    ->toArray();

                // Display options for skema dropdown
                foreach ($tanggalList as $key => $value) {
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
        <div class="col-md-3 mb-3">
            <a href="{{ url('dashboard/prodi/$selected') }}" class="btn btn-secondary rounded-pill waves-effect waves-light btn-modal" style="padding: 10px 30px;" id="batalBtn" href="#">
                Kembali
            </a>
        </div>
    </div>
    <figure class="highcharts-figure">
        <div id="barChartContainer"></div>
    </figure>
</div>
<!-- Place this script section within your view file -->
<script>
    function updateChart() {
        var selectedDate = document.getElementById('tanggal').value;

        var skemaId = "{{ $selectedSkemaId }}";

        fetch(`/getDataSkemaForProdi/${skemaId}/${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                console.log(selectedDate);
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
                        text: "{{ $selectedSkemaName }}"
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
    document.getElementById('tanggal').addEventListener('change', updateChart);

    // Render the chart when the page loads
    updateChart();

</script>
@endsection