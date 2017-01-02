<?php
namespace Pragma\Forms\CSRFTagsManager;

class CSRFTag{
	protected $tag = '';
	protected $date;
	protected $permanent;
	protected $fields = [];


	public function __construct($permanent = false){
		$this->date = time();
		$this->tag = uniqid('', true);
		$this->permanent = $permanent;
	}

	public function storeField($fieldname){
		$name = preg_replace("/\[[^\]]*\]/","",$fieldname);
		$this->fields[$name] = $name;
	}

	public function getTag(){
		return $this->tag;
	}
	public function dump(){
		ksort($this->fields);

		return [
			'date' => $this->date,
			'control' => md5(implode('', array_keys($this->fields))),
			'permanent' => $this->permanent
		];
	}
}
