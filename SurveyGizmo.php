<?php
namespace SurveyGizmo;

use SurveyGizmo\Helpers\SurveyGizmoException;
use SurveyGizmo\Resources\Account;
use SurveyGizmo\ApiRequest;

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
	 * @param bool $bypass_test bypass testing credentials
	 * @return void
	 */
	public static function auth($api_key, $api_secret, $bypass_test = false)
	{
		self::$AuthToken = $api_key;
		self::$AuthSecret = $api_secret;

		if ( ! $bypass_test) {
			self::testCredentials();
		}
	}

	/**
	 * Changes hostname to point API calls to international data centers
	 * @access public
	 * @param string $region what region your account resides on (US/CA/EU)
	 * @return void
	 */
	public static function setRegion($region = 'US') {
		switch (strtoupper($region)) {
			case 'US':
				$region_base_url = 'restapi.surveygizmo.com/v5';
				break;
			case 'EU':
				$region_base_url = 'restapi.surveygizmo.eu/v5';
				break;
			case 'CA':
				$region_base_url = 'restapica.surveygizmo.com/v5';
				break;
			default:
				throw new SurveyGizmoException('Invalid region supplied: ' . $region, SurveyGizmoException::NOT_SUPPORTED);
		}

		ApiRequest::setBaseURI($region_base_url);
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
