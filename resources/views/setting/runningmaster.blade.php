@extends('layout.newlayout')

@section('content-header')
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mt-2">
            <h1 class="m-0 text-dark">Running Number Maintenance</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Flash Menu -->
<div class="table-responsive col-lg-12 col-md-12">
            <form action="/updaterunning" method="post" onsubmit="return validateInput()">
                {{ csrf_field() }}
                <div class="modal-header">
                </div>
                <div class="modal-body">

                    <?php
                    // dd('');
                    
                    if($alert == null){
                        $datavaluesrprefix = "";
                        $datavaluewoprefix = "";
                        $datavaluewtprefix = "";
                        $datavaluewdprefix = "";
                        $datavalueboprefix = "";
                        $datavaluersprefix = "";
                        $datavaluertprefix = "";
                        $datavaluesrnbr = "";
                        $datavaluewonbr = "";
                        $datavaluewtnbr = "";
                        $datavaluewdnbr = "";
                        $datavaluebonbr = "";
                        $datavaluersnbr = "";
                        $datavaluertnbr = "";
                        $datayear = "";
                    }else{
                        $datavaluesrprefix = $alert->sr_prefix;
                        $datavaluewoprefix = $alert->wo_prefix;
                        $datavaluewtprefix = $alert->wt_prefix;
                        $datavaluewdprefix = $alert->wd_prefix;
                        $datavalueboprefix = $alert->bo_prefix;
                        $datavaluersprefix = $alert->rs_prefix;
                        $datavaluertprefix = $alert->rt_prefix;
                        $datavaluesrnbr = $alert->sr_nbr;
                        $datavaluewonbr = $alert->wo_nbr;
                        $datavaluewtnbr = $alert->wt_nbr;
                        $datavaluewdnbr = $alert->wd_nbr;
                        $datavaluebonbr = $alert->bo_nbr;
                        $datavaluersnbr = $alert->rs_nbr;
                        $datavaluertnbr = $alert->rt_nbr;
                        $datayear = $alert->year;
                    }
                    ?>

                    <!-- SR NUMBER  -->
                    <div class="form-group row" style="display: none;">
                        <label for="srprefix" class="col-md-3 col-form-label text-md-right">{{ __('Service Request Prefix') }}</label>
                        <div class="col-md-7">
                            <input id="srprefix" type="text" class="form-control" name="srprefix" maxlength="2" minlength="2" autocomplete="off"
                            value="<?php echo $datavaluesrprefix;?>"> 
                        </div>
                    </div>
                    <div class="form-group row" style="display: none;">
                        <label for="srnumber" class="col-md-3 col-form-label text-md-right">{{ __('Last Service Request Number') }}</label>
                        <div class="col-md-7">
                            <input id="srnumber" type="text" class="form-control" autocomplete="off" name="srnumber" value="<?php echo $datavaluesrnbr; ?>"  
                            maxlength="6" minlength="6">
                            <span id="errorcur" style="color:red"></span>
                        </div>
                    </div>

                    <!-- WO NUMBER -->
                    <div class="form-group row">
                        <label for="woprefix" class="col-md-3 col-form-label text-md-right">{{ __('Work Order Prefix') }}</label>
                        <div class="col-md-7">
                            <input id="woprefix" type="text" class="form-control" name="woprefix" maxlength="2" minlength="2" autocomplete="off"
                            value="<?php echo $datavaluewoprefix; ?>"> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wonbr" class="col-md-3 col-form-label text-md-right">{{ __('Last Work Order Number') }}</label>
                        <div class="col-md-7">
                            <input id="wonbr" type="text" class="form-control" autocomplete="off" name="wonbr" value="<?php echo $datavaluewonbr; ?>"  maxlength="6" minlength="6">
                            <span id="errorwo" style="color:red"></span>
                        </div>
                    </div>

                    <!-- WO OTOMATIS -->
                    <div class="form-group row">
                        <label for="wtprefix" class="col-md-3 col-form-label text-md-right">{{ __('Work Order Automatic Prefix') }}</label>
                        <div class="col-md-7">
                            <input id="wtprefix" type="text" class="form-control" name="wtprefix" maxlength="2" minlength="2" autocomplete="off"
                            value="<?php echo $datavaluewtprefix; ?>"> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wtnumber" class="col-md-3 col-form-label text-md-right">{{ __('Last Work Order Automatic Number') }}</label>
                        <div class="col-md-7">
                            <input id="wtnumber" type="text" class="form-control" autocomplete="off" name="wtnumber" value="<?php echo $datavaluewtnbr; ?>"  maxlength="6" minlength="6">
                            <span id="errorwt" style="color:red"></span>
                        </div>
                    </div>

                    <!-- WO DIRECT -->
                    <div class="form-group row" style="display: none;">
                        <label for="wdprefix" class="col-md-3 col-form-label text-md-right">{{ __('Work Order Direct Prefix') }}</label>
                        <div class="col-md-7">
                            <input id="wdprefix" type="text" class="form-control" name="wdprefix" maxlength="2" minlength="2" autocomplete="off"
                            value="<?php echo $datavaluewdprefix; ?>"> 
                        </div>
                    </div>
                    <div class="form-group row" style="display: none;">
                        <label for="wdnumber" class="col-md-3 col-form-label text-md-right">{{ __('Last Work Order Direct Number') }}</label>
                        <div class="col-md-7">
                            <input id="wdnumber" type="text" class="form-control" autocomplete="off" name="wdnumber" value="<?php echo $datavaluewdnbr; ?>"  maxlength="6" minlength="6">
                            <span id="errorwd" style="color:red"></span>
                        </div>
                    </div>

                    <!-- REQUEST SPAREPART 2023.05.21 -->
                    <div class="form-group row">
                        <label for="rsprefix" class="col-md-3 col-form-label text-md-right">{{ __('Request Sparepart Prefix') }}</label>
                        <div class="col-md-7">
                            <input id="rsprefix" type="text" class="form-control" name="rsprefix" maxlength="2" minlength="2" autocomplete="off"
                            value="<?php echo $datavaluersprefix; ?>"> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rsnumber" class="col-md-3 col-form-label text-md-right">{{ __('Last Request Sparepart Number') }}</label>
                        <div class="col-md-7">
                            <input id="rsnumber" type="text" class="form-control" autocomplete="off" name="rsnumber" value="<?php echo $datavaluersnbr; ?>"  maxlength="6" minlength="6">
                            <span id="errorrs" style="color:red"></span>
                        </div>
                    </div>

                    <!-- RETURN SPAREPART 2023.08.09 -->
                    <div class="form-group row">
                        <label for="rtprefix" class="col-md-3 col-form-label text-md-right">{{ __('Return Sparepart Prefix') }}</label>
                        <div class="col-md-7">
                            <input id="rtprefix" type="text" class="form-control" name="rtprefix" maxlength="2" minlength="2" autocomplete="off"
                            value="<?php echo $datavaluertprefix; ?>"> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rtnumber" class="col-md-3 col-form-label text-md-right">{{ __('Last Return Sparepart Number') }}</label>
                        <div class="col-md-7">
                            <input id="rtnumber" type="text" class="form-control" autocomplete="off" name="rtnumber" value="<?php echo $datavaluertnbr; ?>"  maxlength="6" minlength="6">
                            <span id="errorrt" style="color:red"></span>
                        </div>
                    </div>

                    <!-- ASSET BOOKING -->
                    <div class="form-group row">
                        <label for="boprefix" class="col-md-3 col-form-label text-md-right">{{ __('Asset Booking Prefix') }}</label>
                        <div class="col-md-7">
                            <input id="boprefix" type="text" class="form-control" name="boprefix" maxlength="2" minlength="2" autocomplete="off"
                            value="<?php echo $datavalueboprefix; ?>"> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bonumber" class="col-md-3 col-form-label text-md-right">{{ __('Last Asset Booking Number') }}</label>
                        <div class="col-md-7">
                            <input id="bonumber" type="text" class="form-control" autocomplete="off" name="bonumber" value="<?php echo $datavaluebonbr; ?>"  maxlength="6" minlength="6">
                            <span id="errorbo" style="color:red"></span>
                        </div>
                    </div>


                    <div class="form-group row" id='rowprefix'>
                        <label for="year" class="col-md-3 col-form-label text-md-right">{{ __('Tahun') }}</label>
                        <div class="col-md-7">
                            <input id="year" type="text" class="form-control" name="year" maxlength="2" minlength="2" autocomplete="off"
                            value="<?php echo $datayear; ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                <button type="submit" class="btn btn-success bt-action" id="btnconf">Save</button>
                <button type="button" class="btn bt-action" id="btnloading" style="display:none">
                    <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
                </button>
                </div>
        </form>
    </div>

@endsection

@section('scripts')
<script>
    $(document).on('blur','#srnumber',function(){ // Click to only happen on announce links
       
       //alert('tst');
       var isi = document.getElementById("srnumber").value;
       var nbr = isi.length;

       var isnum = /^\d+$/.test(isi);
       
       if(nbr > 6){
         document.getElementById("errorcur").innerHTML = 'Current Number Must Be 6 Digits';
         document.getElementById("srnumber").focus();
         return false;
       }else if(nbr < 6){
         document.getElementById("errorcur").innerHTML = 'Current Number Must Be 6 Digits';
         document.getElementById("srnumber").focus();

       }else if(!isnum){
         document.getElementById("errorcur").innerHTML = 'Current Number Must Be 6 Digits';
         document.getElementById("srnumber").focus();
         return false;
       }else{
         document.getElementById("errorcur").innerHTML = ''; 
       }
   });

   //Tommy 13/10/2020
   $(document).on('blur', '#wonbr', function(){

       var isi = document.getElementById("wonbr").value;
       var nbr = isi.length;

       var isnum = /^\d+$/.test(isi);

       if(nbr > 6){
         document.getElementById('errorwo').innerHTML = 'Current Number Must Be 6 Digits';
         document.getElementById('wonbr').focus();
         return false;
       }else if(nbr < 6){
         document.getElementById('errorwo').innerHTML = 'Current Number Must Be 6 Digits';
         document.getElementById('wonbr').focus();
         return false;
       }else if(!isnum){
         document.getElementById('errorwo').innerHTML = 'Current Number Must Be 6 Digits';
         document.getElementById('wonbr').focus();
         return false;
       }else{
         document.getElementById('errorwo').innerHTML = '';
       }
   });


    $(document).on('blur', '#wtnumber', function(){

      var isi = document.getElementById("wtnumber").value;
      var nbr = isi.length;

      var isnum = /^\d+$/.test(isi);

      if(nbr > 6){
        document.getElementById('errorwt').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('wtnumber').focus();
        return false;
      }else if(nbr < 6){
        document.getElementById('errorwt').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('wtnumber').focus();
        return false;
      }else if(!isnum){
        document.getElementById('errorwt').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('wtnumber').focus();
        return false;
      }else{
        document.getElementById('errorwt').innerHTML = '';
      }
    });


    $(document).on('blur', '#wdnumber', function(){

      var isi = document.getElementById("wdnumber").value;
      var nbr = isi.length;

      var isnum = /^\d+$/.test(isi);

      if(nbr > 6){
        document.getElementById('errorwd').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('wdnumber').focus();
        return false;
      }else if(nbr < 6){
        document.getElementById('errorwd').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('wdnumber').focus();
        return false;
      }else if(!isnum){
        document.getElementById('errorwd').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('wdnumber').focus();
        return false;
      }else{
        document.getElementById('errorwd').innerHTML = '';
      }
    });

    $(document).on('blur', '#rsnumber', function(){

      var isi = document.getElementById("rsnumber").value;
      var nbr = isi.length;

      var isnum = /^\d+$/.test(isi);

      if(nbr > 6){
        document.getElementById('errorrs').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('rsnumber').focus();
        return false;
      }else if(nbr < 6){
        document.getElementById('errorrs').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('rsnumber').focus();
        return false;
      }else if(!isnum){
        document.getElementById('errorrs').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('rsnumber').focus();
        return false;
      }else{
        document.getElementById('errorrs').innerHTML = '';
      }
    });

    $(document).on('blur', '#rtnumber', function(){

      var isi = document.getElementById("rtnumber").value;
      var nbr = isi.length;

      var isnum = /^\d+$/.test(isi);

      if(nbr > 6){
        document.getElementById('errorrt').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('rtnumber').focus();
        return false;
      }else if(nbr < 6){
        document.getElementById('errorrt').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('rtnumber').focus();
        return false;
      }else if(!isnum){
        document.getElementById('errorrt').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('rtnumber').focus();
        return false;
      }else{
        document.getElementById('errorrt').innerHTML = '';
      }
    });

    $(document).on('blur', '#bonumber', function(){

      var isi = document.getElementById("bonumber").value;
      var nbr = isi.length;

      var isnum = /^\d+$/.test(isi);

      if(nbr > 6){
        document.getElementById('errorbo').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('bonumber').focus();
        return false;
      }else if(nbr < 6){
        document.getElementById('errorbo').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('bonumber').focus();
        return false;
      }else if(!isnum){
        document.getElementById('errorbo').innerHTML = 'Current Number Must Be 6 Digits';
        document.getElementById('bonumber').focus();
        return false;
      }else{
        document.getElementById('errorbo').innerHTML = '';
      }
    });

    function validateInput() {
      var woprefix = document.getElementById("woprefix").value;
      var wtprefix = document.getElementById("wtprefix").value;
      var rsprefix = document.getElementById("rsprefix").value;
      var rtprefix = document.getElementById("rtprefix").value;
      var boprefix = document.getElementById("boprefix").value;

      // Regular expression to match only letters and numbers
      var pattern = /^[A-Z0-9]*$/;

      if (woprefix.length !== 2 || !pattern.test(woprefix)) {
          alert("The Work Order Prefix must consist of 2 uppercase alphanumeric characters without spaces or special characters.");
          return false;
      }

      if (wtprefix.length !== 2 || !pattern.test(wtprefix)) {
        alert("The Work Order Automatic Prefix must consist of 2 uppercase alphanumeric characters without spaces or special characters.");
        return false;
      }

      if (rsprefix.length !== 2 || !pattern.test(rsprefix)) {
        alert("The Request Sparepart Prefix must consist of 2 uppercase alphanumeric characters without spaces or special characters.");
        return false;
      }

      if (rtprefix.length !== 2 || !pattern.test(rtprefix)) {
        alert("The Return Sparepart Prefix must consist of 2 uppercase alphanumeric characters without spaces or special characters.");
        return false;
      }

      if (boprefix.length !== 2 || !pattern.test(boprefix)) {
        alert("The Asset Booking Prefix must consist of 2 uppercase alphanumeric characters without spaces or special characters.");
        return false;
      }

      return true;
  }
</script>
@endsection