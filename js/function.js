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
		isInputNotOk(input1);
		return isInputNotOk(input2);
	}
	else
	{
		isInputOK(input1);
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

function isInputOK(input)
{
	$("#div_" + input).removeClass("has-error").addClass("has-success");
	$("#span_" + input).removeClass("glyphicon-remove").addClass("glyphicon-ok");

	return true;
}

