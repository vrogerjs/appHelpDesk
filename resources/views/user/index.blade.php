@extends('layouts.admin')

@section('htmlheader_title')
    Gestión de Usuarios
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            @if (accesoUser([1]))
                <template v-if="divprincipal" id="divprincipal">
                    @include('user.principal')
                </template>
            @endif
        </div>
    </div>
@endsection
