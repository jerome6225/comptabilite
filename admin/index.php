<?php
	include dirname(__FILE__)."/../include.php";

	if (!isset($_SESSION['id_admin']))
	{
		header("location:auth.php");
		exit;
	}

	include dirname(__FILE__)."/header.php"
?>
<?php include dirname(__FILE__)."/footer.php" ?>
	