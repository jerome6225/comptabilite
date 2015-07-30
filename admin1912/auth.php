<?php include dirname(__FILE__)."/../include.php" ?>
<html>
	<head>
		<title>Admin comptabilit&eacute;</title>
		<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/auth.css">
	</head>
	<body>
		<div id="global_auth">
			<div id="admin_auth" class="admin_auth">
				<div class="border_admin_auth">
					<h1 class="title_auth">Comptablilit&eacute; admin</h1>
					<form name="form_auth" id="form_auth" method="POST" action="">
						<label for="auth_mail">Identifiant: </label><br />
						<input type="text" tabIndex="1" class="input_login" name="auth_mail" id="auth_mail" /><br />
						<label for="auth_password">Mot de passe: </label><br />
						<input type="password" tabIndex="2" class="input_login" name="auth_password" id="auth_password" /><br />
						<button type="button" tabIndex="3" name="submit_auth_info" id="submit_auth_info" class="auth_button button_xlarge">Connexion</button>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(function(){
				$("#auth_mail").focus();

				$(document).on("click", "#submit_auth_info", function(e){
					if ($("#auth_mail").val() == "" || $("#auth_password").val() == "")
					{
						if ($("#auth_mail").val() == "" && $("#auth_password").val() == "")
						{
							$("#auth_mail").addClass("error_input");
							$("#auth_password").addClass("error_input");
						}
						else if ($("#auth_mail").val() == "")
						{
							$("#auth_mail").addClass("error_input");
							$("#auth_password").removeClass("error_input");
						}
						else if ($("#auth_password").val() == "")
						{
							$("#auth_mail").removeClass("error_input");
							$("#auth_password").addClass("error_input");
						}
					}
					else
					{
						$.ajax({
							type: "POST",
							url: "ajax/auth.php",
							data: {
								mail: $("#auth_mail").val(),
								password: $("#auth_password").val(),
							},
							success: function(msg){
								if (msg == 'ok')
								{
									document.location.href="index.php";
								}
								else if (msg == 'error')
								{
									alert('error');
								}
									
							}
						});
					}
				});
			});
		</script>
	</body>
</html>