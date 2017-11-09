<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 1);

function testLog($message, $dump = null)
{
	echo "<h3>" . $message . "</h3>";

	if ($dump) {
		testVardump($dump);
	}
}

function testVardump($dump)
{
	echo "<pre>";
	var_dump($dump);
	echo "</pre>";
}

testLog("TESTING Library");
//Require autoloader
require_once "../SurveyGizmoAutoLoader.php";

//set token & secret (From .credentials file, copy .credentials.example to .credentials and supply your API authentication credentials accordingly)
$credentials = parse_ini_file('.credentials');

//authenticate
testLog("Authenticating");

try {
	\SurveyGizmo\SurveyGizmoAPI::auth($credentials['SG_API_KEY'], $credentials['SG_API_SECRET']);
} catch (\SurveyGizmo\Helpers\SurveyGizmoException $e) {
	testLog("Error Authenticating", $e);
	die;
}

\SurveyGizmo\ApiRequest::setRepeatRateLimitedRequest(10);

$survey = new \SurveyGizmo\Resources\Survey();
// See: https://apihelp.surveygizmo.com/help/survey-object-v5
$survey->title = 'TEST from API';
$survey_save_result = $survey->save();

if ( ! $survey_save_result->result_ok) {
	die($survey_save_result->message);
}

// Newly created surveys contain one page
$page = \SurveyGizmo\Resources\Survey\Page::get($survey->id, reset($survey->pages)->id);
// See: https://apihelp.surveygizmo.com/help/surveypage-sub-object-v5
$page->title->English = 'Example Page';
$page_save_result = $page->save();

if ( ! $page_save_result->result_ok) {
	die($page_save_result->message);
}

$question = new \SurveyGizmo\Resources\Survey\Question();
// See: https://apihelp.surveygizmo.com/help/surveyquestion-sub-object-v5
$question->survey_id = $survey->id;
$question->surveypage = $page->id;
$question->type = "checkbox";
$question->title = (object) array('English' => 'Example Question');
$question->description = (object) array('English' => 'Lorem ipsum dolor sit amet, eu ferri detraxit vis. Et putent docendi assentior nam. Nec quem elaboraret in.');
$question_save_result = $question->save();

if ( ! $question_save_result->result_ok) {
	die($question_save_result->message);
}

$option_ids = array();
$option_save_results = array();

$options = array(
	'foo' => 'Option A',
	'bar' => 'Option B',
	'zoo' => 'Option C',
	'tar' => 'Option D',
);

foreach ($options as $option_value => $option_display) {
	$option = new \SurveyGizmo\Resources\Survey\QuestionOption();
	// See: https://apihelp.surveygizmo.com/help/surveyoption-sub-object-v5
	$option->title = (object) array('English' => $option_display);
	$option->value = $option_value;
	$option->survey_id = $survey->id;
	$option->question_id = $question->id;
	$option_save_result = $option->save();

	if ( ! $option_save_result->result_ok) {
		die($option_save_result->message);
	}

	$option_save_results[] = $option_save_result;
}

die("Your new survey can be taken here: <a href=\"" . htmlentities($survey->links->default) . "\">" . $survey->links->default . "</a>");
