<?php

namespace Pragma\Forms\Fields;

trait FieldsTrait
{
	protected $form = null;

	public function __construct($params = [])
	{
		//ensure that the user does'nt add extra params
		$extra_params = array_diff_key($params, $this->params);
		if (!empty($extra_params)) {
			foreach ($extra_params as $k) {
				unset($params[$k]);
			}
		}

		if (!empty($params)) {
			$this->params = array_merge($this->params, $params);
			if (is_null($this->id) || empty($this->id) && !empty($this->name)) {
				$this->id = $this->name;
			}
		}
	}

	public function __set($key, $value)
	{
		if (array_key_exists($key, $this->params)) {
			$this->params[$key] = $value;
		}
		return $this;
	}

	public function __get($key)
	{
		if (array_key_exists($key, $this->params)) {
			return $this->params[$key];
		} else {
			return null;
		}
	}

	public function __isset($key)
	{
		return array_key_exists($key, $this->params) && isset($this->params[$key]);
	}

	public static function getField($params = [])
	{
		$class = get_called_class();
		return new $class($params);
	}

	public function setForm($form)
	{
		$this->form = $form;
		return $this;
	}

	public function getType()
	{
		return $this->type;
	}
}
