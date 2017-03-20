<?php
namespace SurveyGizmo\Resources\Survey;

use SurveyGizmo\ApiResource;
use SurveyGizmo\Helpers\SurveyGizmoException;

/**
 * Class for Survey Question API objects
 * Question is a sub-object of Surveys
 */
class Question extends ApiResource {

	/**
	 * API call path
	 */
	static $path = "/survey/{survey_id}/surveyquestion/{id}";

	/**
	 * set magic function to keep sub_questions formatted the way we want
	 * @access public
	 * @param String $name - property name
	 * @param Mixed $value - property value
	 */
	public function __set($name, $value)
	{
		$this->{$name} = $value;
		if ($name == 'sub_questions') {
			$this->formatSubQuestions();
		}

	}

	/**
	 * Fetch list of SurveyGizmo Question Objects by survey id
	 * @access public
	 * @param int $survey_id - Survey ID
	 * @param SurveyGizmo\Filter $filters - filter object
	 * @param Array $options
	 * @return SurveyGizmo\ApiResponse Object with SurveyGizmo\Question Objects
	 */
	public static function fetch($survey_id = null, $filters = null, $options = null) {
		if ($survey_id < 1) {
			throw new SurveyGizmoException(500, "Missing survey ID");
		}
		$response = self::_fetch(array('id' => '', 'survey_id' => $survey_id), $filter, $options);
		return $response;
	}

	/**
	 * Get Question Obj by survey id and question id
	 * @access public
	 * @param int $survey_id - survey id
	 * @param int $id - question id
	 * @return SurveyGizmo\Question Object
	 */
	public static function get($survey_id = null, $id = null){
		if ($id < 1 && $survey_id < 1) {
			throw new SurveyGizmoException(500, "IDs required");
		}
		return self::_get(array(
			'survey_id' => $survey_id,
			'id' => $id,
		));
	}

	/**
	 * Save current Question Obj
	 * @access public
	 * @return SurveyGizmo\ApiResponse Object with SurveyGizmo\Question Object
	 */
	public function save(){
		return $this->_save(array(
			'survey_id' => $this->survey_id,
			'id' => $this->exists() ? $this->id : ''
		));
	}

	/**
	 * Delete current Question Obj
	 * @access public
	 * @return SurveyGizmo\ApiResponse Object
	 */
	public function delete(){
		return self::_delete(array(
			'survey_id' => $survey_id,
			'id' => $this->id,
		));
	}

	/**
	 * Get current Question Option Obj by id
	 * @access public
	 * @param Int $id option ID
	 * @return SurveyGizmo\Resource\QuestionOption Object
	 */
	public function getOption($id){
		foreach ($this->options as $key => $option) {
			if($option->id == $id){
				return $option;
			}
		}
	}

	/**
	 * Format sub questions
	 * @access private
	 * @return Array of SurveyGizmo\Question formatted sub questions
	 */
	private function formatSubQuestions(){
		$return_questions = array();
		foreach ($this->sub_questions as $key => $sub_question) {
			$new_question = parent::_formatObject("SurveyGizmo\\Resources\\Survey\\Question", $sub_question);
			$return_questions[$new_question->id] = $new_question;
		}
		$this->sub_questions = $return_questions;
	}
}
?>