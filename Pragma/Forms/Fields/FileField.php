<?php
namespace Pragma\Forms\Fields;

use AbstractTextableField;

class FileField extends AbstractTextableField{
	public function __construct($params = []){
		parent::__construct($params);
		$this->setType('file');
	}
}
