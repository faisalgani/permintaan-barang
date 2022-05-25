<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>
	@include('cpanel.partials.pluginCSS')
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>{{ $title }}</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <div id="cpanel-login-form" data-url="{{URL::to('/')}}" data-token="{{csrf_token()}}"></div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

@include('cpanel.partials.pluginJS')
</body>
</html>
