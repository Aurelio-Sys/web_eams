@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-8">
            <div class="d-flex justify-content-between">
                <h1 class="m-0 text-dark">Asset Report</h1>
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')

<style type="text/css">
  img {
      display:block;
      margin-left: auto;
      margin-right: auto;
      max-width: 180px;
      height: 200px;
      margin-top:10px;
  }
  canvas {
      width: 100% !important;
      max-width: 800px;
      height: auto !important;
  }

  .chart-pie {
    position: relative;
    margin: auto;
    height: 65vh;
    width: 80vh;
  }
</style>

<!--FORM Search Disini -->
<form action="/assetrpt" method="GET">
    <div class="row">
        <div class="col-md-12">
          <button type="button" class="btn btn-block bg-black rounded-0" data-toggle="collapse" data-target="#collapseExample">Click Here To Search</button>
        </div>  
    </div>
    <!-- Element div yang akan collapse atau expand -->
    <div class="collapse" id="collapseExample">
        <!-- Isi element div dengan konten yang ingin ditampilkan saat collapse diaktifkan -->
        <div class="card card-body bg-black rounded-0">
        <div class="col-12 form-group row">
            <!--FORM Search Disini-->
            <label for="s_type" class="col-md-2 col-form-label text-md-right">{{ __('Type') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
                <select id="s_type" class="form-control" style="color:black" name="s_type" autofocus autocomplete="off">
                <option value="">--</option>
                <option value="PM" {{$stype === "PM" ? "selected" : ""}}>PM</option>
                <option value="WO" {{$stype === "WO" ? "selected" : ""}}>WO</option>
                </select>
            </div>
            <label for="s_asset" class="col-md-2 col-form-label text-md-right">{{ __('Asset') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_asset" class="form-control" style="color:black" name="s_asset" autofocus autocomplete="off">
                <option value="">--Select Asset--</option>
                @foreach($dataAsset2 as $assetsearch)
                <option value="{{$assetsearch->asset_code}}" {{$assetsearch->asset_code === $sasset ? "selected" : ""}}>{{$assetsearch->asset_code}} -- {{$assetsearch->asset_desc}}</option>
                @endforeach
            </select>
            </div>
            <label for="s_loc" class="col-md-2 col-form-label text-md-right">{{ __('Location') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_loc" class="form-control" style="color:black" name="s_loc" autofocus autocomplete="off">
                <option value="">--Select Location--</option>
                @foreach($dataloc as $dl)
                <option value="{{$dl->asloc_code}}" {{$dl->asloc_code === $sloc ? "selected" : ""}}>{{$dl->asloc_code}} -- {{$dl->asloc_desc}}</option>
                @endforeach
            </select>
            </div>
            <label for="s_eng" class="col-md-2 col-form-label text-md-right">{{ __('Engineer') }}</label>
            <div class="col-md-4 col-sm-12 mb-2 input-group">
            <select id="s_eng" class="form-control" style="color:black" name="s_eng" autofocus autocomplete="off">
                <option value="">--Select Engineer--</option>
                @foreach($dataeng as $de)
                <option value="{{$de->eng_code}}" {{$de->eng_code === $seng ? "selected" : ""}}>{{$de->eng_code}} -- {{$de->eng_desc}}</option>
                @endforeach
            </select>
            </div>
            <div class="col-md-2 col-sm-12 mb-2 input-group">
            <button class="btn btn-block btn-primary" id="btnsearch" style="float:right"/>Search</button>
            </div>
            <div class="col-md-1 col-sm-6 mb-1 input-group justify-content-md-center">
            <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh'/><i class="fas fa-sync-alt"></i></button>
            </div>
        </div>
        </div>
    </div>
</form>

<div class="col-md-12"><hr></div>

<div class="row">
  @php($line = 1)
  @foreach($dataAsset as $de)
      
      @if($line == 1)
        <div class="card-deck mb-3 col-12">
      @endif
      
      @php($jmlwo = $datawo->where('wo_asset_code','=',$de->asset_code)->count())


      <div class="col-xl-3 col-lg-5 col-md-4 col-xs-12 pl-0 pr-0" >
        <div class="card" style="height:100%">
          <div style="height:55%">
            <a href="" class="editarea2" id='editdata' data-toggle="modal" data-target="#editModal"
              data-code="{{$de->asset_code}}" data-desc="{{$de->asset_desc}}">
              <img class="card-img-top" src="/uploadassetimage/{{$de->asset_image}}" alt="Card image cap" width="200" height="200" >
            </a>
            <input type="hidden" name="code" id="code" value="{{$de->asset_code}}">
          </div>
          <div style="height:30%">
              <div class="card-body">
                <p class="card-text">
                  <small class="font-weight-bold">
                  <br>{{$de->asset_code}}
                  <br>{{$de->asset_desc}}
                  <br>{{$de->asloc_desc}}
                  <br>Work Order : {{$jmlwo}}
                  </small>
                </p>
              </div>
          </div>
        </div>
      </div>
      
      @php($line++)
      
      @if($line == 5)
        </div>
        <br>
        @php($line = 1)
      @endif
  @endforeach
    </div>
</div>

<!-- Modal View -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-center" id="exampleModalLabel">Asset Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
    	    </div>
         	<div class="panel-body">
              	<div class="modal-body">
                	<div class="form-group row col-md-12">
                        <label for="e_code" class="col-md-1 col-form-label text-md-right">{{ __('ID') }}</label>
                        <div class="col-md-4">
                            <input id="e_code" type="text" class="form-control" name="e_code" readonly="true">
                        </div>
                        <label for="e_desc" class="col-md-1 col-form-label text-md-right">{{ __('Name') }}</label>
                        <div class="col-md-6">
                            <input id="e_desc" type="text" class="form-control" name="e_desc" readonly="true">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table width="100%" id='assetTable' class='table table-striped table-bordered dataTable no-footer order-list mini-table' style="table-layout: fixed;">
                            <thead>
                              <tr id='full'>
                                <th width="15%">WO Number</th>
                                <th width="35%">Asset</th>
                                <th width="25%">Engineer</th>
                                <th width="15%">WO Schedule</th>
                                <th width="10%">Status</th>
                              </tr>
                            </thead>
                            <tbody id='detailapp'>
                            </tbody>
                        </table>
                    </div> 
                    <div class="chart-pie pt-4 pb-2 col-12">
                       <canvas id="myexpitm" width="568" height="400"></canvas>
                  </div>      
              	</div>	              									
            </div>    

          	<div class="modal-footer">
    	        <button type="button" class="btn btn-info bt-action" id="e_btnclose" data-dismiss="modal">Close</button>
    	    </div>
		</div>
	</div>
</div>


@endsection('content')

@section('scripts')
<script>
function noexpitm(event, array){
        if(array[0]){
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
</script>

    <script>

      $("#s_loc").select2({
        width : '100%',
        theme : 'bootstrap4',
      });
      $("#s_asset").select2({
          width : '100%',
          theme : 'bootstrap4',
      });
      $("#s_eng").select2({
          width : '100%',
          theme : 'bootstrap4',
      });

      $(document).on('click', '#btnrefresh', function() {
        document.getElementById('s_asset').value  = '';
        document.getElementById('s_type').value  = '';
        document.getElementById('s_loc').value  = '';
        document.getElementById('s_eng').value  = '';
      }); 


       $(document).on('click', '#editdata', function(e){

           var code = $(this).data('code');
           var desc = $(this).data('desc');

           document.getElementById('e_code').value = code;
           document.getElementById('e_desc').value = desc;

           $.ajax({
              url:"assetrptview?code="+code,
              success: function(data) {
              // console.log(data);
              //alert(data);
              $('#detailapp').html('').append(data);
            }
          })

       });
        
      $('#editModal').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);
        var modal = $(this);
        var canvas = modal.find('.chart-pie canvas');
        

        // Chart initialisieren
        var ctx = canvas[0].getContext("2d");
        var chart = new Chart(ctx, {
            type: 'bar',
            responsive: false,
            data: {    
              
              labels: <?php echo json_encode($arraynewdate); ?>,       
              datasets: [
                {
                  label: 'Asset maintenance per month',
                  backgroundColor: '#90C4FF',
                  pointHoverBackgroundColor: '#fff',
                  borderWidth: 2,
                  data: [1,1,1,3]
              }
            ]
            },
             options: {
              enable3D: true,
              responsive: true,
              scales: {
                  xAxes: [{
                    gridLines: {
                      drawOnChartArea: false,
                    }
                  }],
                  yAxes: [ {
                        ticks: {
                          beginAtZero: true,
                        }
                  }]
              },

            },
        });

        var code = $(event.relatedTarget).data('code');
        console.log(code);

        $.ajax({
            url:"assetgraf?code="+code,
            success: function(data) {
              console.log(data.message);

              var arr_tmp1 = data.message.split(',');
              console.log(arr_tmp1);

              
              chart.data.datasets[0].data = arr_tmp1;
              
              chart.update();
          }
        })

        
    });

    </script>

    <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script> -->
@endsection