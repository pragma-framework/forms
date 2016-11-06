<?php
namespace Pragma\Forms\Fields;

use Pragma\Forms\Fields\AbstractCheckableField;

class RadioField extends AbstractCheckableField{
	public function __construct($params = []){
		parent::__construct($params);
		$this->setType('radio');
	}
}
