<aside class="main-sidebar sidebar-dark-primary elevation-4" style="font-size: 14px;">
    <a href="/" class="brand-link text-center">
        <img src="{{ asset('img/logo.png') }}" alt="Gobierno Regional de Ancash" class="brand-image img-circle elevation-3"
            style="float:none;max-height: 100px;">
        <br>
        <span class="brand-text font-weight-light" style="text-decoration:none!important;">Gobierno Regional <br>de Ancash</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('img/user.png') }}" class="img-circle elevation-2" alt="User Image"
                    style="width: 4rem;">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="/home" v-bind:class="classMenu">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>

                @if (accesoUser([1]))
                    <li class="nav-item menu-open">
                        <a href="#" v-bind:class="classMenu1">
                            <i class="nav-icon fa fa-home"></i>
                            <p>
                                Tablas Maestras
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="categorias" class="nav-link">
                                    <i class="fa-solid fa-location-arrow"></i>&nbsp;
                                    <p>Gestión de Categorías</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="responsables" class="nav-link">
                                    <i class="fa-solid fa-location-arrow"></i>&nbsp;
                                    <p>Gestión de Responsables</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif

                @if (accesoUser([1, 2, 3]))
                    <li class="nav-item menu-open">
                        <a href="#" v-bind:class="classMenu2">
                            <i class="nav-icon fa fa-home"></i>
                            <p>
                                Ticket de Incidencias
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('/incidencias')}}" class="nav-link">
                                    <i class="fa-solid fa-location-arrow"></i>&nbsp;
                                    <p>Gestión de Tickets</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="solucions" class="nav-link">
                                    <i class="fa-solid fa-location-arrow"></i>&nbsp;
                                    <p>Gestión de Respuestas</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
