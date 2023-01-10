<!DOCTYPE html>

<html lang="es" style="height: auto;">

@include('layouts.partials.htmlheader')

<body class="hold-transition sidebar-mini">

    <div id="app" v-cloak>
        <div class="wrapper">

            @include('layouts.partials.mainheader')

            @include('layouts.partials.sidebar')

            <div class="content-wrapper">

                @include('layouts.partials.contentheader')

                <div class="content">
                    @yield('content')
                </div>

            </div>

            @include('layouts.partials.footer')

        </div>
    </div>

    {{$modulo}}
    {{-- {{$users}} --}}

    @include('layouts.partials.scripts')

</body>

</html>



@if ($modulo == 'inicioAdmin')
    @include('inicio.vueAdmin')
@elseif($modulo == 'categoria')
    @include('categoria.vue')
@elseif($modulo == 'responsable')
    @include('responsable.vue')
@elseif($modulo == 'incidencia')
    @include('incidencia.vue')
@elseif($modulo == 'solucion')
    @include('solucion.vue')
@endif


