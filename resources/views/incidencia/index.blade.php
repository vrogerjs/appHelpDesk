
@extends('layouts.admin')

@section('htmlheader_title')
Gestión de Incidencias
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">

		{{-- @if(accesoUser([1,2])) --}}
		<template v-if="divprincipal" id="divprincipal">
			@include('incidencia.principal')
		</template>
		{{-- @endif --}}


	</div>
</div>
@endsection
