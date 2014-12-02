@extends('template/template')

@section('content')
	@if(Session::get('flashMessage')) 
    <div class="alert alert-{{ Session::get('flashType', 'danger') }} alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      {{Session::get('flashMessage')}}
    </div>
  @endif
	{{ Form::open(array('url'=>'cancerbero/asignar')) }}
		@foreach($modulopermisos as $modulo => $val )
			<div class="col-md-4">
				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title">{{ $modulo }}</h3>
				  </div>
				  <div class="panel-body">
				  	<div class="pull-right">
				  		<a href="javascript:void(0);" id="tod{{ $val['moduloid'] }}" class="lnkTodos">Todos</a> | 
				  		<a href="javascript:void(0);" id="nin{{ $val['moduloid'] }}" class="lnkNinguno">Ninguno</a>
				  	</div>
				  	@foreach($val['permisos'] as $permiso)
							<div>
								<input type="checkbox" value="{{ $permiso['id'] }}" id="mp{{ $permiso['id'] }}" name="modulopermisos[]" class="chk{{ $val['moduloid'] }}" {{ (in_array($permiso['id'], $rolmodulopermisos)) ? 'checked="true"' : '' }}>
								{{ $permiso['nombre'] }}
							</div>
				  	@endforeach
				  </div>
				</div>
			</div>
		@endforeach
		<div class="col-md-12">{{Form::submit('Guardar', array('class' => 'btn btn-primary'))}}</div>
		{{ Form::hidden('id', $rolid) }}
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