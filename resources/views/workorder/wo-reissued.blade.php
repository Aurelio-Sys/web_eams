@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Work Order Finish Detail</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
<style type="text/css">
    .bootstrap-select .dropdown-menu {
        width: 400px !important;
        min-width: 400px !important;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .swal-popup {
        font-size: 2rem !important;
    }

    hr.new1 {
        border-top: 1px solid red !important;
    }

    .images {
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .images .img,
    .images .pic {
        flex-basis: 31%;
        margin-bottom: 10px;
        border-radius: 4px;
    }

    .images .img {
        width: 112px;
        height: 93px;
        background-size: cover;
        margin-right: 10px;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .images .img:nth-child(3n) {
        margin-right: 0;
    }

    .images .img span {
        display: none;
        text-transform: capitalize;
        z-index: 2;
    }

    .images .img::after {
        content: '';
        width: 100%;
        height: 100%;
        transition: opacity .1s ease-in;
        border-radius: 4px;
        opacity: 0;
        position: absolute;
    }

    .images .img:hover::after {
        display: block;
        background-color: #000;
        opacity: .5;
    }

    .images .img:hover span {
        display: block;
        color: #fff;
    }

    .images .pic {
        background-color: #DCDCD4;
        align-self: center;
        text-align: center;
        padding: 40px 0;
        text-transform: uppercase;
        color: whitesmoke;
        font-size: 12px;
        cursor: pointer;
    }
</style>
<div class="row">
    <div class="col-md-12">
    <form class="form-horizontal" id="newedit" method="post" action="/reissuedwofinish">
        {{ csrf_field() }}
        <div class="modal-body">
            <input type="hidden" id="v_counter">
            <input type="hidden" name="statuswo" id="statuswo">
            <div class="form-group row col-md-12">
                <div class="col-md-3 h-50">
                    <label for="c_wonbr" class="col-md-12 col-form-label text-md-left p-0">Work Order</label>
                </div>
                <div class="col-md-3 h-50">
                    <label for="c_srnbr" class="col-md-12 col-form-label text-md-left p-0">SR Number</label>
                </div>
                <div class="col-md-6 h-50">
                    <label for="c_asset" class="col-md-12 col-form-label text-md-left p-0">Asset</label>
                </div>
                <div class="col-md-3">
                    <input id="c_wonbr" type="text" class="form-control pl-0 col-md-12 c_wonbr" style="background:transparent;border:none;text-align:left" name="c_wonbr" value="{{$dataget->first()->wo_nbr}}" autofocus readonly>
                </div>
                <div class="col-md-3">
                    <input id="c_srnbr" type="text" class="form-control pl-0 col-md-12 c_srnbr" style="background:transparent;border:none;text-align:left" name="c_srnbr" value="{{$dataget->first()->wo_sr_nbr}}" autofocus readonly>
                </div>
                <div class="col-md-6">
                    <input id="c_asset" type="text" class="form-control pl-0 col-md-12 c_asset" style="background:transparent;border:none;text-align:left" name="c_asset" value="{{$dataget->first()->asset_desc}}" autofocus readonly>
                    <input id="c_assethid" type="hidden" class="form-control c_asset" name="c_assethidden">
                </div>

            </div>


                    <div id="testdivgroup">
                        <div class="form-group row col-md-12">
                            <label class="col-md-5 col-form-label text-md-left">Spare Part :</label>
                        </div>
                        <div class="table-responsive col-12">
                            <table class="table table-bordered mt-0" id="dataTable" width="100%" style="border:2px solid" cellspacing="0">
                                <thead>
                                    <tr style="text-align: center;border:2px solid">
                                        <th style="border:2px solid;width:5%;">
                                            <p style="height:100%">No</p>
                                        </th>
                                        <th style="border:2px solid;width:6%">
                                            <p style="height:100%">Repair Code</p>
                                        </th>
                                        <th style="border:2px solid;width:10%">
                                            <p style="height:100%">Inst. Code</p>
                                        </th>
                                        <th style="border:2px solid;width:10%">
                                            <p style="height:100%">Spare Part</p>
                                        </th>
                                        <th style="border:2px solid;width:30%">
                                            <p style="height:100%">Description</p>
                                        </th>
                                        <th style="border:2px solid;width:6%">
                                            <p style="height:100%">UM</p>
                                        </th>
                                        <!-- <th style="border:2px solid;width:10%">
                                            <p style="height:100%">Qty Required</p>
                                        </th> -->
                                        <th style="border:2px solid; width: 10%;">
                                            <p style="height:100%">Qty Issued</p>
                                        </th>
                                        <th style="border:2px solid; width: 10%;">
                                            <p style="height:100%">Qty Confirmed</p>
                                        </th>
                                        <th style="border:2px solid; width: 10%;">
                                            <p style="height:100%">Qty Re-issued</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    $y = 0;
                                    @endphp
                                    @forelse ( $dataget as $spdet )
                                    <tr>
                                        <td style="margin-top:0;min-height:50px;border:2px solid">
                                            {{$i++}}
                                        </td>
                                        <input type="hidden" name="wonbr_hidden[]" value="{{$spdet->wo_dets_nbr}}" />
                                        <td style="margin-top:0;min-height:50px;border:2px solid">
                                            {{$spdet->wo_dets_rc}}
                                            <input type="hidden" name="rc_hidden[]" value="{{$spdet->wo_dets_rc}}" />
                                            <input type="hidden" name="site_hidden[]" value="{{$spdet->	wo_dets_wh_tosite}}"/>
                                            <input type="hidden" name="loc_hidden[]" value="{{$spdet->	wo_dets_wh_toloc}}"/>
                                            <input type="hidden" name="lotserial[]" value="{{$spdet->wo_dets_wh_lot}}"/>
                                        </td>
                                        <td style="margin-top:0;min-height:50px;border:2px solid">
                                            {{$spdet->wo_dets_ins}}
                                            <input type="hidden" name="inscode_hidden[]" value="{{$spdet->wo_dets_ins}}" />
                                        </td>
                                        <td style="margin-top:0;min-height:50px;border:2px solid">
                                            {{$spdet->wo_dets_sp}}
                                            <input type="hidden" name="spcode_hidden[]" value="{{$spdet->wo_dets_sp}}" />
                                        </td>
                                        <td style="margin-top:0;min-height:50px;border:2px solid">
                                            {{$spdet->spm_desc}}
                                        </td>
                                        <td style="margin-top:0;min-height:50px;border:2px solid">
                                            {{($spdet->insd_um != null) ? $spdet->insd_um : $spdet->spm_um }}
                                        </td>
                                        <!-- <td style="margin-top:0;min-height:50px;border:2px solid">
                                            {{($spdet->insd_qty != null) ? $spdet->insd_qty : $spdet->wo_dets_wh_qty}}
                                        </td> -->
                                        <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid;">
                                            {{$spdet->wo_dets_qty_used}}
                                        </td>
                                        <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid;">
                                            {{($spdet->wo_dets_wh_qty != null) ? $spdet->wo_dets_wh_qty : '0' }}
                                        </td>
                                        <td style="text-align:center;vertical-align:middle;margin-top:0;border:2px solid;">
                                            <input type="number" step="1" min="0" class="form-control" style="width: 100%;" min="0.1" max="{{$spdet->wo_dets_wh_qty - $spdet->wo_dets_qty_used}}" name="qtyreissued[]" value="{{(old('qtyreissued.'.$y) !== null) ? old('qtyreissued.'.$y) : $spdet->wo_dets_wh_qty - $spdet->wo_dets_qty_used}}">
                                        </td>
                                    </tr>

                                    @php
                                        $y++;
                                    @endphp
                                    
                                    @empty
                                    <tr>
                                        <td colspan="12" style="color: red; text-align: center;">
                                            No Data Available
                                        </td>
                                    </tr>

                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>


        </div>

        <div class="modal-footer">
            <a href="/woreport" ><button type="button" class="btn btn-info bt-action" id="btnclose" data-dismiss="modal">Cancel</button></a>
            <button type="submit" class="btn btn-success bt-action" id="btnconf">Save</button>
            <button type="button" class="btn btn-info bt-action" id="btnloading" style="display:none">
                <i class="fas fa-spinner fa-spin"></i> &nbsp;Loading
            </button>
        </div>
    </form>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        console.log("ready!");

        // if (document.getElementById('argcheck').checked) {
        //     $('#argcheck').change();
        // }

        // if (document.getElementById('arccheck').checked) {
        //     $('#arccheck').change();
        // }

        $('#newedit').submit(function(event) {
            document.getElementById('btnconf').style.display = 'none';
            document.getElementById('btnclose').style.display = 'none';
            document.getElementById('btnloading').style.display = '';
        });



        uploadImage();

        $('#file-input').on('change', function() { //on file input change
            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {

                var data = $(this)[0].files; //this file data
                // console.log(data);
                $.each(data, function(index, file) { //loop though each file
                    if (/(\.|\/)(jpe?g|png)$/i.test(file.type)) { //check supported file type
                        var fRead = new FileReader(); //new filereader
                        fRead.onload = (function(file) { //trigger function on successful read
                            return function(e) {
                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element 
                                $('#thumb-output').append(img); //append image to output element
                            };
                        })(file);
                        fRead.readAsDataURL(file); //URL representing the file's data.
                    }
                });

                $("#thumb-output").on('click', '.thumb', function() {
                    $(this).remove();
                })

            } else {
                // alert("Your browser doesn't support File API!");
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: "Your browser doesn't support File API!",
                    toast: true,
                    showConfirmButton: false,
                    timer: 2000,
                }) //if File API is absent
            }
        });

    });

    function uploadImage() {
        var button = $('.images .pic')
        var uploader = $('<input type="file" accept="image/jpeg, image/png, image/jpg" />')
        var images = $('.images')
        var potoArr = [];
        var initest = $('.images .img span #imgname')

        button.on('click', function() {
            // alert('aaa');
            uploader.click();
        })

        uploader.on('change', function() {
            var reader = new FileReader();
            i = 0;
            reader.onload = function(event) {
                images.prepend('<div id="img" class="img" style="background-image: url(\'' + event.target.result + '\');" rel="' + event.target.result + '"><span>remove<input type="hidden" style="display:none;" id="imgname" name="imgname[]" value=""/></span></div>')
                // alert(JSON.stringify(uploader));
                document.getElementById('imgname').value = uploader[0].files.item(0).name + ',' + event.target.result;
                document.getElementById('hidden_var').value = 1;
            }
            reader.readAsDataURL(uploader[0].files[0])
            // potoArr.push(uploader[0].files[0]);

            // console.log(potoArr);
        })


        images.on('click', '.img', function() {
            $(this).remove();
        })

        // confirmPhoto(potoArr);
    }

    $('#repairgroup').select2({
        placeholder: "Select Data",
        width: '100%',
        theme: 'bootstrap4',
    });
    $('#repaircode1').select2({
        placeholder: "Select Data",
        width: '100%',
        theme: 'bootstrap4',
    });
    $('#repaircode2').select2({
        placeholder: "Select Data",
        width: '100%',
        theme: 'bootstrap4',
    });
    $('#repaircode3').select2({
        placeholder: "Select Data",
        width: '100%',
        theme: 'bootstrap4',
    });

    // $(document).on('change', '#arccheck', function(e) {
    //     // alert('aaa');
    //     document.getElementById('divrepair').style.display = '';
    //     document.getElementById('divgroup').style.display = 'none';
    //     // alert('aaa');
    //     $("#repairgroup").val(null).trigger('change');
    //     //$("#repaircode1").val(null).trigger('change');
    //     $("#repaircode2").val(null).trigger('change');
    //     $("#repaircode3").val(null).trigger('change');

    //     document.getElementById('repairtype').value = 'code';
    // });

    // $(document).on('change', '#argcheck', function(e) {
    //     document.getElementById('divgroup').style.display = '';
    //     document.getElementById('divrepair').style.display = 'none';
    //     $("#repairgroup").val(null).trigger('change');
    //     //$("#repaircode1").val(null).trigger('change');
    //     $("#repaircode2").val(null).trigger('change');
    //     $("#repaircode3").val(null).trigger('change');
    //     document.getElementById('repairtype').value = 'group';
    // });
</script>
@endsection