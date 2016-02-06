@extends('template/template')

@section('content')
	<style>
		.bs-callout {
	    -moz-border-bottom-colors: none;
	    -moz-border-left-colors: none;
	    -moz-border-right-colors: none;
	    -moz-border-top-colors: none;
	    border-color: #eee;
	    border-image: none;
	    border-radius: 3px;
	    border-style: solid;
	    border-width: 1px 1px 1px 5px;
	    margin: 20px 0;
	    padding: 20px;
	    background-color: #fff;
		}

		.bs-callout-danger {
		  border-left-color: #d9534f;
		}

		.bs-callout-danger h4 {
			color: #d9534f;
		}
	</style>
	<div class="bs-callout bs-callout-danger">
	  <dl class="dl-horizontal">
	    <h4><span class="glyphicon glyphicon-minus-sign"></span> Error</h4>
	    <p>{{ $mensaje }}</p>
	  </dl>
	</div>
@stop