<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/changeAccountController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10 top-sm-xs">
	<form id="form" class="inline-form">
		<legend>Choisissez le compte &agrave; modifier</legend>
		<div class="form-group has-feedback" id="form_select_account">
			<label for="select_account">Utilisateur : </label>
			<select class="input_login" id="select_account">
				<?php foreach ($accounts as $a) echo '<option value="'.$a['id_account'].'">'.$a['name'].'</option>' ?>
			</select>
			<button type="button" class="btn btn-primary btn-sm" name="submit_select_account" id="submit_select_account"><span class="glyphicon glyphicon-thumbs-up"></span> Valider</button>
		</div>
	</form>
	<h2 id="success_form_account" class="text-center text-success sr-only">F&eacute;licitation le compte &agrave; &eacute;t&eacute; modifi&eacute;</h2>
	<div id="div_modif_account"></div>
</div>

<script type="text/javascript">
	$(function(){
		changeAccount();
	});
</script>
<?php include "footer.php" ?>