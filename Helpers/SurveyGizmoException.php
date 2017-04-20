<?php
namespace SurveyGizmo\Helpers;
use \Exception;

/**
 * SurveyGizmo custom exception.
 */
class SurveyGizmoException extends Exception
{
	const NOT_IMPLEMENTED = 404;
	const NOT_SUPPORTED = 405;
	const NOT_AUTHORIZED = 401;

	// Used for HTTP-like status code
	protected $code = 500;

	public function __construct($message = "", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);

		// Default the message based on code (if empty)
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
					$this->message = 'An error has occurred.';
					break;
			}
		}
	}
}
