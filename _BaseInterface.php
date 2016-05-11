<?php namespace SurveyGizmo;
interface iBaseInterface{
	public static function fetch($filter);
	public static function save();
	public static function get();
	public static function delete();

}

?>