<?php namespace SurveyGizmo;
class SurveyGizmoAPI{

	/***PROPERTIES***/
	private $AuthToken;
	private $AuthToken;
	public $Surveys;
	public $Users;
	public $Teams;
	//use \SurveyGizmo\Survey as Surveys

	/***FUNCTIONS***/
	function __construct($token,$secret){
		echo "sg";
		$this->auth($token,$secret)
		//$this->loadConfig();
		//init out objects
		$this->Surveys = new Survey();
	}

	public function Auth($token,$secret){
		//do test auth

		//set property for token & secret
		$this->AuthToken = $token;
		$this->AuthSecret =  $secret;
	}

	/***PRIVATE FUNCTIONS***/
	private function loadConfig(){
		//read json file, parse and set as properties on this class
	}


}

?>