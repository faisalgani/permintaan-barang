@extends('cpanel.index')
@section('content')
        <?php 
            $process = "create";
            $tmpData = array(
                'id' => "",
                'nama_departemen' => ""
            );
            if(count($data) > 0){
                $result = $data[0];
                $tmpData = array(
                    'id' =>  $result->id,
                    'nama_departemen' =>  $result->nama_departemen
                );
                $process = "update";
            }
            $tmpData = json_encode($tmpData);
        ?>
        <!-- /.card-header -->
        <div id="cpanel-departemen-form" data-parameter="{{$tmpData}}" data-process="{{$process}}" data-url="{{URL::to('/')}}" data-token="{{csrf_token()}}"></div>
        <!-- /.card-body -->
    </div>
@endsection('content')

@push('pluginCSS')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/toastr/toastr.min.css')}}">
    <!-- Leaflet -->
    <link rel="stylesheet" href="{{asset('assets/plugins/leaflet/leaflet.css')}}"> 
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.4/dist/esri-leaflet-geocoder.css" />
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/summernote/summernote-bs4.min.css')}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/daterangepicker/daterangepicker.css')}}">
@endpush

@push('pluginJS')
    <!-- Summernote -->
    <script src="{{asset('assets/template/adminLTE/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('assets/template/adminLTE/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/template/adminLTE/plugins/toastr/toastr.min.js')}}"></script>
    <!-- InputMask -->
    <script src="{{asset('assets/template/adminLTE/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets/template/adminLTE/plugins/inputmask/jquery.inputmask.min.js')}}"></script> 
    <script src="{{asset('assets/template/adminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- date-range-picker -->
    <script src="{{asset('assets/template/adminLTE/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Leaflet -->
    <script src="{{asset('assets/plugins/leaflet/leaflet.js')}}"></script>
    <!-- <script src="{{asset('assets/plugins/leaflet3/leaflet.bundle.js')}}"></script> -->
    <script src="{{asset('assets/plugins/esri-leaflet-v3.0.1/esri-leaflet.js')}}"></script>
    <script type="text/javascript" src="https://unpkg.com/esri-leaflet-geocoder@2.2.4"></script>
@endpush