@extends('layout.newlayout')

@section('content-header')
@endsection
@section('content')
<style>
    .card-link1 {
        text-decoration: none;
        color: inherit;
        display: block;
        color: white;
        font-weight: bold;
    }

    .card-link2 {
        text-decoration: none;
        color: inherit;
        display: block;
        font-weight: bold;
    }

    .card-link3 {
        text-decoration: none;
        color: inherit;
        display: block;
        color: white;
        font-weight: bold;
    }
</style>
<div class="container d-flex justify-content-center flex-column" style="background-color: white; height: 32rem; ">
    <div class="row">
        <div class="col-md-6" style="width: 30rem;">
            <h1 class="card-text text-right font-weight-bold" style="color: #5B9BD5; position: absolute; bottom: 0; left: 0; right: 0;">PLAN</h1>
        </div>
        <div class="col-md-6" style="width: 30rem;">
            <img src="{{asset('images/plan-pic.png')}}" height="220" width="150" alt="Card image cap">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 d-flex align-items-center justify-content-center">
            <div class="card" style="border-radius: 30px; height: 10rem; width: 30rem; background-color: #FFD966; box-shadow: 0 4px 8px rgba(0, 0, 0, 1) !important;">
                <div class="card-body text-center">
                    <a class="card-link2" href="/rcmmstr" target="_blank">Register routine assets check</a>
                    <a class="card-link2" href="/viewwogenerator" target="_blank">Generate asset maintenance plans</a>
                    <a class="card-link2" href="/pmconf" target="_blank">Maintenance plans confirmation</a>
                    <a class="card-link2" href="/needsp" target="_blank">Generate spare part requirements</a>
                    <a class="card-link2" href="#" target="_blank">Send spare part requirements to purchase</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
</script>
@endsection