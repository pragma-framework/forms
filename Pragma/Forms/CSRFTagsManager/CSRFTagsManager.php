<?php
namespace Pragma\Forms\CSRFTagsManager;

//This system use the session ($_SESSION). Do not use this in the context of a RESTFUL API

class CSRFTagsManager{
	const UNLIMITED_TAG = -1;
	const CSRF_TAG_NAME = 'pragma-csrf-tag';

	private static $manager = null;//singleton
	protected $tags = null;
	protected $limit = self::UNLIMITED_TAG;//in minutes


	public function __construct($session_var){
		//only if we can access the session and if the user does'nt disable the CSRF Protection
		if( ! self::isEnabled()){
			throw new CSRFTagsException(CSRFTagsException::NO_SESSION_MESS, CSRFTagsException::NO_SESSION);
		}

		if(defined('CUSTOM_TOKEN_TIME')){
			$this->limit = CUSTOM_TOKEN_TIME;
		}
		$this->tags = &$_SESSION[$session_var];
	}

	public static function isEnabled(){
		return session_status() == PHP_SESSION_ACTIVE && (!defined('DISABLE_CSRF_PROTECTION') || ! DISABLE_CSRF_PROTECTION);
	}

	public static function getManager($session_var = 'Pragma\\Forms\\CSRFTagsManager'){
		if(is_null(self::$manager)){
			self::$manager = new CSRFTagsManager($session_var);
		}
		return self::$manager;
	}

	public function prepareTag($permanent = false){
		return new CSRFTag($permanent);
	}

	public function storeTag(CSRFTag $tag){
		$this->tags[$tag->getTag()] = $tag->dump();
	}

	public function checkTag($tag, $params, $files = []){
		if( empty($tag) || ! isset($this->tags[$tag]) ){
			throw new CSRFTagsException(CSRFTagsException::UNKNOWN_TAG_MESS, CSRFTagsException::UNKNOWN_TAG);
		}

		if( ! ( $this->limit == self::UNLIMITED_TAG || $this->tags[$tag]['date'] >= strtotime('-'.$this->limit.' minutes') ) ){
			throw new CSRFTagsException(CSRFTagsException::OUTDATED_TAG_MESS, CSRFTagsException::OUTDATED_TAG);
		}

		//check fields
		$params = !isset($params) ? [] : $params;
		$files = !isset($files) ? [] : $files;
		$names = array_merge(array_keys($params), array_keys($files));

		sort($names);
		if( md5(implode('', $names)) == $this->tags[$tag]['control'] ){
			if( ! $this->tags[$tag]['permanent'] ){
				unset($this->tags[$tag]);
			}
			return true;
		}
		else{
			throw new CSRFTagsException(CSRFTagsException::CONTROL_MISMATCH_MESS, CSRFTagsException::CONTROL_MISMATCH);
		}
	}

	//useful for Ajax
	//Be careful, use $permanent "true" with precautions
	public static function emulateForm($fields, $permanent = false){
		if(static::isEnabled()){
			$manager = self::getManager();
			$tag = $manager->prepareTag($permanent);
			sort($fields);
			foreach($fields as $name){
				$tag->storeField($name);
			}
			$manager->tags[$tag->getTag()] = $tag->dump();

			return $tag->getTag();
		}
		else{
			return null;
		}
	}

	//delete tokens when there are too old
	public function cleanup(){
		if( $this->limit != self::UNLIMITED_TAG){
			if(!empty($this->tags))
			foreach($this->tags as $tag => $time){
				if($time < strtotime('-'.$this->limit.' minutes')){
					unset($this->tags[$tag]);
				}
			}
		}
	}

}
