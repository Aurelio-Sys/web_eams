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
            grid-gap: 20px;
            /* This sets the gap between the cards */
            padding: 20px;
            /* This adds some spacing around the grid */
        }

        .card {
            background-color: white;
            /* The color for the card */
            border-radius: 15px;
            /* This makes the corners rounded */
            padding: 20px;
            /* Padding inside the cards */
            color: #1E90FF;
            font-weight: lighter;
            /* Text color inside the card */
        }

        /* For demonstration, we can force the first card to span two columns */
        .card:nth-child(3) {
            grid-column: span 2;
            grid-row: span 4;
        }

        .card:nth-child(1) {
            grid-row: span 2;
        }

        .card:nth-child(2) {
            grid-row: span 2;
        }

        .card:nth-child(4) {
            grid-row: span 2;
        }

        .card:nth-child(5) {
            grid-row: span 2;
        }
    </style>
</head>

<body>
    <!-- <div class="container-fluid h-100"> -->

    <!-- <div class="row">
            <div class="col-md-3 col-sm-12">
                <a href="/servicerequest" class="card h-100 text-decoration-none">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-tools fa-5x"></i> 
                        <h5 class="card-title text-center mt-3">Service Request Create</h5>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-12">
                <a href="/womaint" class="card h-100 text-decoration-none">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-cogs fa-5x"></i> 
                        <h5 class="card-title text-center mt-3">Work Order Maintenance</h5>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card h-100">
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-12">
                <div class="card h-100">
                    <div class="card-body">
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="card h-100">
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div> -->

    <div class="grid-container">
        <div class="card">
            <a href="/servicerequest" class="text-decoration-none">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fas fa-tools fa-5x"></i>
                    <h5 class="card-title text-center mt-3">Service Request Create</h5>
                </div>
            </a>
        </div>
        <div class="card">
            <a href="/womaint" class="text-decoration-none">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fas fa-cogs fa-5x"></i>
                    <h5 class="card-title text-center mt-3">Work Order Maintenance</h5>
                </div>
            </a>
        </div>
        <div class="card">

        </div>
        <div class="card">
            <!-- Year to Date Corrective Maitnenance -->
            

        </div>
        <div class="card">

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
</script>
<script>



</script>
@endsection