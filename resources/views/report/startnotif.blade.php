@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Notifications</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
      </div><!-- /.container-fluid -->
@endsection
@section('content')

<div class="col-md-12"><hr></div>

<div class="table-responsive col-8">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="50%">Transactions</th>
                <th width="30%">Status</th>
                <th width="20%">Count</th>
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('report.table-startnotif')
        </tbody>
    </table>
</div>

@endsection

@section('scripts')
    <script>
       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }
    
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

@endsection