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
            font-size: 2em;
            /* Icon size */
        }

        .card-title {
            font-size: 18px;
            /* Title font size */
            color: #333;
            /* Title text color */
            margin-bottom: 2px;
            text-align: center;
            /* Space below title */

            font-weight: 600;
        }

        .card-value {
            font-size: 24px;
            /* Value font size */
            color: #1E90FF;
            /* Value text color */
            font-weight: bold;
            /* Bold font weight for the value */
            text-align: center;
            font-weight: 600;
            margin-top: 0;
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

        .card:nth-child(1) {
            padding: 10px !important;
        }

        .card:nth-child(2) {
            padding: 10px !important;
        }

        .card:nth-child(3) {
            padding: 10px !important;
        }

        .card:nth-child(4) {
            padding: 10px !important;
        }

        .card:nth-child(9) {
            grid-column: span 2;
        }

        .card:nth-child(10) {
            grid-column: span 2;
            min-height: fit-content;

        }

        .content-header {
            padding: 0.1rem 0.1rem;
        }

        .card-header {
            display: flex;
            margin-bottom: 10px;
        }

        .header-title {
            font-size: 14px;
            color: black;
            font-weight: 600;
        }

        .card-main {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .main-number {
            font-size: 18px;
            color: #1E90FF;
        }

        .main-change {
            font-size: 1rem;
            color: #4caf50;
            display: flex;
            align-items: center;
        }

        .change-icon {
            margin-right: 5px;
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
            <div class="card-header">
                <div class="header-title">CM Work Order</div>
            </div>
            <div class="card-main">
                <div class="main-number">200</div>
            </div>
            <div id="miniBarChart" style="width: 100%; height: 40px;"></div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-title">CM Service Request</div>
            </div>
            <div class="card-main">
                <div class="main-number">456</div>
            </div>
            <div id="miniBarChart2" style="width: 100%; height: 40px;"></div>
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
                    <div class="col text-center">
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
                    <div class="col text-center">
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
                    <div class="col text-center">
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
                    <div class="col text-center">
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
            <div id="topAssetsChart" style="width: auto; min-height: 200px;"></div>

        </div>
        <div class="card">
            <div id="assetIssuesChart" style="width: auto; min-height: 200px;"></div>
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
                text: '25 Top Assets Cost Consumption',
                textStyle: {
                    fontSize: 14,
                }
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            grid: {
                left: '15%', // Adjust these values as needed for your layout
                right: '15%',
                top: '40px',
                bottom: '40px',
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
                barWidth: '50%'
            }]
        };

        myChart.setOption(option);

        // Resize chart on window resize
        window.addEventListener('resize', function() {
            console.log('resizee');
            myChart.resize();
        });

        // Initialize the second chart for "Top 25 Asset Issues"
        var issuesChartDom = document.getElementById('assetIssuesChart');
        var issuesChart = echarts.init(issuesChartDom);
        var issuesOption;

        // Dummy data for the second chart
        var issueNames = Array.from({
            length: 25
        }, (v, i) => `Issue ${i + 1}`);
        var issueCounts = Array.from({
            length: 25
        }, () => Math.floor(Math.random() * 500));

        issuesOption = {
            title: {
                text: '25 Top Asset Issues',
                textStyle: {
                    fontSize: 14,
                }
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            grid: {
                left: '15%', // Adjust these values as needed for your layout
                right: '15%',
                top: '40px',
                bottom: '40px',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                data: issueNames // Categories (issue names) on the x-axis
            },
            yAxis: {
                type: 'value', // Numeric scale on the y-axis
                boundaryGap: [0, 0.01]
            },
            series: [{
                type: 'bar',
                data: issueCounts,
                barWidth: '50%' // Adjust bar width as needed
            }]
        };

        issuesChart.setOption(issuesOption);

        // Resize chart on window resize
        window.addEventListener('resize', function() {
            issuesChart.resize();
        });

        // Generate random data for each month from January to December
        var monthlyData = Array.from({
            length: 12
        }, () => Math.floor(Math.random() * 500));

        // Initialize the mini bar chart
        var miniChartDom = document.getElementById('miniBarChart');
        var miniChart = echarts.init(miniChartDom);
        var miniChartOption = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow' // 'shadow' as default; can also be 'line' or 'none'
                },
                formatter: function(params) {
                    var data = params[0].data;
                    var tooltipText = `${params[0].name}: ${data}`;
                    return tooltipText;
                }
            },
            grid: {
                left: '0%',
                right: '0%',
                top: '0%',
                bottom: '0%',
                containLabel: false
            },
            xAxis: {
                type: 'category',
                data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                show: false
            },
            yAxis: {
                type: 'value',
                show: false
            },
            series: [{
                data: monthlyData,
                type: 'bar',
                barWidth: '60%',
                showBackground: false,
                color: '#007bff'
            }]
        };
        miniChart.setOption(miniChartOption);

        // Resize chart on window resize
        window.addEventListener('resize', function() {
            miniChart.resize();
        });

        // Generate random data for each month from January to December
        var monthlyData2 = Array.from({
            length: 12
        }, () => Math.floor(Math.random() * 500));

        // Initialize the mini bar chart
        var miniChartDom = document.getElementById('miniBarChart2');
        var miniChart = echarts.init(miniChartDom);
        var miniChartOption = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow' // 'shadow' as default; can also be 'line' or 'none'
                },
                formatter: function(params) {
                    var data = params[0].data;
                    var tooltipText = `${params[0].name}: ${data}`;
                    return tooltipText;
                }
            },
            grid: {
                left: '0%',
                right: '0%',
                top: '0%',
                bottom: '0%',
                containLabel: false
            },
            xAxis: {
                type: 'category',
                data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                show: false
            },
            yAxis: {
                type: 'value',
                show: false
            },
            series: [{
                data: monthlyData2,
                type: 'bar',
                barWidth: '60%',
                showBackground: false,
                color: '#007bff'
            }]
        };
        miniChart.setOption(miniChartOption);

        // Resize chart on window resize
        window.addEventListener('resize', function() {
            miniChart.resize();
        });
    });
</script>
<script>



</script>
@endsection