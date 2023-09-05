@extends('layout.newlayout')


@section('content')
<!-- Flash Menu -->
@if(session()->has('updated'))
<div class="alert alert-success  alert-dismissible fade show" role="alert">
    {{ session()->get('updated') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" id="getError" role="alert">
    {{ session()->get('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<ul>
    @if(count($errors) > 0)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </ul>
    </div>
    @endif
</ul>

<head>
    <title>Chart</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>

<body>
    <style type="text/css">
        .content-header {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        span.b {
            display: inline-block;
            padding: 5px;
            border: 1px solid blue;
        }

        .satux {
            font-size: 15px !IMPORTANT;
            color: blue !IMPORTANT;
            text-align: center !IMPORTANT;

        }

        .empat {
            font-size: 25px;
            font-weight: 500px;
            color: red;
            background-color: #F0E68C;
        }


        .dua {
            font-size: 15px !IMPORTANT;
            color: white !IMPORTANT;
            font-weight: 500px;


        }

        #divpie {
            border: 1px solid black;

            background-color: transparent;
            color: red !important;
        }

        #divpiex {

            background-color: #F5F5F5;
            color: red !important;


        }

        .divbutton {
            background: #A8E9FF;
        }

        .divbutton1 {
            background: #66CDAA;
        }

        .divbutton2 {
            background: #F5F5F5;
        }

        @media screen and (max-width: 992px) {
            .allchart {
                height: 100% !important;
                width: 100% !important;
            }

        }

        .chart-wrapper {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .chart-canvas {
            max-width: 100%;
            height: auto;
        }

        .info-row {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .cost-box {
            border: 2px double black;
            padding: 10px;
            vertical-align: middle;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cost-text {
            font-weight: bold;
        }

        .row {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
        }
    </style>

    <!-- <iframe width="100%" height="950" src="https://datastudio.google.com/embed/reporting/10AcjQX5oOui-cHXFL6B-k5YxcdMeFWqy/page/aY0VB" frameborder="0" style="border:0" allowfullscreen></iframe> -->



    <div class="row">
        <div class="col-md-12 chart-wrapper">
            <canvas id="maintenanceChart" class="chart-canvas"></canvas>
        </div>
    </div>
    <div class="row info-row">
        <div class="col-md-6 text-right">
            <h3>Total Biaya Maintenance</h3>
        </div>
        <div class="col-md-6 text-center cost-box">
            <span class="cost-text" id="totalcost"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 chart-wrapper">
            <canvas id="wograph" class="chart-canvas" height="150"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 chart-wrapper">
            <canvas id="woperdept" class="chart-canvas" height="150"></canvas>
        </div>
    </div>


</body>

@endsection
@section('scripts')
<script src="{{asset('plugins/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js')}}"></script>
<script>
    function noexpitm(event, array) {
        if (array[0]) {
            let element = this.getElementAtEvent(event);
            if (element.length > 0) {
                //var series= element[0]._model.datasetLabel;
                //var label = element[0]._model.label;
                //var value = this.data.datasets[element[0]._datasetIndex].data[element[0]._index];
                window.location = "/expitem";

                //console.log()
            }
        }
    }

    function belowStockClickEvent(event, array) {
        if (array[0]) {
            let element = this.getElementAtEvent(event);
            if (element.length > 0) {
                //var series= element[0]._model.datasetLabel;
                //var label = element[0]._model.label;
                //var value = this.data.datasets[element[0]._datasetIndex].data[element[0]._index];
                window.location = "/bstock";
                //console.log()
            }
        }
    }

    $(document).ready(function() {
        function generateRandomColors(count) {
            var colors = [];
            for (var i = 0; i < count; i++) {
                var color = '#' + Math.floor(Math.random() * 16777215).toString(16);
                colors.push(color);
            }
            return colors;
        }


        // Data biaya pengeluaran maintenance per departemen
        $(document).ready(function() {
            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(amount);
            }


            // Menggunakan AJAX untuk mengambil data dari controller
            $.ajax({
                url: '/expensemt', // Sesuaikan dengan rute yang Anda definisikan
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var departments = data.map(item => item.dept_desc);

                    var totalCosts = data.map(item => item.total_sparepart_cost ? parseFloat(item.total_sparepart_cost) : 0);
                    
                    var totalSum = totalCosts.reduce((acc, cost) => acc + cost, 0);

                    // Menampilkan totalSum di elemen dengan id "totalcost"
                    var totalCostElement = document.getElementById('totalcost');
                    totalCostElement.textContent = formatCurrency(totalSum);

                    var backgroundColors = generateRandomColors(departments.length);

                    var datas = departments.map((department, index) => ({
                        label: department,
                        data: [totalCosts[index]], // Menggunakan array satu elemen untuk masing-masing dataset
                        backgroundColor: backgroundColors[index],
                    }));

                    var ctx = document.getElementById("maintenanceChart").getContext("2d");
                    var maintenanceChart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: ['Biaya'],
                            datasets: datas
                        },
                        options: {
                            title: {
                                display: true,
                                text: "Dashboard Biaya Maintenance PT Dua Kelinci"
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value, index, values) {
                                            return value.toLocaleString('en-US', {
                                                minimumFractionDigits: 2
                                            });
                                        }
                                    }
                                },
                            },
                            plugins: {
                                datalabels: {
                                    display: true,
                                    color: 'black',
                                    anchor: 'end',
                                }
                            }
                        },
                    });


                },
                error: function(err) {
                    console.error(err);
                }
            });

            // chart open wo
            $.ajax({
                url: '/wograph', // Sesuaikan dengan route Anda
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var ctx = document.getElementById('wograph').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'horizontalBar',
                        data: {
                            labels: ['Open WO', 'Overdue WO', 'On progress WO'],
                            datasets: [{
                                label: 'Work Order',
                                data: [data.WoOpen, data.WoOverDue, data.WoOnProg],
                                backgroundColor: [
                                    'blue',
                                    'red',
                                    'green'
                                ],
                                borderColor: [
                                    'black',
                                    'black',
                                    'black'
                                ],
                                borderWidth: 1
                            }]

                        },
                        options: {
                            title: {
                                display: true,
                                text: "Work Order"
                            },
                            scales: {
                                xAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        suggestedMin: 0,
                                        stepSize: 5
                                    }
                                }]
                            },
                            legend: {
                                display: false
                            },
                            plugins: {
                                datalabels: {
                                    display: true,
                                    color: 'white',
                                }
                            }
                        }
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });

            // chart WO per department
            // Fungsi untuk menghasilkan warna acak
            function getRandomColor() {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

            // Request data dari server
            $.ajax({
                url: '/wodeptstats', // Sesuaikan URL dengan route Anda
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var labels = [];
                    var data = [];
                    var backgroundColors = [];
                    var borderColors = [];
                    var total = 0;

                    for (var i = 0; i < response.length; i++) {
                        labels.push(response[i].dept_desc);
                        data.push(response[i].count);
                        total += response[i].count;

                        // Menggunakan fungsi getRandomColor untuk setiap departemen
                        var randomColor = getRandomColor();
                        backgroundColors.push(randomColor);
                        borderColors.push("black"); // Warna hitam untuk border
                    }

                    // Buat chart
                    var ctx = document.getElementById('woperdept').getContext('2d');
                    var myDoughnutChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: data,
                                backgroundColor: backgroundColors,
                                borderColor: borderColors,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: "WO Per Department"
                            },
                            legend: {
                                position: 'right' // Meletakkan legend di sisi kanan
                            },
                            tooltips: {
                                enabled: true
                            },
                            plugins: {
                                datalabels: {
                                    display: true,
                                    color: 'black',
                                    align: 'center',
                                    anchor: 'center',
                                    rotation: '45',
                                    formatter: function(value, context) {
                                        return (value / total * 100).toFixed(2) + '%'; // Menghitung persentase
                                    }
                                }
                            }
                        },
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

    });
</script>
<script>



</script>
@endsection