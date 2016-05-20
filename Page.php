<?php
namespace SurveyGizmo;
use SurveyGizmo\ApiResource;

class Page extends ApiResource {

	static $path = "/survey/{survey_id}/surveypage";

	public function save(){
		return parent::_save();
	}
	public static function get($id){
		return parent::_get(get_class($this),$id);
	}
	public function delete(){
		return parent::_delete();
	}

	public static function fetch($filters=null, $options=null){
		if(!$options['survey_id']){
			return new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
		}
		self::setPath($options);
		return parent::_fetch(get_class($this),$filter);
	}

	private static function setPath($options){
		self::$path = parent::_mergePath(self::$path,$options);
		echo "setting path";
		var_dump(self::$path);
	}

}
?>