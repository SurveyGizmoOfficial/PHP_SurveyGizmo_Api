<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

$sg_autoload_mapping = array(
	"SurveyGizmo\SurveyGizmoAPI" => __DIR__ . "/SurveyGizmo.php",
	"SurveyGizmo\ApiResource" => __DIR__ . "/_ApiResource.php",
	"SurveyGizmo\iBaseInterface" => __DIR__ . "/_BaseInterface.php",
	"SurveyGizmo\Auth" => __DIR__ . "/Auth.php",
	"SurveyGizmo\Survey" => __DIR__ . "/Survey.php",
	"SurveyGizmo\Page" => __DIR__ . "/Page.php",
	"SurveyGizmo\Quesiton" => __DIR__ . "/Quesiton.php",
	"SurveyGizmo\Filter" => __DIR__ . "/Helpers/Filter.php",
	"SurveyGizmo\FilterItem" => __DIR__ . "/Helpers/FilterItem.php",
	"SurveyGizmo\Request" => __DIR__ . "/Helpers/Request.php",
	"SurveyGizmo\Response" => __DIR__ . "/Helpers/Response.php",
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