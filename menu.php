<nav class="navbar navbar-inverse navbar-fixed-top" id="navbar-defile">
	<div class="container-fluid">
		<div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu-navigation"> 
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button> 
            <a class="navbar-brand visible-xs" href="#">Menu</a> 
        </div>
        <div class="collapse navbar-collapse"  id="menu-navigation">
			<ul class="nav navbar-nav">
				<li><a href="index.php">Accueil</a></li>
				<?php if (!isset($_SESSION['id_user'])){ ?>
				<li><a href="auth.php">Cr&eacute;er un compte</a></li>
			</ul>
				<form class="navbar-form navbar-right inline-form">
	            	<div class="form-group">
	            		<div class="form-group has-feedback" id="div_customer_login_login">
							<input type="text" class="input-sm form-control" placeholder="Login" name="customer_login_login" id="customer_login_login">
							<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_customer_login_login"></span>
						</div>
						<div class="form-group has-feedback" id="div_customer_login_password">
							<input type="password" class="input-sm form-control" placeholder="Mot de passe" name="customer_login_password" id="customer_login_password">
							<span class="glyphicon form-control-feedback" aria-hidden="true" id="span_customer_login_password"></span>
						</div>
						<button type="button" class="btn btn-primary btn-sm" name="submit_customer_info" id="submit_customer_info"><span class="glyphicon glyphicon-user"></span> Connexion</button>
		            </div>
	          	</form>
	          <?php }else{ ?>
	          		<li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#">Gestion des comptes <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li></li><li><a href="accountStatement.php">Relev&eacute; des comptes</a></li>
							<li class="divider"></li><li><a href="synthesis.php">Synth&egrave;se</a></li>
							<li class="divider"></li><li><a href="prelevementMensuel.php">D&eacute;pense mensuel</a></li>
							<!--<li class="divider"></li><li><a href="project.php">Projet</a></li>-->
							<li class="divider"></li><li><a href="maintenance.php">Projet</a></li>
							<li class="divider"></li><li><a href="emprunt.php">Emprunt</a></li>
							<li class="divider"></li><li><a href="check.php">Ch&egrave;que</a></li>
						</ul>
					</li>
	          		<li class="dropdown"><a data-toggle="dropdown" class="dropdown-hover" href="#">Bonjour <?php echo $_SESSION['login'] ?> <b class="caret"></b></a>
	          			<ul class="dropdown-menu">
							<li><a href="passwordChange.php">Changer mot de passe</a></li>
							<li class="divider"></li><li><a href="newUserAccount.php">Nouvel utilisateur</a></li>
							<li class="divider"></li><li><a href="changeUserAccount.php">Modifier utilisateur</a></li>
							<li class="divider"></li><li><a href="deleteUserAccount.php">Supprimer utilisateur</a></li>
							<li class="divider"></li><li><a href="newAccount.php">Ajouter un compte</a></li>
							<li class="divider"></li><li><a href="changeAccount.php">Modifier un compte</a></li>
							<li class="divider"></li><li><a href="deleteAccount.php">Supprimer un compte</a></li>
						</ul>
	          		</li>
	          		<li><a href="#" id="account_name_menu"><?php if (isset($_SESSION['id_account'])) { echo $_SESSION['account_name']; } ?></a></li>
	          		<li><a href="logout.php">Deconnexion</a></li>
	          	</ul>
				<!--<form class="navbar-form navbar-right inline-form">
	            	<div class="form-group">
	            		<select class="form-control" id="select_choice_account" name="select_choice_account" placeholder="Selection du compte">
							<?php //foreach ($accounts as $a) echo '<option value="'.$a['id_account'].'">'.$a['name'].'</option>' ?>
						</select>
		              <button type="button" class="btn btn-primary btn-sm" name="submit_select_choice_account" id="submit_select_choice_account"><span class="glyphicon glyphicon-user"></span> Selection du compte</button>
		            </div>
	          	</form>-->
	          <?php } ?>
		</div>
	</div>
</nav>
<script type="text/javascript">
	$(function(){
		submitAccount();
		submitChoiceAccount();
	});
</script>