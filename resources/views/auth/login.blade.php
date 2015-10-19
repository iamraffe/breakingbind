<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Admin Panel | Fundaseth, S.L</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="{{ elixir('css/admin/all.css') }}" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-page">
        <div class="login-box">
          <div class="login-logo">
            <a href="{{ url('/') }}">{!! HTML::image('img/logo-inverse.svg', 'Fundaseth, S.L') !!}</a>
          </div><!-- /.login-logo -->
          <div class="panel panel-default login-box-body">
            <div class="panel-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/auth/login') }}" method="post">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="row">
                    <div class="form-group has-feedback">
                      <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
                      <span class="fa fa-envelope form-control-feedback red-color"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group has-feedback">
                      <input type="password" class="form-control" name="password" placeholder="Contraseña"/>
                      <span class="fa-lock fa form-control-feedback yellow-color"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group pull-right">
                      <a href="#">Olvidé mi contraseña</a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group has-feedback">
                      <div class="col-xs-12">
                        <button type="submit" class="btn btn-danger btn-block btn-flat">Iniciar sesión</button>
                      </div><!-- /.col -->
                    </div>
                  </div>
                </form>
            </div>

          </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
        <script src="{{ asset('/js/admin/vendor.js') }}"></script>
        <script src="{{ asset('/js/admin/custom.js') }}"></script>
  </body>
</html>