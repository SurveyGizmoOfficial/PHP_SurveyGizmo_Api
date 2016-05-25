<?php
namespace SurveyGizmo;
use SurveyGizmo\ApiResource;

/**
 * Class for Account API object
 */
class Account extends ApiResource 
{
	/**
	 * API call path 
	 */
	static $path = "/account";

	/**
	 * Singleton instance
	 * @var SurveyGizmo\Account
	 */
	static $_instance;

	/**
	 * Saves the account singleton instance.
	 * @access public
	 * @return SurveyGizmo\APIResponse Object with SurveyGizmo\Page Object
	 */
	public function save()
	{
		return self::_save();
	}

	/**
	 * Returns the instance of the account (a singleton)
	 * @access public
	 * @static
	 * @return SurveyGizmo\Account Object
	 */
	public static function get()
	{
		if (!self::$_instance) {
			self::$_instance = self::_get();
		}
		return self::$_instance;
	}

}
