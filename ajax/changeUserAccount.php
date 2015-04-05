<?php
	include dirname(__FILE__)."/../include.php";

	$userAccount = UserAccount::getUserAccount($_POST['id_user_account']);

	if ($userAccount)
	{
		echo '<form id="form_change_user_account">
					<legend>Modifier l\'utilisateur</legend>
					<section class="col-sm-5">
						<div class="form-group has-feedback" id="div_name_modif_user_account">
					    	<label for="name_modif_user_account">Nom : </label>
							<input type="text" placeholder="Nom" class="form-control" name="name_modif_user_account" id="name_modif_user_account" />
							<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_name_modif_user_account"></span>
						</div>
						<div class="form-group has-feedback" id="div_color_modif_user_account">
					    	<label for="color_modif_user_account">Nouveau mot de passe : </label>
							<input type="color" placeholder="Nouveau mot de passe" class="form-control" name="color_modif_user_account" id="color_modif_user_account" />
							<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_color_modif_user_account"></span>
						</div>

						<button type="button" class="btn btn-primary btn-sm" name="submit_form_modif_user_account" id="submit_form_modif_user_account"><span class="glyphicon glyphicon-thumbs-up"></span> Modifier</button>
					</section>
				</form>
				<script>
					$(function(){
						changeUserAccount("'.$_POST['id_user_account'].'");
					});
				</script>';
				exit;
	}

	echo 'error';
	exit;