<?php namespace SurveyGizmo;
use SurveyGizmo\ApiResource;
use SurveyGizmo\iBaseInterface;
class Survey extends ApiResource implements iBaseInterface{

	static $path = "/survey";

	public function save(){
		$this->type = empty($this->type) ? "survey" : $this->type;
		return parent::_save();
	}
	public static function get($id){
		$survey = parent::_get(get_class($this), $id);
		$survey = self::formatPages($survey);
		return $survey;
	}
	public function delete(){
		return parent::_delete();	
	}

	public static function fetch($filter, $options){
		return parent::_fetch(get_class($this), $filter);
	}

	public static function getPath($append = ""){
		return parent::_getPath(self::$path,$append);
	}

	/*HELPERS*/
	private function getSubObjects($type){
		$options = array("survey_id" => $this->id);
		return $type::fetch($filter, $options);
	}

	/*PAGES*/
	public function getPages(){
		//return $this->pages;
	}
	public function getPage($sku){
		
	}

	/*RESPONSES*/
	public function getResponses($filter = null){
		return $this->getSubObjects("SurveyGizmo\\Response");
	}
	public function getResponse($id){

	}
	/*REPORTS*/
	public function getReports($filter = null){
		return $this->getSubObjects("SurveyGizmo\\Report");
	}
	public function getReport($id){

	}

	/*FORMATERS*/
	private static function formatPages($survey){
		$return = array();
		$pages = $survey->pages;
		foreach($pages as $obj){
			$page = self::formatPage($obj);
			$return[] = $page;
		}
		$survey->pages = $return;
		return $survey;
	}

	private static function formatPage($page_obj){
		$page = parent::_formatObject("SurveyGizmo\\Page",$page_obj);
		$page->questions = self::formatQuestions($page);
		return $page;
	}

	private static function formatQuestions($page){
		$return = array();
		$raw_questions = $page->questions;
		foreach($raw_questions as $obj){
			$question = parent::_formatObject("SurveyGizmo\\Question",$obj);
			//format options
			$question->options = self::formatQuestionOptions($question);
			$return[] = $question;
		}
		return $return;
	}
	private static function formatQuestionOptions($question){
		$return = array();
		$raw_options = $question->options;
		foreach($raw_options as $obj){
			$option = parent::_formatObject("SurveyGizmo\\QuestionOption",$obj);
			//format options
			$return[] = $option;
		}
		return $return;
	}

}
?>