<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/empruntController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10">
	<h1>Emprunt</h1>
	<legend>Ajouter un nouvel emprunt <span id="btn_form_new_emprunt" class="glyphicon glyphicon-plus text-primary cursor_pointer"></span></legend>
	<form class="sr-only" name="form_new_emprunt" id="form_new_emprunt" method="POST" action="#">
		<div id="columns" class="row">
			<section class="col-sm-5">
				<div class="form-group has-feedback" id="div_name_emprunt">
					<label for="name_emprunt">Nom de l'emprunt : </label>
					<input type="text" placeholder="Nom" class="form-control" name="name_emprunt" id="name_emprunt" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_name_emprunt"></span>
				</div>
				<div class="form-group has-feedback" id="div_somme_emprunt">
					<label for="somme_emprunt">Somme emprunt&eacute;e : </label>
					<input type="text" placeholder="Somme" class="form-control" name="somme_emprunt" id="somme_emprunt" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_somme_emprunt"></span>
				</div>
				<div class="form-group has-feedback" id="div_date_emprunt">
					<label for="date_emprunt">Date de l'emprunt : </label>
					<input type="text" placeholder="Date" class="form-control" name="date_emprunt" id="date_emprunt" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_date_emprunt"></span>
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
			<button type="submit" class="btn btn-primary btn-sm" name="submit_new_emprunt" id="submit_new_emprunt"><span class="glyphicon glyphicon-plus"></span> Ajouter</button>
		</div>
	</form>
	<script type="text/javascript">
		$(function() {
			$(function() {
				$("#date_emprunt").datepicker({ dateFormat: 'dd-mm-yy' });
				newEmprunt();
				toggleForm("form_new_emprunt");
			});
	});
	</script>
	<br /><br />
	<legend>Liste des emprunts</legend>
	<ul class="nav nav-tabs nav-justified">
		<?php $class = '' ?>
		<?php $i = 0 ?>
		<?php foreach ($listEmprunts as $key => $emprunt) {?>
			<?php $class = ($class == '') ? 'active' : 'disable'; ?>
			<li class="<?php echo $class ?>"><a href="#<?php echo $i ?>" data-toggle="tab"><?php echo $emprunt['name'] ?></a></li>
			<?php $i++ ?>
		<?php } ?>
	</ul>
	<div class="tab-content">
		<?php $classContent = '' ?>
		<?php $j = 0 ?>
		<?php foreach ($listEmprunts as $key => $emprunt) {?>
			<?php $classContent = ($classContent == '') ? 'active' : 'blabla'; ?>
			<div class="table-responsive tab-pane <?php echo $classContent ?>" id="<?php echo $j ?>">
				<div class="info_emprunt">
					<div class="col-xs-12">Date de l'emprunt: <?php echo $emprunt['date'] ?></div>
					<div class="col-xs-12">Montant de l'emprunt: <?php echo $emprunt['montant'] ?></div>
					<div class="col-xs-12"><?php echo ($emprunt['remboursement'] != '') ? 'Remboursement par mois: '.$emprunt['remboursement'] : 'Etalonnement: '.$emprunt['etalonnement'] ?></div>
				</div>
				<div class="col-sm-12">
					<table class="table table-hover">
						<tr>
							<th>Date</th>
							<th>Montant</th>
							<th id="title_remboursement">Rembours&eacute;</th>
							<th>&nbsp;</th>
						</tr>
						<?php foreach ($emprunt['listRemboursement'] as $remboursement) { ?>
							<tr class="text-left" id="tr_<?php echo $remboursement['id_remboursement'] ?>">
								<td>
									<span class="span_modify_emprunt_<?php echo $remboursement['id_remboursement'] ?>" id="date_<?php echo $remboursement['id_remboursement'] ?>"><?php echo $remboursement['date'] ?></span>
									<input type="text" class="sr-only input_hidden_<?php echo $remboursement['id_remboursement'] ?> input_date" id="modify_date_<?php echo $remboursement['id_remboursement'] ?>" value="<?php echo $remboursement['date'] ?>" />
								</td>
								<td class="text-left">
									<span class="span_modify_emprunt_<?php echo $remboursement['id_remboursement'] ?>" id="montant_<?php echo $remboursement['id_remboursement'] ?>"><?php echo $remboursement['montant'] ?></span>
									<input type="text" class="sr-only input_hidden_<?php echo $remboursement['id_remboursement'] ?>" id="modify_montant_<?php echo $remboursement['id_remboursement'] ?>" value="<?php echo $remboursement['montant'] ?>" />
								</td>
								<td class="text-left">
									<span class="span_modify_emprunt_<?php echo $remboursement['id_remboursement'] ?> cursor_pointer" id="rembourse_<?php echo $remboursement['id_remboursement'] ?>"><?php if ($remboursement['effectue'] == 1){ ?><span class="glyphicon glyphicon-ok text-success"></span><?php }else{ ?><span class="glyphicon glyphicon-remove text-danger"></span><?php } ?></span>
								</td>
								<td class="text-left">
									<span class="span_modify_emprunt_<?php echo $remboursement['id_remboursement'] ?> glyphicon glyphicon-edit text-primary cursor_pointer" id="modify_remboursement_<?php echo $remboursement['id_remboursement'] ?>" title="Modifier"></span>
									<span class="sr-only input_hidden_<?php echo $remboursement['id_remboursement'] ?> cursor_pointer" id="cancel_modif_remboursement_<?php echo $remboursement['id_remboursement'] ?>" title="Annuler"><span class="glyphicon glyphicon-ban-circle text-primary"></span></span>
									<span class="sr-only input_hidden_<?php echo $remboursement['id_remboursement'] ?> cursor_pointer" id="valid_modif_remboursement_<?php echo $remboursement['id_remboursement'] ?>" title="Valider"><span class="glyphicon glyphicon-ok text-success"></span></span>
								</td>
							</tr>
							<input type="hidden" id="id_account_<?php echo $remboursement['id_remboursement'] ?>" value="<?php //echo $remboursement['id_account'] ?>" />
							<input type="hidden" id="debit_<?php echo $remboursement['id_remboursement'] ?>" value="<?php //echo $remboursement['debit'] ?>" />
							<script type="text/javascript">
								$(function() {
									$("#modify_date_<?php echo $remboursement['id_remboursement'] ?>").datepicker({ dateFormat: 'yy-mm-dd' });

									$(document).on("click", "#rembourse_<?php echo $remboursement['id_remboursement'] ?>", function(){
										changeRemboursementStatus("<?php echo $remboursement['id_remboursement'] ?>", "<?php echo $remboursement['effectue'] ?>");
									});

									$(document).on("click", "#modify_remboursement_<?php echo $remboursement['id_remboursement'] ?>", function(){
										modifyRemboursement("<?php echo $remboursement['id_remboursement'] ?>");
									});

									$(document).on("click", "#cancel_modif_remboursement_<?php echo $remboursement['id_remboursement'] ?>", function(){
										cancelModifRemboursement("<?php echo $remboursement['id_remboursement'] ?>");
									});
								});
							</script>
						<?php } ?>
					</table>
				</div>
			</div>
			<?php $j++ ?>
		<?php } ?>
	</div>
</div>
<?php include "footer.php" ?>