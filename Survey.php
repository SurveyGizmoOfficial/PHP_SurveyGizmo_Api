<?php
namespace SurveyGizmo;
use SurveyGizmo\ApiResource;

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
		if ($name == 'pages') {
			$this->formatPages();
		}
	}

	/**
	 * Fetch list of SurveyGizmo Survey Objects
	 * @access public
	 * @param SurveyGizmo\Filter $filters - filter object
	 * @param Array $options
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Survey Objects
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
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Survey Object
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
	 * @return SurveyGizmo\APIResponse
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
	 * Return page array from current Survey by page sku
	 * @access public
	 * @param Int $sku - page sku
	 * @return SurveyGizmo\Page Object
	 */
	public function getPage($sku)
	{
		foreach ($this->pages as $page) {
			if ($page->id == $sku) {
				return $page;
			}
		}
		return false;
	}

	/*QUESTIONS*/
	/**
	 * Return questions from current Survey object
	 * @access public
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Question Objects
	 */
	public function getQuestions()
	{
		return $this->getSubObjects("SurveyGizmo\\Question");
	}
	
	/**
	 * Return question from current Survey by question sku
	 * @access public
	 * @param Int $id - question id
	 * @return SurveyGizmo\Question Object
	 */
	public function getQuestion($id)
	{
		return $this->getSubObject("SurveyGizmo\\Question", $id);
	}

	/*RESPONSES*/
	/**
	 * Return responses from current Survey object
	 * @access public
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Response Objects
	 */
	public function getResponses($filter = null)
	{
		return $this->getSubObjects("SurveyGizmo\\Response");
	}

	/**
	 * Return question from current Survey by question sku
	 * @access public
	 * @param Int $id - response id
	 * @return SurveyGizmo\Question Object
	 */
	public function getResponse($id)
	{
		return $this->getSubObject("SurveyGizmo\\Response", $id);
	}

	/*REPORTS*/
	/**
	 * Return Reports array from current Survey object
	 * @access public
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Reports Objects
	 */
	public function getReports($filter = null)
	{
		return $this->getSubObjects("SurveyGizmo\\Report");
	}

	/**
	 * Return report from current Survey by report id
	 * @access public
	 * @param Int $id - report id
	 * @return SurveyGizmo\Report Object
	 */
	public function getReport($id)
	{

	}

	/**
	 * Return pages array from current Survey object
	 * @access public
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Page Objects
	 */
	public function getStatistics()
	{
		return $this->getSubObjects("SurveyGizmo\\Statistics");
	}

	/*CAMPAIGNS*/
	/**
	 * Return pages array from current Survey object
	 * @access public
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Page Objects
	 */
	public function getCampaigns($filter = null)
	{
		return $this->getSubObjects("SurveyGizmo\\Campaign");
	}

	/**
	 * Return campaign from current Survey by campaign id
	 * @access public
	 * @param Int $id - campaign id
	 * @return SurveyGizmo\Campaign Object
	 */
	public function getCampaign($id)
	{
		return $this->getSubObject("SurveyGizmo\\Campaign", $id);
	}

	/*HELPERS*/
	/**
	 * Helper function to get Survey sub objects
	 * @access private
	 * @param String $type - class name of object requested
	 * @param SurveyGizmo\Filter $filter - filter object
	 * @param Array $options
	 * @return SurveyGizmo\APIResponse Object with SurveyGizmo\{$type} Object
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
		$page = parent::_formatObject("SurveyGizmo\\Page", $page_obj);
		$page->questions = self::formatQuestions($page);
		return $page;
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
			$question = parent::_formatObject("SurveyGizmo\\Question", $obj);
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
			$option = parent::_formatObject("SurveyGizmo\\QuestionOption", $obj);
			//format options
			$return[] = $option;
		}
		return $return;
	}

}
