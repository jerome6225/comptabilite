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
						
				}
			});
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
					
			}
		});
	});
}

function submitChoiceAccount()
{
	$(document).on("click", "#submit_select_choice_account", function(e){
		e.preventDefault();
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
					
			}
		});
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
						
				}
			});
		}
	});
}

function createNewUser()
{
	$(document).on("click", "#submit_new_customer_user_account", function(e){
		var checkUserName = checkInput("new_customer_user_account_name");
		
		if (checkUserName)
		{
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
				}
			});
		}
	});
}

function modifAccount(){
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
				}
			});
		}
	});
}

function deleteMovement(id_movement){
	$.ajax({
		type: "POST",
		url: "ajax/deleteMovement.php",
		data: {
			id_movement: id_movement,
			idAccount: $("#id_account_" + id_movement).val(),
			amount: $("#amount_" + id_movement).html(),
			debit: $("#debit_" + id_movement).val(),
		},
		success: function(msg){
			if (msg == "error")
			{
				alert("error");
			}
			else
			{
				$("#tr_" + id_movement).addClass('sr-only');
				return false;
			}
		}
	});
}

function validModify(id_movement, monthly){
	var date_end = (monthly == 1) ? $("#modify_date_end_" + id_movement).val() : '0000-00-00';

	$.ajax({
		type: "POST",
		url: "ajax/modifyMovement.php",
		data: {
			id_movement: id_movement,
			date_begin: $("#modify_date_begin_" + id_movement).val(),
			date_end: date_end,
			user: $("#modify_user_" + id_movement).val(),
			name: $("#modify_name_" + id_movement).val(),
			category: $("#modify_category_" + id_movement).val(),
			amount: $("#modify_amount_" + id_movement).val(),
			oldAmount: $("#amount_" + id_movement).html(),
			idAccount: $("#id_account_" + id_movement).val(),
			debit: $("#debit_" + id_movement).val(),
		},
		success: function(msg){
			if (msg == "error")
			{
				alert("error");
			}
			else
			{
				$("#date_" + id_movement).html($("#modify_date_begin_" + id_movement).val());
				$("#name_" + id_movement).html($("#modify_name_" + id_movement).val());
				$("#category_" + id_movement).html(msg);
				$("#amount_" + id_movement).html($("#modify_amount_" + id_movement).val());
				$(".span_modify_movement_" + id_movement).removeClass('sr-only');
				$(".input_hidden_" + id_movement).addClass("sr-only");
				return false;
			}
		}
	});
}

function changeAccount(){
	$(document).on("click", "#submit_select_account", function(e){
			e.preventDefault();
			$("#success_form_account").addClass("sr-only");
			$("#modif_account_subtitle").hide();
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
				}
			});
		});
}

function selectChangeUserAccount(){
	$(document).on("click", "#submit_form_select_modif_user_account", function(e){
		$("#success_form_account").addClass("sr-only");
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
					return false;
				}
			}
		});
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
				}
			});
		}
	});
}

function showUserAccountForm(userInput, divUserAccountForm, current)
{
	$(document).on("blur", "#" + userInput, function(e){
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
			}
		});
	});
}

function movement(id_account)
{
	$(document).on('click', '#select_monthly_' + id_account, function(e){
		if ($("#select_monthly_" + id_account).val() == '1')
			$("#div_monthly_" + id_account).show();
		else
			$("#div_monthly_" + id_account).hide();
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
		var checkIntitule    = checkInput("intitule_" + id_account);
		var checkDate        = checkInput("date_movement_" + id_account);
		var checkInputAnnual = true;

		if ($("#select_monthly_" + id_account).val() == 1 && $("#select_annual_" + id_account).val() == 0)
			checkInputAnnual = checkIntVal("input_annual_" + id_account);

		if (checkAmount && checkIntitule && checkDate && checkInputAnnual)
		{
			$.ajax({
				type: "POST",
				url: "ajax/newMovement.php",
				data: {
					amount: $("#amount_" + id_account).val(),
					intitule: $("#intitule_" + id_account).val(),
					category: $("#select_type_movement_" + id_account).val(),
					debit: $("#select_debit_" + id_account).val(),
					date: $("#date_movement_" + id_account).val(),
					monthly: $("#select_monthly_" + id_account).val(),
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
						
				}
			});
		}
	});
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
						
				}
			});
		}
	});
}

function changeRemboursementStatus(id_remboursement, status)
{
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
				
		}
	});
}