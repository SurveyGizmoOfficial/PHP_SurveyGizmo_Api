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
//set token & secret
$api_key = "";
$api_secret = "";

//authenticate
testLog("Authenticating");

try {
	\SurveyGizmo\SurveyGizmoAPI::auth($api_key, $api_secret);
} catch (\SurveyGizmo\Helpers\SurveyGizmoException $e) {
	testLog("Error Authenticating", $e);
	die;
}

\SurveyGizmo\ApiRequest::setRepeatRateLimitedRequest(10);

// $filter = new \SurveyGizmo\Helpers\Filter();
// $fiterItem = new \SurveyGizmo\Helpers\FilterItem('field','=','x');
// $filter->add($filterItem);

// testLog("Getting surveys with paging");
// testVardump(\SurveyGizmo\Survey::fetch(null, array(
//     'page' => 3,
//     'limit' => 100
// )));

testLog("Getting Surveys");
$filter = new \SurveyGizmo\Helpers\Filter();
$filter_item = new \SurveyGizmo\Helpers\FilterItem();
$filter_item->setField('title');
$filter_item->setOperator('=');
$filter_item->setCondition('TEST from API');
$filter->addFilterItem($filter_item);
testLog("Getting Surveys 2");
$surveys = \SurveyGizmo\Resources\Survey::fetch($filter);

// testLog("got Surveys",$surveys);

$survey = current($surveys->data);

$sid = $survey->id;
testLog("Updating Survey " . $sid);
$survey->title = "TEST from API";
$survey->save();

testLog("Getting Survey " . $sid);
$survey = \SurveyGizmo\Resources\Survey::get($sid);
// testLog("got Survey",$survey);

$campaigns = $survey->getCampaigns();
$campaign_id = current($campaigns->data)->id;

$campaign = $survey->getCampaign($campaign_id);
testLog("got Campaign", $campaign);

$emails = $campaign->getEmailMessages();
$email_id = current($emails->data)->id;

$email = $campaign->getEmailMessage($email_id);
testLog("got Email Message", $email);

$questions = $survey->getQuestions();
$question_id = current($questions->data)->id;

$question = $survey->getQuestion($question_id);
$question->title->English = "API TEST";
$ret = $question->save();
testLog('Updated Question ' . $question_id, $ret);

$stats = $survey->getStatistics();
// testLog("Statistics!", $stats);

$response = new \SurveyGizmo\Resources\Survey\Response();
$response->survey_id = $survey->id;
$response->status = 'Partial';
$response->survey_data = array(
	2 => array(
		'options' => array(
			10001 => array('answer' => 'foo'),
			10002 => array('answer' => 'bar'),
		),
	),
);
$response->save();

testLog("Getting Responses for survey " . $sid);
$responses = $survey->getResponses();

$response_id = current($responses->data)->id;

$response = $survey->getResponse($response_id);
// testLog("got Response ", $response);
$response->survey_data[2]['answer'] = 'BOB';
$response->status = 'Complete';
$ret = $response->save();
// testLog("saved Response ", $ret);

// testLog("Getting Reports for survey " . $survey->id);
//$reports = $survey->getReports();
// testLog("got Reports ",$reports);
// if (count($reports->data) > 1) {
// 	$report = new \SurveyGizmo\Resources\Survey\Report();
// 	$report->survey_id = $survey->id;
// 	$report->type = 'standard';
// 	$report->save();

// 	sleep(60);
// 	$reports = $survey->getReports();
// }

// $report_id = current($reports->data)->id;

// testLog("Getting one report for survey " . $survey->id);
// $report = \SurveyGizmo\Resources\Survey\Report::get($survey->id, $report_id);
// testLog("got report",$report);

testLog("Updating Survey Page 1 title for survey " . $survey->id);
$page = current($survey->pages);
$page->title = "API PAGE TITLE";
$page->save();

testLog("Creating a new survey");
$survey = new \SurveyGizmo\Resources\Survey();
$survey->title = "NEW FROM API";
$results = $survey->save();
testLog("Survey created", $results->data);

testLog("Deleting our new survey " . $survey->id);
$results = $survey->delete();
testVardump($results);

testLog("Getting account");
$account = \SurveyGizmo\Resources\Account::get();
testVardump($account);

// testLog("Getting account users");
// $response = \SurveyGizmo\Resources\User::fetch();
// testVardump($response);

// testLog("Getting one user");
// $user = \SurveyGizmo\Resources\User::get(123);
// testVardump($user);

// $user = new \SurveyGizmo\Resources\User();
// $user->email = 'test@email.com';
// $user->password = '123qwe';
// $user->username = 'Username';
// $user->team = 123;
// var_dump($user->save());

// testLog("Getting teams");
// $team = \SurveyGizmo\Resources\Team::get(123);
// testVardump(\SurveyGizmo\Resources\Team::fetch());
// testVardump($team);
// $team->delete();

// $team = new \SurveyGizmo\Resources\Team();
// $team = \SurveyGizmo\Resources\Team::get(235681);
// $team->teamname = 'Team Awesome';
// $team->description = 'Team Awesome is awesome too';
// testVardump($team);
// $team->save();
