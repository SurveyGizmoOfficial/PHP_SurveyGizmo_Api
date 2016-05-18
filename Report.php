<?php 
namespace SurveyGizmo;

use SurveyGizmo\ApiResource;
use SurveyGizmo\iBaseInterface;

class Report extends ApiResource implements iBaseInterface
{

	static $path = "/survey/{survey_id}/surveyreport";

	public function save()
	{
		return parent::_save();
	}
	public static function get($id)
	{
		return parent::_get(__CLASS__, $id);
	}
	public function delete()
	{
		return parent::_delete();
	}

	public static function fetch($filters = null, $options = null)
	{
		return parent::_fetch(__CLASS__, $filter);
	}

	public static function getPath($append = "")
	{
		return parent::_getPath(self::$path, $append);
	}
}
