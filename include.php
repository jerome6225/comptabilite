<?php 
	session_start();

	include dirname(__FILE__)."/config/config.php";
	include dirname(__FILE__)."/classes/db/Db.php";
	include dirname(__FILE__)."/classes/Account.php";
	include dirname(__FILE__)."/classes/Admin.php";
	include dirname(__FILE__)."/classes/AccountBalance.php";
	include dirname(__FILE__)."/classes/CategoryMovement.php";
	include dirname(__FILE__)."/classes/Check.php";
	include dirname(__FILE__)."/classes/Emprunt.php";
	include dirname(__FILE__)."/classes/IdUserAccountIdAccount.php";
	include dirname(__FILE__)."/classes/Movement.php";
	include dirname(__FILE__)."/classes/Remboursement.php";
	include dirname(__FILE__)."/classes/TypeAccount.php";
	include dirname(__FILE__)."/classes/UserAccount.php";
	include dirname(__FILE__)."/classes/User.php";
	include dirname(__FILE__)."/classes/Tools.php";
	include dirname(__FILE__)."/classes/Form.php";
	include dirname(__FILE__)."/controllers/choiceAccountController.php";
