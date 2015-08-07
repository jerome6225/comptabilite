<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10 top-sm-xs">
	<form id="form" class="inline-form">
		<legend>Supprimer votre compte</legend>
		<div class="form-group has-feedback" id="form_delete_user">
			<label for="delete_user">Voulez vous vraiment supprimer votre compte? (toutes vos donn&eacute;es seront supprim&eacute;es) : </label>
			<button type="button" class="btn btn-primary btn-sm" name="submit_delete_user" id="submit_delete_user"><span class="glyphicon glyphicon-floppy-remove"></span> Supprimer</button>
		</div>
	</form>
	<h2 id="success_form_account" class="text-center text-success sr-only">Votre compte &agrave; &eacute;t&eacute; supprim&eacute;</h2>
</div>

<script type="text/javascript">
	$(function(){
		deleteUser();
	});
</script>
<?php include "footer.php" ?>