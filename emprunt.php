<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/empruntController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10">
	<legend>Emprunt</legend>
	<form class="" name="form_new_emprunt" id="form_new_emprunt" method="POST" action="#">
		<div id="columns" class="row">
			<legend>Ajouter un nouvel emprunt</legend>
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
				createNewEmprunt();
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
				<br /><br />
				<div class="row">
					<div class="col-xs-12">Date de l'emprunt: <?php echo $emprunt['date'] ?></div>
					<div class="col-xs-12">Montant de l'emprunt: <?php echo $emprunt['montant'] ?></div>
					<div class="col-xs-12"><?php echo ($emprunt['remboursement'] != '') ? 'Remboursement par mois: '.$emprunt['remboursement'] : 'Etalonnement: '.$emprunt['etalonnement'] ?></div>
				</div>
				<table class="table table-hover">
					<tr>
						<th>Date</th>
						<th>Montant</th>
						<th>Rembours&eacute;</th>
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
						</tr>
						<input type="hidden" id="id_account_<?php echo $remboursement['id_remboursement'] ?>" value="<?php //echo $remboursement['id_account'] ?>" />
						<input type="hidden" id="debit_<?php echo $remboursement['id_remboursement'] ?>" value="<?php //echo $remboursement['debit'] ?>" />
						<script type="text/javascript">
							$(function() {
								$("#modify_date_<?php echo $remboursement['id_remboursement'] ?>").datepicker({ dateFormat: 'yy-mm-dd' });

								$(document).on("click", "#rembourse_<?php echo $remboursement['id_remboursement'] ?>", function(){
									changeRemboursementStatus("<?php echo $remboursement['id_remboursement'] ?>", "<?php echo $remboursement['effectue'] ?>");
								});
							});
						</script>
					<?php } ?>
				</table>
			</div>
			<?php $j++ ?>
		<?php } ?>
	</div>
<script type="text/javascript">
$(function(){

});
</script>
</div>
<?php include "footer.php" ?>