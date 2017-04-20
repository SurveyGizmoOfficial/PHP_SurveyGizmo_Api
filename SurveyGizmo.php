<?php
namespace SurveyGizmo;

use SurveyGizmo\Helpers\SurveyGizmoException;
use SurveyGizmo\Resources\Account;

/**
 * Simple class to store auth credentials for SG API and authorize API use. 
 */
class SurveyGizmoAPI
{
	/**
	 * API AuthToken
	 */
	static $AuthToken;

	/**
	 * API AuthSecret
	 */
	static $AuthSecret;
	
	/**
	 * Authorizes API use for all calls and performes a test to verify creds are still good
	 * @access public
	 * @param string $api_key api key from SurveyGizmo
	 * @param string $api_secret api secret from SurveyGizmo
	 * @return void
	 */
	public static function auth($api_key, $api_secret)
	{
		self::$AuthToken = $api_key;
		self::$AuthSecret = $api_secret;
		
		return self::testCredentials();
	}

	/**
	 * Get authorization credentials for subsequent api calls
	 * @access public
	 * @return Array - AuthToken and AuthSecret
	 */
	public static function getAuth()
	{
		return array("AuthToken" => self::$AuthToken, "AuthSecret" => self::$AuthSecret);
	}

	/**
	 * Test call to verify AuthToken and AuthSecret
	 * @access private
	 * @return void
	 */
	private static function testCredentials()
	{
		if (!Account::get() || !Account::get()->exists()) {
			throw new SurveyGizmoException('', SurveyGizmoException::NOT_AUTHORIZED);
		}
	}

}
