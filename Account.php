<?php
namespace SurveyGizmo;

use SurveyGizmo\ApiResource;
use SurveyGizmo\iBaseInterface;

class Account extends ApiResource
{

	static $path = "/account";

	public function save()
	{
		return parent::_save();
	}

	public static function get($id)
	{
		return parent::_get(__CLASS__);
	}

	public static function getPath($append = "")
	{
		return parent::_getPath(self::$path, $append);
	}

}
