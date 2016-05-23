<?php
namespace SurveyGizmo;

use SurveyGizmo\ApiResource;

class Report extends ApiResource
{

	static $path = "/survey/{survey_id}/surveyreport/{id}";

	public function save()
	{
		return $this->_save(array(
			'survey_id' => $this->survey_id,
			'id' => $this->id
		));
	}

	public static function get($survey_id, $id)
	{
		if ($survey_id < 1 || $id < 1) {
                        throw new SurveyGizmoException(500, "Missing survey ID and/or report ID");
                }
		return self::_get(array(
			'survey_id' => $survey_id,
			'id' => $id
		));
	}

	public function delete()
	{
		return self::_delete(array(
			'survey_id' => $this->survey_id,
			'id' => $this->id
		));
	}

	public static function fetch($survey_id, $filters = null, $options = null) {
		if ($survey_id < 1) {
			throw new SurveyGizmoException(500, "Missing survey ID");
		}
		$response = self::_fetch(array('id' => '', 'survey_id' => $survey_id), $filter, $options);
		return $response;
	}
}
