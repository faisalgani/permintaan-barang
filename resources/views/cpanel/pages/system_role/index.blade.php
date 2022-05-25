@extends('cpanel.index')
@section('content')
<div class="row">
          <div class="col-12">
            <div class="card">
                <div id="cpanel-system_role-form" data-url="{{URL::to('/')}}" data-token="{{csrf_token()}}"></div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
@endsection('content')
@push('pluginCSS')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('assets/template/adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
@endpush

@push('pluginJS')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('assets/template/adminLTE/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/template/adminLTE/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('assets/template/adminLTE/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/template/adminLTE/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
    <script>
        async function openModal(){
            await $('#exampleModal').modal('show');
            await $('#id').val("");
            await $('#group').val("");
            await $("#active").prop('checked', true);
        }
    </script>
@endpush