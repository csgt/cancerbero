@extends('template/template')

@section('content')
	<div class="bs-callout bs-callout-warning">
	  <dl class="dl-horizontal">
	    <h3>Error!</h3>
	    <p>{{ $mensaje }}</p>
	  </dl>
	</div>
@stop