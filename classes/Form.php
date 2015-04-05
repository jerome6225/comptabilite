<?php

// last-edited on may, 29th 2009

// ---------------------------------------------------------------------------
class Form {

	protected $fields;
	protected $hidden_fields;
	protected $submit_fields;
	protected $fieldsets;
	protected $errors;
	protected $auto_id;
	protected $label_suffix;
	protected $bounded_data;
	protected $cleaned_data;
	protected $attrs;
	protected $uniqid;

	protected static $instances = array();

	public function __construct($uniqid, $method = 'get') {

		$this->fields= array();
		$this->hidden_fields = array();
		$this->submit_fields = array();
		$this->fieldsets     = array();
		$this->errors        = array();
		$this->auto_id       = 'id_%s';
		$this->label_suffix  = ' :';
		$this->bounded_data  = array();
		$this->cleaned_data  = array();
		$this->attrs         = new AttributeList(array('method' => $method));

		if (false !== $uniqid && in_array($uniqid, self::$instances)) {

			trigger_error("Un formulaire identifiÃ© par '$uniqid' existe dÃ©jÃ  ! Conflits potentiels dÃ©tectÃ©s !", E_USER_WARNING);

		} else {

			self::$instances[] = $uniqid;
			$this->uniqid = $uniqid;
			$this->add('Hidden', 'uniqid')->value($uniqid);
		}
	}

	public function is_valid(array $values) {

		if ($this->is_submited()) {

			$valid = true;

			foreach($this->fields as $name => $f) {

				$values[$name] = (isset($values[$name])) ? $values[$name] : null;
				$valid = $f->is_valid($values[$name]) && $valid;
			}

			if ($valid) {

				$this->cleaned_data = array();

				foreach($this->fields as $name => $f) {

					$this->cleaned_data[$f->get_name()] = $f->get_cleaned_value($values[$name]);
				}
			}
			return $valid;
		}
		return false;
	}

	public function fields() {

		return $this->fields;
	}

	public function field($name) {

		return $this->fields[$name];
	}

	public function errors() {

		$this->errors = array();

		foreach($this->fields as $name=>$f) {

			$this->errors[$name] = $f->errors();
		}
		return $this->errors;
	}

	public function bound($data) {

		return $this->bind($data);
	}

	public function bind($data) {

		foreach($data as $k=>$v) {

			$this->bounded_data[$k] = $v;
		}
		return $this;
	}

	public function label_suffix() {

		return $this->label_suffix;
	}

	public function auto_id() {

		return $this->auto_id;
	}

	public function action($action) {

		$this->attrs['action'] = $action;
		return $this;
	}

	public function enctype($enctype) {

		$enctype = strtolower($enctype);

		if (in_array($enctype, array('multipart/form-data', 'application/x-www-form-urlencoded'))) {

			$this->attrs['enctype'] = $enctype;
		}
		return $this;
	}

	public function method($method) {

		$method = strtolower($method);

		if (in_array($method, array('get', 'post'))) {

			$this->attrs['method'] = $method;
		}
		return $this;
	}

	public function fieldsets($array) {

		$this->fieldsets = $array;
	}

	public function is_submited() {

		return $this->is_submitted();
	}

	public function is_submitted() {

		$check = ($_SERVER['REQUEST_METHOD'] == 'POST') ? $_POST : $_GET;

		if (!empty($check['uniqid']) && $check['uniqid'] == $this->uniqid) {

			foreach($this->submit_fields as $s) {

				if (isset($check[$s->get_name()])) { return true; }
			}
		}
		return false;
	}

	public function add($field, $name) {

		if (!isset($this->fields[$name])) {

			$field = 'Form_'.ucfirst($field);
			$field_object = new $field($name, $this);

			if ('Form_Submit' == $field) {

				$this->submit_fields[$name] = $field_object;

			} else if ('Form_Hidden' == $field) {

				$this->hidden_fields[$name] = $field_object;
			}
			$this->fields[$name] = $field_object;

			return $field_object;

		} else {

			trigger_error("Un champ nommÃ© '$name' existe dÃ©jÃ  dans le formulaire identifiÃ© par '{$this->uniqid}'.", E_USER_WARNING);
		}
	}

	public function get_bounded_data($name = null) {

		if (null !== $name) {

			return isset($this->bounded_data[$name]) ? $this->bounded_data[$name] : '';

		} else {

			return $this->bounded_data;
		}
		return null;
	}

	public function get_cleaned_data($name = null) {

		if (!empty($this->cleaned_data)) {

			$out = array();

			if (func_num_args() > 1) {

				if (!is_array($name)) {

					$name = func_get_args();
				}

				foreach($name as $n) {

					$out[] = isset($this->cleaned_data[$n]) ? $this->cleaned_data[$n] : '';
				}

				return $out;
			}

			if (null !== $name) {

				return isset($this->cleaned_data[$name]) ? $this->cleaned_data[$name] : '';

			} else {

				return $this->cleaned_data;
			}
		}
		return null;
	}

	public function __toString() {

		$tab = func_num_args() > 0 ? func_get_arg(0) : '';
		
		$o = $tab.'<form'.$this->attrs.'>'."\n";

		if (empty($this->fieldsets)) {

			$o .= $this->_html_fields($tab."\t", array_diff_key($this->fields, $this->hidden_fields, $this->submit_fields));
			if (!empty($this->hidden_fields)) { $o .= $this->_html_hidden_fields($tab."\t", $this->hidden_fields); }
			$o .= $this->_html_fields($tab."\t", $this->submit_fields);

		} else {

			$hidden_fields = $this->hidden_fields;
			$submit_fields = $this->submit_fields;

			foreach ($this->fieldsets as $legend => $fields) {

				$o .= $this->_html_fieldset($tab, $legend, $fields);

				foreach($fields as $f) {

					unset($hidden_fields[$f], $submit_fields[$f]);
				}
			}
			if (!empty($hidden_fields)) { $o .= $this->_html_hidden_fields($tab."\t", $hidden_fields); }
			if (!empty($submit_fields)) { $o .= $this->_html_fields($tab."\t", $submit_fields); }
		}
		$o .= $tab.'</form>';
		return $o;
	}

	protected function _html_fields($tab, $fields, $filter = array()) {

		$o = '';

		foreach($fields as $f) {

			if (empty($filter) || in_array($f->get_name(), $filter)) {

				$o .= "$tab<p>\n".$f->__toString($tab."\t")."\n$tab</p>\n";
			}
		}
		return $o;
	}

	protected function _html_hidden_fields($tab, $fields, $filter = array()) {

		$o = ''; // "$tab<p>\n";

		foreach($fields as $f) {

			if (empty($filter) || in_array($f->get_name(), $filter)) {

				$o .= $tab.$f->__toString($tab)."\n";
			}
		}
		// $o .= "$tab</p>\n";
		return $o;
	}

	protected function _html_fieldset($tab, $legend, $fields) {

		$o  = "$tab\t".'<fieldset>'."\n";
		$o .= "$tab\t".'<legend>'.$legend.'</legend>'."\n";
		$o .= $this->_html_fields($tab."\t\t", $this->fields, $fields);
		$o .= "$tab\t".'</fieldset>'."\n";
		return $o;
	}
}

// ---------------------------------------------------------------------------

abstract class Form_Field {

	protected $form;
	protected $required;
	protected $label;
	protected $value;
	protected $class;
	protected $attrs;
	protected $error_messages;
	protected $custom_error_messages;

	protected static $error_list = array();

	public function __construct($name, $form) {

		$this->form     = $form;
		$this->required = true;
		$this->label    = '';
		$this->value    = '';
		$this->class    = array();
		$this->attrs    = new AttributeList;
		$this->attrs['name'] = $name;
		$this->error_messages= new ErrorList;
		$this->custom_error_messages = array();

		$this->_init();
	}

	protected function _init() {

		if (!isset(self::$error_list['required'])) {

			self::$error_list['required'] = 'Ce champ est obligatoire.';
		}
		if (!isset(self::$error_list['maxlength'])) {

			self::$error_list['maxlength'] = 'La longueur maximale est de %d caractÃ¨res.';
		}
	}

	public function is_valid($value) {

		$value = $this->get_cleaned_value($value);

		$valid = true;

		if ($this->required && $value == '') {

			$this->_error('required');
			$valid = false;
		}

		if (isset($this->attrs['maxlength'])) {

			if (isset($value[$this->attrs['maxlength']])) {

				$this->_error('maxlength');
				$valid = false;
			}
		}

		return $valid;
	}

	public function label($text) {

		$this->label = $text;
		return $this;
	}

	public function value($text) {

		$this->value = $text;
		return $this;
	}

	public function add_class($class) {

		if (!in_array($class, $this->class)) { $this->class[] = $class; }
		return $this;
	}

	public function required($bool = true) {

		if (true === $bool) { $this->attrs['required'] = 'required'; $this->required = true; }
		else { unset($this->attrs['required']); $this->required = false; }
		return $this;
	}

	public function disabled($bool = true) {

		if (true === $bool) { $this->attrs['disabled'] = 'disabled'; }
		else { unset($this->attrs['disabled']); }
		return $this;
	}

	public function readonly($bool = true) {

		if (true === $bool) { $this->attrs['readonly'] = 'readonly'; }
		else { unset($this->attrs['readonly']); }
		return $this;
	}

	public function maxlength($value) {

		if (ctype_digit((string)$value) && $value > 0) { $this->attrs['maxlength'] = $value; }
		else { unset($this->attrs['maxlength']); }
		return $this;
	}

	public function errors() {

		return $this->error_messages;
	}

	public function get_name() {

		return $this->attrs['name'];
	}

	public function get_cleaned_value($value) {

		return $value;
	}

	public function get_value() {

		return isset($this->attrs['value']) ? $this->attrs['value'] : '';
	}

	public function custom_error_message($id_error, $message) {

		if (!isset(self::$error_list[$id_error])) {

			trigger_error("Le message d'erreur identifiÃ© par '$id_error' ne s'applique pas Ã  la classe ".get_class($this).".");

		} else {

			$this->custom_error_messages[$id_error] = $message;
		}
		return $this;
	}

	protected function _error($id_error) {

		$error = $this->_get_error_message($id_error);

		if ('maxlength' == $id_error) {

			$this->error_messages[$id_error] = vsprintf($error, $this->attrs['maxlength']);

		} else if (!$this->_custom_errors($id_error, $error)) {

			$this->error_messages[$id_error] = $error;
		}
	}

	protected function _custom_errors($id_error, $error) {

		return false;
	}

	abstract public function __toString();

	static protected function _generate_for_id($auto_id, $name) {

		if (!empty($auto_id)) {

			$for = sprintf(' for="'.$auto_id.'"', $name);
			$id  = sprintf(' id="'.$auto_id.'"',  $name);
			return array($for, $id);
		}
		return array('', '');
	}

	protected function _generate_class() {

		if (!empty($this->class)) {

			$this->attrs['class'] = implode(' ', $this->class);
		}
	}

	protected function _get_error_message($id_error) {

		if (isset($this->custom_error_messages[$id_error])) {

			return $this->custom_error_messages[$id_error];

		} else if (isset(self::$error_list[$id_error])) {

			return self::$error_list[$id_error];
		}
		return 'Erreur inconnue : "'.$id_error.'"';
	}
}

// ---------------------------------------------------------------------------
abstract class Form_Input extends Form_Field {

	public function __construct($name, $form) {

		parent::__construct($name, $form);
		$this->attrs['type'] = 'text';
	}

	public function get_cleaned_value($value) {

		$value = trim($value);
		return parent::get_cleaned_value($value);
	}

	// abstract public function __toString($tab = '');
}

// ---------------------------------------------------------------------------
class Form_Text extends Form_Input {

	protected $autocomplete;

	public function __construct($name, $form) {

		parent::__construct($name, $form);
		$this->attrs['type'] = 'text';
		$this->autocomplete = true;
	}

	public function autocomplete($bool) {

		if (false === $bool) { $this->attrs['autocomplete'] = 'off'; $this->autocomplete = false; }
		else { unset($this->attrs['autocomplete']); $this->autocomplete = true; }
		return $this;

	}

	public function get_cleaned_value($value) {

		return parent::get_cleaned_value(preg_replace('`[\x00-\x19]`i', '', $value));
	}

	public function __toString() {

		$tab = func_num_args() > 0 ? func_get_arg(0) : '';
		
		$this->_generate_class();

		$id = '';
		$label = '';
		if (!empty($this->label)) {

			list($for, $id) = self::_generate_for_id($this->form->auto_id(), $this->attrs['name']);
			$label = '<label'.$for.'>'.$this->label.$this->form->label_suffix().'</label>'."\n$tab";
		}

		$errors = $this->error_messages->__toString($tab);
		if (!empty($errors)) { $errors = "\n".$errors; }

		if (true === $this->autocomplete) {

			$value = $this->form->get_bounded_data($this->attrs['name']);
			$value = (!empty($value)) ? $value : $this->value;
			$value = (!empty($value)) ? ' value="'.htmlspecialchars($value).'"' : '';

		} else {

			$value = '';
		}

		$field = '<input'.$id.$this->attrs.$value.' />';
		return $tab.sprintf("%2\$s%1\$s%3\$s", $field, $label, $errors);
	}
}

// ---------------------------------------------------------------------------
class Form_Hidden extends Form_Input {

	public function __construct($name, $form) {

		parent::__construct($name, $form);
		$this->attrs['type'] = 'hidden';
	}

	public function __toString() {

		$tab = func_num_args() > 0 ? func_get_arg(0) : '';
		
		return $tab.'<input'.$this->attrs.' value="'.htmlspecialchars($this->value).'" />';
	}
}

// ---------------------------------------------------------------------------
class Form_Password extends Form_Text {

	public function __construct($name, $form) {

		parent::__construct($name, $form);
		$this->attrs['type'] = 'password';
	}

	public function __toString() {

		$tab = func_num_args() > 0 ? func_get_arg(0) : '';
		
		$this->_generate_class();

		$id = '';
		$label = '';
		if (!empty($this->label)) {

			list($for, $id) = self::_generate_for_id($this->form->auto_id(), $this->attrs['name']);
			$label = '<label'.$for.'>'.$this->label.$this->form->label_suffix().'</label>'."\n$tab";
		}

		$errors = $this->error_messages->__toString($tab);
		if (!empty($errors)) { $errors = "\n".$errors; }

		$field = '<input'.$id.$this->attrs.' />';
		return $tab.sprintf("%2\$s%1\$s%3\$s", $field, $label, $errors);
	}
}

// ---------------------------------------------------------------------------
class Form_Email extends Form_Text {

	protected function _init() {

		if (!isset(self::$error_list['invalid_email'])) {

			self::$error_list['invalid_email'] = "Ce n'est pas une adresse e-mail valide.";
		}
	}

	public function is_valid($value) {

		if (parent::is_valid($value)) {

			if (0 < preg_match('`^[[:alnum:]]([-_.]?[[:alnum:]])*@[[:alnum:]]([-.]?[[:alnum:]])*\.([a-z]{2,4})$`', $value)) {

				return true;
			}
			$this->_error('invalid_email');
			return false;
		}
		return false;
	}
}

// ---------------------------------------------------------------------------
class Form_Date extends Form_Text {

	protected $format;

	protected function _init() {

		if (!isset(self::$error_list['invalid_date'])) {

			self::$error_list['invalid_date'] = "La date entrÃ©e n'existe pas.";
		}
		if (!isset(self::$error_list['invalid_date_format'])) {

			self::$error_list['invalid_date_format'] = "La date entrÃ©e ne respecte pas le format imposÃ© (%s).";
		}
	}

	public function format($format) {

		$this->format = $format;
		return $this;
	}

	public function is_valid($value) {

		if (parent::is_valid($value)) {

			$from = array('dd', 'mm', 'yyyy', 'yy', 'HH', 'MM', 'SS');
			$to   = array('%d', '%m',  '%Y',  '%y', '%H', '%M', '%S');
			$format = str_replace($from, $to, $this->format);

			date_default_timezone_set('Europe/Paris');
			$datetime = strptime($value, $format);

			if (false !== ($datetime)) {

				if (!checkdate($datetime['tm_mon']+1, $datetime['tm_mday'], $datetime['tm_year']+1900)) {

					$this->_error('invalid_date');
					return false;
				}
				return true;
			}
			$this->_error('invalid_date_format');
			return false;
		}
		return false;
	}

	protected function _custom_errors($id_error, $error) {

		if ('invalid_date_format' == $id_error) {

			$this->error_messages[$id_error] = vsprintf($error, $this->format);
			return true;
		}
		return false;
	}
}

// ---------------------------------------------------------------------------
class Form_File extends Form_Input {

	protected $extensions;
	protected $max_size;

	public function __construct($name, $form) {

		parent::__construct($name, $form);
		$this->attrs['type'] = 'file';
		$this->form->enctype('multipart/form-data');
		$this->extensions = array();
		$this->max_size = 0;
	}

	public function filter_extensions($extensions) {

		if (!is_array($extensions)) {

			$extensions = func_get_args();
		}
		$this->extensions = $extensions;

		return $this;
	}

	protected function _init() {

		if (!isset(self::$error_list['invalid_file_extension'])) {

			self::$error_list['invalid_file_extension'] = "Cette extension est interdite ! (sont autorisÃ©es : %s).";
		}
		if (!isset(self::$error_list['file_too_big'])) {

			self::$error_list['file_too_big'] = "Fichier trop volumineux ! (maximum : %d octets).";
		}
	}

	public function is_valid($value) {

		$name = $this->attrs['name'];

		if (isset($_FILES[$name])) {

			$value = isset($_FILES[$name]) ? $_FILES[$name]['name'] : null;

			if (parent::is_valid($value)) {

				if (!$this->required) {

					return true;
				}

				if (!empty($this->extensions)) {

					$ext = pathinfo($value, PATHINFO_EXTENSION);
					if (!in_array($ext, $this->extensions)) {

						$this->_error('invalid_file_extension');
						$valid = false;
					}
				}

				if (0 < $this->max_size && $this->max_size < $_FILES[$name]['size']) {

					$this->_error('file_too_big');
					$valid = false;
				}

				return ($_FILES[$name]['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES[$name]['tmp_name']));
			}
		}
		return false;
	}

	public function get_cleaned_value($value) {

		return isset($_FILES[$this->attrs['name']]) ? $_FILES[$this->attrs['name']]['tmp_name'] : null;
	}

	public function max_size($size) {

		$this->form->add('Hidden', 'POST_MAX_SIZE')->value($size);
		$this->max_size = $size;

		return $this;
	}

	protected function _custom_errors($id_error, $error) {

		if ('invalid_file_extension' == $id_error) {

			$this->error_messages[$id_error] = vsprintf($error, implode(', ', $this->extensions));
			return true;
		}
		if ('file_too_big' == $id_error) {

			$this->error_messages[$id_error] = vsprintf($error, implode(', ', $this->max_size));
			return true;
		}
		return false;
	}

	public function __toString() {

		$tab = func_num_args() > 0 ? func_get_arg(0) : '';
		
		$this->_generate_class();

		$id = '';
		$label = '';
		if (!empty($this->label)) {

			list($for, $id) = self::_generate_for_id($this->form->auto_id(), $this->attrs['name']);
			$label = '<label'.$for.'>'.$this->label.$this->form->label_suffix().'</label>'."\n$tab";
		}

		$errors = $this->error_messages->__toString($tab);
		if (!empty($errors)) { $errors = "\n".$errors; }

		$field = '<input'.$id.$this->attrs.' />';
		return $tab.sprintf("%2\$s%1\$s%3\$s", $field, $label, $errors);
	}
}

// ---------------------------------------------------------------------------
class Form_Submit extends Form_Input {

	public function __construct($name, $form) {

		parent::__construct($name, $form);
		$this->attrs['type'] = 'submit';
	}

	public function __toString() {

		$tab = func_num_args() > 0 ? func_get_arg(0) : '';
		

		$this->_generate_class();

		// Pas d'auto_id pour les champs Submit...
		$label = (!empty($this->label)) ? '<label>'.$this->label.$this->form->label_suffix().'</label>'."\n$tab" : '';
		$value = empty($this->value) ? '' : ' value="'.$this->value.'"';

		$field = '<input'.$this->attrs.$value.' />';
		return $tab.sprintf("%2\$s%1\$s", $field, $label);
	}
}

// ---------------------------------------------------------------------------
class Form_Radio extends Form_Input {

	protected $choices;

	public function __construct($name, $form) {

		parent::__construct($name, $form);
		$this->attrs['type'] = 'radio';
		$this->choices = array();
	}

	public function choices($array) {

		if (!is_array($array)) {

			$array = func_get_args();
		}
		$this->choices = $array;

		return $this;
	}

	protected function _init() {

		if (!isset(self::$error_list['incorrect_value'])) {

			self::$error_list['incorrect_value'] = "La valeur fournie est interdite.";
		}
	}

	public function is_valid($value) {

		if (parent::is_valid($value)) {

			if ($this->required && !in_array($value, $this->choices)) {

				$this->_error('incorrect_value');
				return false;
			}
			return true;
		}
		return false;
	}

	public function __toString() {

		$tab = func_num_args() > 0 ? func_get_arg(0) : '';
		
		$this->_generate_class();

		$i = $this->form->auto_id();
		$span = (!empty($this->label)) ? '<span>'.$this->label.$this->form->label_suffix().'<br /></span>' : '';
		$errors = $this->error_messages->__toString($tab);
		if (!empty($errors)) { $errors = "\n".$errors; }
		$value = $this->form->get_bounded_data($this->attrs['name']);
		$value = (!empty($value)) ? $value : $this->value;

		$j = 0;
		$fields = array();
		foreach($this->choices as $v => $c) {

			$id = '';
			$label = '';
			if (!empty($i)) {

				list($for, $id) = self::_generate_for_id($this->form->auto_id().'_'.(++$j), $this->attrs['name']);
				$label = '<label'.$for.'>'.$c.'</label>';
			}
			$this->attrs['value'] = htmlspecialchars($v);
			$checked = '';
			if ($value == $v) { $checked = ' checked="checked"';  }
			$fields[] = '<input'.$id.$this->attrs.$checked.' /> '.$label.'<br />';

		}
		$field = "\n$tab".implode("\n$tab", $fields);
		return $tab.sprintf("%2\$s%3\$s%1\$s", $field, $span, $errors);
	}
}

// ---------------------------------------------------------------------------
class Form_Select extends Form_Input {

	protected $choices;

	public function __construct($name, $form) {

		parent::__construct($name, $form);
		$this->choices = array();
		unset($this->attrs['type']);
	}

	public function choices($array) {

		if (!is_array($array)) {

			$array = func_get_args();
		}
		$this->choices = $array;

		return $this;
	}

	protected function _init() {

		if (!isset(self::$error_list['incorrect_value'])) {

			self::$error_list['incorrect_value'] = "La valeur fournie est interdite.";
		}
	}

	public function is_valid($value) {

		if (parent::is_valid($value)) {

			if ($this->required && !in_array($value, $this->choices)) {

				$this->_error('incorrect_value');
				return false;
			}
			return true;
		}
		return false;
	}

	public function __toString() {

		$tab = func_num_args() > 0 ? func_get_arg(0) : '';
		
		$this->_generate_class();

		$id = '';
		$label = '';
		if (!empty($this->label)) {

			list($for, $id) = self::_generate_for_id($this->form->auto_id(), $this->attrs['name']);
			$label = '<label'.$for.'>'.$this->label.$this->form->label_suffix().'</label>'."\n$tab";
		}
		$errors = $this->error_messages->__toString($tab);
		if (!empty($errors)) { $errors = "\n".$errors; }
		$value = $this->form->get_bounded_data($this->attrs['name']);
		$value = (!empty($value)) ? $value : $this->value;

		$j = 0;
		$fields = array();
		foreach($this->choices as $v => $c) {

			if (is_array($c)) {

				$fields[] = "$tab\t".'<optgroup label="'.htmlspecialchars($v).'">';
				foreach($c as $vv => $cc) {

					$selected = '';
					if ($value == $vv) { $selected = ' selected="selected"';  }
					$fields[] = "$tab\t\t".'<option value="'.htmlspecialchars($vv).'"'.$selected.'> '.$cc.'</option>';
				}
				$fields[] = "$tab\t".'</optgroup>';

			} else {
				$selected = '';
				if ($value == $v) { $selected = ' selected="selected"';  }
				$fields[] = "$tab\t".'<option value="'.htmlspecialchars($v).'"'.$selected.'> '.$c.'</option>';
			}
		}

		$field = '<select'.$id.$this->attrs.'>'."\n".implode("\n", $fields)."\n$tab</select>";
		return $tab.sprintf("%2\$s%1\$s%3\$s", $field, $label, $errors);
	}
}

// ---------------------------------------------------------------------------
class Form_Checkbox extends Form_Input {

	public function __construct($name, $form) {

		parent::__construct($name, $form);
		$this->attrs['type'] = 'checkbox';
	}

	protected function _init() {

		if (!isset(self::$error_list['incorrect_value'])) {

			self::$error_list['incorrect_value'] = "La valeur fournie est interdite.";
		}
	}

	public function is_valid($value) {

		if (parent::is_valid($value)) {

			if ($this->required && !empty($this->value) && $value != $this->value) {

				$this->_error('incorrect_value');
				return false;
			}
			return true;
		}
		return false;
	}

	public function __toString() {

		$tab = func_num_args() > 0 ? func_get_arg(0) : '';
		
		$this->_generate_class();

		$id = '';
		$label = '';
		if (!empty($this->label)) {

			list($for, $id) = self::_generate_for_id($this->form->auto_id(), $this->attrs['name']);
			$label = "\n$tab".'<label'.$for.'>'.$this->label.'</label>';
		}
		$errors = $this->error_messages->__toString($tab);
		if (!empty($errors)) { $errors = "\n".$errors; }

		$value = (!empty($this->value)) ? ' value="'.htmlspecialchars($this->value).'"' : '';
		$checked = ($this->value == $this->form->get_bounded_data($this->attrs['name'])) ? ' checked="checked"' : '';

		$field = '<input'.$id.$this->attrs.$value.$checked.' />';
		return $tab.sprintf("%1\$s%2\$s%3\$s", $field, $label, $errors);
	}
}

// ---------------------------------------------------------------------------
class Form_Textarea extends Form_Field {

	public function cols($value) {

		if (ctype_digit((string)$value) && $value > 0) { $this->attrs['cols'] = $value; }
		else { unset($this->attrs['cols']); }
		return $this;
	}

	public function get_cleaned_value($value) {

		return preg_replace('`[\x00\x08-\x0b\x0c\x0e\x19]`i', '', $value);
	}

	public function rows($value) {

		if (ctype_digit((string)$value) && $value > 0) { $this->attrs['rows'] = $value; }
		else { unset($this->attrs['rows']); }
		return $this;
	}

	public function __toString() {

		$tab = func_num_args() > 0 ? func_get_arg(0) : '';
		
		$this->_generate_class();

		$id = '';
		$label = '';
		if (!empty($this->label)) {

			list($for, $id) = self::_generate_for_id($this->form->auto_id(), $this->attrs['name']);
			$label = '<label'.$for.'>'.$this->label.$this->form->label_suffix().'</label>'."\n$tab";
		}
		$errors = $this->error_messages->__toString($tab);
		if (!empty($errors)) { $errors = "\n".$errors; }
		$value = $this->form->get_bounded_data($this->attrs['name']);
		$value = (!empty($value)) ? htmlspecialchars($value) : htmlspecialchars($this->value);

		$field = '<textarea'.$id.$this->attrs.'>'.$value.'</textarea>';
		return $tab.sprintf("%2\$s%1\$s%3\$s", $field, $label, $errors);
	}
}

// ---------------------------------------------------------------------------
class ListArray implements Iterator, ArrayAccess {

	protected $array = array();
	private $valid = false;

	function __construct(Array $array = array()) {
		$this->array = $array;
	}

	/* Iterator */
	function rewind()  { $this->valid = (FALSE !== reset($this->array)); }
	function current() { return current($this->array);      }
	function key()     { return key($this->array);  }
	function next()    { $this->valid = (FALSE !== next($this->array));  }
	function valid()   { return $this->valid;  }

	/* ArrayAccess */
	public function offsetExists($offset) {
		return isset($this->array[$offset]);
	}
	public function offsetGet($offset) {
		return $this->array[$offset];
	}
	public function offsetSet($offset, $value) {
		return $this->array[$offset] = $value;
	}
	public function offsetUnset($offset) {
		unset($this->array[$offset]);
	}
}


// ---------------------------------------------------------------------------
class ErrorList extends ListArray {

	public function as_array() {

		return $this->array;
	}

	public function __toString() {

		$tab = func_num_args() > 0 ? func_get_arg(0) : '';
		
		if (!empty($this->array)) {

			return sprintf($tab."<ul>\n\t$tab<li>%s</li>\n$tab</ul>", implode("</li>\n\t$tab<li>", $this->array));
		}
		return '';
	}
}

// ---------------------------------------------------------------------------
class AttributeList extends ListArray {

	public function __toString() {

		$o = '';
		if (!empty($this->array)) {

			foreach($this->array as $a=>$v) {

				$o .= sprintf(' %s="%s"', $a, htmlspecialchars($v));
			}
		}
		return $o;
	}
}

// ---------------------------------------------------------------------------


/**
  * Parse a time/date generated with strftime().
  *
  * This function is the same as the original one defined by PHP (Linux/Unix only),
  *  but now you can use it on Windows too.
  *  Limitation : Only this format can be parsed %S, %M, %H, %d, %m, %Y
  *
  * @author Lionel SAURON
  * @version 1.0
  * @public
  *
  * @param $sDate(string)    The string to parse (e.g. returned from strftime()).
  * @param $sFormat(string)  The format used in date  (e.g. the same as used in strftime()).
  * @return (array)  Returns an array with the <code>$sDate</code> parsed, or <code>false</code> on error.
  */
if(function_exists("strptime") == false) {

	function strptime($sDate, $sFormat) {
		$aResult = array (
			'tm_sec'   => 0,
			'tm_min'   => 0,
			'tm_hour'  => 0,
			'tm_mday'  => 1,
			'tm_mon'   => 0,
			'tm_year'  => 0,
			'tm_wday'  => 0,
			'tm_yday'  => 0,
			'unparsed' => $sDate,
		);

		while(!empty($sFormat)) {
		// ===== Search a %x element, Check the static string before the %x =====

			$nIdxFound = strpos($sFormat, '%');

			if($nIdxFound === false)
			{
				// There is no more format. Check the last static string.
				$aResult['unparsed'] = ($sFormat == $sDate) ? "" : $sDate;
				break;
			}
			$sFormatBefore = substr($sFormat, 0, $nIdxFound);
			$sDateBefore   = substr($sDate,   0, $nIdxFound);
			if($sFormatBefore != $sDateBefore) break;

			// ===== Read the value of the %x found =====
			$sFormat = substr($sFormat, $nIdxFound);
			$sDate   = substr($sDate,   $nIdxFound);
			$aResult['unparsed'] = $sDate;
			$sFormatCurrent = substr($sFormat, 0, 2);
			$sFormatAfter   = substr($sFormat, 2);
			$nValue = -1;
			$sDateAfter = "";

			switch($sFormatCurrent) {

				case '%S': // Seconds after the minute (0-59)
					sscanf($sDate, "%2d%[^\\n]", $nValue, $sDateAfter);
					if(($nValue < 0) || ($nValue > 59)) return false;
					$aResult['tm_sec']  = $nValue;
				break;
				// ----------

				case '%M': // Minutes after the hour (0-59)
					sscanf($sDate, "%2d%[^\\n]", $nValue, $sDateAfter);
					if(($nValue < 0) || ($nValue > 59)) return false;
					$aResult['tm_min']  = $nValue;
				break;
				// ----------

				case '%H': // Hour since midnight (0-23)
					sscanf($sDate, "%2d%[^\\n]", $nValue, $sDateAfter);
					if(($nValue < 0) || ($nValue > 23)) return false;
					$aResult['tm_hour']  = $nValue;
				break;

				// ----------
				case '%d': // Day of the month (1-31)
					sscanf($sDate, "%2d%[^\\n]", $nValue, $sDateAfter);
					if(($nValue < 1) || ($nValue > 31)) return false;
					$aResult['tm_mday']  = $nValue;
				break;

				// ----------
				case '%m': // Months since January (0-11)
					sscanf($sDate, "%2d%[^\\n]", $nValue, $sDateAfter);
					if(($nValue < 1) || ($nValue > 12)) return false;
					$aResult['tm_mon']  = ($nValue - 1);
				break;

				// ----------
				case '%Y': // Years since 1900
					sscanf($sDate, "%4d%[^\\n]", $nValue, $sDateAfter);
					if($nValue < 1900) return false;
					$aResult['tm_year']  = ($nValue - 1900);
				break;

				// ----------
				default: break 2; // Break Switch and while
			}
			// ===== Next please =====
			$sFormat = $sFormatAfter;
			$sDate   = $sDateAfter;
			$aResult['unparsed'] = $sDate;
		}
		// END while($sFormat != "")

		// ===== Create the other value of the result array =====
		$nParsedDateTimestamp = mktime($aResult['tm_hour'], $aResult['tm_min'], $aResult['tm_sec'], $aResult['tm_mon'] + 1, $aResult['tm_mday'], $aResult['tm_year']+1900-28*floor((($aResult['tm_year']-100)/28)));

		// Before PHP 5.1 return -1 when error
		if(($nParsedDateTimestamp === false) || ($nParsedDateTimestamp === -1))
			return false;

		$aResult['tm_wday'] = strftime("%w", $nParsedDateTimestamp); // Days since Sunday (0-6)
		$aResult['tm_yday'] = (strftime("%j", $nParsedDateTimestamp) - 1); // Days since January 1 (0-365)

		return $aResult;
	}
	// END of function
}
// END if(function_exists("strptime") == false)

// end of file */