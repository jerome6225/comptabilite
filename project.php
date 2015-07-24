<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/projectController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10">
	<h1>Projet</h1>
	<legend>Ajouter un nouveau projet <span id="btn_form_new_project" class="glyphicon glyphicon-plus text-primary cursor_pointer"></span></legend>
	<form class="sr-only" name="form_new_project" id="form_new_project" method="POST" action="#">
		<div id="columns" class="row">
			<section class="col-sm-5">
				<div class="form-group has-feedback" id="div_name_project">
					<label for="name_project">Nom du project : </label>
					<input type="text" placeholder="Nom" class="form-control" name="name_project" id="name_project" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_name_project"></span>
				</div>
				<div class="form-group has-feedback" id="div_somme_project">
					<label for="somme_project">Somme : </label>
					<input type="text" placeholder="Somme" class="form-control" name="somme_project" id="somme_project" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_somme_project"></span>
				</div>
				<div class="form-group has-feedback" id="div_date_project">
					<label for="date_project">Date de l'project : </label>
					<input type="text" placeholder="Date" class="form-control" name="date_project" id="date_project" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_date_project"></span>
				</div>
			</section>
			<section class="col-sm-5">
				<legend>Choisir un des deux</legend>
				<span id="choice_one" class="text-danger sr-only">Ne choisir que l'un des deux</span>
				<div class="form-group has-feedback" id="div_somme_rembourse">
					<label for="somme_rembourse">Montant des remboursements : </label>
					<input type="text" placeholder="Remboursement" class="form-control" name="somme_rembourse" id="somme_rembourse" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_somme_rembourse"></span>
				</div>
				<div class="form-group has-feedback" id="div_etalonnement">
					<label for="etalonnement">Etalonnement des remboursements : </label>
					<input type="text" placeholder="Etalonnement" class="form-control" name="etalonnement" id="etalonnement" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_etalonnement"></span>
				</div>
			</section>
		</div>
		<div class="row">
			<button type="submit" class="btn btn-primary btn-sm" name="submit_new_project" id="submit_new_project"><span class="glyphicon glyphicon-plus"></span> Ajouter</button>
		</div>
	</form>
</div>
	<script type="text/javascript">
		$(function() {
			$(function() {
				$("#date_project").datepicker({ dateFormat: 'dd-mm-yy' });
				newproject();
				toggleForm("form_new_project");
			});
	});
	</script>




<?php include "footer.php" ?>