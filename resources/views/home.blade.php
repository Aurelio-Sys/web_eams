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
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            /* Adjust this to fit the layout */
            grid-gap: 10px;
            /* This sets the gap between the cards */
            padding: 5px;
            /* This adds some spacing around the grid */
        }

        .card {
            background-color: white;
            border-radius: 5px;
            padding: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-bottom: 0;

        }

        .card-icon {
            font-size: 1.5em;
            /* Icon size */
        }

        .card-title {
            font-size: 14px;
            /* Title font size */
            color: #333;
            /* Title text color */
            margin-bottom: 8px;
            text-align: center;
            /* Space below title */

            font-weight: 600;
        }

        .card-value {
            font-size: 18px;
            /* Value font size */
            color: #1E90FF;
            /* Value text color */
            font-weight: bold;
            /* Bold font weight for the value */

            text-align: center;

            font-weight: 600;
        }

        .card-subtitle {
            font-size: 1em;
            /* Subtitle font size */
            color: #777;
            /* Subtitle text color */
        }
        
        .card-body {
            padding: 3px;
        }

        .card:nth-child(9) {
            grid-column: span 2;
            min-height: fit-content;
        }

        .card:nth-child(10) {
            grid-column: span 2;
            min-height: fit-content;

        }
    </style>
</head>

<body>
    <div class="grid-container">
        <div class="card">
            <div class="card-title">Spare part value</div>
            <div class="card-value">535,222,000</div>
        </div>
        <div class="card">
            <div class="card-title">YTD CM work order</div>
            <div class="card-value">78</div>
        </div>
        <div class="card">
            <div class="card-title">YTD service request</div>
            <div class="card-value">148</div>
        </div>
        <div class="card">
            <div class="card-title">Late work order</div>
            <div class="card-value">45</div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fas fas fa-tools card-icon"></i>
                    </div>
                    <div class="col">
                        <div class="font-weight-small">
                            34 Active
                        </div>
                        <div class="text-secondary">
                            Service Request
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fas fa-cogs card-icon"></i>
                    </div>
                    <div class="col">
                        <div class="font-weight-small">
                            34 Active
                        </div>
                        <div class="text-secondary">
                            Service Request
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fas fa-toolbox card-icon"></i>
                    </div>
                    <div class="col">
                        <div class="font-weight-small">
                            7 Assets
                        </div>
                        <div class="text-secondary">
                            Being Repaired
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fas fa-wrench card-icon"></i>
                    </div>
                    <div class="col">
                        <div class="font-weight-small">
                            8 Assets
                        </div>
                        <div class="text-secondary">
                            Being Maintained
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div id="topAssetsChart" style="width: 100%; min-height: 250px;"></div>

        </div>
        <div class="card">
            <div class="card-title">25 Top Asset Issues</div>

        </div>
    </div>
    <!-- </div> -->


</body>

@endsection
@section('scripts')
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

    document.addEventListener("DOMContentLoaded", function(event) {
        // Generate dummy data
        var assetNames = Array.from({
            length: 25
        }, (v, i) => `Asset ${i + 1}`);
        var assetCosts = Array.from({
            length: 25
        }, () => Math.floor(Math.random() * 100000));

        // Initialize ECharts
        var chartDom = document.getElementById('topAssetsChart');
        var myChart = echarts.init(chartDom);
        var option;

        option = {
            title: {
                text: 'Top 25 Assets Cost Consumption',
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                data: assetNames // Categories (asset names) on the x-axis
            },
            yAxis: {
                type: 'value', // Numeric scale on the y-axis
                boundaryGap: [0, 0.01]
            },
            series: [{
                type: 'bar',
                data: assetCosts,
                label: {
                    show: false,
                },
                barWidth: '30%' 
            }]
        };

        myChart.setOption(option);

        // Resize chart on window resize
        window.addEventListener('resize', function() {
            myChart.resize();
        });
    });
</script>
<script>



</script>
@endsection