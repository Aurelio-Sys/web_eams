@extends('layout.newlayout')
@section('content-header')
    <style>
        .fontAwesomeIcon .custFa {
            font-family: "Font Awesome 5 Free", Open Sans;
            font-weight: 501;
        }
    </style>

    <div class="container-fluid">
        <div class="form-group row mt-2">
            <div class="col-md-6">
                <h1 class="m-0 text-dark">Fav. Menu</h1>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-primary addMenuFav" data-toggle="modal" data-dismiss="close">Add Fav. Menu</button>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    <!-- <hr> -->

    <!--Modal Create menu fav-->
    <div class="modal fade" id="addMenuFav" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">Add Fav. Menu</h5>
                    <button type="button" id="xclose" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('saveFavMenu') }}" method="post">
                    @method('POST')
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group row justify-content-center">
                            <label for="menu_name" class="col-md-2 col-lg-3 col-form-label my-auto">Menu <span
                                    id="alert1" style="color: red; font-weight: 200;">*</span></label>
                            <div class="col-md-5 col-sm-12">
                                <select name="menu_name" id="menu_name">
                                    <option value="Service Request Create">Service Request Create</option>
                                    <option value="Service Request Maintenance">Service Request Maintenance</option>
                                    <option value="Service Request Browse">Service Request Browse</option>
                                    <option value="Service Request Approve">Service Request Approve</option>
                                    <option value="Work Order Create">Work Order Create</option>
                                    <option value="Work Order Maintenance">Work Order Maintenance</option>
                                    <option value="Work Order Browse">Work Order Browse</option>
                                    <option value="Return Sparepart">Return Sparepart</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="menu_url" class="col-md-2 col-lg-3 col-form-label my-auto">URL <span id="alert1"
                                    style="color: red; font-weight: 200;">*</span></label>
                            <div class="col-md-5 col-sm-12">
                                <input type="text" class="form-control" name="menu_url" value="">
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="menu_icon" class="col-md-2 col-lg-3 col-form-label my-auto">Icon <span
                                    id="alert1" style="color: red; font-weight: 200;">*</span></label>
                            <div class="col-md-5 col-sm-12 fontAwesomeIcon">
                                <select name="menu_icon" id="menu_icon">
                                    <option class="custFa" data-icon="fas fa-globe" value="fas fa-globe"> Browse</option>
                                    <option class="custFa" data-icon="fas fa-plus-circle" value="fas fa-plus-circle"> Create
                                    </option>
                                    <option class="custFa" data-icon="fas fa-user-check" value="fas fa-user-check"> Approve
                                    </option>
                                    <option class="custFa" data-icon="fas fa-warehouse" value="fas fa-warehouse"> Warehouse
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <button type="submit" id="btnsubmit" class="btn btn-success"
                            style="color: white !important;">Save</button>&nbsp;
                        <button type="button" class="btn btn-block btn-info" id="btnloading" style="display:none">
                            <i class="fas fa-spinner fa-spin"></i> &nbsp;Saving
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        @foreach ($favMenus as $favMenu)
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box clickable-info-box" style="cursor: pointer;" data-url="{{$favMenu->fm_menu_url}}">
                    <span class="info-box-icon bg-primary">
                        <i class="{{ $favMenu->fm_menu_icon }} fa-1x"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ substr($favMenu->fm_menu_name, 0, 20) }}</span>
                    </div>
                    <form class="card-tools" action="{{route('deleteFavMenu')}}" method="POST">
                        {{ csrf_field() }}
                        @method('POST')
                        <input type="hidden" name="d_id" value="{{$favMenu->id}}" readonly>
                        <button type="submit" class="btn btn-tool delete-btn">
                            <i class="fas fa-trash-alt fa-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.addMenuFav').on('click', function() {
                $('#addMenuFav').modal('show');
            });

            $("#menu_name").select2({
                width: '100%',
                allowClear: true,
                placeholder: 'Select Menu',
                // theme : 'bootstrap4',
            });

            $('#menu_icon').select2({
                width: '100%',
                allowClear: true,
                placeholder: 'Select Icon',
                templateResult: formatIcon,
            });

            // Function to create a custom template for Select2 options
            function formatIcon(icon) {
                if (!icon.id) {
                    return icon.text;
                }

                var $icon = $(
                    '<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>'
                );
                return $icon;
            }

            $('.clickable-info-box').on('click', function(e) {
                let url = $(this).data('url');
                window.location.href = url;
            });

            $('.delete-btn').on('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
@endsection
