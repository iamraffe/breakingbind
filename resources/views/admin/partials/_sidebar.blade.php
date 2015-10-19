<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Auth::user()->pictureURL }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }} {{ Auth::user()->lastname }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form 
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>-->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MENÚ</li>
            <li class="active">
                <a href="{{ url('/admin') }}">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span></i>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                <i class="fa fa-pencil-square"></i>
                <span>Inscripciones</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/admin/pdf-download') }}"><i class="fa fa-file-pdf-o"></i> Descargar PDF</a></li>
                    <li><a href="{{ url('/admin/excel-download') }}"><i class="fa fa-file-excel-o"></i> Descargar Excel</a></li>
                </ul>
            </li>
            <li><a href="{{ url('/') }}"><i class="fa fa-chevron-left"></i> Volver a la web</a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
