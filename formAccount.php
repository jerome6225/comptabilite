<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/accountController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10">
	<h2 id="success_form_account" class="text-center text-success sr-only">F&eacute;licitation votre compte est maintenant configur&eacute;</h2>
	<form id="form_account">
		<?php for ($i=0;$i<$account;$i++){ ?>
			<?php $nb = ($i == 0) ? '1er' : ($i +1).'&egrave;me'; ?>
			<div id="columns" class="row">
				<legend>Saisissez les informations de votre <?php echo $nb ?> compte</legend>
				    <section class="col-sm-5">
				    	<div class="form-group has-feedback" id="div_new_customer_account_name_<?php echo $i ?>">
					    	<label for="new_customer_account_name_<?php echo $i ?>">Nom du compte : </label>
							<input type="text" placeholder="Nom" class="form-control" name="new_customer_account_name_<?php echo $i ?>" id="new_customer_account_name_<?php echo $i ?>" />
							<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_account_name_<?php echo $i ?>"></span>
						</div>
						<div class="form-group has-feedback" id="div_new_customer_account_type_<?php echo $i ?>">
							<label for="new_customer_account_type_<?php echo $i ?>">Type de compte : </label>
							<select id="new_customer_account_type_<?php echo $i ?>">
								<?php foreach ($accountType as $type) echo '<option value="'.$type['id_type_account'].'">'.$type['name_type_account'].'</option>' ?>
							</select>
						</div>
						<div class="form-group has-feedback" id="div_new_customer_account_nb_user_<?php echo $i ?>">
					    	<label for="new_customer_account_nb_user_<?php echo $i ?>">Nombre de personnes associ&eacute;es : </label>
							<input type="text" placeholder="Nombre de personnes" class="form-control" name="new_customer_account_nb_user_<?php echo $i ?>" id="new_customer_account_nb_user_<?php echo $i ?>" />
							<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_account_nb_user_<?php echo $i ?>"></span>
						</div>
						<div id="user_account_<?php echo $i ?>"></div>
					</section>
			</div>
			<script type="text/javascript">
				$(function(){
					showUserAccountForm("new_customer_account_nb_user_<?php echo $i ?>", "user_account_<?php echo $i ?>", "<?php echo $i ?>");
				});
			</script>
		<?php } ?>
		<div class="row">
			<button type="button" class="btn btn-primary btn-sm" name="submit_new_customer_account" id="submit_new_customer_account"><span class="glyphicon glyphicon-plus glyphicon-user"></span> Cr&eacute;er</button>
		</div>
	</form>
	<script type="text/javascript">
		$(function(){
			$(document).on("click", "#submit_new_customer_account", function(e){
				var check = true;
				<?php for ($i=0;$i<$account;$i++){ ?>
					if (!checkInput("new_customer_account_name_<?php echo $i ?>") || !checkIntVal("new_customer_account_nb_user_<?php echo $i ?>"))
						check = false;
				<?php } ?>

				if (check)
				{
					var info = {};
					<?php for ($i=0;$i<$account;$i++){ ?>
						info["account_name_<?php echo $i ?>"] = $("#new_customer_account_name_<?php echo $i ?>").val();
						info["account_type_<?php echo $i ?>"] =  $("#new_customer_account_type_<?php echo $i ?>").val();
						info["nb_user_<?php echo $i ?>"]      = $("#new_customer_account_nb_user_<?php echo $i ?>").val();

						for(var i=0;i<parseInt($("#new_customer_account_nb_user_<?php echo $i ?>").val());i++)
						{
							var infoUserAccountName = "id_user_account_<?php echo $i ?>_"+i;
							info[infoUserAccountName] =  $("#customer_user_account_name_<?php echo $i ?>_"+i).val();
						}
							
					<?php } ?>
					info["nb_account"] = "<?php echo $i ?>";

					$.ajax({
						type: "POST",
						url: "ajax/newAccount.php",
						data: {data: JSON.stringify(info)},
						success: function(msg){
							if (msg == 'ok')
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
							else
							{
								alert('error');
							}
						}
					});
				}
			});
		});
	</script>
</div>

<?php include "footer.php" ?>