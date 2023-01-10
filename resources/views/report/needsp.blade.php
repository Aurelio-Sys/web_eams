@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Sparepart Needs</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12">
          <hr>
        </div>
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="{{route('generateSO')}}" method="post" id="genso">
    {{ method_field('post') }}
    {{ csrf_field() }}
    <div class="row mb-4">
        <label for="site_genso" class="col-form-label col-md-1 text-md-left">Site</label>
        <div class="col-md-3">
            <select class="form-control" id="site_genso" name="site_genso" required>
                    <option></option>
                @foreach ( $datasite as $site )
                    <option value="{{$site->site_code}}">{{$site->site_code}} -- {{$site->site_desc}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" id="btngenso" class="btn btn-primary">Generate SO</button>
            <button type="button" class="btn btn-info" id="btnloading" style="display:none;">
                <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
        </div>
    </div>
</form>
<!--FORM Search Disini -->

<div class="row">
    <div class="container-fluid mb-2">
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
                    <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Department Code</label>
                    <div class="col-md-4 mb-2 input-group">
                        <input id="s_code" type="text" class="form-control" name="s_code"
                        value="" autofocus autocomplete="off"/>
                    </div>
                    <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">Department Description</label>
                    <div class="col-md-4 mb-2 input-group">
                        <input id="s_desc" type="text" class="form-control" name="s_desc"
                        value="" autofocus autocomplete="off"/>
                    </div>
                    <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-left">{{ __('') }}</label>
                    <div class="col-md-2 mb-2 input-group">
                        <input type="button" class="btn btn-block btn-primary" id="btnsearch" value="Search" />
                    </div>
                    <div class="col-md-2 col-sm-12 mb-2 input-group">
                        <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
                    </div>
                    <input type="hidden" id="tmpcode"/>
                    <input type="hidden" id="tmpdesc"/>
                </div>
            </div>
        </div>
</div>

<!-- Bagian Searching -->
<div class="col-md-12"><hr></div>

<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="10%">No WO</th>
                <th width="10%">Sechedule Date</th>
                <th width="10%">Status</th>
                <th width="15%">Sparepart</th>
                <th width="25%">Desc</th>  
                <th width="10%">Qty Req</th>  
                <th width="10%">Qty Whs</th>  
                <th width="10%">Qty Needed</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            @include('report.table-needsp')
        </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="dept_code"/>
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#genso').submit(function(event) {
                // alert('aa');
                document.getElementById('btngenso').style.display = 'none';
                document.getElementById('btnloading').style.display = '';
            });
        });

       function clear_icon()
       {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
       }

       

       $('#site_genso').select2({
            width:'100%',
            placeholder: 'Select Site',
            allowClear: true,
       });

       function fetch_data(page, sort_type, sort_by, code, desc){
            $.ajax({
                url:"prevsch/pagination?page="+page+"&sorttype="+sort_type+"&sortby="+sort_by+"&code="+code+"&desc="+desc,
                success:function(data){
                    console.log(data);
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            })
        }

        $(document).on('click', '#btnsearch', function(){

            var code = $('#s_code').val();
            var desc = $('#s_desc').val();
            var column_name = $('#hidden_column_name').val();
			var sort_type = $('#hidden_sort_type').val();
            var page = 1;
            
            document.getElementById('tmpcode').value = code;
            document.getElementById('tmpdesc').value = desc;

            fetch_data(page, sort_type, column_name, code, desc);
        });

       $(document).on('click', '#btnrefresh', function() {

            var code  = ''; 
            var desc = '';

            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();
            var page = 1;

            document.getElementById('s_code').value  = '';
            document.getElementById('s_desc').value  = '';
            document.getElementById('tmpcode').value  = code;
            document.getElementById('tmpdesc').value  = desc;

            fetch_data(page, sort_type, column_name, code, desc);
        });

        {{--  document.getElementById('bulandisplay').innerHTML='{{ $bulan }}';  --}}

        $(document).ready(function() {
            var cur_url = window.location.href;
    
            let paramString = cur_url.split('?')[1];
            let queryString = new URLSearchParams(paramString);
    
            {{--  let asset = queryString.get('s_asset');
            let priority = queryString.get('s_priority');
    
            $('#s_asset').val(asset).trigger('change');
            $('#s_priority').val(priority).trigger('change');  --}}
        });
    
    
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

@endsection