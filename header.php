<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- favicon -->
	<link rel="shortcut icon" href="img/favicons/favicon.ico" type="image/x-icon">
	<link rel="icon" href="img/favicons/favicon.png" type="image/png">
	<link rel="icon" sizes="32x32" href="img/favicons/favicon-32.png" type="image/png">
	<link rel="icon" sizes="64x64" href="img/favicons/favicon-64.png" type="image/png">
	<link rel="icon" sizes="96x96" href="img/favicons/favicon-96.png" type="image/png">
	<!-- /favicon -->

	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="js/function.js"></script>
	<script type="text/javascript" src="js/jquery-datepicker.min.js"></script>
	<script type="text/javascript" src="js/tab.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>

	<!--<link rel="stylesheet/less" type="text/css" href="css/style.less">
	<link rel="stylesheet/less" type="text/css" href="css/form.less">
	<link rel="stylesheet/less" type="text/css" href="css/popup.less">-->
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/global.css">

	<!--<script src="js/less.js" type="text/javascript"></script>-->
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<title>Comptabilit&eacute;</title>

</head>
<body data-spy="scroll" data-target="#navbar-defile">
	<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.4";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<div class="container">
		<img src="img/banniere.png" class="banniere_size" />
		<?php include "menu.php" ?>