<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/createUserController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10 top-sm-xs">
	<form>
		<?php for ($i=0;$i<$nb_user;$i++){ ?>
			<?php $currentUser = ($i == 0) ? '1er' : ($i +1).'&egrave;me'; ?>
			<div id="columns" class="row">
				<legend>Information du <?php echo $currentUser ?> utilisateur <?php echo $titleNbAccount ?></legend>
				    <section class="col-sm-5">
				    	<div class="form-group has-feedback" id="div_new_customer_user_account_name_<?php echo $i ?>">
					    	<label for="new_customer_user_account_name_<?php echo $i ?>">Nom : </label>
							<input type="text" placeholder="Nom" class="form-control" name="new_customer_user_account_name_<?php echo $i ?>" id="new_customer_user_account_name_<?php echo $i ?>" />
							<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_user_account_name_<?php echo $i ?>"></span>
						</div>
						<div class="form-group has-feedback" id="div_new_customer_user_account_color_<?php echo $i ?>">
							<label for="new_customer_user_account_color_<?php echo $i ?>">Couleur : </label>
							<input type="color" placeholder="Couleur" class="form-control" name="new_customer_user_account_color_<?php echo $i ?>" id="new_customer_user_account_color_<?php echo $i ?>" />
							<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_new_customer_user_account_color_<?php echo $i ?>"></span>
						</div>
					</section>
			</div>
		<?php } ?>
		<div class="row">
			<button type="button" class="btn btn-primary btn-sm" name="submit_new_customer_user_account" id="submit_new_customer_user_account"><span class="glyphicon glyphicon-floppy-saved"></span> Cr&eacute;er</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	$(function(){
		$(document).on("click", "#submit_new_customer_user_account", function(e){
			var continu = true;
			<?php for ($i=0;$i<$nb_user;$i++){ ?>
				if (!checkInput("new_customer_user_account_name_<?php echo $i ?>"))
					continu = false
			<?php } ?>
			
			if (continu)
			{
				$.ajax({
					type: "POST",
					url: "ajax/newUserAccount.php",
					data: {
						nb_user: '<?php echo $nb_user ?>',
						<?php for ($i=0;$i<$nb_user;$i++){ ?>
							user_name_<?php echo $i ?>: $("#new_customer_user_account_name_<?php echo $i ?>").val(),
							user_color_<?php echo $i ?>: $("#new_customer_user_account_color_<?php echo $i ?>").val(),
						<?php } ?>
					},
					success: function(msg){
						if (msg == "ok")
						{
							document.location.href="formAccount.php";

							return false;
						}
						else if (msg == "error_insert_user_account")
						{
							alert("erreur pendant l\'enregistrement");
						}
						else if (msg =="error_select_account")
						{
							alert("num&eacutero de compte non trouv&eacute;");
						}
					}
				});
			}
		});
	});
</script>

<?php include "footer.php" ?>