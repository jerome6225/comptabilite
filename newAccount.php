<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/accountController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10 top-sm-xs">
	<h2 id="success_form_account" class="text-center text-success sr-only">F&eacute;licitation votre nouveau compte est enregistr&eacute;</h2>
	<form id="form_account">
		<legend>Saisissez Les informations de votre nouveau compte</legend>
		<div id="columns" class="row">
		    <section class="col-sm-5">
		    	<div class="form-group has-feedback" id="div_new_customer_account_name">
			    	<label for="new_customer_account_name">Nom : </label>
					<input type="text" placeholder="Nom" class="form-control" name="new_customer_account_name" id="new_customer_account_name" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_account_name"></span>
				</div>
				<div class="form-group has-feedback" id="div_new_customer_account_type">
					<label for="new_customer_account_type">Type : </label>
					<select id="new_customer_account_type">
						<?php foreach ($accountType as $type) echo '<option value="'.$type['id_type_account'].'">'.$type['name_type_account'].'</option>' ?>
					</select>
				</div>
				<div class="form-group has-feedback" id="div_new_customer_account_nb_user">
			    	<label for="new_customer_account_nb_user">Nombre de personnes associ&eacute;es : </label>
					<input type="text" placeholder="Nombre de personnes" class="form-control" name="new_customer_account_nb_user" id="new_customer_account_nb_user" />
					<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_account_nb_user"></span>
				</div>
				<div id="user_account"></div>
			</section>
		</div>
		<div class="row">
			<button type="button" class="btn btn-primary btn-sm" name="submit_new_customer_account" id="submit_new_customer_account"><span class="glyphicon glyphicon-plus"></span> Cr&eacute;er</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	$(function(){
		showUserAccountForm("new_customer_account_nb_user", "user_account", "0");

		$(document).on("click", "#submit_new_customer_account", function(e){
			var checkName      = checkInput("new_customer_account_name");
			var checkIsIntPers = checkIntVal("new_customer_account_nb_user");

			if (checkName && checkIsIntPers)
			{
				var info = {};
				info["account_name_0"] = $("#new_customer_account_name").val();
				info["account_type_0"] =  $("#new_customer_account_type").val();
				info["nb_user_0"]      = $("#new_customer_account_nb_user").val();

				for(var i=0;i<parseInt($("#new_customer_account_nb_user").val());i++)
				{
					var infoUserAccountName = "id_user_account_0_"+i;
					info[infoUserAccountName] =  $("#customer_user_account_name_0_"+i).val();
				}
				info["nb_account"] = 1;

				$.ajax({
					type: "POST",
					url: "ajax/newAccount.php",
					data: {data: JSON.stringify(info)},
					success: function(msg){
						if (msg == 'error')
						{
							alert('Erreur pendant l\'enregistrement');
						}
						else
						{
							$.ajax({
								type: "POST",
								url: "ajax/getInfoAccount.php",
								success: function(msg){
									if (msg == "error")
									{
										alert("erreur pendant l\'enregistrement");
									}
									else
									{
										$("#select_choice_account").html(msg);
									}
								}
							});
							$("#success_form_account").removeClass("sr-only");
							$("#form_account").addClass("sr-only");
						}
					}
				});
			}
		});
	});
</script>

<?php include "footer.php" ?>