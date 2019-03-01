@extends('master')
@section('title', 'Contact')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">

			<div style="padding:20px;" class="panel panel-default">
				<div class="panel-header">
				  <h2>Pago B&aacute;sico</h2>
				</div>

				<div class="panel-body">
					
						<form action="{!! asset('pagos/store') !!}" method="POST" class="form-horizontal" role="form">
								@foreach ($errors->all() as $error)
									<p class="alert alert-danger">{{ $error }}</p>
								@endforeach
							
								<input type="hidden" name="_token" value="{!! csrf_token() !!}">

								<div class="form-group">
					                    	<label>Referencia:</label>
					                        <input id='referencia' name='referencia' type='text' maxlength='45' class='form-control'>
								</div>
								<div class="form-group">
					                    	<label>Descripci&oacute;n del pago:</label>
					                        <input id='descripcion' name='descripcion' type='text' maxlength='45' class='form-control'>
								</div>
								<div class="form-group">
					                    	<label>Moneda:</label>
					                    	<select id="moneda" name="moneda" class="form-control">
					                    		<option value="COP">COP</option>
					                    	</select>
								</div>
								<div class="form-group">
					                    	<label>Monto:</label>
					                        <input id="monto" name="monto" type="number" maxlength='12' class="form-control">
								</div>

								<div class="form-group">
										<button type="submit" class="btn btn-primary">Enviar</button>
								</div>
						</form>
					</div>
				</div>

	</div>
</div>
</div>
@endsection