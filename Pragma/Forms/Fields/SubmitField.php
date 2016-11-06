<?php
namespace Pragma\Forms\Fields;

use Pragma\Forms\Fields\FieldsInterface;
class SubmitField implements FieldsInterface{

	use FieldsTrait;

	protected $params = [
		'name' => '',
		'id' =>  null,
		'value' =>  null,
		'classes' => '',
		'additional_attributes' => '',
	];

	protected $type = 'submit';

	public function render(){
		if($this->name == "submit"){
			$this->name = "";
		}

		$field = '<input type="submit" name="'.$this->name.'" id="'.$this->id.'" value="'.$this->value.'" ';
		if( ! is_null($this->classes) && ! empty($this->classes) ) $field .= ' class="'.$this->classes.'" ';
		$field .= ' '.$this->additionnal_attributes. ' />';
		return $field;
	}
}
