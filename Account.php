<?php namespace SurveyGizmo;
use SurveyGizmo\ApiResource;
use SurveyGizmo\iBaseInterface;
class Account extends ApiResource implements iBaseInterface{

	static $path = "/account";

	public function save(){
		return parent::_save();
	}
	public static function get($id){
		$id = null;//don't let them pass in id
		return parent::_get(get_class($this));
	}
	public function delete(){
		throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
	}

	public static function fetch($filter){
		throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
	}

	public static function getPath($append = ""){
		return parent::_getPath(self::$path,$append);
	}

}
?>