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
    <h1 style="display:none">Breaking Bind</h1>

    @include('partials._nav')

    @yield('content')
    @include('partials._footer')
    <!-- Scripts -->
    {!! HTML::script('js/all.js') !!}
    @include('partials._flash')
    @yield('scripts')
</body>
</html>