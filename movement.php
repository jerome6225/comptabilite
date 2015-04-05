<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>
<?php if (!isset($_SESSION['id_account'])){ ?>
	<div class="row col-sm-offset-1 col-sm-10">
		<header class="page-header">
        	<h2 class="has-error">S&eacute;lectionner d'abord un compte sur lequel le mouvement sera comptabilis&eacute;</h2>
		</header>
	</div>
<?php }else{ ?>
	<?php include dirname(__FILE__)."/controllers/movementController.php" ?>
	<div class="row col-sm-offset-1 col-sm-10">
		<form>
			<div id="columns" class="row">
				<legend>Saisir une nouvelle entr&eacute;e</legend>
			    <section class="col-sm-5">
			    	<div class="form-group has-feedback" id="div_amount">
				    	<label for="amount">Montant : </label>
						<input type="text" placeholder="Montant" class="form-control" name="amount" id="amount" />
						<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_amount"></span>
					</div>
					<div class="form-group has-feedback" id="div_intitule">
						<label for="intitule">Intitul&eacute; : </label>
						<input type="text" placeholder="Intitul&eacute;" class="form-control" name="intitule" id="intitule" />
						<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_intitule"></span>
					</div>
					<div class="form-group has-feedback" id="div_new_customer_login">
						<label for="select_type_movement">Cat&eacute;gorie : </label>
						<select class="form-control" id="select_type_movement" name="select_type_movement">
							<?php foreach ($categoryMovement as $c) echo '<option value="'.$c['id_category_movement'].'">'.$c['name_category_movement'].'</option>' ?>
						</select>
					</div>
					<div class="form-group has-feedback" id="div_select_debit">
						<label for="select_debit">Type : </label>
						<select class="form-control" id="select_debit" name="select_debit">
							<option value="0">Revenus</option>
							<option value="1">D&eacute;pense</option>
						</select>
					</div>
					<div class="form-group has-feedback" id="div_date_movement">
						<label for="date_movement">Date : </label>
						<input type="text" placeholder="Date" class="form-control" name="date_movement" id="date_movement" />
						<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_date_movement"></span>
					</div>
				</section>
				<section class="col-sm-5">
					<div class="form-group has-feedback" id="div_select_user_movement">
						<label for="select_user_movement">Assigner &agrave; : </label>
						<select class="form-control" id="select_user_movement" name="select_user_movement">
							<option value="0">Tous le monde</option>
							<?php foreach ($users as $u) echo '<option value="'.$u['id'].'">'.$u['name'].'</option>' ?>
						</select>
					</div>
					<div class="form-group has-feedback" id="div_select_monthly">
						<label for="select_monthly">P&eacute;riodicit&eacute; : </label>
						<select class="form-control" id="select_monthly" name="select_monthly">
							<option value="0">Une seule fois</option>
							<option value="1">Tous les mois</option>
						</select>
					</div>
					<div id="div_monthly" style="display: none;">
						<div class="form-group has-feedback" id="div_date_end_movement">
							<label for="date_end_movement">Date de fin : </label>
							<input type="text" placeholder="Date de fin" class="form-control" name="date_end_movement" id="date_end_movement" />
							<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_date_end_movement"></span>
						</div>
						<div class="form-group has-feedback" id="div_select_annual">
							<label for="select_annual">Mouvement annuel : </label><br />
							<select class="input_login" id="select_annual" name="select_annual">
								<option value="1">Annuel</option>
								<option value="0">Sur quelques mois</option>
							</select>
						</div>
					</div>
					<div id="div_annual" style="display: none;">
						<div class="form-group has-feedback" id="div_input_annual">
							<label for="input_annual">Combien de mois : </label>
							<input type="text" placeholder="Date de fin" class="form-control" name="input_annual" id="input_annual" />
							<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_input_annual"></span>
						</div>
					</div>
				</section>
			</div>
			<div class="row">
				<button type="button" class="btn btn-primary btn-sm" name="submit_select_choice_account" id="submit_select_choice_account"><span class="glyphicon glyphicon-plus"></span> Enregistrer</button>
			</div>
		</form>
	</div>

	<script type="text/javascript">
	$(function() {
		$(function() {
			$("#date_movement").datepicker({ dateFormat: 'yy-mm-dd' });
		});
		$(function() {
			$("#date_end_movement").datepicker({ dateFormat: 'yy-mm-dd' });
		});

		movement();
	});
	</script>
<?php } ?>
<?php include "footer.php" ?>