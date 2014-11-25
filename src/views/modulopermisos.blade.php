@extends('template/template')

@section('content')
	@if(Session::get('flashMessage')) 
    <div class="alert alert-{{ Session::get('flashType', 'danger') }} alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      {{Session::get('flashMessage')}}
    </div>
  @endif
	{{ Form::open() }}
		@foreach($modulos as $modulo)
			<div class="col-md-4">
				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title">{{ $modulo->modulo }} <small>{{ $modulo->nombre }}</small></h3>
				  </div>
				  <div class="panel-body">
				  	<div class="pull-right">
				  		<a href="javascript:void(0);" id="tod{{$modulo->moduloid}}" class="lnkTodos">Todos</a> | 
				  		<a href="javascript:void(0);" id="nin{{$modulo->moduloid}}" class="lnkNinguno">Ninguno</a>
				  	</div>
				  	@foreach($permisos as $permiso)
							<div>
								<input type="checkbox" value="{{$modulo->moduloid.'-'.$permiso->permisoid}}" id="mp{{$modulo->moduloid.'-'.$permiso->permisoid}}" name="permiso[]" class="chk{{$modulo->moduloid}}" {{ (isset($modulopermisos[$modulo->moduloid][$permiso->permisoid])) ? 'checked="true"' : '' }}>
								{{ $permiso->permiso }} <small>{{ $permiso->alias }}</small>
							</div>
				  	@endforeach
				  </div>
				</div>
			</div>
		@endforeach
		<div class="col-md-12">{{Form::submit('Guardar', array('class' => 'btn btn-primary'))}}</div>
	{{ Form::close() }}
	<script>
		$(document).ready(function(){
			$('.lnkTodos').click(function(){
				id = $(this).attr('id').substr(3);
				$('.chk' + id).prop('checked',true);
			});

			$('.lnkNinguno').click(function(){
				id = $(this).attr('id').substr(3);
				$('.chk' + id).prop('checked', false);
			});
		});
	</script>
@stop