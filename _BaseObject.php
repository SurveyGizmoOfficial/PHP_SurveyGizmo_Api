<?php namespace SurveyGizmo;
class BaseObject{

	public static $obj;

	public static function fetch($filter){}
	public static function save(){}
	public static function get(){}
	public static function delete(){}

	public static function set(){}
	public static function get(){}

	public static function makeRequest($path, $filter){
		$request = new Request();
		$request->path = $path;
		$request->filter = $filter;
		$response = $request->makeRequest();
		if(isset($response)){
			self::$obj = $response->data;
			return $response;
		}
	}
}
?>