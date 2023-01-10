@extends('layouts.admin')

@section('htmlheader_title')
    Inicio
@endsection

<style type="text/css">
    #modaltamanio {
        width: 70% !important;
    }
</style>

@section('content')
    <div class="container-fluid">
        <div class="row">
            <template v-if="divhome" id="divhome" v-show="divhome">
                @include('inicio.menuAdmin')
            </template>
        </div>
    </div>
@endsection
