<?php
namespace SurveyGizmo;
use SurveyGizmo\ApiResource;

class Page extends ApiResource {

	static $path = "/survey/{survey_id}/surveypage";

	public function save(){
		return parent::_save(array(
			'id' => $this->id,
		));
	}
	public static function get($id){
		if ($id < 1) {
			throw new SurveyGizmoException(500, "ID required");
		}
		return self::_get(array(
			'id' => $id,
		));
	}
	public function delete(){
		return self::_delete(array(
			'id' => $this->id,
		));
	}

	public static function fetch($filters=null, $options=null){
		if(!$options['survey_id']){
			return new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
		}
		return parent::_fetch(array('id' => ''),get_class($this),$filter);
	}

}
?>