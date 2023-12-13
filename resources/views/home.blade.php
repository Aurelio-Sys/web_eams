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
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .container-fluid {
            padding: 10px;
            height: 100%;
        }

        .card {
            height: calc(50% - 20px);
            /* Adjust the 20px if you change the padding */
        }

        .row {
            margin-bottom: 20px;
        }

        /* If you have additional styling, you can add here */
    </style>
</head>

<body>
    <div class="container-fluid h-100">
        <div class="row">
            <div class="col-md-6 col-sm-12 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <!-- Content for card 1 -->
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <!-- Content for card 2 -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <!-- Content for card 3 -->
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <!-- Content for card 4 -->
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

@endsection
@section('scripts')
<script src="{{url('vendors\chart-js-datalabel\chartjs-plugin-datalabels-new.js')}}"></script>
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
</script>
<script>



</script>
@endsection