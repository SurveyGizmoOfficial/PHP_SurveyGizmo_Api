<?php
namespace SurveyGizmo;

class SurveyGizmoAPI
{
	/***PROPERTIES***/
	static $AuthToken;
	static $AuthSecret;
	static $config;
	/***FUNCTIONS***/

	public static function auth($api_key, $api_secret)
	{
		self::$AuthToken = $api_key;
		self::$AuthSecret = $api_secret;
		
		return self::testCredentials();
	}

	public static function getAuth()
	{
		return array("AuthToken" => self::$AuthToken, "AuthSecret" => self::$AuthSecret);
	}

	private static function testCredentials()
	{
		if (!Account::get()->exists()) {
			throw new SurveyGizmoException(SurveyGizmoException::NOT_AUTHORIZED);
		}
	}

}
