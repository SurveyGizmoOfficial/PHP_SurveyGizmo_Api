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

//authetnicate
testLog("Authenticating");

try {
    $sg = SurveyGizmo\SurveyGizmoAPI::auth($api_key, $api_secret);
} catch (Exception $e) {
    testLog("Error Authenticating", $e);
    die;
}

// $filter = new SurveyGizmo\Helpers\Filter();
// $fiterItem = new SurveyGizmo\Helpers\FilterItem('field','=','x');
// $filter->add($filterItem);

// testLog("Getting surveys with paging");
// testVardump(SurveyGizmo\Survey::fetch(null, array(
//     'page' => 3,
//     'limit' => 100
// )));

testLog("Getting Surveys");
$filter = new SurveyGizmo\Helpers\Filter();
$filter_item = new SurveyGizmo\Helpers\FilterItem();
$filter_item->setField('title');
$filter_item->setOperator('=');
$filter_item->setCondition('TEST from API');
$filter->addFilterItem($filter_item);
testLog("Getting Surveys 2");
$surveys = SurveyGizmo\Resources\Survey::fetch($filter);

// testLog("got Surveys",$surveys);

$survey = $surveys->data[0];
$sid = $survey->id;
testLog("Updating Survey " . $sid);
$survey->title = "TEST from API";
$survey->save();

$sid = 123;
testLog("Getting Survey " . $sid);
$survey = SurveyGizmo\Resources\Survey::get($sid);
// testLog("got Survey",$survey);
$campaign = $survey->getCampaign(123);

testLog("got Campaign", $campaign);
$email = $campaign->getEmailMessage(123);
testLog("got Email Message", $email);

$question = $survey->getQuestion(10);
$question->title->English = "API TEST";
$ret = $question->save();
testLog('Updated Question 10', $ret);

$stats = $survey->getStatistics();
// testLog("Statistics!", $stats);

testLog("Getting Responses for survey " . $sid);
// $responses = $survey->getResponses();
$response = $survey->getResponse(3118);
// testLog("got Response ", $response);
$response->survey_data[2]['answer'] = 'BOB';
$ret = $response->save();
// testLog("saved Response ", $ret);

testLog("Getting Reports for survey " . $sid);
$reports = $survey->getReports();
// testLog("got Reports ",$reports);

testLog("Getting one report for survey " . $sid);
$report = SurveyGizmo\Resources\Survey\Report::get($sid, 123);
// testLog("got report",$report);

testLog("Updating Survey Page 1 title for survey " . $sid);
$page = $survey->pages[0];
$page->title = "API PAGE TITLE";
$page->save();

testLog("Creating a new survey");
$survey = new SurveyGizmo\Resources\Survey();
$survey->title = "NEW FROM API";
$results = $survey->save();
testLog("Survey created", $results->data);

testLog("Deleting our new survey " . $survey->id);
$results = $survey->delete();
testVardump($results);

testLog("Getting account");
$account = SurveyGizmo\Resources\Account::get();
testVardump($account);

// testLog("Getting account users");
// $response = SurveyGizmo\Resources\User::fetch();
// testVardump($response);

// testLog("Getting one user");
// $user = SurveyGizmo\Resources\User::get(123);
// testVardump($user);

// $user = new SurveyGizmo\Resources\User();
// $user->email = 'test@email.com';
// $user->password = '123qwe';
// $user->username = 'Username';
// $user->team = 123;
// var_dump($user->save());

// testLog("Getting teams");
// $team = SurveyGizmo\Resources\Team::get(123);
// testVardump(SurveyGizmo\Resources\Team::fetch());
// testVardump($team);
// $team->delete();

// $team = new SurveyGizmo\Resources\Team();
// $team = SurveyGizmo\Resources\Team::get(235681);
// $team->teamname = 'Team Awesome';
// $team->description = 'Team Awesome is awesome too';
// testVardump($team);
// $team->save();
