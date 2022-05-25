@extends('cpanel.index')
@section('content')
    <div class="card card-default">
        <?php 
            $process = "create";
            $tmpData = array(
                "id" => "",
                "menu" => "",
                "link" => "#",
                "icon" => "",
                "parent" => "",
                "class" => "",
                "active" => true,
                "state" => "",
                "order" => "0",
            );
            if(count($data) > 0){
                $result = $data[0];
                $tmpData = array(
                    "id" => $result->id,
                    "menu" => $result->menu,
                    "link" => $result->link,
                    "icon" => $result->icon,
                    "parent" => $result->parent,
                    "class" => $result->class,
                    "active" => $result->active,
                    "state" => $result->state,
                    "order" => $result->order,
                );
                $process = "update";
            }
            $tmpData = json_encode($tmpData);
        ?>
        <!-- /.card-header -->
        <div id="cpanel-system_menu-form" data-parameter="{{$tmpData}}" data-process="{{$process}}" data-url="{{URL::to('/')}}" data-token="{{csrf_token()}}"></div>
        <!-- /.card-body -->
    </div>
@endsection('content')

@push('pluginCSS')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/toastr/toastr.min.css')}}">
@endpush

@push('pluginJS')
    <script src="{{asset('assets/template/adminLTE/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/template/adminLTE/plugins/toastr/toastr.min.js')}}"></script>
    <!-- InputMask -->
    <script src="{{asset('assets/template/adminLTE/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets/template/adminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
@endpush