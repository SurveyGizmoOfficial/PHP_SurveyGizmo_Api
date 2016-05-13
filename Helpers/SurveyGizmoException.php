<?php namespace SurveyGizmo;
class SurveyGizmoException{

	const NOT_IMPLEMENTED  = 404;
    const NOT_SUPPORTED  = 405;
    const NOT_AUTHORIZED = 401;

	function __construct($type = null) {
		$this->type = $type;
    }

    function getMessage(){
    	$type = $this->type;
    	$response = new Response();
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
}
?>