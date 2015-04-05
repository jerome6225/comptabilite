<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/changeUserAccountController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10">
	<form id="form_account" class="inline-form">
		<legend>Selectionnez l'utilisateur &agrave; modifier</legend>
		<div class="form-group has-feedback" id="div_form_select_modif_user_account">
			<label for="form_select_modif_user_account">Utilisateur : </label>
			<select class="input_login" id="select_modif_user_account">
				<?php foreach ($users as $user) echo '<option value="'.$user['id_user_account'].'">'.$user['name_user_account'].'</option>' ?>
			</select>
			<button type="button" class="btn btn-primary btn-sm" name="submit_form_select_modif_user_account" id="submit_form_select_modif_user_account"><span class="glyphicon glyphicon-thumbs-up"></span> Valider</button>
		</div>
	</form>
	<h2 id="success_form_account" class="text-center text-success sr-only">F&eacute;licitation l'utilisateur &agrave; &eacute;t&eacute; modifi&eacute;</h2>
	<div id="div_modif_user_account"></div>
</div>
<script type="text/javascript">
	$(function(){
		selectChangeUserAccount();
	});
</script>

<?php include "footer.php" ?>