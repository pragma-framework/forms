<?php
namespace Pragma\Forms;

use Pragma\Forms\Form;
use Pragma\Forms\LayeredFormBlock;
use Pragma\View\View;

class LayeredForm extends Form{
	protected $blocks = [];
	protected $layout = null;

	protected $params = [
		'name' => 'pragma_form',
		'id'	=> 'pragma_form',
		'object' => null,
		'action' => '#',
		'method' => 'POST',
		'additional_js' => '',
		'enctype' => false,
		'additional_attributes' => null,
		'cancel_url' => null
	];

	public function __construct($params = []){
		parent::__construct($params);
		$this->blocks['default'] = new LayeredFormBlock('default');
		$this->layout = __DIR__ . '/Views/default_form_layout.tpl.php';
	}

	public function add_text_field($params = [], $label = null, $block = 'default'){
		$this->addField($block, $this->text_field($params, true), $label);

	}
	public function add_password_field($params = [], $label = null, $block = 'default'){
		$this->addField($block, $this->password_field($params, true), $label);

	}
	public function add_hidden_field($params = [], $label = null, $block = 'default'){
		$this->addField($block, $this->hidden_field($params, true), $label);

	}
	public function add_file_field($params = [], $label = null, $block = 'default'){
		$this->addField($block, $this->file_field($params, true), $label);

	}
	public function add_textarea_field($params = [], $label = null, $block = 'default'){
		$this->addField($block, $this->textarea_field($params, true), $label);

	}
	public function add_select_field($params = [], $label = null, $block = 'default'){
		$this->addField($block, $this->select_field($params, true), $label);

	}
	public function add_checkbox_field($params = [], $label = null, $block = 'default'){
		$this->addField($block, $this->checkbox_field($params, true), $label);

	}
	public function add_radio_field($params = [], $label = null, $block = 'default'){
		$this->addField($block, $this->radio_field($params, true), $label);

	}
	public function add_submit_field($params = [], $label = null, $block = 'default'){
		$this->addField($block, $this->submit_field($params, true), $label);
	}

	private function addField($block, $field, $label){
		if(!isset($this->blocks[$block])){
			$this->addBlock($block);
		}

		$this->blocks[$block]->addField($field, $label);
	}

	public function addBlock($id, $label = '', $hlevel = LayeredFormBlock::DEFAULT_HEADER_LEVEL){
		if(!isset($this->blocks[$id])){
			$this->blocks[$id] = new LayeredFormBlock($id, $label, $hlevel);
		}

		return $this->blocks[$id];
	}

	public function getBlock($id){
		return isset($this->blocks[$id]) ? $this->blocks[$id] : null;
	}

	public function getBlocks(){
		return $this->blocks;
	}

	public function setLayout($layout){
		$this->layout = $layout;
	}

	public function build(){
		$view = new View();//new instance
		$view->setLayout($this->layout);
		$view->assign('form', $this);
		return $view->compile();
	}
}
