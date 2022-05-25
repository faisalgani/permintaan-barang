@extends('cpanel.index')
@section('content')
<div class="row">
          <div class="col-12">
            <div class="card">
                <div id="cpanel-system_menu-datatree" data-url="{{URL::to('/')}}" data-token="{{csrf_token()}}"></div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
@endsection('content')
@push('pluginCSS')
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/jstree/themes/default/style.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/toastr/toastr.min.css')}}">
@endpush

@push('pluginJS')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('assets/plugins/jstree/jstree.min.js')}}"></script>
    <script src="{{asset('assets/template/adminLTE/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/template/adminLTE/plugins/toastr/toastr.min.js')}}"></script>
@endpush