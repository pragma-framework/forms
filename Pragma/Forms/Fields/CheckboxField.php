<?php
namespace Pragma\Forms\Fields;

use Pragma\Forms\Fields\AbstractCheckableField;

class CheckboxField extends AbstractCheckableField{
	public function __construct($params = []){
		parent::__construct($params);
		$this->setType('checkbox');
	}
}
