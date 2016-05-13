<?php namespace SurveyGizmo;
class SurveyGizmoAPI{

	/***PROPERTIES***/
	static $AuthToken;
	static $AuthSecret;
	static $config;
	/***FUNCTIONS***/

	public static function auth($token,$secret){
		self::$AuthToken = $token;
		self::$AuthSecret =  $secret;
		//TODO: test auth & return exception if not valid
		$creds_ok = self::testCredentials();
		if($creds_ok->results == true){
			self::$AuthToken = null;
			self::$AuthSecret =  null;
		}
		return $creds_ok;
	}

	public static function getAuth(){
		return array("AuthToken"=>self::$AuthToken,"AuthSecret"=>self::$AuthSecret);
	}

	private static function testCredentials(){
		//check creds
		$account = Account::get();
		if($account && !empty($account->id) && (int)$account->id > 0){
			return true;
		}else{
			$response = new SurveyGizmoException(SurveyGizmoException::NOT_AUTHORIZED);
			return $response->getMessage();
		}
	}


}

?>