<?php
namespace Pragma\Forms\CSRFTagsManager;

class CSRFTagsException extends \Exception{
	const NO_SESSION = 1;
	const UNKNOWN_TAG = 2;
	const OUTDATED_TAG = 3;
	const TAG_REQUESTED = 4;
	const CONTROL_MISMATCH = 5;

	const NO_SESSION_MESS = 'No session found or CSRF Protection voluntarily disabled. Unable to activate the CSRF Manager';
	const UNKNOWN_TAG_MESS = 'Unknown CSRF Tag';
	const OUTDATED_TAG_MESS = 'This tag is no longer valid';
	const TAG_REQUESTED_MESS = 'CSRF Tag is missing';
	const CONTROL_MISMATCH_MESS = 'A difference between params and the stored CSRF tag has been detected';

	public function __toString(){
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}
