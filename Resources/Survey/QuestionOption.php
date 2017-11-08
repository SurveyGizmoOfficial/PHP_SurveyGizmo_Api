<?php
namespace SurveyGizmo\Resources\Survey;

use SurveyGizmo\ApiResource;
use SurveyGizmo\Helpers\SurveyGizmoException;

class QuestionOption extends ApiResource {

	static $path = "/survey/{survey_id}/surveyquestion/{question_id}/surveyoption/{id}";

	public function save(){
		return $this->_save(array(
			'survey_id' => $this->survey_id,
			'question_id' => $this->question_id,
			'id' => $this->exists() ? $this->id : ''
		));
	}

	public static function get($id = null){
		return parent::_get(get_class($this),$id);
	}

	public function delete(){
		return parent::_delete();
	}

	public static function fetch($filter = null, $options = null){
		return parent::_fetch(get_class($this), $filter, $options);
	}
}
?>