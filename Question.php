<?php namespace SurveyGizmo;
use SurveyGizmo\ApiResource;
use SurveyGizmo\iBaseInterface;
class Question extends ApiResource implements iBaseInterface{

	static $path = "/?";

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
		return parent::_fetch(get_class($this), $filter);
	}

	public static function getPath($append = ""){
		return parent::_getPath(self::$path,$append);
	}
}
?>