<?php
namespace Pragma\Forms\Fields;

use Pragma\Forms\Fields\FieldsInterface;
class TextareaField implements FieldsInterface{

	use FieldsTrait;

	protected $params = [
		'name' => 'text_field',
		'id' =>  null,
		'db_field' => null,
		'value' =>  null,
		'classes' => '',
		'additional_attributes' => '',
		'dom_extension' =>  null
	];

	protected $type = 'textarea';

	public function render(){
		$object = isset($this->form) && !empty($this->form->object) ? $this->form->object : null;

		$field =  '<textarea type="text" name="'.$this->name.'" id="'.$this->id.'" ';
		if( ! is_null($this->classes) && ! empty($this->classes) ){
			$field .= ' class="'.$this->classes.'" ';
		}
		$field .= ' '.$this->additional_attributes. '>';

		$column = $this->db_field;
		if( ! is_null($this->db_field) && ! empty($this->db_field) && ! is_null($object) && isset($object->$column) ){
			$field .= $object->$column;
		}
		else if( ! is_null($this->value) && isset($this->value)){
			$field .= $this->value;
		}
		$field .= '</textarea>';
		if( ! is_null($this->dom_extension) ){
			$field .= $this->dom_extension;
		}

		return $field;
	}
}
