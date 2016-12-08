<?php
namespace Pragma\Forms\Fields;

use Pragma\Forms\Fields\FieldsInterface;
class AbstractCheckableField implements FieldsInterface{

	use FieldsTrait;

	protected $params = [
		'name' => 'text_field',
		'id' =>  null,
		'db_field' => null,
		'value' =>  null,
		'classes' => '',
		'additional_attributes' => '',
		'dom_extension' =>  null,
		'checked'	=> false
	];

	protected $type = null;

	public function setType($type){
		$this->type = $type;
		return $this;
	}

	public function render(){
		$object = isset($this->form) && !empty($this->form->object) ? $this->form->object : null;

		$field =  '<input type="'.$this->type.'" name="'.$this->name.'" id="'.$this->id.'" value="'.$this->value.'" ';
		if( ! is_null($this->classes) && ! empty($this->classes) ) $field .= ' class="'.$this->classes.'" ';

		$column = $this->db_field;
		if( ! is_null($this->db_field) && ! empty($this->db_field) && ! is_null($object) && isset($object->$column)	&& $object->$column == $this->value){
			$field .= ' checked="checked" ';
		}
		else if( $this->checked ) $field .= ' checked="checked" ';


		$field .= ' '.$this->additional_attributes. ' />';
		if( ! is_null($this->dom_extension) ) $field .= $this->dom_extension;

		return $field;
	}
}


