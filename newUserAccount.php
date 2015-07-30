<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/accountController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10 top-sm-xs">
	<h2 id="success_form_account" class="text-center text-success sr-only">F&eacute;licitation le nouvel utilisateur &agrave; &eacute;t&eacute; cr&eacute;&eacute;</h2>
	<form id="form_account">
		<legend>Saisir le nouvel utilisateur</legend>
		<section class="col-sm-5">
			<div class="form-group has-feedback" id="div_new_customer_user_account_name">
		    	<label for="new_customer_user_account_name">Nom : </label>
				<input type="text" placeholder="Nom" class="form-control" name="new_customer_user_account_name" id="new_customer_user_account_name" />
				<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_user_account_name"></span>
			</div>
			<div class="form-group has-feedback" id="div_new_customer_user_account_color">
		    	<label for="new_customer_user_account_color">Couleur : </label>
				<input type="color" placeholder="" class="form-control" name="new_customer_user_account_color" id="new_customer_user_account_color" />
				<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_user_account_color"></span>
			</div>

			<button type="button" class="btn btn-primary btn-sm" name="submit_new_customer_user_account" id="submit_new_customer_user_account"><span class="glyphicon glyphicon-user"></span> Modifier</button>
		</section>
	</form>
</div>
<script type="text/javascript">
	$(function(){
		createNewUser();
	});
</script>

<?php include "footer.php" ?>