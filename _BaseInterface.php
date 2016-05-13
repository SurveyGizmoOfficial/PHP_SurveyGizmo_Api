<?php namespace SurveyGizmo;
interface iBaseInterface{
	public static function fetch($filter,$options);
	public function save();
	public static function get($id);
	public function delete();
}

?>