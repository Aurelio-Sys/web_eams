@extends('layout.newlayout')

@section('content-header')
@endsection
@section('content')
<style>
    .square {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        height: 90%;
        border: 4px solid #FFFFFF; /* Ganti warna border di sini */
    }

    .card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
</style>

<!-- <div class="container" style="background-color: #7030A0 !important;"> -->
<div class="container">
    <div class="row">
        <div class="col-md-3 p-2">
            <!-- Konten untuk kotak pertama -->
            <a href="{{ route('trainSetup') }}" class="card-link">
                <div class="card d-flex align-items-center" style="border-radius: 50px; height: 25rem;">
                    <div class="card-body">
                        <h3 class="card-text text-center font-weight-bold">SETUP</h3>
                    </div>
                    <img class="p-3" style="border-radius: 50px;" src="{{asset('images/robot-setup.png')}}" height="300" width="165" alt="Card image cap">
                </div>
            </a>
        </div>
        <div class="col-md-3 p-2">
            <!-- Konten untuk kotak kedua -->
            <a href="{{ route('trainPlan') }}" class="card-link">
                <div class="card d-flex align-items-center" style="border-radius: 50px; height: 25rem;">
                    <div class="card-body">
                        <h3 class="card-text text-center font-weight-bold">PLAN</h3>
                    </div>
                    <img class="p-3" style="border-radius: 50px;" src="{{asset('images/plan-robot.png')}}" height="300" width="165" alt="Card image cap">
                </div>
            </a>
        </div>
        <div class="col-md-3 p-2">
            <!-- Konten untuk kotak ketiga -->
            <a href="{{ route('trainExecute') }}" class="card-link">
                <div class="card d-flex align-items-center" style="border-radius: 50px; height: 25rem;">
                    <div class="card-body">
                        <h3 class="card-text text-center font-weight-bold">EXECUTE</h3>
                    </div>
                    <img class="p-3" style="border-radius: 50px;" src="{{asset('images/execute-robot.png')}}" height="300" width="165" alt="Card image cap">
                </div>
            </a>
        </div>
        <div class="col-md-3 p-2">
            <!-- Konten untuk kotak keempat -->
            <a href="{{ route('trainAnalyze') }}" class="card-link">
                <div class="card d-flex align-items-center" style="border-radius: 50px; height: 25rem;">
                    <div class="card-body">
                        <h3 class="card-text text-center font-weight-bold">ANALYZE</h3>
                    </div>
                    <img class="p-3" style="border-radius: 50px;" src="{{asset('images/robot4.jpg')}}" height="300" width="165" alt="Card image cap">
                </div>
            </a>
        </div>
    </div>
</div>
@endsection




@section('scripts')
<script>
</script>
@endsection