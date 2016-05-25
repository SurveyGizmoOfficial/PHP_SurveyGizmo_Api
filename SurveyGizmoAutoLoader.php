<?php
/**
 * SurveyGizmo api library autoloader
 */
$sg_autoload_mapping = array(
    "SurveyGizmo\SurveyGizmoAPI" => __DIR__ . "/SurveyGizmo.php",
    
    "SurveyGizmo\ApiResource" => __DIR__ . "/ApiResource.php",
    "SurveyGizmo\ApiRequest" => __DIR__ . "/ApiRequest.php",
    "SurveyGizmo\ApiResponse" => __DIR__ . "/ApiResponse.php",

    "SurveyGizmo\Helpers\Filter" => __DIR__ . "/Helpers/Filter.php",
    "SurveyGizmo\Helpers\FilterItem" => __DIR__ . "/Helpers/FilterItem.php",
    "SurveyGizmo\Helpers\SurveyGizmoException" => __DIR__ . "/Helpers/SurveyGizmoException.php",

    "SurveyGizmo\Resources\Account" => __DIR__ . "/Resources/Account.php",
    "SurveyGizmo\Resources\Survey" => __DIR__ . "/Resources/Survey.php",
    "SurveyGizmo\Resources\Page" => __DIR__ . "/Resources/Page.php",
    "SurveyGizmo\Resources\Question" => __DIR__ . "/Resources/Question.php",
    "SurveyGizmo\Resources\QuestionOption" => __DIR__ . "/Resources/QuestionOption.php",
    "SurveyGizmo\Resources\Statistics" => __DIR__ . "/Resources/Statistics.php",
    "SurveyGizmo\Resources\Response" => __DIR__ . "/Resources/Response.php",
    "SurveyGizmo\Resources\User" => __DIR__ . "/Resources/User.php",
    "SurveyGizmo\Resources\Team" => __DIR__ . "/Resources/Team.php",
    "SurveyGizmo\Resources\ContactList" => __DIR__ . "/Resources/ContactList.php",
    "SurveyGizmo\Resources\ContactListContact" => __DIR__ . "/Resources/ContactListContact.php",
    "SurveyGizmo\Resources\Campaign" => __DIR__ . "/Resources/Campaign.php",
    "SurveyGizmo\Resources\EmailMessage" => __DIR__ . "/Resources/EmailMessage.php",
    "SurveyGizmo\Resources\Report" => __DIR__ . "/Resources/Report.php",
);

spl_autoload_register(function ($class_name) {
    global $sg_autoload_mapping;
    if (isset($sg_autoload_mapping[$class_name])) {
        require $sg_autoload_mapping[$class_name];
    }
});
