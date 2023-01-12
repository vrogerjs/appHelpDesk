<div class="col">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Bienvenidos al Menú Principal</h3>
        </div>
        <div class="card-body">
            <div class="row">

                @if (accesoUser([1]))
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary" style="height: 143px;">
                            <div class="inner">
                                {{-- <h3>53<sup style="font-size: 20px">%</sup></h3> --}}
                                <p>Gestión de Usuarios</p>
                            </div>
                            <div class="icon pt-4">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="{{ url('users') }}" class="small-box-footer mt-2"
                                style="padding: 5px 0!important">Ingresar <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif

                @if (accesoUser([1]))
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info" style="height: 143px;">
                            <div class="inner">
                                {{-- <h3>10</h3> --}}
                                <p>Gestión de Categorías</p>
                            </div>
                            <div class="icon pt-4">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <a href="{{ url('categorias') }}" class="small-box-footer mt-2"
                                style="padding: 5px 0!important">Ingresar <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif

                @if (accesoUser([1]))
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success" style="height: 143px;">
                            <div class="inner">
                                {{-- <h3>53<sup style="font-size: 20px">%</sup></h3> --}}
                                <p>Gestión de Responsables</p>
                            </div>
                            <div class="icon pt-4">
                                <i class="fas fa-users-gear"></i>
                            </div>
                            <a href="{{ url('responsables') }}" class="small-box-footer mt-2"
                                style="padding: 5px 0!important">Ingresar <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif

                @if (accesoUser([1, 2, 3]))
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning" style="height: 143px;">
                            <div class="inner">
                                {{-- <h3>44</h3> --}}
                                <p>Gestión de Tikets</p>
                            </div>
                            <div class="icon pt-4">
                                <i class="fas fa-list"></i>
                            </div>
                            <a href="{{ url('incidencias') }}" class="small-box-footer mt-2"
                                style="padding: 5px 0!important">Ingresar <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif

                @if (accesoUser([1, 2, 3]))
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger" style="height: 143px;">
                            <div class="inner">
                                {{-- <h3>65</h3> --}}
                                <p>Gestión de Respuestas</p>
                            </div>
                            <div class="icon pt-4">
                                <i class="fas fa-reply-all"></i>
                            </div>
                            <a href="{{ url('solucions') }}" class="small-box-footer mt-2"
                                style="padding: 5px 0!important">Ingresar <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
