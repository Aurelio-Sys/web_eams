@extends('layout.newlayout')
@section('content-header')
      <div class="container-fluid">
        <div class="row">          
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">PM Confirm Maintenance</h1>
          </div>    
        </div><!-- /.row -->
        <div class="col-md-12 m-0">
            Menu ini digunakan untuk melakukan konfirmasi tanggal transaksi untuk preventive maintenance per asset dan per PM Code.
        </div>
      </div><!-- /.container-fluid -->
@endsection
@section('content')
<form action="/pmconf" method="GET">
<!-- Bagian Searching -->
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
                <label for="s_code" class="col-md-2 col-sm-2 col-form-label text-md-right">Asset</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_code" type="text" class="form-control" name="s_code" value="{{$s_code}}" autofocus autocomplete="off"/>
                </div>
                <label for="s_desc" class="col-md-2 col-sm-2 col-form-label text-md-right">PM</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_desc" type="text" class="form-control" name="s_desc" value="{{$s_desc}}" autofocus autocomplete="off"/>
                </div>
                <label for="s_loc" class="col-md-2 col-sm-2 col-form-label text-md-right">Location</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <select id="s_loc" class="form-control" name="s_loc">
                        <option value="">--Select Data--</option>
                        @foreach($dataloc as $dl)
                          <option value="{{$dl->asloc_code}}" {{$s_loc === $dl->asloc_code ? "selected" : ""}}>{{$dl->asloc_code}} -- {{$dl->asloc_desc}}</option>
                        @endforeach
                    </select>
                </div>
                <label for="s_loc" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    
                </div>
                <label for="s_date1" class="col-md-2 col-sm-2 col-form-label text-md-right">Date</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_date1" type="date" class="form-control" name="s_date1" value="{{$s_date1}}" autofocus autocomplete="off"/>
                </div>
                <label for="s_date2" class="col-md-2 col-sm-2 col-form-label text-md-right">To</label>
                <div class="col-md-4 col-sm-4 mb-2 input-group">
                    <input id="s_date2" type="date" class="form-control" name="s_date2" value="{{$s_date2}}" autofocus autocomplete="off"/>
                </div>
                <label for="btnsearch" class="col-md-2 col-sm-2 col-form-label text-md-right"></label>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <button class="btn btn-block btn-primary" id="btnsearch" style="float:right"/>Search</button>
                </div>
                <div class="col-md-2 col-sm-4 mb-2 input-group">
                    <button class="btn btn-block btn-primary" style="width: 40px !important" id='btnrefresh' /><i class="fas fa-sync-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<div class="col-md-12"><hr></div>
<form action="/pmtoconf" method="post" id="submit">
    {{ method_field('post') }}
    {{ csrf_field() }}
<div class="table-responsive col-12">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="10%">Asset Code</th>
                <th width="16%">Asset Desc</th>
                <th width="7%">Site</th>
                <th width="7%">Location</th>
                <th width="16%">Location Desc</th>
                <th width="10%">PM Code</th>
                <th width="15%">PM Desc</th>
                <th width="7%">Schedule Date</th>
                <th width="7%">Due Date</th>
                <th width="5%">Action</th>  
                <th width="5%">Source</th>  
            </tr>
        </thead>
        <tbody>
            <!-- untuk isi table -->
            {{--  @include('schedule.table-pmconf')  --}}
            @forelse($data as $show)
                @if(is_null($show->pma_leadtime))
                    @php($leadtime = 0)
                @else
                    @php($leadtime = $show->pma_leadtime)
                @endif
                @php($tglakhir = date_add(date_create($show->pmo_sch_date), date_interval_create_from_date_string(''.round($leadtime).' days')))
                <tr>
                    <td>{{$show->pmo_asset}}</td>
                    <td>{{$show->asset_desc}}</td>
                    <td>{{$show->asset_site}}</td>
                    <td>{{$show->asset_loc}}</td>
                    <td>{{$show->asloc_desc}}</td>
                    <td>{{$show->pmo_pmcode}}</td>
                    <td>{{$show->pmc_desc}}</td>
                    <td class="td_pmdate">@if($show->pmo_sch_date != "0000-00-00") {{date('d-m-Y', strtotime($show->pmo_sch_date))}} @endif</td>
                    <td>{{date_format($tglakhir,"d-m-Y")}} </td>

                    <td>
                        @if($show->pmo_number != "")
                            <input type="checkbox" name="cek[]" id="cek" class="cek" value="0">
                        @endif

                        <input type="hidden" name="tick[]" id="tick" class="tick" value="0">
                        <input type="hidden" name="he_wonbr[]" class="he_wonbr" value="{{$show->pmo_wonumber}}">
                        <input type="hidden" name="he_pick[]" class="he_pick" value="TEMP-PM">
                        <input type="hidden" name="te_asset[]" class="te_asset" value="{{$show->pmo_asset}}">
                        <input type="hidden" name="te_pmcode[]" class="te_pmcode" value="{{$show->pmo_pmcode}}">
                        <input type="hidden" name="te_pmdate[]" class="te_pmdate" value="{{$show->pmo_sch_date}}">
                        <input type="hidden" name="te_id[]" class="te_id" value="{{$show->id}}">

                        @if($show->pmo_wonumber != "" && $show->pmo_number != "")
                            <i class="icon-table fa fa-edit fa-lg detpmco"></i></a>
                        @endif

                    </td>
                    
                    <td>{{ $show->pmo_source == "PM Meter" ? "Meter" : "Cal" }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="color:red">
                        <center>No Data Available</center>
                    </td>
                </tr>
            @endforelse
            <tr>
            <td colspan="12" style="border: none !important;">
                {{--  {{ $data->appends($_GET)->links() }}  --}}
            </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal-footer">
    {{--  Checkbox untuk confirm ALL  --}}
    <input type="checkbox" id="t_all" name="t_all" value="1">
    <label for="t_all">Confirm All</label>

    <a class="btn btn-danger" href="/pmconf" id="btnback">Back</a>
    <button type="submit" class="btn btn-success bt-action" id="btnconf">Confirm</button>
    <button type="button" class="btn bt-action" id="btnloading" style="display:none">
        <i class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Loading
    </button>
</div>

</form>

@endsection

@section('scripts')
    <script>
        var counter = 1;

        function selectPicker() {
            $('.selectpicker').selectpicker().focus();
        }
       
        $(document).on('click', '#btnrefresh', function() {
            $('#s_code').val('');
            $('#s_desc').val('');
            $('#s_loc').val('');
            $('#s_date1').val('');
            $('#s_date2').val('');
        });   

          $(document).on('click', '.detpmco', function() { 
            var row = $(this).closest("tr");
            const code = row.find(".he_wonbr").val();

            $.ajax({
                url: '/getdetpmco',
                method: 'GET',
                data: {
                    code : code,
                },
                success: function(vamp) {
                    console.log(vamp);
                    // select elemen HTML tempat menampilkan tabel
                    const tableContainer = document.getElementById("thistablemodal");

                    // hapus tabel lama (jika ada)
                    if (tableContainer.hasChildNodes()) {
                       tableContainer.removeChild(tableContainer.firstChild);
                    }

                    // membuat elemen tabel
                    const table = document.createElement("table");
                    table.setAttribute("class", "table table-bordered table-hover");

                    // membuat header tabel
                    const headerRow = document.createElement("tr");
                    const headerColumns = ["Source", "Number", "Date", "Select"];
                    headerColumns.forEach((columnTitle) => {
                        const headerColumn = document.createElement("th");
                        headerColumn.textContent = columnTitle;
                        headerRow.appendChild(headerColumn);
                    });
                    table.appendChild(headerRow);

                    // membuat baris record untuk setiap objek dalam dataLocLotFrom
                    vamp.forEach((record) => {
                        const rowtable = document.createElement("tr");
                        const column = document.createElement("td"); //td pertama
                        column.textContent = "TEMP-PM";
                        rowtable.appendChild(column);
                        const column2 = document.createElement("td"); //td kedua
                        column2.textContent = record['det_pm_number'];
                        rowtable.appendChild(column2);
                        const colum3 = document.createElement("td"); //td ketiga
                        colum3.textContent = record['det_pm_date'];
                        rowtable.appendChild(colum3);
                        const selectColumn = document.createElement("td");
                        const selectButton = document.createElement("button");
                        selectButton.setAttribute("class", "btn btn-primary");
                        selectButton.textContent = "Select";
                        selectButton.setAttribute("type", "button");
                        selectButton.addEventListener("click", function() {
                            // aksi yang ingin dilakukan saat tombol select diklik

                            row.find(".he_pick").val("TEMP-PM");    // Mengembalikan nilai yang pilih
                            row.find(".tick").val("1");    // Mengembalikan nilai yang pilih
                            row.find(".cek").prop("checked", true);

                            // Mengubah warna text yang dipilih menjadi biru
                            {{--  row.find(".td_pmdate, .td_pmnumber").each(function() {
                                $(this).css({
                                  "color": "blue",
                                  "font-weight": "bold"
                                });
                            });  --}}

                            // Mengembalikan text lain yang tidak terpilih menjadi hitam
                            row.find(".td_wodate, .td_wonumber").each(function() {
                                $(this).css({
                                    "color": "black",
                                    "font-weight": "normal"
                                });
                            });

                            $('#editModal').modal('hide');
                        });
                        selectColumn.appendChild(selectButton);
                        rowtable.appendChild(selectColumn);
                        table.appendChild(rowtable);

                        //batas antar ROW

                        const rowtable2 = document.createElement("tr");
                        const column4 = document.createElement("td"); //td pertama
                        column4.textContent = "WO";
                        rowtable2.appendChild(column4);
                        const column5 = document.createElement("td"); //td kedua
                        column5.textContent = record['det_wo_number'];
                        rowtable2.appendChild(column5);
                        const colum6 = document.createElement("td"); //td ketiga
                        colum6.textContent = record['det_wo_date'];
                        rowtable2.appendChild(colum6);
                        const selectColumn2 = document.createElement("td");
                        const selectButton2 = document.createElement("button");
                        selectButton2.setAttribute("class", "btn btn-primary");
                        selectButton2.textContent = "Select";
                        selectButton2.setAttribute("type", "button");
                        selectButton2.addEventListener("click", function() {
                            
                            row.find(".he_pick").val("WO");     // Mengembalikan nilai yang pilih, memilih nomor WO yang akan di confirm
                            row.find(".tick").val("1");
                            row.find(".cek").prop("checked", true);

                            // Mengubah warna text yang dipilih menjadi biru
                            row.find(".td_wodate, .td_wonumber").each(function() {
                                $(this).css({
                                  "color": "blue",
                                  "font-weight": "bold"
                                });
                            });

                            // Mengembalikan text lain yang tidak terpilih menjadi hitam
                            {{--  row.find(".td_pmdate, .td_pmnumber").each(function() {
                                $(this).css({
                                    "color": "black",
                                    "font-weight": "normal"
                                });
                            });  --}}

                            $('#editModal').modal('hide');
                        });
                        selectColumn2.appendChild(selectButton2);
                        rowtable2.appendChild(selectColumn2);
                        table.appendChild(rowtable2);
                    });

                    // menampilkan tabel pada elemen HTML yang dituju
                    tableContainer.appendChild(table);

                    // memanggil modal setelah tabel dimuat
                    $('#editModal').modal('show');
                }
            });

          }); 

        $(document).on('change','#cek',function(e){
            var checkbox = $(this), // Selected or current checkbox
            value = checkbox.val(); // Value of checkbox

            if (checkbox.is(':checked'))
            {
                $(this).closest("tr").find('.tick').val(1);
            } else
            {
                $(this).closest("tr").find('.tick').val(0);
            }        
        });

        $(document).on('change', '#t_all', function(e) {
            var isChecked = $(this).prop('checked'); // Mendapatkan status centang checkbox "t_all"
        
            // Mengubah status centang semua checkbox "cek"
            $('.cek').prop('checked', isChecked);

            if(isChecked == true) {
                $('.tick').val(1);
            } else {
                $('.tick').val(0);
            }
            
        });
        


        $("#s_loc").select2({
            width : '100%',
            theme : 'bootstrap4',   
        });

    </script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

    <script>
        // $('#t_groupidtype').select2({
        //     width: '100%'
        // });
        // $('#te_groupidtype').select2({
        //     width: '100%'
        // });
    </script>
@endsection