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
    "SurveyGizmo\Resources\ContactList" => __DIR__ . "/Resources/ContactList.php",
    "SurveyGizmo\Resources\ContactListContact" => __DIR__ . "/Resources/ContactListContact.php",
    "SurveyGizmo\Resources\User" => __DIR__ . "/Resources/User.php",
    "SurveyGizmo\Resources\Team" => __DIR__ . "/Resources/Team.php",
    "SurveyGizmo\Resources\Survey" => __DIR__ . "/Resources/Survey.php",
    "SurveyGizmo\Resources\Survey\Page" => __DIR__ . "/Resources/Survey/Page.php",
    "SurveyGizmo\Resources\Survey\Question" => __DIR__ . "/Resources/Survey/Question.php",
    "SurveyGizmo\Resources\Survey\QuestionOption" => __DIR__ . "/Resources/Survey/QuestionOption.php",
    "SurveyGizmo\Resources\Survey\Statistics" => __DIR__ . "/Resources/Survey/Statistics.php",
    "SurveyGizmo\Resources\Survey\Response" => __DIR__ . "/Resources/Survey/Response.php",
    "SurveyGizmo\Resources\Survey\Campaign" => __DIR__ . "/Resources/Survey/Campaign.php",
    "SurveyGizmo\Resources\Survey\EmailMessage" => __DIR__ . "/Resources/Survey/EmailMessage.php",
    "SurveyGizmo\Resources\Survey\Report" => __DIR__ . "/Resources/Survey/Report.php",
);

spl_autoload_register(function ($class_name) {
    global $sg_autoload_mapping;
    if (isset($sg_autoload_mapping[$class_name])) {
        require $sg_autoload_mapping[$class_name];
    }
});
