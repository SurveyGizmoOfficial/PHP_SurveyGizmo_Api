<?php namespace SurveyGizmo;
use SurveyGizmo\BaseObject;
use SurveyGizmo\iBaseInterface;
class Survey extends BaseObject implements iBaseInterface{
	

	public static function save(){

	}
	public static function get(){

	}
	public static function delete(){

	}

	public static function fetch($filter){
		parent::makeRequest("/survey",$filter);
	}
}
?>