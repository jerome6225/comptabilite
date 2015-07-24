<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/accountStatementController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10">
	<legend>Relev&eacute; des comptes</legend>
	<legend>S&eacute;lectionnez un mois pour voir relev&eacute; <span id="btn_form_synthesis_date" class="glyphicon glyphicon-plus text-primary cursor_pointer"></span></legend>
	<form class="form-inline sr-only" name="form_synthesis_date" id="form_synthesis_date" method="POST" action="accountStatement.php">
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
		<button type="submit" class="btn btn-primary btn-sm" name="submit_date_releve_info" id="submit_date_releve_info"><span class="glyphicon glyphicon-calendar"></span> Voir</button>
	</form>
	<br /><br />
	<legend>Relev&eacute; de compte</legend>
	<ul class="nav nav-tabs nav-justified">
		<?php $class = '' ?>
		<?php $i = 0 ?>
		<?php foreach ($movements as $key => $movement) { ?>
			<?php $explKey = explode('*', $key) ?>
			<?php $class = ($class == '') ? 'active' : 'disable'; ?>
			<li class="<?php echo $class ?>"><a href="#<?php echo $i ?>" data-toggle="tab"><?php echo $explKey[0] ?></a></li>
			<?php $i++ ?>
		<?php } ?>
	</ul>
	<div class="tab-content">
		<?php $classContent = '' ?>
		<?php $j = 0 ?>
		<?php foreach ($movements as $key => $movement) { ?>
			<?php $explKey = explode('*', $key) ?>
			<?php $id_account = $explKey[1] ?>
			<?php $classContent = ($classContent == '') ? 'active' : 'blabla'; ?>
			<div class="table-responsive tab-pane <?php echo $classContent ?>" id="<?php echo $j ?>">
				<br /><br />
				<?php if (count($movement) == 0){ ?>
					<div>Aucune informations pour ce compte</div>
				<?php }else{ ?>
					<table class="table table-hover">
						<tr>
							<th>Date</th>
							<th>Utilisateur</th>
							<th>Intitul&eacute;</th>
							<th>Cat&eacute;gorie</th>
							<th>Montant</th>
							<th colspan="2">&nbsp;</th>
						</tr>
						<?php $total = 0 ?>
						<?php foreach ($movement as $mov) { ?>
							<?php foreach ($mov as $m) { ?>
								<tr class="text-left" id="tr_<?php echo $m['id_movement'] ?>">
									<td>
										<span class="span_modify_movement_<?php echo $m['id_movement'] ?>" id="date_<?php echo $m['id_movement'] ?>"><?php echo $m['date_movement'] ?></span>
											<input type="text" class="sr-only input_hidden_<?php echo $m['id_movement'] ?> input_monthly" id="modify_date_begin_<?php echo $m['id_movement'] ?>" value="<?php echo $m['date_begin'] ?>" />
										<?php if($m['monthly']){ ?>
											<input type="text" class="sr-only input_hidden_<?php echo $m['id_movement'] ?> input_monthly" id="modify_date_end_<?php echo $m['id_movement'] ?>" value="<?php echo $m['date_end'] ?>" />
										<?php } ?>
									</td>
									<td class="text-left" id="user_color_<?php echo $m['id_movement'] ?>" <?php if (isset($m['color'])){ ?>style="background-color: <?php echo $m['color'] ?>"<?php } ?>>
										<span class="span_modify_movement_<?php echo $m['id_movement'] ?>" id="user_<?php echo $m['id_movement'] ?>"><?php echo (isset($m['name_user_account'])) ? $m['name_user_account'] : 'Tout le monde'; ?></span>
										<select class="sr-only input_hidden_<?php echo $m['id_movement'] ?>" id="modify_user_<?php echo $m['id_movement'] ?>"><option value="0">Tout le monde</option><?php foreach ($users as $user){ ?><option value="<?php echo $user['id_user_account']?>"><?php echo $user['name_user_account']?></option><?php } ?></select>
									</td>
									<td class="text-left">
										<span class="span_modify_movement_<?php echo $m['id_movement'] ?>" id="name_<?php echo $m['id_movement'] ?>"><?php echo $m['name_movement'] ?></span>
										<input type="text" class="sr-only input_hidden_<?php echo $m['id_movement'] ?>" id="modify_name_<?php echo $m['id_movement'] ?>" value="<?php echo $m['name_movement'] ?>" />
									</td>
									<td class="text-right">
										<span class="span_modify_movement_<?php echo $m['id_movement'] ?>" id="category_<?php echo $m['id_movement'] ?>"><?php echo $m['movement_category'] ?></span>
										<select class="sr-only input_hidden_<?php echo $m['id_movement'] ?>" id="modify_category_<?php echo $m['id_movement'] ?>">
											<?php foreach ($categoryMovement as $c)
												{
													$selected = ($c['name_category_movement'] == $m['movement_category']) ? 'selected' : '';
													echo '<option value="'.$c['id_category_movement'].'" '.$selected.'>'.$c['name_category_movement'].'</option>';
												}
											?>
										</select>
									</td>
									<td class="text-right <?php echo $m['color_debit'] ?>">
										<span class="span_modify_movement_<?php echo $m['id_movement'] ?>" id="amount_<?php echo $m['id_movement'] ?>"><?php echo $m['amount'] ?></span>
										<input type="text" class="sr-only input_hidden_<?php echo $m['id_movement'] ?>" id="modify_amount_<?php echo $m['id_movement'] ?>" value="<?php echo $m['amount'] ?>" />
									</td>
									<td class="cursor_pointer" id="modifier_<?php echo $m['id_movement'] ?>">
										<span class="span_modify_movement_<?php echo $m['id_movement'] ?> glyphicon glyphicon-edit text-primary cursor_pointer" onclick="showModifyMovement('<?php echo $m['id_movement'] ?>');"></span>
										<button type="button" class="btn btn-primary btn-sm sr-only input_hidden_<?php echo $m['id_movement'] ?>" onclick="validModify('<?php echo $m['id_movement'] ?>', '<?php echo $m['monthly'] ?>');" id="modify_valid_<?php echo $m['id_movement'] ?>"><span class="glyphicon glyphicon-pencil"></span> Valider</button>
									</td>
									<td class="cursor_pointer" id="supprimer_<?php echo $m['id_movement'] ?>">
										<span class="span_modify_movement_<?php echo $m['id_movement'] ?> glyphicon glyphicon-trash text-danger cursor_pointer" onclick="deleteMovement('<?php echo $m['id_movement'] ?>');"></span>
										<button type="button" class="btn btn-primary btn-sm sr-only input_hidden_<?php echo $m['id_movement'] ?>" onclick="cancelModify('<?php echo $m['id_movement'] ?>');" id="modify_cancel_<?php echo $m['id_movement'] ?>"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
									</td>
								</tr>
								<input type="hidden" id="id_movement_assoc_<?php echo $m['id_movement'] ?>" value="<?php echo $m['id_movement_assoc'] ?>" />
								<input type="hidden" id="id_account_<?php echo $m['id_movement'] ?>" value="<?php echo $m['id_account'] ?>" />
								<input type="hidden" id="debit_<?php echo $m['id_movement'] ?>" value="<?php echo $m['debit'] ?>" />
								<script type="text/javascript">
									$(function() {
										 $(function() {
											$("#modify_date_begin_<?php echo $m['id_movement'] ?>").datepicker({ dateFormat: 'yy-mm-dd' });
										});
										 $(function() {
											$("#modify_date_end_<?php echo $m['id_movement'] ?>").datepicker({ dateFormat: 'yy-mm-dd' });
										});
									});
								</script>
								<?php $total = ($m['debit'] == "1") ? (float)$total - (float)$m['calc_amount'] : (float)$total + (float)$m['calc_amount'] ?>
							<?php } ?>
						<?php } ?>
					
						<tr>
							<td class="text-right" colspan="4">TOTAL DES MOUVEMENTS</td>
							<td class="text-right <?php if ((float)$total > 0){ ?>text-success<?php }else{ ?>text-danger<?php } ?> total_movement_<?php echo $id_account ?>"><?php echo round($total, 2, PHP_ROUND_HALF_UP) ?></td>
						</tr>
					</table>
				<?php } ?>
				<div class="col-xs-12">
					<legend>Saisir une nouvelle entr&eacute;e <span id="btn_form_choice_account_<?php echo $id_account ?>" class="glyphicon glyphicon-plus text-primary cursor_pointer"></span></legend>
					<form id="form_choice_account_<?php echo $id_account ?>" class="sr-only">
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
								<div class="form-group has-feedback" id="div_type_movement_<?php echo $id_account ?>">
									<label for="select_type_movement_<?php echo $id_account ?>">Cat&eacute;gorie : </label>
									<select class="form-control" id="select_type_movement_<?php echo $id_account ?>" name="select_type_movement_<?php echo $id_account ?>">
										<?php foreach ($categoryMovement as $c) echo '<option value="'.$c['id_category_movement'].'">'.$c['name_category_movement'].'</option>' ?>
									</select>
								</div>
								<div class="form-group has-feedback" id="div_account_movement_<?php echo $id_account ?>" style="display: none;">
									<label for="select_account_movement_<?php echo $id_account ?>">Compte associ&eacute; : </label>
									<select class="form-control" id="select_account_movement_<?php echo $id_account ?>" name="select_account_movement_<?php echo $id_account ?>">
										<?php foreach ($accounts as $a) if ($a['id_account'] != $id_account) echo '<option value="'.$a['id_account'].'">'.$a['name'].'</option>' ?>
									</select>
								</div>
								<div class="form-group has-feedback" id="div_select_debit_<?php echo $id_account ?>">
									<label for="select_debit_<?php echo $id_account ?>">Type : </label>
									<select class="form-control" id="select_debit_<?php echo $id_account ?>" name="select_debit_<?php echo $id_account ?>">
										<option value="0">Revenus</option>
										<option value="1">D&eacute;pense</option>
									</select>
								</div>
								<div class="form-group has-feedback" id="div_date_movement_<?php echo $id_account ?>">
									<label for="date_movement_<?php echo $id_account ?>">Date : </label>
									<input type="text" placeholder="Date" class="form-control" name="date_movement_<?php echo $id_account ?>" id="date_movement_<?php echo $id_account ?>" />
									<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_date_movement_<?php echo $id_account ?>"></span>
								</div>
							</section>
							<section class="col-sm-5">
								<div class="form-group has-feedback" id="div_select_user_movement_<?php echo $id_account ?>">
									<label for="select_user_movement_<?php echo $id_account ?>">Assigner &agrave; : </label>
									<select class="form-control" id="select_user_movement_<?php echo $id_account ?>" name="select_user_movement_<?php echo $id_account ?>">
										<option value="0">Tous le monde</option>
										<?php foreach ($users as $u) echo '<option value="'.$u['id_user_account'].'">'.$u['name_user_account'].'</option>' ?>
									</select>
								</div>
								<div class="form-group has-feedback" id="div_select_monthly_<?php echo $id_account ?>">
									<label for="select_monthly_<?php echo $id_account ?>">P&eacute;riodicit&eacute; : </label>
									<select class="form-control" id="select_monthly_<?php echo $id_account ?>" name="select_monthly_<?php echo $id_account ?>">
										<option value="0">Une seule fois</option>
										<option value="1">Tous les mois</option>
									</select>
								</div>
								<div id="div_monthly_<?php echo $id_account ?>" style="display: none;">
									<div class="form-group has-feedback" id="div_date_end_movement_<?php echo $id_account ?>">
										<label for="date_end_movement_<?php echo $id_account ?>">Date de fin : </label>
										<input type="text" placeholder="Date de fin" class="form-control" name="date_end_movement_<?php echo $id_account ?>" id="date_end_movement_<?php echo $id_account ?>" />
										<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_date_end_movement_<?php echo $id_account ?>"></span>
									</div>
									<div class="form-group has-feedback" id="div_select_annual_<?php echo $id_account ?>">
										<label for="select_annual_<?php echo $id_account ?>">Mouvement annuel : </label><br />
										<select class="input_login" id="select_annual_<?php echo $id_account ?>" name="select_annual_<?php echo $id_account ?>">
											<option value="1">Annuel</option>
											<option value="0">Sur quelques mois</option>
										</select>
									</div>
								</div>
								<div id="div_annual_<?php echo $id_account ?>" style="display: none;">
									<div class="form-group has-feedback" id="div_input_annual_<?php echo $id_account ?>">
										<label for="input_annual_<?php echo $id_account ?>">Combien de mois : </label>
										<input type="text" placeholder="Date de fin" class="form-control" name="input_annual_<?php echo $id_account ?>" id="input_annual_<?php echo $id_account ?>" />
										<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_input_annual_<?php echo $id_account ?>"></span>
									</div>
								</div>
							</section>
						</div>
						<div class="row">
							<button type="button" class="btn btn-primary btn-sm" name="submit_select_choice_account_<?php echo $id_account ?>" id="submit_select_choice_account_<?php echo $id_account ?>"><span class="glyphicon glyphicon-plus"></span> Enregistrer</button>
						</div>
					</form>
				</div>
			</div>
			
			<script type="text/javascript">
				$(function() {
					$(function() {
						$("#date_movement_<?php echo $id_account ?>").datepicker({ dateFormat: 'yy-mm-dd' });
					});
					$(function() {
						$("#date_end_movement_<?php echo $id_account ?>").datepicker({ dateFormat: 'yy-mm-dd' });
					});

					movement("<?php echo $id_account ?>");
					toggleForm("form_choice_account_<?php echo $id_account ?>");
				});
			</script>
			<?php $j++ ?>
		<?php } ?>
	</div>
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