<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

$sg_autoload_mapping = array(
	"SurveyGizmo\SurveyGizmoAPI" => __DIR__ . "/SurveyGizmo.php",
	"SurveyGizmo\ApiResource" => __DIR__ . "/_ApiResource.php",
	"SurveyGizmo\iBaseInterface" => __DIR__ . "/_BaseInterface.php",
	"SurveyGizmo\Account" => __DIR__ . "/Account.php",
	"SurveyGizmo\Survey" => __DIR__ . "/Survey.php",
	"SurveyGizmo\Page" => __DIR__ . "/Page.php",
	"SurveyGizmo\Question" => __DIR__ . "/Question.php",
	"SurveyGizmo\QuestionOption" => __DIR__ . "/QuestionOption.php",
	"SurveyGizmo\Statistics" => __DIR__ . "/Statistics.php",
	"SurveyGizmo\Response" => __DIR__ . "/Response.php",
	"SurveyGizmo\User" => __DIR__ . "/User.php",
	"SurveyGizmo\Team" => __DIR__ . "/Team.php",
	"SurveyGizmo\ContactList" => __DIR__ . "/ContactList.php",
	"SurveyGizmo\ContactListContact" => __DIR__ . "/ContactListContact.php",
	"SurveyGizmo\Report" => __DIR__ . "/Report.php",
	"SurveyGizmo\Filter" => __DIR__ . "/Helpers/Filter.php",
	"SurveyGizmo\FilterItem" => __DIR__ . "/Helpers/FilterItem.php",
	"SurveyGizmo\Request" => __DIR__ . "/Helpers/Request.php",
	"SurveyGizmo\APIResponse" => __DIR__ . "/Helpers/APIResponse.php",
	"SurveyGizmo\SurveyGizmoException" => __DIR__ . "/Helpers/SurveyGizmoException.php"
);

spl_autoload_register(function ($class_name) {
	global $sg_autoload_mapping;
	//var_dump($class_name,$sg_autoload_mapping[$class_name]);
    if (isset($sg_autoload_mapping[$class_name])) {
        require $sg_autoload_mapping[$class_name];
    }
});

?>