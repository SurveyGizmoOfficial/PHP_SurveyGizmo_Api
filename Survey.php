<?php
namespace SurveyGizmo;

use SurveyGizmo\ApiResource;

class Survey extends ApiResource 
{

	static $path = "/survey/{id}";

	public function __set($name, $value)
	{
		$this->{$name} = $value;
		if ($name == 'pages') {
			$this->formatPages();
		}
	}

	public function save()
	{
		$this->type = empty($this->type) ? "survey" : $this->type;
		return $this->_save(array(
			'id' => $this->exists() ? $this->id : ''
		));
	}
	
	public static function get($id)
	{
		return self::_get(array(
			'id' => $id
		));
	}

	public function delete()
	{
		return self::_delete(array(
			'id' => $this->id
		));
	}

	public static function fetch($filter, $options)
	{
		return self::_fetch(array('id' => ''), $filter, $options);
	}

	// public static function getPath($append = "")
	// {
	// 	return parent::_getPath(self::$path, $append);
	// }

	/*HELPERS*/
	private function getSubObjects($type, $filter = null, $options = null)
	{
		$options = array("survey_id" => $this->id);
		return $type::fetch($this->id, $filter, $options);
	}

	/*HELPERS*/
	private function getSubObject($type, $id)
	{
		$options = array("survey_id" => $this->id);
		return $type::get($id, $options);
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
