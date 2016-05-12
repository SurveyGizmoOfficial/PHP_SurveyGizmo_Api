<?php namespace SurveyGizmo;
class SurveyGizmoAPI{

	/***PROPERTIES***/
	static $AuthToken;
	static $AuthSecret;
	static $config;
	/***FUNCTIONS***/

	public static function auth($token,$secret){
		//TODO: test auth & return exception if not valid
		//set property for token & secret
		self::$AuthToken = $token;
		self::$AuthSecret =  $secret;
	}

	public static function getAuth(){
		return array("AuthToken"=>self::$AuthToken,"AuthSecret"=>self::$AuthSecret);
	}


}

?>