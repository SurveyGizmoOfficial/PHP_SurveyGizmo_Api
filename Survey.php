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
	public function getPages()
	{
		return $this->pages;
	}

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
	public function getQuestions()
	{
		return $this->getSubObjects("SurveyGizmo\\Question");
	}

	public function getQuestion($id)
	{
		return $this->getSubObject("SurveyGizmo\\Question", $id);
	}
	/*RESPONSES*/
	public function getResponses($filter = null)
	{
		return $this->getSubObjects("SurveyGizmo\\Response");
	}

	public function getResponse($id)
	{
		return $this->getSubObject("SurveyGizmo\\Response", $id);
	}

	/*REPORTS*/
	public function getReports($filter = null)
	{
		return $this->getSubObjects("SurveyGizmo\\Report");
	}

	public function getReport($id)
	{

	}

	public function getStatistics()
	{
		return $this->getSubObjects("SurveyGizmo\\Statistics");
	}

	/*CAMPAIGNS*/
	public function getCampaigns($filter = null)
	{
		return $this->getSubObjects("SurveyGizmo\\Campaign");
	}

	public function getCampaign($id)
	{
		return $this->getSubObject("SurveyGizmo\\Campaign", $id);
	}

	/*HELPERS*/
	private function getSubObjects($type, $filter = null, $options = null)
	{
		$options = array("survey_id" => $this->id);
		return $type::fetch($this->id, $filter, $options);
	}

	/*HELPERS*/
	private function getSubObject($type, $id)
	{
		return $type::get($this->id, $id);
	}

	/*FORMATERS*/
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

	private static function formatPage($page_obj)
	{
		$page = parent::_formatObject("SurveyGizmo\\Page", $page_obj);
		$page->questions = self::formatQuestions($page);
		return $page;
	}

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
