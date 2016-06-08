<?php
namespace SurveyGizmo\Resources;

use SurveyGizmo\ApiResource;
use SurveyGizmo\Helpers\SurveyGizmoException;

/**
 * Class for Survey API objects - the blood and soul of SurveyGizmo!
 */
class Survey extends ApiResource 
{

	/**
	 * API call path 
	 */
	static $path = "/survey/{id}";

	/**
	 * set magic function to keep pages formatted the way we want
	 * @access public
	 * @param String $name - property name
	 * @param Mixed $value - property value
	 */
	public function __set($name, $value)
	{
		$this->{$name} = $value;
		if ($name == 'team') {
			$this->formatTeams();
		}
		if ($name == 'pages') {
			$this->formatPages();
		}
	}

	/**
	 * Fetch list of SurveyGizmo Survey Objects
	 * @access public
	 * @param SurveyGizmo\Filter $filters - filter object
	 * @param Array $options
	 * @return SurveyGizmo\ApiResponse with SurveyGizmo\Survey Objects
	 */
	public static function fetch($filter = null, $options = null)
	{
		return self::_fetch(array('id' => ''), $filter, $options);
	}
	
	/**
	 * Get Survey object by survey id
	 * @access public
	 * @param int $id - survey id
	 * @return SurveyGizmo\Survey Object
	 */
	public static function get($id)
	{
		if ($id < 1) {
			throw new SurveyGizmoException(500, "ID required");
		}
		return self::_get(array(
			'id' => $id
		));
	}

	/**
	 * Saves current Survey Object
 	 * @access public
	 * @return SurveyGizmo\ApiResponse with SurveyGizmo\Survey Object
	 */
	public function save()
	{
		$this->type = empty($this->type) ? "survey" : $this->type;
		return $this->_save(array(
			'id' => $this->id
		));
	}

	/**
	 * Delete current Survey Object
	 * @access public
	 * @return SurveyGizmo\ApiResponse
	 */
	public function delete()
	{
		return self::_delete(array(
			'id' => $this->id
		));
	}

	/*PAGES*/
	/**
	 * Return pages array from current Survey object
	 * @access public
	 * @return Array of SurveyGizmo\Page Objects
	 */
	public function getPages()
	{
		return $this->pages;
	}

	/**
	 * Return page array from current Survey by page id
	 * @access public
	 * @param Int $id - page id
	 * @return SurveyGizmo\Page Object
	 */
	public function getPage($id)
	{
		foreach ($this->pages as $page) {
			if ($page->id == $id) {
				return $page;
			}
		}
		return false;
	}

	/*QUESTIONS*/
	/**
	 * Return questions from current Survey object
	 * @access public
	 * @return SurveyGizmo\ApiResponse with SurveyGizmo\Question Objects
	 */
	public function getQuestions()
	{
		return $this->getSubObjects("SurveyGizmo\\Resources\\Survey\\Question");
	}
	
	/**
	 * Return question from current Survey by question id
	 * @access public
	 * @param Int $id - question id
	 * @return SurveyGizmo\Question Object
	 */
	public function getQuestion($id)
	{
		return $this->getSubObject("SurveyGizmo\\Resources\\Survey\\Question", $id);
	}

	/*RESPONSES*/
	/**
	 * Return responses from current Survey object
	 * @access public
	 * @return SurveyGizmo\ApiResponse with SurveyGizmo\Response Objects
	 */
	public function getResponses($filter = null)
	{
		return $this->getSubObjects("SurveyGizmo\\Resources\\Survey\\Response");
	}

	/**
	 * Return question from current Survey by question id
	 * @access public
	 * @param Int $id - response id
	 * @return SurveyGizmo\Question Object
	 */
	public function getResponse($id)
	{
		return $this->getSubObject("SurveyGizmo\\Resources\\Survey\\Response", $id);
	}

	/*REPORTS*/
	/**
	 * Return Reports array from current Survey object
	 * @access public
	 * @return SurveyGizmo\ApiResponse with SurveyGizmo\Reports Objects
	 */
	public function getReports($filter = null)
	{
		return $this->getSubObjects("SurveyGizmo\\Resources\\Survey\\Report");
	}

	/**
	 * Return report from current Survey by report id
	 * @access public
	 * @param Int $id - report id
	 * @return SurveyGizmo\Report Object
	 */
	public function getReport($id)
	{
		return $this->getSubObject("SurveyGizmo\\Resources\\Survey\\Report", $id);
	}

	/**
	 * Return statistics array from current Survey object
	 * @access public
	 * @return SurveyGizmo\ApiResponse with SurveyGizmo\Resources\Survey\Statistics Objects
	 */
	public function getStatistics()
	{
		return $this->getSubObjects("SurveyGizmo\\Resources\\Survey\\Statistics");
	}

	/**
	 * Return stats object from current Survey object by question id
	 * @access public
	 * @return SurveyGizmo\Resources\Survey\Statistics Object
	 */
	public function getStatisticsByID($question_id)
	{
		$stats = $this->getSubObjects("SurveyGizmo\\Resources\\Survey\\Statistics");
		foreach ($stats->data as $key => $question_stats) {
			if($question_stats->id == $question_id){
				return $question_stats;
			}
		}
	}

	/*CAMPAIGNS*/
	/**
	 * Return pages array from current Survey object
	 * @access public
	 * @return SurveyGizmo\ApiResponse with SurveyGizmo\Page Objects
	 */
	public function getCampaigns($filter = null)
	{
		return $this->getSubObjects("SurveyGizmo\\Resources\\Survey\\Campaign");
	}

	/**
	 * Return campaign from current Survey by campaign id
	 * @access public
	 * @param Int $id - campaign id
	 * @return SurveyGizmo\Campaign Object
	 */
	public function getCampaign($id)
	{
		return $this->getSubObject("SurveyGizmo\\Resources\\Survey\\Campaign", $id);
	}

	/*HELPERS*/
	/**
	 * Helper function to get Survey sub objects
	 * @access private
	 * @param String $type - class name of object requested
	 * @param SurveyGizmo\Filter $filter - filter object
	 * @param Array $options
	 * @return SurveyGizmo\ApiResponse Object with SurveyGizmo\{$type} Object
	 */
	private function getSubObjects($type, $filter = null, $options = null)
	{
		$options = array("survey_id" => $this->id);
		return $type::fetch($this->id, $filter, $options);
	}

	/**
	 * Helper function to get a single Survey sub object
	 * @access private
	 * @param String $type - class name of object requested
	 * @param Int $id - sub object id
	 * @return SurveyGizmo\{$type} Object
	 */
	private function getSubObject($type, $id)
	{
		return $type::get($this->id, $id);
	}

	/*FORMATERS*/
	/**
	 * Format teams! We want to keep things useable and organized, 
	 * hence the custom formatter for teams
	 * Loops through teams, formats the team
	 * @access private
	 * @return void
	 */
	private function formatTeams()
	{
		$return = array();
		$teams = $this->team;
		foreach ($teams as $obj) {
			$team = $this->formatTeam($obj);
			$return[] = $team;
		}
		$this->team = $return;
	}

	/**
	 * Format pages! We want to keep things useable and organized, 
	 * hence the custom formatter for pages
	 * Loops through pages, formats the page, and each page formats its questions. 
	 * @access private
	 * @return void
	 */
	private function formatPages()
	{
		$return = array();
		$pages = $this->pages;
		foreach ($pages as $obj) {
			$page = self::formatPage($obj);
			$return[] = $page;
		}
		$this->pages = $return;
	}

	/**
	 * Format pages and its questions
	 * @access private
	 * @param object $page_obj
	 * @return SurveyGizmo\Page formatted page
	 */
	private static function formatPage($page_obj)
	{
		$page = parent::_formatObject("SurveyGizmo\\Resources\\Survey\\Page", $page_obj);
		$page->questions = self::formatQuestions($page);
		return $page;
	}

		/**
	 * Format teams
	 * @access private
	 * @param object $team_info
	 * @return SurveyGizmo\Team formatted page
	 */
	private function formatTeam($team_info)
	{
		$team = Team::get($team_info->id);
		return $team;
	}

	/**
	 * Format individual questions
	 * @access private
	 * @param SurveyGizmo\Page $page
	 * @return SurveyGizmo\Question formatted question
	 */
	private static function formatQuestions($page)
	{
		$return = array();
		$raw_questions = $page->questions;
		foreach ($raw_questions as $obj) {
			$question = parent::_formatObject("SurveyGizmo\\Resources\\Survey\\Question", $obj);
			//format options
			$question->options = self::formatQuestionOptions($question);
			$return[] = $question;
		}
		return $return;
	}
	
	/**
	 * Format individual question options
	 * @access private
	 * @param SurveyGizmo\Question $question
	 * @return SurveyGizmo\Option formatted option
	 */
	private static function formatQuestionOptions($question)
	{
		$return = array();
		$raw_options = $question->options;
		foreach ($raw_options as $obj) {
			$option = parent::_formatObject("SurveyGizmo\\Resources\\Survey\\QuestionOption", $obj);
			//format options
			$return[] = $option;
		}
		return $return;
	}

}
