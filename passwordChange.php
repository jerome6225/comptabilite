<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10">
	<h2 id="success_form_account" class="text-center text-success sr-only">F&eacute;licitation votre mot de passe &agrave; &eacute;t&eacute; modifi&eacute;</h2>
	<form id="form_account">
		<legend>Changer de mot de passe</legend>
		<section class="col-sm-5">
			<div class="form-group has-feedback" id="div_old_customer_password">
		    	<label for="old_customer_password">Ancien mot de passe : </label>
				<input type="password" placeholder="Ancien mot de passe" class="form-control" name="old_customer_password" id="old_customer_password" />
				<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_old_customer_password"></span>
			</div>
			<div class="form-group has-feedback" id="div_change_password">
		    	<label for="change_password">Nouveau mot de passe : </label>
				<input type="password" placeholder="Nouveau mot de passe" class="form-control" name="change_password" id="change_password" />
				<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_change_password"></span>
			</div>
			<div class="form-group has-feedback" id="div_change_password_confirm">
		    	<label for="change_password_confirm">Confirmez nouveau mot de passe : </label>
				<input type="password" placeholder="Confirmez nouveau mot de passe" class="form-control" name="change_password_confirm" id="change_password_confirm" />
				<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_change_password_confirm"></span>
			</div>

			<button type="button" class="btn btn-primary btn-sm" name="submit_change_password" id="submit_change_password"><span class="glyphicon glyphicon-thumbs-up"></span> Modifier</button>
		</section>
	</form>
</div>
<script type="text/javascript">
	$(function(){
		changePassword();
	});
</script>

<?php include "footer.php" ?>