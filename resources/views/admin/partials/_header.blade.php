<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/admin') }}" class="logo"><span class="logo-mini">EM</span><span class="logo-lg">Efecto Mariposa</span></a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ Auth::user()->get('pictureURL') }}" class="user-image" alt="User Image"/>
                    <span class="hidden-xs">{{ Auth::user()->get('name') }} {{ Auth::user()->get('lastname') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ Auth::user()->get('pictureURL') }}" class="img-circle" alt="User Image" />
                            <p>
                            {{ Auth::user()->get('name') }} {{ Auth::user()->get('lastname') }}
                            <small>Administrador</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            {{-- <div class="pull-left">
                                <a href="{{ url('/users/'.Auth::user()->objectId) }}" class="btn btn-default btn-flat"><span class="fa fa-sign-in"></span> Mi perfil</a>
                            </div> --}}
                            <div class="pull-right">
                                <a href="{{ url('/auth/logout') }}" class="btn btn-default btn-flat"><span class="fa fa-sign-out"></span> Cerrar sesión</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
