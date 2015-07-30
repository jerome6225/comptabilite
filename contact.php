<?php include dirname(__FILE__)."/include.php" ?>
<?php include dirname(__FILE__)."/redirectAuth.php" ?>
<?php include dirname(__FILE__)."/controllers/contactController.php" ?>
<?php include dirname(__FILE__)."/header.php" ?>

<div class="row col-sm-offset-1 col-sm-10 top-sm-xs">
	<legend>Contact</legend>
	<?php if ($mailPost && $checkCaptcha){ 
		if ($result) { ?>
			<h2 id="success_form_account" class="text-center text-success">F&eacute;licitation le message a bien &eacute;t&eacute; envoy&eacute;</h2>
		<?php } else { ?>
			<h2 id="success_form_account" class="text-center text-danger">D&eacute;sol&eacute; le message n'a pas &eacute;t&eacute; envoy&eacute;</h2>
		<?php } ?>
	<?php }else { ?>
	<form class="" name="form_contact" id="form_contact" method="POST" action="contact.php">
		<div id="columns" class="row">
		    <section class="col-sm-7">
		    	<div class="form-group has-feedback margin_bottom col-sm-8" id="div_email">
			    	<label for="email">Email : </label>
					<input type="text" placeholder="Email" class="form-control" name="email" id="email" />
					<span class="glyphicon form-control-feedback email-width" aria-hidden="true" id="span_email"></span>
				</div>
				<div class="form-group has-feedback margin_bottom col-sm-12" id="div_message">
					<label for="message">Message : </label>
					<textarea type="text" placeholder="Votre message" class="form-control" name="message" id="message" rows="4"></textarea>
				</div>
			</section>
			<section class="col-sm-7 margin_bottom">
				<?php if (!$checkCaptcha){ ?>
					<legend class="text-danger">D&eacute;sol&eacute; erreur de captcha</legend>
				<?php } ?>
				<div class="g-recaptcha col-sm-8" data-sitekey="6Le0igoTAAAAAAeuGa9K_C_jUsw_20u_GPw5BSLu"></div>
			</section>
		</div>
		<div class="row">
			<button type="submit" class="btn btn-primary btn-sm" name="submit_message" id="submit_message"><span class="glyphicon glyphicon-envelope"></span> Envoyer</button>
		</div>
	</form>
	<script type="text/javascript">
		$(function(){
			$(document).on("blur", "#email", function(){
				checkMail($("#email").val());
			});

			$(document).on("click", "#submit_message", function(e){
				e.preventDefault();
				if (isMailValid)
					$("#form_contact").submit();
			});
		});
	</script>
<?php } ?>
</div>
<?php include "footer.php" ?>