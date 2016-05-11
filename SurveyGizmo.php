<?php namespace SurveyGizmo;
class SurveyGizmoAPI{

	/***PROPERTIES***/
	static $AuthToken;
	static $AuthSecret;
	static $config;
	// public $Surveys;
	// public $Users;
	// public $Teams;

	/***FUNCTIONS***/

	public static function auth($token,$secret){
		//do test auth
		//set property for token & secret
		self::$AuthToken = $token;
		self::$AuthSecret =  $secret;
	}

	public static function getAuth(){
		return array("AuthToken"=>self::$AuthToken,"AuthSecret"=>self::$AuthSecret);
	}
	//public static function getConfig(){
	// public static function getConfig(){
	// 	if(!isset(self::$config)){
	// 		self::$config = self::loadConfig();
	// 	}
	// 	return self::$config;
	// }

	// /***PRIVATE FUNCTIONS***/
	// private static function loadConfig(){
	// 	var_dump(file_get_contents(__DIR__ . "config.json"));
	// 	return json_decode(file_get_contents(__DIR__ . "config.json"));
	// }


}

?>