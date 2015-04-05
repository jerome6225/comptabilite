<?php
	include dirname(__FILE__)."/../include.php";

	$_SESSION['id_account_modif'] = $_POST['account'];

	$account = Account::getAccounts($_SESSION['id_user']);
	
	if ($account)
	{
		$accountType = TypeAccount::getTypesAccount();

		$select = "";

		foreach ($accountType as $a)
			if ($a['id'] == $account->type_account)
				$select .= '<option value="'.$a['id_type_account'].'" selected>'.$a['name_type_account'].'</option>';
			else
				$select .= '<option value="'.$a['id_type_account'].'">'.$a['name_type_account'].'</option>';

		$html = '<form id="form_account">
					<legend>Saisissez Les modifications du compte</legend>
					<div id="columns" class="row">
					    <section class="col-sm-5">
					    	<div class="form-group has-feedback" id="div_select_name_modif_account">
						    	<label for="select_name_modif_account">Nom : </label>
								<input type="text" placeholder="Nom" class="form-control" name="select_name_modif_account" id="select_name_modif_account" />
								<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_select_name_modif_account"></span>
							</div>
							<div class="form-group has-feedback" id="div_select_type_modif_account">
								<label for="select_type_modif_account">Type : </label>
								<select id="select_type_modif_account">
									'.$select.'
								</select>
							</div>
							<div class="form-group has-feedback" id="div_select_user_modif_account">
						    	<label for="select_user_modif_account">Nombre de personnes associ&eacute;es : </label>
								<input type="text" placeholder="Nombre de personnes" class="form-control" name="select_user_modif_account" id="select_user_modif_account" />
								<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_select_user_modif_account"></span>
							</div>
							<div id="user_account"></div>
						</section>
					</div>
					<div class="row">
						<button type="button" class="btn btn-primary btn-sm" name="submit_modif_account" id="submit_modif_account"><span class="glyphicon glyphicon-plus"></span> Modifier</button>
					</div>
				</form>
				<script type="text/javascript">
					$(function(){
						showUserAccountForm("select_user_modif_account", "user_account", "0");
						modifAccount();
					});
				</script>';

		echo $html;
		exit;
	}
	else
	{
		echo 'error';
		exit;
	}
	