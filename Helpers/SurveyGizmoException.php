<?php
namespace SurveyGizmo;

use \Exception;

class SurveyGizmoException extends Exception
{

	const NOT_IMPLEMENTED = 404;
	const NOT_SUPPORTED = 405;
	const NOT_AUTHORIZED = 401;

	// Used for HTTP-like status code
	protected $code = 500;

	// Redefine the exception so code is first parameter
	public function __construct($code = 0, $message, Exception $previous = null) {
		parent::__construct($message, $code, $previous);

		if (!$this->message) {
			switch ($this->code) {
				case self::NOT_IMPLEMENTED:
					$this->message = 'Method not implemented';
					break;
				case self::NOT_SUPPORTED:
					$this->message = 'Method not supported';
					break;
				case self::NOT_AUTHORIZED:
					$this->message = 'Not Authorized';
					break;
				default:
					$this->message = 'An Error has Occurred.';
					break;
			}
		}
	}

	/*
	public function __construct($type = null)
	{
		$this->type = $type;
	}

	public function getMessage()
	{
		$type = $this->type;
		$response = new APIResponse();
		$response->results = false;
		$message = 'An Error has Occurred.';

		switch ($type) {
			case self::NOT_IMPLEMENTED:
				$message = 'Method not implemented';
				break;
			case self::NOT_SUPPORTED:
				$message = 'Method not supported';
				break;
			case self::NOT_AUTHORIZED:
				$message = 'Not Authorized';
				break;
			default:
				$type = 500;
				break;
		}
		$response->code = $type;
		$response->message = $message;
		return $response;
	}
	*/
}
