<?php
namespace Pragma\Forms;

use Pragma\Forms\CSRFTagsManager\CSRFTagsManager;

class Form{
	protected $params = [
		'name' => 'pragma_form',
		'id'	=> 'pragma_form',
		'object' => null,
		'action' => '#',
		'method' => 'POST',
		'additional_js' => '',
		'enctype' => false,
		'additional_attributes' => null
	];

	protected $tag = null;
	protected $boxes = [];

	public function __construct($params = []){
		$this->params = array_merge($this->params, $params);

		if(CSRFTagsManager::isEnabled()){
			$this->tag = CSRFTagsManager::getManager()->prepareTag();
		}
	}

	public function __set($key, $value){
		if(array_key_exists($key, $this->params)){
			$this->params[$key] = $value;
		}
	}

	public function __get($key){
		if(array_key_exists($key, $this->params)){
			return $this->params[$key];
		}
		else return null;
	}

	public function __isset($key){
		return array_key_exists($key, $this->params) && isset($this->params[$key]);
	}

	public function get_header(){
		$header = '<form name="'.$this->name .'" id="'. $this->id .'" action="'. $this->action .'" method="' . $this->method .'" '. (( $this->enctype ) ? 'enctype="multipart/form-data"' : ''). ' '.$this->additional_attributes.' >';
		return $header;
	}

	public function close(){
		$js = empty($this->additional_js) ? '' : '<script type="text/javascript">'.$this->additional_js.'</script>';
		$csrf = '';
		if(CSRFTagsManager::isEnabled()){
			CSRFTagsManager::getManager()->storeTag($this->tag);
			$csrf = $this->hidden_field(['name' => CSRFTagsManager::CSRF_TAG_NAME, 'value' => $this->tag->getTag()]);
		}
		return "$js\n$csrf\n</form>";
	}

	public function getBoxes(){
		return $this->boxes;
	}

	public function text_field($params = [], $deferred = false){
		$field = Fields\TextField::getField($params)->setForm($this);
		if(CSRFTagsManager::isEnabled()){
			$this->tag->storeField($field->name);
		}
		return ! $deferred ? $field->render() : $field;
	}

	public function password_field($params = [], $deferred = false){
		$field = Fields\PasswordField::getField($params)->setForm($this);
		if(CSRFTagsManager::isEnabled()){
			$this->tag->storeField($field->name);
		}
		return ! $deferred ? $field->render() : $field;
	}

	public function hidden_field($params = [], $deferred = false){
		$field = Fields\HiddenField::getField($params)->setForm($this);
		if(CSRFTagsManager::isEnabled()){
			$this->tag->storeField($field->name);
		}
		return ! $deferred ? $field->render() : $field;
	}

	public function file_field($params = [], $deferred = false){
		$field = Fields\FileField::getField($params)->setForm($this);
		if(CSRFTagsManager::isEnabled()){
			$this->tag->storeField($field->name);
		}
		return ! $deferred ? $field->render() : $field;
	}

	public function textarea_field($params = [], $deferred = false){
		$field = Fields\TextareaField::getField($params)->setForm($this);
		if(CSRFTagsManager::isEnabled()){
			$this->tag->storeField($field->name);
		}
		return ! $deferred ? $field->render() : $field;
	}

	public function select_field($params = [], $deferred = false){
		$field = Fields\SelectField::getField($params)->setForm($this);
		$html = "";
		if(CSRFTagsManager::isEnabled()){
			$this->tag->storeField($field->name);
			//Special issue if the select is multiple : The field may not be present in the query
			//if no option has been selected by the user
			if($field->multiple)){
				$rawname = preg_replace("/\[[^\]]*\]/","", $field->name);
				if( ! isset($this->boxes[$rawname])){
					$this->boxes[$rawname] = $rawname;
					if(!$deferred){
						$html .= $this->hidden_field(['name' => $field->name]);
					}
				}
			}
		}
		return ! $deferred ? $html."\n".$field->render() : $field;
	}

	public function checkbox_field($params = [], $deferred = false){
		$field = Fields\CheckboxField::getField($params)->setForm($this);
		$html = "";
		if(CSRFTagsManager::isEnabled()){
			$this->tag->storeField($field->name);
			$rawname = preg_replace("/\[[^\]]*\]/","", $field->name);
			if( ! isset($this->boxes[$rawname])){
				$this->boxes[$rawname] = $rawname;
				if(!$deferred){
					$html .= $this->hidden_field(['name' => $field->name]);
				}
			}
		}

		return ! $deferred ? $html."\n".$field->render() : $field;
	}

	public function radio_field($params = [], $deferred = false){
		$field = Fields\RadioField::getField($params)->setForm($this);
		$html = "";
		if(CSRFTagsManager::isEnabled()){
			$this->tag->storeField($field->name);
			$rawname = preg_replace("/\[[^\]]*\]/","", $field->name);
			if( ! isset($this->boxes[$rawname])){
				$this->boxes[$rawname] = $rawname;
				$html .= $this->hidden_field(['name' => $rawname]);
			}
		}

		return ! $deferred ? $html."\n".$field->render() : $field;
	}

	public function submit_field($params = [], $deferred = false){
		$field = Fields\SubmitField::getField($params)->setForm($this);
		if(CSRFTagsManager::isEnabled()){
			$this->tag->storeField($field->name);
		}
		return ! $deferred ? $field->render() : $field;
	}
}
