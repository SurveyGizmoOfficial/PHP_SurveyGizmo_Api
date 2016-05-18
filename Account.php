<?php
namespace SurveyGizmo;

use SurveyGizmo\ApiResource;

class Account extends ApiResource 
{
	static $path = "/account";

	// Account::get is a singleton
	static $_instance;

	public function save()
	{
		return parent::_save();
	}

	public static function get()
	{
		if (!self::$_instance) {
			self::$_instance = self::_get();
		}
		return self::$_instance;
	}

}
