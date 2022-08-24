@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row justify-content-between">
          <div>
                <h1>Overall Schedule</h1>
          </div>
          <div>
            Work Order Status  :  
            <span class="badge badge-primary">Planned</span>
            <span class="badge badge-danger">Open</span>
            <span class="badge badge-warning">Started</span>
            <span class="badge badge-success">Finish</span>
            <span class="badge badge-secondary">Closed</span>
          </div>
        </div><!-- /.row -->
        <div class="row justify-content-center">
            <h1 class="col-sm-6 text-dark">
                <a href="/allrpt?bulan={{$bulan}}&stat=mundur" ><i class="fas fa-angle-left"></i></a>
                &ensp;&ensp;{{$bulan}}&ensp;&ensp;
                <input type='hidden' name='bulan' id='bulan' value='{{$bulan}}'>
                <a href="/allrpt?bulan={{$bulan}}&stat=maju" ><i class="fas fa-angle-right"></i></a>
            </h1>
        </div>
      </div><!-- /.container-fluid -->
@endsection
@section('content')

<head>
    <title>Chart</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
</head>
<body>
<style>
    table {
        table-layout:fixed;
    }
    th {
        text-align: center;
    }
    td {
        width: 100px;
        height: 100px;
        text-align: right;
        overflow: auto;
    }
</style>
    <table class="table table-bordered">
    <thead class="table-info">
        <tr>
        <th scope="col">Monday</th>
        <th scope="col">Tuesday</th>
        <th scope="col">Wednesday</th>
        <th scope="col">Thursday</th>
        <th scope="col">Friday</th>
        <th scope="col">Saturday</th>
        <th scope="col">Sunday</th>
        </tr>
    </thead>
    <tbody>
        @php($i = 1)
        @php($stop = 0)
        @for($x = 1; $x <= 6; $x++)
        <tr>
            @if($i == 1)
                @for($z = 1; $z <= $kosong; $z++)
                    <td></td>
                @endfor
            @else 
                @php($z = 1)
            @endif
            @for($y = $z; $y <= 7; $y++)
                @if($i > $skrg)
                    <td></td>
                @else
                    @php($ds = $datawo->where('tgl','=',$i)->count())
                    <td>
                        {{$i}}
                        <br>
                        @if($ds == 1)
                            @php($ds = $datawo->where('tgl','=',$i)->first())
                            @include('report.allrpt-det')
                        @elseif($ds > 1)
                            @foreach($datawo as $ds)
                                @if($ds->tgl == $i)
                                    @include('report.allrpt-det')
                                @endif
                            @endforeach
                        @endif
                    </td>
                @endif
                @if($i == $skrg)
                    @php($stop = 1)
                    @break
                @else
                    @php($i += 1)
                @endif
            @endfor
            </tr>
            @if($stop == 1)
                @break
            @endif
        @endfor
    </tbody>
    </table>
    
</body>


<!--Modal View-->
<div class="modal fade" id="viewModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Work Order View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <input type="hidden" id="v_counter" value=0>
        <div class="modal-body">
          <div class="form-group row ">
            <label for="v_nowo" class="col-md-3 col-form-label text-md-left">Work Order Number</label>
            <div class="col-md-3">
              <input id="v_nowo" type="text" class="form-control" name="v_nowo"  autocomplete="off" readonly autofocus>
            </div>
         
            <label for="v_nosr" class="col-md-2 col-form-label text-md-right">SR Number</label>
            <div class="col-md-3">
              <input id="v_nosr" type="text" class="form-control" name="v_nosr"  readonly autofocus>
            </div>
          </div>
          <div class="form-group row ">
            <label for="v_engineer" class="col-md-3 col-form-label text-md-left">Engineer</label>
            <div class="col-md-8">
              <input type='text' id="v_engineer" class="form-control v_engineer" name="v_engineer"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="v_asset" class="col-md-3 col-form-label text-md-left">Asset</label>
            <div class="col-md-8">
              <input type="text" readonly id="v_asset" type="text" class="form-control v_asset" name="v_asset" autofocus >
            </div>
          </div>
          <!-- <div class="form-group row ">
            <label for="v_failure" class="col-md-3 col-form-label text-md-left">Failure Code</label>
            <div class="col-md-8">
              <textarea id="v_failure" class="form-control v_failure" autofocus readonly></textarea>
            </div>
          </div> -->
          <div class="form-group row ">
            <label for="v_note" class="col-md-3 col-form-label text-md-left">Note</label>
            <div class="col-md-8">
              <textarea id="v_note" class="form-control v_note" autofocus readonly></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="v_schedule" class="col-md-3 col-form-label text-md-left">Schedule Date</label>
            <div class="col-md-3">
              <input id="v_schedule" readonly type="date" class="form-control" name="v_schedule" value="{{ old('v_schedule') }}"   autofocus>
            </div>
          
            <label for="v_duedate" class="col-md-2 col-form-label text-md-right">Due Date</label>
            <div class="col-md-3">
              <input id="v_duedate" type="date" class="form-control" name="v_duedate" value="{{ old('v_duedate') }}"  autofocus readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="v_creator" class="col-md-3 col-form-label text-md-left">Created By</label>
            <div class="col-md-8">
              <input  id="v_creator" readonly  class="form-control" name="v_creator" value="{{ old('v_creator') }}"  autofocus>
            </div>
          </div>
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  
@endsection('content')

@section('scripts')
<script type="text/javascript">

    $(document).on('click', '.viewwo', function() {
        
        var wonbr       = $(this).data('wonbr');
        var srnbr       = $(this).data('srnbr');
        var asset       = $(this).data('woasset');
        var assdesc       = $(this).data('assdesc');
        var schedule       = $(this).data('schedule');
        var duedate       = $(this).data('duedate');
        var eng       = $(this).data('eng');
        var dfailure       = $(this).data('dfc');
        var creator       = $(this).data('creator');
        var note       = $(this).data('note');

        document.getElementById('v_nowo').value       = wonbr;
        document.getElementById('v_nosr').value       = srnbr;
        document.getElementById('v_asset').value      = asset+' -- '+assdesc;
        document.getElementById('v_schedule').value   = schedule;
        document.getElementById('v_duedate').value    = duedate;
        document.getElementById('v_engineer').value  = eng;
        // document.getElementById('v_failure').value   = dfailure;
        document.getElementById('v_creator').value    = creator;
        document.getElementById('v_note').value    = note;

    });

</script>
@endsection