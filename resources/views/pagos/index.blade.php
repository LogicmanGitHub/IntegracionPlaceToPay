@extends('master')
@section('title', 'Contact')

@section('content')
			<div class="container">

				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-default ">
					  <div class="panel-heading">
					    <h3 class="panel-title">Pagos</h3>
					  </div>
					  <div class="panel-body">
					  		<a href="{!! asset('pagos/create') !!}" class="btn btn-default">Nuevo Pago</a>
					  		<hr>
							@if (count($pagos)>0)
								<table class="table">
									<thead>
										<tr>
											<th>Fecha</th>
											<th>Referencia</th>
											<th>Descripcion</th>
											<th>Moneda</th>
											<th>Monto</th>
											<th>Status</th>
											
										</tr>
									</thead>
									<tbody>
										@foreach($pagos as $pago)
										<tr>
											<td>{!! date("d-m-Y", strtotime($pago->fecha )) !!}</td>
											<td>{!! $pago->referencia !!}</td>
											<td>{!! $pago->descripcion !!}</td>		
											<td>{!! $pago->moneda !!}</td>
											<td>{!! $pago->monto !!}</td>
											<td>{!! $pago->status !!}</td>

										</tr>
										@endforeach
									</tbody>
									
								</table>
							@else
								<p> No hay Pagos Registrados</p>
							@endif

					  </div>
					</div>			
				</div>	
	</div>
@endsection