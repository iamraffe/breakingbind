<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>Breaking Bind</title>
    <meta name="description" content="Si eres atrevi@, quieres conocer gente y viajar, disfrutar de esta vida, porque ¿no hay otra verdad? Entonces esta es tú página.">
    @yield('css')
    <link href="{{ elixir('css/all.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top" class='{{ $bodyClass or "index" }}'>

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

    @include('partials._nav')

    @yield('content')
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <p>&copy; <span class="copyright">Breaking Bind</span> 2015</p>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
{{--                         <li><a href="https://twitter.com/aecat_es"><i class="fa fa-twitter"></i></a>
                        </li> --}}
{{--                         <li class="animated pulse infinite"><a href="https://www.facebook.com/breakingbind"><i class="fa fa-facebook"></i></a>
                        </li> --}}
{{--                         <li><a href="https://www.youtube.com/user/AECATiroides"><i class="fa fa-youtube"></i></a>
                        </li> --}}
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li><a href="{{ url('/terms-and-conditions') }}">Condiciones de uso</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- Scripts -->
    {!! HTML::script('js/all.js') !!}
    <script>
        $('#flash-overlay-modal').modal();
    </script>
    @yield('scripts')
</body>
</html>