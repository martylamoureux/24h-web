<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>24h iut </title>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Gestion portuaire le havre <i class="text-danger">24h</i></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @if(Auth::check())
                    <li><a href="{{ url('/') }}">Acceuil</a></li>
                @endif
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="{{ url('/auth/login') }}">Se connecter</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/auth/logout') }}">Déconnexion</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

	<div class="container">

    @if (Session::has('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i> {!! Session::get('success') !!}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">
            <i class="fa fa-times-circle"></i> {!!Session::get('error') !!}
        </div>
    @endif
    @if (Session::has('warning'))
        <div class="alert alert-warning">
            <i class="fa fa-exclamation-triangle"></i> {!!Session::get('warning') !!}
        </div>
    @endif
    @if (Session::has('info'))
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> {!!Session::get('info') !!}
        </div>
    @endif

    @if ($errors->has())
        <div class="alert alert-danger">
        <i class="fa fa-exclamation-triangle"></i>
        <b class="alert-title">Veuillez résoudre les problèmes suivants pour pouvoir poursuivre : </b>
        @foreach ($errors->all() as $error)
            <p class="m-l-md"><i class="fa fa-caret-right"></i> {!!$error !!}</p>
        @endforeach
        </div>
    @endif

	@yield('content')
	</div>

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	@yield('javascripts')
</body>
</html>
