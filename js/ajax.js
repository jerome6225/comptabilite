function submitNewUser(){
	$(document).on("blur", "#new_customer_password_confirm", function(e){
		checkIsSame("new_customer_password", "new_customer_password_confirm");
	});

	$(document).on("click", "#submit_new_customer_info", function(e){
		e.preventDefault();
		var checkFirstName   = checkInput("new_customer_first_name");
		var checkLastName    = checkInput("new_customer_last_name");
		var checkLogin       = ($("#div_new_customer_login").hasClass("has-success")) ? checkInput("new_customer_login") : false;
		var checkAccount     = checkIntVal("new_customer_account");
		var checkUserAccount = checkIntVal("new_customer_user_account");
		var checkPassword    = checkInput("new_customer_password");

		
		if (checkFirstName && checkLastName && checkLogin && checkAccount && checkUserAccount && checkPassword)
		{
			if (!ajax_in_progress)
			{
				ajaxInProgress();

				$.ajax({
					type: "POST",
					url: "ajax/newUser.php",
					data: {
						first_name: $("#new_customer_first_name").val(),
						last_name: $("#new_customer_last_name").val(),
						login: $("#new_customer_login").val(),
						password: $("#new_customer_password").val(),
						account: $("#new_customer_account").val(),
						nb_user: $("#new_customer_user_account").val(),
					},
					success: function(msg){
						if (msg == 'error_login')
						{
							$("#error_exist_login").show();
							setTimeout( function() { $('#new_customer_login').focus() }, 0 );
						}
						else if (msg == 'error')
						{
							alert("Une erreur est survenue pendant l'enregistrement");
						}
						else
						{
							document.location.href="createUser.php";
						}
						
						ajaxNotInProgress();
					}
				});
			}
		}
		
		
	});
}

function checkNewLogin(input)
{
	$(document).on("blur", "#" + input, function(e){
		$.ajax({
			type: "POST",
			url: "ajax/newLogin.php",
			data: {
				login: $("#" + input).val(),
			},
			success: function(msg){
				if (msg == 'ok')
				{
					$("#span_login_exist").attr("style", "display: none;");
					isInputOK(input);
				}
				else if (msg == 'error')
				{
					$("#span_login_exist").removeAttr("style");
					isInputNotOk(input);
				}
					
			}
		});
	});
}

function submitAccount(){
	$(document).on("click", "#submit_customer_info", function(e){
		e.preventDefault();
		if (!ajax_in_progress)
		{
			ajaxInProgress();
			$.ajax({
				type: "POST",
				url: "ajax/login.php",
				data: {
					login: $("#customer_login_login").val(),
					password: $("#customer_login_password").val(),
				},
				success: function(msg){
					if (msg == 'error_password')
					{
						$("#div_customer_login_password").removeClass("has-success").addClass("has-error");
						$("#span_customer_login_password").removeClass("glyphicon-ok").addClass("glyphicon-remove");
						setTimeout( function() { $('#customer_login_password').focus() }, 0 );
					}
					else if (msg == 'error_login')
					{
						$("#div_customer_login_login").removeClass("has-success").addClass("has-error");
						$("#span_customer_login_login").removeClass("glyphicon-ok").addClass("glyphicon-remove");
						setTimeout( function() { $('#customer_login_login').focus() }, 0 );
					}
					else
					{
						$("#div_customer_login_login").addClass("has-success").removeClass("has-error");
						$("#div_customer_login_password").addClass("has-success").removeClass("has-error");
						$("#span_customer_login_password").addClass("glyphicon-ok").removeClass("glyphicon-remove");
						$("#span_customer_login_login").addClass("glyphicon-ok").removeClass("glyphicon-remove");
						document.location.href = "index.php";
					}
					
					ajaxNotInProgress();
				}
			});
		}
	});
}

function submitChoiceAccount()
{
	$(document).on("click", "#submit_select_choice_account", function(e){
		e.preventDefault();
		if (!ajax_in_progress)
		{
			ajaxInProgress();

			$.ajax({
				type: "POST",
				url: "ajax/choiceAccount.php",
				data: {
					select_choice_account: $("#select_choice_account").val(),
				},
				success: function(msg){
					if (msg == 'error')
					{
						alert('error');
					}
					else
					{
						$("#account_name_menu").html(msg);
					}
					
					ajaxNotInProgress();
				}
			});
		}
	});
}

function changePassword(){
	$(document).on("click", "#submit_change_password", function(e){
		e.preventDefault();
		var checkOldPassword  = checkInput("old_customer_password");
		var checkNewPassword  = checkInput("change_password");
		var checkSamePassword = checkIsSame("change_password", "change_password_confirm");

		if (checkOldPassword && checkNewPassword && checkSamePassword)
		{
			$("#error_old_password").hide();
			$("#error_change_password").hide();
			$("#error_change_password_confirm").hide();

			if (!ajax_in_progress)
			{
				ajaxInProgress();

				$.ajax({
					type: "POST",
					url: "ajax/changePassword.php",
					data: {
						old_password: $("#old_customer_password").val(),
						new_password: $("#change_password").val(),
					},
					success: function(msg){
						if (msg == 'error_password')
						{
							alert("Votre ancien mot de passe est incorrect");
						}
						else if (msg == 'error_update')
						{
							alert("Une erreur est survenue pendant la modification du mot de passe");
						}
						else
						{
							$("#success_form_account").removeClass("sr-only");
							$("#form_account").addClass("sr-only");
						}
						
						ajaxNotInProgress();
					}
				});
			}
		}
	});
}

function createNewUser()
{
	$(document).on("click", "#submit_new_customer_user_account", function(e){
		var checkUserName = checkInput("new_customer_user_account_name");
		
		if (checkUserName)
		{
			if (!ajax_in_progress)
			{
				ajaxInProgress();

				$.ajax({
					type: "POST",
					url: "ajax/newUserAccount.php",
					data: {
						user_name:$("#new_customer_user_account_name").val(),
						user_color:$("#new_customer_user_account_color").val(),
					},
					success: function(msg){
						if (msg == "ok")
						{
							$("#success_form_account").removeClass("sr-only");
							$("#form_account").addClass("sr-only");
						}
						else if (msg == "error_insert_user_account")
						{
							alert("erreur pendant l'enregistrement");
						}
						else if (msg =="error_select_account")
						{
							alert("num&eacutero de compte non trouv&eacute;");
						}

						ajaxNotInProgress();
					}
				});
			}
		}
	});
}

function modifAccount()
{
	$(document).on("click", "#submit_modif_account", function(e){
		e.preventDefault();
		var checkName    = checkInput("select_name_modif_account");
		var checkIntPers = checkIntVal("select_user_modif_account");

		if (checkName && checkIntPers)
		{
			var info = {};
			info["account_name"] = $("#select_name_modif_account").val();
			info["account_type"] =  $("#select_type_modif_account").val();
			info["nb_user"]      = $("#select_user_modif_account").val();

			for(var i=0;i<parseInt($("#select_user_modif_account").val());i++)
			{
				var infoUserAccountName = "id_user_account_"+i;
				info[infoUserAccountName] =  $("#customer_user_account_name_0_"+i).val();
			}
			info["nb_account"] = 1;

			if (!ajax_in_progress)
			{
				ajaxInProgress();

				$.ajax({
					type: "POST",
					url: "ajax/modifUserAccount.php",
					data: {data: JSON.stringify(info)},
					success: function(msg){
						if (msg == "error")
						{
							alert("Erreur durant l'enregistrement");
						}
						else
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
										$("#select_account").html(msg);
									}
								}
							});
							$("#success_form_account").removeClass("sr-only");
							$("#form_account").addClass("sr-only");
						}

						ajaxNotInProgress();
					}
				});
			}
		}
	});
}

function deleteMovement(id_movement)
{
	if (!ajax_in_progress)
	{
		ajaxInProgress();

		$.ajax({
			type: "POST",
			url: "ajax/deleteMovement.php",
			data: {
				id_movement: id_movement,
				idAccount: $("#id_account_" + id_movement).val(),
				amount: $("#amount_" + id_movement).html(),
				debit: $("#debit_" + id_movement).val(),
				id_movement_assoc: $("#id_movement_assoc_" + id_movement).val(),
			},
			success: function(msg){
				if (msg == "error")
				{
					alert("error");
				}
				else
				{
					$("#tr_" + id_movement).addClass('sr-only');
					$("#tr_" + $("#id_movement_assoc_" + id_movement).val()).addClass('sr-only');

					var newTotalAccount = 0;
					var newTotalAccountAssoc = 0;

					if ($("#debit_" + id_movement).val() == 1)
					{
						newTotalAccount = parseFloat($(".total_movement_" + $("#id_account_" + id_movement).val()).html()) + parseFloat($("#amount_" + id_movement).html());
						$(".total_movement_" + $("#id_account_" + id_movement).val()).html(newTotalAccount);

						if ($("#id_movement_assoc_" + id_movement).val() != 0)
						{
							newTotalAccountAssoc = parseFloat($(".total_movement_" + msg).html()) - parseFloat($("#amount_" + id_movement).html());
							$(".total_movement_" + msg).html(newTotalAccountAssoc);
						}
					}
					else
					{
						newTotalAccount = parseFloat($(".total_movement_" + $("#id_account_" + id_movement).val()).html()) - parseFloat($("#amount_" + id_movement).html());
						$(".total_movement_" + $("#id_account_" + id_movement).val()).html(newTotalAccount);

						if ($("#id_movement_assoc_" + id_movement).val() != 0)
						{
							newTotalAccountAssoc = parseFloat($(".total_movement_" +  msg).html()) + parseFloat($("#amount_" + id_movement).html());
							$(".total_movement_" + msg).html(newTotalAccountAssoc);
						}
					}

					ajaxNotInProgress();

					return false;
				}
			}
		});
	}
}

function validModify(id_movement, monthly){
	var date_end = (monthly == 1) ? $("#modify_date_end_" + id_movement).val() : '0000-00-00';

	if ($("#id_movement_assoc_" + id_movement).val() != 0)
	{
		var name = $("#name_" + id_movement).html();
	}
	else
	{
		name = $("#modify_name_" + id_movement).val();
	}

	if (!ajax_in_progress)
	{
		ajaxInProgress();

		$.ajax({
			type: "POST",
			url: "ajax/modifyMovement.php",
			data: {
				id_movement: id_movement,
				date_begin: $("#modify_date_begin_" + id_movement).val(),
				date_end: date_end,
				user: $("#modify_user_" + id_movement).val(),
				name: name,
				category: $("#modify_category_" + id_movement).val(),
				amount: $("#modify_amount_" + id_movement).val(),
				oldAmount: $("#amount_" + id_movement).html(),
				idAccount: $("#id_account_" + id_movement).val(),
				debit: $("#debit_" + id_movement).val(),
				id_movement_assoc: $("#id_movement_assoc_" + id_movement).val(),
			},
			success: function(msg){
				if (msg == "error")
				{
					alert("error");
				}
				else
				{
					var result = JSON.parse(msg);

					var oldAmount     = parseFloat($("#amount_" + id_movement).html());
					var newAmount     = parseFloat($("#modify_amount_" + id_movement).val());
					var totalMovement = parseFloat($(".total_movement_" + $("#id_account_" + id_movement).val()).html());
					var userName      = (result['userName'] == null) ? 'Tout le monde' : result['userName'];
					$("#date_" + id_movement).html($("#modify_date_begin_" + id_movement).val());
					$("#user_color_" + id_movement).attr("style", "background-color: " + result['userColor'] + ";");
					$("#user_" + id_movement).html(userName);
					$("#name_" + id_movement).html($("#modify_name_" + id_movement).val());
					$("#category_" + id_movement).html(result['categoryMovement']);
					$("#amount_" + id_movement).html($("#modify_amount_" + id_movement).val());
					$(".span_modify_movement_" + id_movement).removeClass('sr-only');
					$(".input_hidden_" + id_movement).addClass("sr-only");

					if ($("#id_movement_assoc_" + id_movement).val() != 0)
					{
						$("#date_" + $("#id_movement_assoc_" + id_movement).val()).html($("#modify_date_begin_" + id_movement).val());
						$("#user_color_" + $("#id_movement_assoc_" + id_movement).val()).attr("style", "background-color: " + result['userColor'] + ";");
						$("#user_" + $("#id_movement_assoc_" + id_movement).val()).html(userName);
						$("#name_" + $("#id_movement_assoc_" + id_movement).val()).html($("#modify_name_" + id_movement).val());
						$("#category_" + $("#id_movement_assoc_" + id_movement).val()).html(result['categoryMovement']);
						$("#amount_" + $("#id_movement_assoc_" + id_movement).val()).html($("#modify_amount_" + id_movement).val());
					}

					if (oldAmount != newAmount)
					{
						if ($("#debit_" + id_movement).val() == 1)
						{
							newTotalAccount = totalMovement + oldAmount - newAmount;

							if (parseInt($("#id_movement_assoc_" + id_movement).val()) != 0)
							{
								newTotalAccountAssoc = parseFloat($(".total_movement_" + result['idAccountAssoc']).html()) - oldAmount + newAmount;
								$(".total_movement_" + result['idAccountAssoc']).html(newTotalAccountAssoc);
							}
						}
						else
						{
							newTotalAccount = totalMovement - oldAmount + newAmount;
							
							if (parseInt($("#id_movement_assoc_" + id_movement).val()) != 0)
							{
								newTotalAccountAssoc = parseFloat($(".total_movement_" + result['idAccountAssoc']).html()) + oldAmount - newAmount;
								$(".total_movement_" + result['idAccountAssoc']).html(newTotalAccountAssoc);
							}
						}

						$(".total_movement_" + $("#id_account_" + id_movement).val()).html(newTotalAccount);
					}
					
					ajaxNotInProgress();

					return false;
				}
			}
		});
	}
}

function changeAccount(){
	$(document).on("click", "#submit_select_account", function(e){
		e.preventDefault();
		$("#success_form_account").addClass("sr-only");
		$("#modif_account_subtitle").hide();

		if (!ajax_in_progress)
		{
			ajaxInProgress();

			$.ajax({
				type: "POST",
				url: "ajax/changeAccount.php",
				data: {
					account: $("#select_account").val(),
				},
				success: function(msg){
					if (msg == 'error')
					{
						alert('Erreur lors de la selection du compte');
					}
					else
					{
						$('#div_modif_account').html(msg);
					}

					ajaxNotInProgress();
				}
			});
		}
	});
}

function selectChangeUserAccount(){
	$(document).on("click", "#submit_form_select_modif_user_account", function(e){
		$("#success_form_account").addClass("sr-only");

		if (!ajax_in_progress)
		{
			ajaxInProgress();

			$.ajax({
				type: "POST",
				url: "ajax/changeUserAccount.php",
				data: {
					id_user_account:$("#select_modif_user_account").val(),
				},
				success: function(msg){
					if (msg == "error")
					{
						alert("erreur pendant l'enregistrement");
					}
					else
					{
						$('#div_modif_user_account').html(msg);
					}

					ajaxNotInProgress();

					return false;
				}
			});
		}
	});
}

function changeUserAccount(idUserAccount)
{
	$(document).on("click", "#submit_form_modif_user_account", function(e){
		if ($("#name_modif_user_account").val() == "")
		{
			$("#error_name_modif_user_account").show();
			setTimeout( function() { $("#name_modif_user_account").focus() }, 0 );
		}
		else
		{
			$("#error_name_modif_user_account").hide();

			if (!ajax_in_progress)
			{
				ajaxInProgress();

				$.ajax({
					type: "POST",
					url: "ajax/changeUserAccountValid.php",
					data: {
						id_user_account: idUserAccount,
						name_user_account: $("#name_modif_user_account").val(),
						color: $("#color_modif_user_account").val(),
					},
					success: function(msg){
						if (msg == "error")
						{
							alert("erreur pendant l\'enregistrement");
						}
						else
						{
							$.ajax({
								type: "POST",
								url: "ajax/getInfoUser.php",
								success: function(msg){
									if (msg == "error")
									{
										alert("erreur pendant l\'enregistrement");
									}
									else
									{
										$("#select_modif_user_account").html(msg);
									}
								}
							});
							$("#success_form_account").removeClass("sr-only");
							$("#form_change_user_account").addClass("sr-only");
						}

						ajaxNotInProgress();
					}
				});
			}
		}
	});
}

function deleteUserAccount(){
	$(document).on("click", "#submit_form_select_delete_user_account", function(e){
		$("#success_form_account").addClass("sr-only");

		if (!ajax_in_progress)
		{
			ajaxInProgress();

			$.ajax({
				type: "POST",
				url: "ajax/deleteUserAccount.php",
				data: {
					id_user_account:$("#select_delete_user_account").val(),
				},
				success: function(msg){
					if (msg == "error")
					{
						alert("erreur pendant la suppression");
					}
					else
					{
						$("#success_form_account").removeClass("sr-only");
					}

					ajaxNotInProgress();

					return false;
				}
			});
		}
	});
}

function deleteAccount(){
	$(document).on("click", "#submit_delete_account", function(e){
		e.preventDefault();
		$("#success_form_account").addClass("sr-only");

		if (!ajax_in_progress)
		{
			ajaxInProgress();

			$.ajax({
				type: "POST",
				url: "ajax/deleteAccount.php",
				data: {
					account: $("#delete_account").val(),
				},
				success: function(msg){
					if (msg == 'error')
					{
						alert('Erreur lors de la suppression du compte');
					}
					else
					{
						$("#success_form_account").removeClass("sr-only");
					}

					ajaxNotInProgress();
				}
			});
		}
	});
}

function deleteUser(){
	$(document).on("click", "#submit_delete_user", function(e){
		e.preventDefault();
		$("#success_form_account").addClass("sr-only");

		if (!ajax_in_progress)
		{
			ajaxInProgress();

			$.ajax({
				type: "POST",
				url: "ajax/deleteUser.php",
				success: function(msg){
					if (msg == 'error')
					{
						alert('Erreur lors de la suppression de votre compte');
					}
					else
					{
						alert('Votre compte a été supprimé');
					}

					ajaxNotInProgress();

					document.location.href="index.php";
				}
			});
		}
	});
}
function showUserAccountForm(userInput, userSubmit, divUserAccountForm, current)
{
	$(document).on("click", "#" + userSubmit, function(e){
		if (!ajax_in_progress)
		{
			ajaxInProgress();


			$.ajax({
				type: "POST",
				url: "ajax/userAccountForm.php",
				data: {
					nb_user: $("#" + userInput).val(),
					current: current,
				},
				success: function(msg){
					setTimeout( function() { $('#customer_user_account_name_' + current + '_0').focus() }, 0 );
					$("#" + divUserAccountForm).html(msg);
					$("#submit_new_customer_account").removeClass("sr-only");

					ajaxNotInProgress();
				}
			});
		}
	});
}

function movement(id_account)
{
	$(document).on('click', '#select_type_movement_' + id_account, function(e){
		if ($("#select_type_movement_" + id_account).val() == '17')
		{
			$("#div_account_movement_" + id_account).show();
			$("#div_intitule_" + id_account).hide();
		}
		else
		{
			$("#div_account_movement_" + id_account).hide();
			$("#div_intitule_" + id_account).show();
		}
	});

	$(document).on('click', '#select_monthly_' + id_account, function(e){
		if ($("#select_monthly_" + id_account).val() == '1')
		{
			$("#div_monthly_" + id_account).show();
			$("#div_x_month_" + id_account).hide();
		}
		else if ($("#select_monthly_" + id_account).val() == '2')
		{
			$("#div_x_month_" + id_account).show();
			$("#div_monthly_" + id_account).hide();
			$("#div_annual_" + id_account).hide();
		}
		else
		{
			$("#div_x_month_" + id_account).hide();
			$("#div_monthly_" + id_account).hide();
			$("#div_annual_" + id_account).hide();
		}
	});

	$(document).on('click', '#select_annual_' + id_account, function(e){
		if ($("#select_annual_" + id_account).val() == '0')
			$("#div_annual_" + id_account).show();
		else
			$("#div_annual_" + id_account).hide();
	});

	$(document).on("click", "#submit_select_choice_account_" + id_account, function(e){
		e.preventDefault();

		var checkAmount      = checkFloatVal("amount_" + id_account);
		var checkIntitule    = true;
		var checkDate        = checkInput("date_movement_" + id_account);
		var checkInputAnnual = true;

		if ($("#select_type_movement_" + id_account).val() != '17')
			checkIntitule = checkInput("intitule_" + id_account);

		if ($("#select_monthly_" + id_account).val() == 1 && $("#select_annual_" + id_account).val() == 0)
			checkInputAnnual = checkIntVal("input_annual_" + id_account);

		if (checkAmount && checkIntitule && checkDate && checkInputAnnual)
		{
			if (!ajax_in_progress)
			{
				ajaxInProgress();

				$.ajax({
					type: "POST",
					url: "ajax/newMovement.php",
					data: {
						amount: $("#amount_" + id_account).val(),
						intitule: $("#intitule_" + id_account).val(),
						category: $("#select_type_movement_" + id_account).val(),
						account_assoc: $("#select_account_movement_" + id_account).val(),
						debit: $("#select_debit_" + id_account).val(),
						date: $("#date_movement_" + id_account).val(),
						monthly: $("#select_monthly_" + id_account).val(),
						x_month: $("#x_month_" + id_account).val(),
						annual: $("#select_annual_" + id_account).val(),
						date_end: $("#date_end_movement_" + id_account).val(),
						nb_month: $("#input_annual_" + id_account).val(),
						id_user: $("#select_user_movement_" + id_account).val(),
						id_account: id_account,
					},
					success: function(msg){
						if (msg == 'error_movement')
						{
							alert('Une erreur est survenu durant l\'enregistrement');
						}
						else
						{
							clear_form_elements("#form_choice_account" + id_account);
							window.location.reload();
							//$(".title_choice_account_" + id_account).show().html(msg);
						}
							
						ajaxNotInProgress();
					}
				});
			}
		}
	});
}

function addCheck(id_account)
{
	$(document).on("click", "#submit_check_" + id_account, function(e){
		e.preventDefault();

		var checkAmount   = checkFloatVal("amount_" + id_account);
		var checkNumber   = checkIntVal("number_check_" + id_account);
		var checkIntitule = checkInput("intitule_" + id_account);
		var checkDate     = checkInput("date_movement_" + id_account);

		if (checkAmount && checkNumber && checkIntitule && checkDate)
		{
			if (!ajax_in_progress)
			{
				ajaxInProgress();

				$.ajax({
					type: "POST",
					url: "ajax/newCheck.php",
					data: {
						amount: $("#amount_" + id_account).val(),
						number: $("#number_check_" + id_account).val(),
						intitule: $("#intitule_" + id_account).val(),
						category: $("#select_type_check_" + id_account).val(),
						date: $("#date_release_check_" + id_account).val(),
						id_user: $("#select_user_check_" + id_account).val(),
						id_account: id_account,
					},
					success: function(msg){
						console.log(msg);
						if (msg == 'error_check')
						{
							alert('Une erreur est survenu durant l\'enregistrement');
						}
						else
						{
							clear_form_elements("#form_add_check_" + id_account);
							window.location.reload();
						}
						
						ajaxNotInProgress();
					}
				});
			}
		}
	});
}

function addCheckMovement(id_account, id_check)
{
	if (!ajax_in_progress)
	{
		ajaxInProgress();

		$.ajax({
			type: "POST",
			url: "ajax/newMovement.php",
			data: {
				id_user: $("#user_" + id_check).data("iduser"),
				amount: $("#amount_" + id_check).html(),
				intitule: $("#number_" + id_check).html() + " " + $("#name_" + id_check).html(),
				category: $("#category_" + id_check).data("idcategory"),
				id_account: id_account,
				debit: 1,
				date: $("#date_now").val(),
				monthly: 0,
				annual: 0,
				date_end: "",
				nb_month: "",
			},
			success: function(msg){
				if (msg == 'error_movement')
				{
					alert('Une erreur est survenu durant l\'enregistrement');
				}
				else
				{
					$.ajax({
						type: "POST",
						url: "ajax/updateCheckDateDebit.php",
						data: {
							id_check: id_check,
							date: $("#date_now").val(),
							id_movement: msg,
						},
						success: function(m){
							if (m == 'error_add_check')
							{
								alert('Une erreur est survenu durant l\'enregistrement');
							}
							else
							{
								$("#check_" + id_check).html($("#date_now").val() +' <span class="glyphicon glyphicon-ok text-success"></span>');
							}

							ajaxNotInProgress();
						}
					});
				}
			}
		});
	}
}

function deleteCheck(id_account, id_check, id_movement)
{
	if (!ajax_in_progress)
	{
		ajaxInProgress();

		$.ajax({
			type: "POST",
			url: "ajax/deleteCheck.php",
			data: {
				id_check: id_check,
				id_movement: id_movement,
				id_account: id_account,
				amount: $("#amount_" + id_check).html(),
			},
			success: function(m){
				if (m == 'error_remove_check')
				{
					alert('Une erreur est survenu durant la suppression');
				}
				else
				{
					$("#tr_" + id_check).hide();
				}

				ajaxNotInProgress();
			}
		});
	}
}

function createNewEmprunt()
{
	$(document).on("click", "#submit_new_emprunt", function(e){
		e.preventDefault();

		var checkName               = checkInput("name_emprunt");
		var checkSomme              = checkFloatVal("somme_emprunt");
		var checkDate               = checkInput("date_emprunt");
		var checkRembOrEtalonnement = checkIfOneIsOk("somme_rembourse", "etalonnement");

		if (checkName && checkSomme && checkDate && checkRembOrEtalonnement)
		{
			if (!ajax_in_progress)
			{
				ajaxInProgress();

				$.ajax({
					type: "POST",
					url: "ajax/emprunt.php",
					data: {
						name: $("#name_emprunt").val(),
						somme: $("#somme_emprunt").val(),
						date: $("#date_emprunt").val(),
						remboursement: $("#somme_rembourse").val(),
						etalonnement: $("#etalonnement").val(),
					},
					success: function(msg){
						if (msg == 'error')
						{
							alert('Une erreur est survenu durant l\'enregistrement');
						}
						else
						{
							clear_form_elements("#form_new_emprunt");
							document.location.href = "emprunt.php";
						}
						
						ajaxNotInProgress();
					}
				});
			}
		}
	});
}

function changeRemboursementStatus(id_remboursement, status)
{
	if (!ajax_in_progress)
	{
		ajaxInProgress();
		$.ajax({
			type: "POST",
			url: "ajax/statusRemboursement.php",
			data: {
				idRemboursement: id_remboursement,
				status: status,
			},
			success: function(msg){
				if (msg == 'error')
				{
					alert('Une erreur est survenu durant l\'enregistrement');
				}
				else
				{
					if (status == 1)
						$("#rembourse_" + id_remboursement).html('<span class="glyphicon glyphicon-remove text-danger"></span>');
					else
						$("#rembourse_" + id_remboursement).html('<span class="glyphicon glyphicon-ok text-success"></span>');
				}
				
				ajaxNotInProgress();
			}
		});
	}
}