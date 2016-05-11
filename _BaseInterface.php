<?php namespace SurveyGizmo;
interface iBaseInterface{

	// public function __construct();
	public function fetch($filter);
	public function save();
	public function get();
	public function delete();

}

?>