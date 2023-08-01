@extends('layout.newlayout')
@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <h1 class="m-0 text-dark">Return Sparepart</h1>
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
</style>
<form id="submitsearch" action="/searchaccutrf" method="get">
    <div class="row">
        <div class="form-group row col-md-12">
            <label class="col-md-2 col-form-label text-md-right">Asset Site</label>
            <div class="col-md-3">
                <select class="form-control" id="site_search" name="site_search" >
                    <option></option>
                    @foreach ( $datasite as $as )
                        <option value="{{$as->assite_code}}">{{$as->assite_code}} -- {{$as->assite_desc}}</option>
                    @endforeach
                </select>
            </div>
            <label class="col-md-2 col-form-label text-md-right">Sparepart</label>
            <div class="col-md-3">
                <select class="form-control" id="spsearch" name="spsearch" >
                    <option></option>
                    @foreach ( $datasp as $sp )
                        <option value="{{$sp->spm_code}}">{{$sp->spm_code}} -- {{$sp->spm_desc}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-secondary" id="searchbtn">Search</button>
            </div>
        </div>
    </div>
</form>

<span id="errorMessage" style="color: red;"></span>

@endsection

@section('scripts')
<script type="text/javascript">
    var counter = 1;

    function selectPicker() {
        $('.selectpicker').selectpicker().focus();
    }

    $(document).ready(function() {

        $('#site_search').select2({
            placeholder: 'Select Asset Site',
            width: '100%',
            theme: 'bootstrap4',
            allowClear: true,
            closeOnSelect: true,
            templateSelection: function (data, container) {
                // Memotong teks opsi menjadi 20 karakter
                var text = data.text.slice(0, 20);
                // Mengembalikan teks opsi yang sudah dipotong dan menambahkan tanda elipsis
                return text + (data.text.length > 20 ? '...' : '');
            }
        });

        $('#spsearch').select2({
            placeholder: 'Select Asset Site',
            width: '100%',
            theme: 'bootstrap4',
            allowClear: true,
            closeOnSelect: true,
            templateSelection: function (data, container) {
                // Memotong teks opsi menjadi 20 karakter
                var text = data.text.slice(0, 20);
                // Mengembalikan teks opsi yang sudah dipotong dan menambahkan tanda elipsis
                return text + (data.text.length > 20 ? '...' : '');
            }
        });

        document.getElementById('submitsearch').addEventListener('submit', function(event) {
            var select1 = document.getElementById('site_search');
            var select2 = document.getElementById('spsearch');
            var errorMessage = document.getElementById('errorMessage');
            
            if (select1.value === '' && select2.value === '') {
                event.preventDefault(); // Menghentikan pengiriman formulir
                
                errorMessage.textContent = 'Please fill in at least one input field.';
            } else {
                errorMessage.textContent = ''; // Menghapus pesan kesalahan jika opsi yang valid dipilih
            }
        });


    });
</script>
@endsection