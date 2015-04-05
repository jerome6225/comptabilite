<?php
	include dirname(__FILE__)."/../include.php";

	$update = Movement::updateMovement($_POST['id_movement'], $_POST['amount'], $_POST['date_begin'], $_POST['name'], $_POST['category'], $_POST['date_end']);

	if ($update)
	{
		$categoryMovement = CategoryMovement::getNameCategoryMovement($_POST['category']);

		echo $categoryMovement->name_category_movement;
		exit;
	}
	else
	{
		echo 'error';
		exit;
	}