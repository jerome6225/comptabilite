var isMailValid = false;

function clear_form_elements(ele) 
{ 
	$(ele).find(':input').each(function() {
		switch(this.type) {
			case 'password':
			case 'select-multiple':
			case 'select-one':
			case 'text':
			case 'textarea':
				$(this).val('');
			break;
			case 'checkbox':
			case 'radio':
				this.checked = false;
		}
	});
}

function showModifyMovement(id_movement)
{
	$(".span_modify_movement_" + id_movement).addClass('sr-only');
	$(".input_hidden_" + id_movement).removeClass("sr-only");

	if ($("#id_movement_assoc_" + id_movement).val() != 0)
	{
		$("#name_" + id_movement).removeClass('sr-only');
		$("#modify_name_" + id_movement).addClass("sr-only");
		$("#category_" + id_movement).removeClass('sr-only');
		$("#modify_category_" + id_movement).addClass("sr-only");
	}
	return false;
}

function cancelModify(id_movement)
{
	$(".span_modify_movement_" + id_movement).removeClass("sr-only");
	$(".input_hidden_" + id_movement).addClass("sr-only");
	return false;
}

function checkInput(input)
{
	if ($("#" + input).val() == '')
		return isInputNotOk(input);
	else
		return isInputOK(input);
}

function checkIntVal(input)
{
	if ($("#" + input).val() != parseInt($("#" + input).val()) || $("#" + input).val() == '')
		return isInputNotOk(input);
	else
		return isInputOK(input);
}

function checkFloatVal(input)
{
	if ($("#" + input).val() != parseFloat($("#" + input).val()) || $("#" + input).val() == '')
		return isInputNotOk(input);
	else
		return isInputOK(input);
}

function checkIsSame(input1, input2)
{
	if ($("#" + input1).val() != $("#" + input2).val() || $("#" + input1).val() == '')
	{
		isInputPasswordNotOk(input1);
		return isInputPasswordNotOk(input2);
	}
	else
	{
		isInputOK(input1);
		return isInputOK(input2);
	}
		
}

function checkIfOneIsOk(input1, input2)
{
	if (($("#" + input1).val() == '' &&  $("#" + input2).val() == '') || ($("#" + input1).val() != '' &&  $("#" + input2).val() != ''))
	{
		isInputNotOk(input1);
		$("#choice_one").removeClass("sr-only");
		return isInputNotOk(input2);
	}
	else
	{
		isInputOK(input1);
		$("#choice_one").addClass("sr-only");
		return isInputOK(input2);
	}
		
}

function isInputNotOk(input)
{
	$("#div_" + input).removeClass("has-success").addClass("has-error");
	$("#span_" + input).removeClass("glyphicon-ok").addClass("glyphicon-remove");
	setTimeout( function() { $('#' + input).focus() }, 0 );

	return false;
}

function isInputPasswordNotOk(input)
{
	$("#div_" + input).removeClass("has-success").addClass("has-error");
	$("#span_" + input).removeClass("glyphicon-ok").addClass("glyphicon-remove");

	return false;
}

function isInputOK(input)
{
	$("#div_" + input).removeClass("has-error").addClass("has-success");
	$("#span_" + input).removeClass("glyphicon-remove").addClass("glyphicon-ok");

	return true;
}

function newEmprunt()
{
	$(document).on("click", "#btn_hide_form_emprunt", function(){
		if ($('#form_hide_emprunt').css('display') == 'none')
			$("#form_hide_emprunt").show('slow');
		else
			$("#form_hide_emprunt").hide('slow');
	});
}

function toggleForm(form)
{
	$(document).on("click", "#btn_" + form, function(){
		$("#" + form).toggleClass('sr-only', 1000);
	});
}

function modifyRemboursement(id_remboursement)
{
	$(".span_modify_emprunt_" + id_remboursement).addClass("sr-only");
	$(".input_hidden_" + id_remboursement).removeClass("sr-only");
	alert($("#title_remboursement").html());
	$("#title_remboursement").html("");
}

function cancelModifRemboursement(id_remboursement)
{
	$(".span_modify_emprunt_" + id_remboursement).removeClass("sr-only");
	$(".input_hidden_" + id_remboursement).addClass("sr-only");
	$("#title_remboursement").html("test");
}

function checkMail(mail) {
	var regEmail = new RegExp('^[0-9a-z._-]+@{1}[0-9a-z.-]{2,}[.]{1}[a-z]{2,5}$','i');

    if (regEmail.test(mail))
    {
    	$("#div_email").removeClass("has-error").addClass("has-success");
		$("#span_email").removeClass("glyphicon-remove").addClass("glyphicon-ok");
		isMailValid = true;
    }
    else
    {
    	isMailValid = false;
    	$("#div_email").removeClass("has-success").addClass("has-error");
		$("#span_email").removeClass("glyphicon-ok").addClass("glyphicon-remove");
		setTimeout( function() { $('#email').focus() }, 0 );
    }
}