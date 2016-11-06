<?php
namespace Pragma\Forms\Fields;

use Pragma\Forms\Fields\AbstractTextableField;

class TextField extends AbstractTextableField{
	public function __construct($params = []){
		parent::__construct($params);
		$this->setType('text');
	}
}
