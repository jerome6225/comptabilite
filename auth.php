<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10 top-sm-xs">
	<form>
		<div id="columns" class="row">
			<legend>Cr&eacute;ez votre compte</legend>
		    <section class="col-sm-5">
		    	<div class="form-group has-feedback" id="div_new_customer_first_name">
			    	<label for="new_customer_first_name">Pr&eacute;nom : </label>
					<input type="text" placeholder="Pr&eacute;nom" class="form-control" name="new_customer_first_name" id="new_customer_first_name" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_first_name"></span>
				</div>
				<div class="form-group has-feedback" id="div_new_customer_last_name">
					<label for="new_customer_last_name">Nom : </label>
					<input type="text" placeholder="Nom" class="form-control" name="new_customer_last_name" id="new_customer_last_name" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_last_name"></span>
				</div>
				<div class="form-group has-feedback" id="div_new_customer_login">
					<label for="new_customer_login">Login : </label>
					<input type="text" placeholder="Login" class="form-control" name="new_customer_login" id="new_customer_login" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_login"></span>
					<span class="text-danger" id="span_login_exist" style="display: none;">Login d&eacute;j&agrave; existant</span>
				</div>
			</section>
			<section class="col-sm-5">
				<div class="form-group has-feedback" id="div_new_customer_password">
					<label for="new_customer_password">Mot de passe : </label>
					<input type="password" placeholder="Mot de passe" class="form-control" name="new_customer_password" id="new_customer_password" value="" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_password"></span>
				</div>
				<div class="form-group has-feedback" id="div_new_customer_password_confirm">
					<label for="new_customer_password_confirm">Confirmez mot de passe: </label>
					<input type="password" placeholder="Mot de passe" class="form-control" name="new_customer_password_confirm" id="new_customer_password_confirm" value="" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_password_confirm"></span>
				</div>
				<div class="form-group has-feedback" id="div_new_customer_account">
					<label for="new_customer_account">Nombre de compte : </label>
					<input type="text" placeholder="Nombre de compte" class="form-control" name="new_customer_account" id="new_customer_account" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_account"></span>
				</div>
				<div class="form-group has-feedback" id="div_new_customer_user_account">
					<label for="new_customer_user_account">Nombre de personne &agrave; associer: </label><br />
					<input type="text" placeholder="Nombre de personne" class="form-control" name="new_customer_user_account" id="new_customer_user_account" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_user_account"></span>
				</div>
			</section>
		</div>
		<div class="row">
			<button type="button" class="btn btn-primary btn-sm" name="submit_new_customer_info" id="submit_new_customer_info"><span class="glyphicon glyphicon-plus glyphicon-user"></span> Cr&eacute;er</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	$(function(){
		checkNewLogin("new_customer_login");
		submitNewUser();
	});
</script>

<?php include "footer.php" ?>