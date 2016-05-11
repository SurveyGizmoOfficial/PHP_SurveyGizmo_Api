<?php
namespace SurveyGizmo;
class Auth{
	
	/***PROPERTIES***/
	
	/***FUNCTIONS***/
	function __construct($token,$secret){
		if(isset($token) && isset($secret)){
			$this->token = $token;
		}else{
			new SurveyGizmoException();
		}
	}

	private function authenticate(){

	}
}
?>