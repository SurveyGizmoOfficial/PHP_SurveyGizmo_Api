<?php
namespace SurveyGizmo\Resources\Survey;

use SurveyGizmo\ApiResource;
use SurveyGizmo\Helpers\SurveyGizmoException;

/**
 * Class for Survey Page API objects
 * Page is a sub-object of Surveys
 */
class Page extends ApiResource {

	/**
	 * API call path
	 */
	static $path = "/survey/{survey_id}/surveypage/{id}";

	/**
	 * Fetch list of SurveyGizmo Page Objects
	 * @access public
	 * @param int $survey_id - Survey ID
	 * @param SurveyGizmo\Filter $filter - filter object
	 * @param Array $options
	 * @return SurveyGizmo\ApiResponse Object with SurveyGizmo\Page Objects
	 */
	public static function fetch($survey_id = null, $filter = null, $options = null) {
		if ($survey_id < 1) {
			throw new SurveyGizmoException("Missing survey ID", 500);
		}
		$response = self::_fetch(array('id' => '', 'survey_id' => $survey_id), $filter, $options);
		return $response;
	}

	/**
	 * Get Page Obj by survey id and page id
	 * @access public
	 * @param int $survey_id - survey id
	 * @param int $id - page id
	 * @return SurveyGizmo\Page Object
	 */
	public static function get($survey_id = null, $id = null){
		if ($id < 1 && $survey_id < 1) {
			throw new SurveyGizmoException("IDs required", 500);
		}
		return self::_get(array(
			'survey_id' => $survey_id,
			'id' => $id,
		));
	}

	/**
	 * Save current Page Obj
	 * @access public
	 * @return SurveyGizmo\ApiResponse Object with SurveyGizmo\Page Object
	 */
	public function save(){
		return $this->_save(array(
			'survey_id' => $this->survey_id,
			'id' => $this->exists() ? $this->id : ''
		));
	}

	/**
	 * Delete current Page Obj
	 * @access public
	 * @return SurveyGizmo\ApiResponse Object
	 */
	public function delete(){
		return self::_delete(array(
			'id' => $this->id,
		));
	}

	/**
	 * Get current Pages Question Obj by id
	 * @access public
	 * @param Int $id question ID
	 * @return SurveyGizmo\Resource\Question Object
	 */
	public function getQuestion($id){
		foreach ($this->questions as $key => $question) {
			if($question->id == $id){
				return $question;
			}
		}
	}
}
?>