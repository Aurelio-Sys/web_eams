@extends('layout.newlayout')

@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Asset Measurement Reporting</h1>
          </div><!-- /.col -->
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Asset Measurement Reporting</li>
            </ol>
          </div>/.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection

@section('content')
<!-- Flash Menu -->

<!--FORM Search Disini-->
<form action="/usagemt" method="GET">
<div class="col-12 form-group row">
  <label for="s_nomorwo" class="col-md-2 col-form-label text-md-left">{{ __('Asset') }}</label>
  <div class="col-md-4 col-sm-12 mb-2 input-group">
    <select name="asset" id="asset" class="form-control">
            <option value="">-- Select Data --</option>
        @foreach($asset as $asset)
            <option value="{{$asset->asset_code}}">{{$asset->asset_code}} - {{$asset->asset_desc}} - {{$asset->asloc_desc}}</option>
        @endforeach
    </select>
  </div>
  <label for="" class="col-md-2 col-form-label text-md-right">{{ __('') }}</label>
  <div class="col-md-2 col-sm-12 mb-2 input-group">
    <button class="btn btn-block btn-primary" id="btnsearch" style="float:right"/>Search</button>
  </div>
  <div class="col-md-2 col-sm-12 mb-2 input-group">
    <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
  </div>
</div>
</form>


<div class="table-responsive col-12 mt-0 pt-0 align-top" style="overflow-x: auto; display: block;white-space: nowrap;">
  <table class="table table-bordered mt-0" id="dataTable" width="100%" cellspacing="0" style="width:100%;padding: .2rem !important;">
    <thead>
      <tr style="text-align: center;">
        <th class="sorting" width="10%">Asset Code</th>
        <th class="sorting" width="20%">Asset Description</th>
        <th class="sorting" width="20%">Location</th>
        <th class="sorting" width="5%">UM</th>
        <th class="sorting" width="10%">Last Date Measurement</th>
        <th class="sorting" width="10%">Last Measurement</th>
        <th width="10%">Action</th>
      </tr>
    </thead>
    <tbody>
        @include('schedule.table-usage')
    </tbody>
  </table>
  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="asset_mstr.asset_code" />
  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
</div>

<!--Modal Edit-->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Asset Measurement Reporting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="new" method="post" action="updateusage" autocomplete="off">
          {{ csrf_field() }}
          <div class="form-group row col-md-12">
            <label for="e_asset" class="col-md-4 col-form-label text-md-left">Asset</label>
            <div class="col-md-8">
              <input id="e_asset" type="text" class="form-control e_asset" name="e_asset" readonly>
            </div>
          </div>

          <div class="form-group row col-md-12">
            <label for="e_assetdesc" class="col-md-4 col-form-label text-md-left">Asset Desc</label>
            <div class="col-md-8">
              <input id="e_assetdesc" type="text" class="form-control e_assetdesc" name="e_assetdesc" readonly>
            </div>
          </div>

          <div class="form-group row col-md-12">
            <label for="e_loc" class="col-md-4 col-form-label text-md-left">Location</label>
            <div class="col-md-8">
              <input id="e_loc" type="text" class="form-control e_loc" name="e_loc" readonly>
            </div>
          </div>

          <div class="form-group row col-md-12">
            <label for="e_usage" class="col-md-4 col-form-label text-md-left">Last Measurement Date</label>
            <div class="col-md-8">
              <input id="e_usage" type="text" class="form-control e_usage" name="e_usage" readonly>
            </div>
          </div>

          <div class="form-group row col-md-12">
            <label for="e_checked" class="col-md-4 col-form-label text-md-left">Last Measurement</label>
            <div class="col-md-5">
              <input id="e_checked" type="text" class="form-control e_checked" name="e_checked" readonly>
            </div>
            <div class="col-md-3">
              <input id="e_meterum" type="text" class="form-control e_meterum" name="e_meterum" readonly>
            </div>
          </div>

          <div class="form-group row col-md-12">
            <label for="e_date" class="col-md-4 col-form-label text-md-left">Date Time Measurement</label>
            <div class="col-md-4">
              <input id="e_date" type="date" class="form-control e_date" name="e_date" required >
            </div>
            <div class="col-md-4">
              <input id="e_time" type="time" class="form-control e_time" name="e_time">
            </div>
          </div>

          <div class="form-group row col-md-12">
            <label for="e_current" class="col-md-4 col-form-label text-md-left">Current Measurement</label>
            <div class="col-md-8">
              <input id="e_current" type="number" step="0.01" class="form-control e_current" name="e_current" autofocus required>
            </div>
          </div>
          
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success bt-action" id="btnconf">Save</button>
        <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
          <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
        </button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="loadingtable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <h1 class="animate__animated animate__bounce" style="display:inline;width:100%;text-align:center;color:white;font-size:larger;text-align:center">Loading...</h1>      
    </div>
</div>

@endsection

@section('scripts')
<script>
    $('#asset').select2({
        placeholder: "Select Data",
        width:'100%',
        theme: 'bootstrap4',
    });
    
    {{--  $("#new").submit(function() {
        document.getElementById('btnclose').style.display = 'none';
        document.getElementById('btnconf').style.display = 'none';
        document.getElementById('btnloading').style.display = '';
    });  --}}

    function clear_icon() {
        $('#id_icon').html('');
        $('#post_title_icon').html('');
    }

    $(document).on('click', '.editmodal',function(){
        asset = $(this).data('asset');
        lastusage = $(this).data('lastusage');
        lastdate = $(this).data('lastdate');
        desc = $(this).data('desc');
        meterum = $(this).data('meterum');
        assetloc = $(this).attr('data-assetloc');
{{--  alert(lastdate);  --}}
        document.getElementById('e_asset').value = asset;
        document.getElementById('e_assetdesc').value = desc;
        document.getElementById('e_loc').value = decodeURIComponent(assetloc);
        document.getElementById('e_usage').value = lastdate;
        document.getElementById('e_checked').value = lastusage.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        document.getElementById('e_meterum').value = meterum;

    });

</script>
@endsection