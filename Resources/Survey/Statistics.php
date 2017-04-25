<?php
namespace SurveyGizmo\Resources\Survey;

use SurveyGizmo\ApiResource;
use SurveyGizmo\Helpers\SurveyGizmoException;

class Statistics extends ApiResource {

	static $path = "/survey/{survey_id}/surveystatistic";

	public function __set($name, $value)
	{
		if ($name == 'Breakdown') {
			$this->{$name} = json_decode(json_encode($value), 1);
		} else {
			$this->{$name} = $value;
		}
	}

	public static function fetch($survey_id = null){
		if($survey_id < 1){
			throw new SurveyGizmoException("Survey ID required", 500);
		}
		return self::_fetch(array(
			'survey_id' => $survey_id
		));
	}
}
?>
