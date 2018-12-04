<?php
namespace Pragma\Forms\Fields;

use Pragma\Forms\Fields\FieldsInterface;
class AbstractTextableField implements FieldsInterface{

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

	protected $typeinput = null;

	public function setType($type){
		$this->type = $type;
		return $this;
	}

	public function render(){
		$object = isset($this->form) && !empty($this->form->object) ? $this->form->object : null;
		$field =  '<input type="'.$this->type.'" name="'.$this->name.'" id="'.$this->id.'" ';
		if( ! is_null($this->classes) && ! empty($this->classes) ){
			$field .= ' class="'.$this->classes.'" ';
		}
		$column = $this->db_field;
		if( ! is_null($this->db_field) && ! empty($this->db_field) && ! is_null($object) && isset($object->$column) ){
			$field .= ' value="'.str_replace('"', '&quot;', $object->$column).'" ';
		}
		elseif( ! is_null($this->value) && isset($this->value)){
			$field .= ' value="'.str_replace('"', '&quot;', $this->value).'" ';
		}

		$field .= ' '.$this->additional_attributes. ' />';
		if( ! is_null($this->dom_extension) ){
			$field .= $this->dom_extension;
		}

		return $field;
	}
}
