<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/checkController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10">
	<legend>Ch&egrave;ques</legend>
	<legend>S&eacute;lectionnez un mois pour voir les ch&egrave;ques de ce mois <span id="btn_form_synthesis_date" class="glyphicon glyphicon-plus text-primary cursor_pointer"></span></legend>
	<form class="form-inline sr-only" name="form_synthesis_date" id="form_synthesis_date" method="POST" action="check.php">
		<div class="form-group has-feedback" id="div_month">
	    	<label for="month">Mois : </label>
	    	<select class="" id="month" name="month">
	    		<?php foreach ($months as $key => $month){ ?><option value="<?php echo $key ?>"><?php echo $month ?></option><?php } ?>
	    	</select>
		</div>
		<div class="form-group has-feedback" id="div_year">
	    	<label for="year">Ann&eacute; : </label>
	    	<select class="" id="year" name="year">
	    		<?php foreach ($years as $year){ ?><option value="<?php echo $year ?>"><?php echo $year ?></option><?php } ?>
	    	</select>
		</div>
		<button type="submit" class="btn btn-primary btn-sm" name="submit_date_check_info" id="submit_date_check_info"><span class="glyphicon glyphicon-calendar"></span> Voir</button>
	</form>
	<br /><br />
	<legend>Ch&egrave;que</legend>
	<ul class="nav nav-tabs nav-justified">
		<?php $class = '' ?>
		<?php $i = 0 ?>
		<?php foreach ($checks as $key => $check) { ?>
			<?php $explKey = explode('*', $key) ?>
			<?php $class = ($class == '') ? 'active' : 'disable'; ?>
			<li class="<?php echo $class ?>"><a href="#<?php echo $i ?>" data-toggle="tab"><?php echo $explKey[0] ?></a></li>
			<?php $i++ ?>
		<?php } ?>
	</ul>
	<div class="tab-content">
		<?php $classContent = '' ?>
		<?php $j = 0 ?>
		<?php foreach ($checks as $key => $check) { ?>
			<?php $explKey = explode('*', $key) ?>
			<?php $id_account = $explKey[1] ?>
			<?php $classContent = ($classContent == '') ? 'active' : 'blabla'; ?>
			<div class="table-responsive tab-pane <?php echo $classContent ?>" id="<?php echo $j ?>">
				<br /><br />
				<?php if (count($check) == 0){ ?>
					<div>Aucune informations pour ce compte</div>
				<?php }else{ ?>
					<table class="table table-hover">
						<tr>
							<th>Date d'&eacute;dition</th>
							<th>Utilisateur</th>
							<th>Intitul&eacute;</th>
							<th>Cat&eacute;gorie</th>
							<th>Montant</th>
							<th>D&eacute;bit&eacute;</th>
							<th colspan="2">&nbsp;</th>
						</tr>
						<?php $total = 0 ?>
						<?php foreach ($check as $ch) { ?>
							<?php foreach ($ch as $c) { ?>
								<tr class="text-left" id="tr_<?php echo $c['id_check'] ?>">
									<td>
										<span class="span_modify_check_<?php echo $c['id_check'] ?>" id="date_<?php echo $c['id_check'] ?>"><?php echo $c['string_date_release_check'] ?></span>
									</td>
									<td class="text-left" <?php if (isset($c['color'])){ ?>style="background-color: <?php echo $c['color'] ?>"<?php } ?>>
										<span class="span_modify_check_<?php echo $c['id_check'] ?>" id="user_<?php echo $c['id_check'] ?>" data-iduser="<?php echo (isset($c['id_user_account'])) ? $c['id_user_account'] : '0'; ?>"><?php echo (isset($c['name_user_account'])) ? $c['name_user_account'] : 'Tout le monde'; ?></span>
									</td>
									<td class="text-left">
										<span class="span_modify_check_<?php echo $c['id_check'] ?>" id="name_<?php echo $c['id_check'] ?>"><?php echo $c['name_check'] ?></span>
									</td>
									<td class="text-right">
										<span class="span_modify_check_<?php echo $c['id_check'] ?>" id="category_<?php echo $c['id_check'] ?>" data-idcategory="<?php echo $c['id_category_movement'] ?>"><?php echo $c['name_category_movement'] ?></span>
									</td>
									<td class="text-right <?php echo $c['color_debit'] ?>">
										<span class="span_modify_check_<?php echo $c['id_check'] ?>" id="amount_<?php echo $c['id_check'] ?>"><?php echo $c['amount'] ?></span>
									</td>
									<td class="text-right <?php echo $c['color_debit'] ?>">
										<?php if (isset($c['date_debit'])){ ?>
											<span class="span_modify_check_<?php echo $c['id_check'] ?> cursor_pointer" id="check_<?php echo $c['id_check'] ?>"><?php echo $c['date_debit'] ?> <span class="glyphicon glyphicon-ok text-success"></span></span>
										<?php }else{ ?>
											<span class="span_modify_check_<?php echo $c['id_check'] ?> cursor_pointer" id="check_<?php echo $c['id_check'] ?>" onclick="addCheckMovement('<?php echo $id_account ?>', '<?php echo $c['id_check'] ?>');"> <span class="glyphicon glyphicon-remove text-danger"></span></span>
										<?php } ?>
									</td>
									<td class="cursor_pointer" id="supprimer_<?php echo $c['id_check'] ?>">
										<span class="span_modify_check_<?php echo $c['id_check'] ?> glyphicon glyphicon-trash text-danger cursor_pointer" onclick="deleteCheck('<?php echo $id_account ?>', '<?php echo $c['id_check'] ?>', '<?php echo $c['id_movement'] ?>');"></span>
									</td>
								</tr>
							<?php } ?>
						<?php } ?>
					</table>
				<?php } ?>
				<div class="col-xs-12">
					<legend>Saisir un nouveau ch&egrave;que <span id="btn_form_add_check_<?php echo $id_account ?>" class="glyphicon glyphicon-plus text-primary cursor_pointer"></span></legend>
					<form id="form_add_check_<?php echo $id_account ?>" class="sr-only">
						<div id="columns" class="row">
						    <section class="col-sm-5">
						    	<div class="form-group has-feedback" id="div_amount_<?php echo $id_account ?>">
							    	<label for="amount_<?php echo $id_account ?>">Montant : </label>
									<input type="text" placeholder="Montant" class="form-control" name="amount_<?php echo $id_account ?>" id="amount_<?php echo $id_account ?>" />
									<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_amount_<?php echo $id_account ?>"></span>
								</div>
								<div class="form-group has-feedback" id="div_intitule_<?php echo $id_account ?>">
									<label for="intitule_<?php echo $id_account ?>">Intitul&eacute; : </label>
									<input type="text" placeholder="Intitul&eacute;" class="form-control" name="intitule_<?php echo $id_account ?>" id="intitule_<?php echo $id_account ?>" />
									<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_intitule_<?php echo $id_account ?>"></span>
								</div>
								<div class="form-group has-feedback" id="div_type_check_<?php echo $id_account ?>">
									<label for="select_type_check_<?php echo $id_account ?>">Cat&eacute;gorie : </label>
									<select class="form-control" id="select_type_check_<?php echo $id_account ?>" name="select_type_check_<?php echo $id_account ?>">
										<?php foreach ($categoryMovement as $c) echo '<option value="'.$c['id_category_movement'].'">'.$c['name_category_movement'].'</option>' ?>
									</select>
								</div>
							</section>
							<section class="col-sm-5">
								<div class="form-group has-feedback" id="div_date_release_check_<?php echo $id_account ?>">
									<label for="date_release_check_<?php echo $id_account ?>">Date : </label>
									<input type="text" placeholder="Date" class="form-control" name="date_release_check_<?php echo $id_account ?>" id="date_release_check_<?php echo $id_account ?>" />
									<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_date_release_check_<?php echo $id_account ?>"></span>
								</div>
								<div class="form-group has-feedback" id="div_select_user_check_<?php echo $id_account ?>">
									<label for="select_user_check_<?php echo $id_account ?>">Assigner &agrave; : </label>
									<select class="form-control" id="select_user_check_<?php echo $id_account ?>" name="select_user_check_<?php echo $id_account ?>">
										<option value="0">Tous le monde</option>
										<?php foreach ($users as $u) echo '<option value="'.$u['id_user_account'].'">'.$u['name_user_account'].'</option>' ?>
									</select>
								</div>
							</section>
						</div>
						<div class="row">
							<button type="button" class="btn btn-primary btn-sm" name="submit_check_<?php echo $id_account ?>" id="submit_check_<?php echo $id_account ?>"><span class="glyphicon glyphicon-plus"></span> Enregistrer</button>
						</div>
					</form>
				</div>
			</div>

			<script type="text/javascript">
				$(function() {
					$(function() {
						$("#date_release_check_<?php echo $id_account ?>").datepicker({ dateFormat: 'yy-mm-dd' });
					});

					addCheck("<?php echo $id_account ?>");
					toggleForm("form_add_check_<?php echo $id_account ?>");
				});
			</script>
			<?php $j++ ?>
		<?php } ?>
	</div>
	<input type="hidden" value="<?php echo $dateNow ?>" id="date_now" />
	<script type="text/javascript">
		$(function() {
			 $(function() {
				$("#date_begin").datepicker();
			});
			 $(function() {
				$("#date_end").datepicker();
			});

			toggleForm('form_synthesis_date');
		});
	</script>
</div>
<?php include "footer.php" ?>