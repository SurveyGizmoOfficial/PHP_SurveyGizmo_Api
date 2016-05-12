<?php namespace SurveyGizmo;
interface iBaseInterface{
	public static function fetch($filter);
	public function save();
	public static function get($id);
	public function delete();
}

?>