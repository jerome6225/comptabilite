<?php 
	if (!isset($_SESSION['id_user']))
	{
		header("location:auth.php");
		exit;
	}
?>