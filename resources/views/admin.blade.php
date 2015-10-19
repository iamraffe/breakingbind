<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard | Fundaseth, S.L</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <link href="{{ elixir('css/admin/all.css') }}" rel="stylesheet" type="text/css" />
        @yield('css')
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="fixed sidebar-mini skin-purple">

        @if (Session::get('flash_notification.overlay'))
            <div id="flash-overlay-modal" class="modal fade {{ $modalClass or '' }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                            <h4 class="modal-title">{{ Session::get('flash_notification.title') }}</h4>
                        </div>

                        <div class="modal-body">
                            <p>{{ Session::get('flash_notification.message') }}</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="wrapper">
            @include('admin.partials._header')
            @include('admin.partials._sidebar')

            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        Panel de Control
                        <small>Dashboard</small>
                    </h1>
                    <!-- Content Wrapper. Contains page content
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
                        <li class="active">Dashboard</li>
                    </ol>-->
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-10 col-xs-push-1">
                          <div class="row">
{{--                            @include('flash::message')--}}
                          </div>
                        </div>
                    </div>
                    @yield('content')
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0
                </div>
                <strong>Copyright &copy; 2015 <a href="http://fundaseth.es">Fundaseth, S.L</a>.</strong> All rights reserved.
            </footer>
        </div><!-- ./wrapper -->

        <script src="{{ asset('/js/admin/vendor.js') }}"></script>
        <script type="text/javascript">
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <script src="{{ asset('/js/admin/custom.js') }}"></script>
        @yield('scripts')
    </body>
</html>