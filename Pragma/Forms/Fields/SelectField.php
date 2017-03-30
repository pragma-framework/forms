<?php
namespace Pragma\Forms\Fields;

use Pragma\Forms\Fields\FieldsInterface;
class SelectField implements FieldsInterface{

	use FieldsTrait;

	protected $params = [
		'name' => 'select_field',
		'id' =>  null,
		'db_field' => null,
		'options' => null,
		'empty_message' => null,
		'value' =>  null,
		'classes' => '',
		'additional_attributes' => '',
		'dom_extension' =>  null,
		'multiple' => false
	];

	protected $type = 'select';

	public function render(){
		$object = isset($this->form) && !empty($this->form->object) ? $this->form->object : null;

		if($this->multiple && substr_compare($this->name, "[]", strlen($this->name)-2, 2) !== 0){
			$this->name .= '[]';
		}

		$field = '<select name="'.$this->name.'" id="'.$this->id.'" ';
		if( ! is_null($this->classes) && ! empty($this->classes) ) $field .= ' class="'.$this->classes.'" ';
		if($this->multiple) $field .= ' multiple="true" ';
		$field .= ' '.$this->additional_attributes. '>';

		if(!is_null($this->empty_message)){ //the message can be empty if it's the developper's wish.
			$field .= '<option value="">'.$this->empty_message.'</option>';
		}

		if( ! is_null($this->options) && !empty($this->options)){
			$column = $this->db_field;
			$db_field_exploitable = ! is_null($this->db_field) && ! empty($this->db_field) && ! is_null($object) && isset($object->$column);

			$need_value = true;
			if($db_field_exploitable && isset($this->options[$object->$column])){ //if the column value of the object is part of the available options
				$need_value = false;
			}

			$first = null;
			//TODO : improve this. current  returns me an Indirect modification of overloaded property
			foreach($this->options as $label){
				$first = $label;
				break;
			}

			if(is_array($first)){ // handle groups
				foreach($this->options as $val => $label){
					$field .= '<optgroup label="'.htmlentities($val).'">';
					foreach($label as $v => $l){
						$selected = '';
						if( $db_field_exploitable && $object->$column == $v){
							$selected = ' selected="selected" ';
						}
						else if($need_value && !is_null($this->value) && ! is_array($this->value) && $this->value == $v) $selected = ' selected="selected" ';
						else if($need_value && !is_null($this->value) && is_array($this->value) && isset($this->value[$v]) ) $selected = ' selected="selected" ';
						$field .= '<option value="'.htmlentities($v).'" '.$selected.'>'.$l.'</option>';
					}
					$field .= '</optgroup>';
					$selected = '';
				}
			}else{
				foreach($this->options as $val => $label){

					$selected = '';
					if( $db_field_exploitable && $object->$column == $val){
						$selected = ' selected="selected" ';
					}
					else if($need_value && !is_null($this->value) && ! is_array($this->value) && $this->value == $val) $selected = ' selected="selected" ';
					else if($need_value && !is_null($this->value) && is_array($this->value) && isset($this->value[$val]) ) $selected = ' selected="selected" ';
					$field .= '<option value="'.htmlentities($val).'" '.$selected.'>'.$label.'</option>';
				}
			}
		}
		$field .= '</select>';
		if( ! is_null($this->dom_extension) ) $field .= $this->dom_extension;

		return $field;
	}
}
