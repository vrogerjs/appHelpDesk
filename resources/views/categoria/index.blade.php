
@extends('layouts.admin')

@section('htmlheader_title')
Gestión de Categorías
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">

		{{-- @if(accesoUser([1,2])) --}}
		<template v-if="divprincipal" id="divprincipal">
			@include('categoria.principal')
		</template>
		{{-- @endif --}}


	</div>
</div>
@endsection
