<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/deleteAccountController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10 top-sm-xs">
	<form id="form" class="inline-form">
		<legend>Choisissez le compte &agrave; supprimer</legend>
		<div class="form-group has-feedback" id="form_delete_account">
			<label for="delete_account">Utilisateur : </label>
			<select class="input_login" id="delete_account">
				<?php foreach ($accounts as $a) echo '<option value="'.$a['id_account'].'">'.$a['name'].'</option>' ?>
			</select>
			<button type="button" class="btn btn-primary btn-sm" name="submit_delete_account" id="submit_delete_account"><span class="glyphicon glyphicon-thumbs-up"></span> Valider</button>
		</div>
	</form>
	<h2 id="success_form_account" class="text-center text-success sr-only">F&eacute;licitation le compte &agrave; &eacute;t&eacute; supprim&eacute;</h2>
</div>

<script type="text/javascript">
	$(function(){
		deleteAccount();
	});
</script>
<?php include "footer.php" ?>