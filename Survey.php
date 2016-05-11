<?php namespace SurveyGizmo;
use SurveyGizmo\BaseObject;
use SurveyGizmo\iBaseInterface;
class Survey extends BaseObject{
//class Survey{
	/***PROPERTIES***/
	// public Pages;
	// public Questions;
	// public Responses;
	// public Reports;

	// public id;
	// public title;

	/***FUNCTIONS***/
	function __construct(){
		echo('surveys');
		//parent::__construct();
	}

	public function save(){

	}
	public function get(){

	}
	public function delete(){

	}

	public function fetch($filter){
		$request = new Request();
		
	}
}
?>