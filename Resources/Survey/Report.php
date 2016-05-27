<?php
namespace SurveyGizmo\Resources\Survey;

use SurveyGizmo\ApiResource;
use SurveyGizmo\Helpers\SurveyGizmoException;

/**
 * Class for Survey Report API objects
 * Report is a sub-object of Surveys
 */
class Report extends ApiResource
{

	/**
	 * API call path 
	 */
	static $path = "/survey/{survey_id}/surveyreport/{id}";

	/**
	 * Fetch list of SurveyGizmo Report Objects by survey id
	 * @access public
	 * @param int $survey_id - Survey ID
	 * @param SurveyGizmo\Filter $filters - filter object
	 * @param Array $options
	 * @return SurveyGizmo\ApiResponse Object with SurveyGizmo\Report Objects
	 */
	public static function fetch($survey_id, $filters = null, $options = null) {
		if ($survey_id < 1) {
			throw new SurveyGizmoException(500, "Missing survey ID");
		}
		$response = self::_fetch(array('id' => '', 'survey_id' => $survey_id), $filter, $options);
		return $response;
	}

	/**
	 * Get Report Obj by survey id and report id
	 * @access public
	 * @param int $survey_id - survey id
	 * @param int $id - question sku
	 * @return SurveyGizmo\Report Object
	 */
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

	/**
	 * Save current Report Obj
	 * @access public
	 * @return SurveyGizmo\ApiResponse Object with SurveyGizmo\Report Object
	 */
	public function save()
	{
		return $this->_save(array(
			'survey_id' => $this->survey_id,
			'id' => $this->id
		));
	}

	/**
	 * Delete current Report Obj
	 * @access public
	 * @return SurveyGizmo\ApiResponse Object
	 */
	public function delete()
	{
		return self::_delete(array(
			'survey_id' => $this->survey_id,
			'id' => $this->id
		));
	}
}
