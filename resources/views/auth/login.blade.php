@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Se connecter</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Adresse e-mail</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Mot de passe</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Se souvenir de moi
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Se connecter</button>

								<a class="btn btn-link" href="{{ url('/password/email') }}">Mot de passe oublié ?</a>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Comptes de test</div>
				<div class="panel-body">
					<p>
					    <b>Agent Portuaire :</b> agent@lehavre.fr / agent
					</p>
					<p>
					    <b>Compagnie CMA CGM :</b> contact@cmacgm.fr / cmacgm
					</p>
					<p>
					    <b>Compagnie Hapag-Lloyd :</b> contact@hapag-lloyd.fr / hapag-lloyd
					</p>
					<p>
					    <b>Client Hugues DUFLO :</b> hugues@duflo.fr / hugues
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
