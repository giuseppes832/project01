<form action="/resources" method="post">
	@csrf
	<div class="row g-1">
		<div class="col-10">
			<div class="form-floating">
				<input type="text" class="form-control form-control-sm" name="name"/>
				<label>Nome nuova risorsa</label>
			</div>

		</div>
		<div class="col-2">
			<button type="submit" class="btn btn-primary btn-sm">Salva</button>
		</div>
	</div>


</form>
