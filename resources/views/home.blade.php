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
    </style>

    <!-- <iframe width="100%" height="950" src="https://datastudio.google.com/embed/reporting/10AcjQX5oOui-cHXFL6B-k5YxcdMeFWqy/page/aY0VB" frameborder="0" style="border:0" allowfullscreen></iframe> -->



    <div class="row">
        <div class="col-md-12">
            <canvas id="maintenanceChart" width="400" height="200"></canvas>
        </div>
    </div>


</body>

@endsection
@section('scripts')
<!-- <script src="{{url('vendors\chart-js-datalabel\chartjs-plugin-datalabels-new.js')}}"></script> -->
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
            // Menggunakan AJAX untuk mengambil data dari controller
            $.ajax({
                url: '/expensemt', // Sesuaikan dengan rute yang Anda definisikan
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var departments = data.map(item => item.dept_desc);

                    var totalCosts = data.map(item => parseFloat(item.total_sparepart_cost));

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
                        },
                    });


                },
                error: function(err) {
                    console.error(err);
                }
            });
        });

    });
</script>
<script>



</script>
@endsection