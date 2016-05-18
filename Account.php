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
			self::$_instance = parent::_get(__CLASS__);
			// self::$_instance = self::_get();
		}
		return self::$_instance;
	}
	
	public function delete()
	{
		throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
	}

	public static function fetch()
	{
		throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
	}

	public static function getPath($append = "")
	{
		return parent::_getPath(self::$path, $append);
	}

}
