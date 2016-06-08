<?php
namespace SurveyGizmo\Resources\Survey;

use SurveyGizmo\ApiResource;
use SurveyGizmo\Helpers\SurveyGizmoException;

class QuestionOption extends ApiResource {

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
}
?>