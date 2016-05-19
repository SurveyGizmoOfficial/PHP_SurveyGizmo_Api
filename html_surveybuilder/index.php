<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 1);
function testLog($message, $dump = null){
	echo "<h3>". $message . "</h3>";
	if($dump){
		testDump($dump);
	}
}
function testDump($dump){
	echo "<pre>";
	var_dump($dump);
	echo "</pre>";
}
testLog("TESTING Library");
//Require autoloader
require_once "../SurveyGizmoAutoLoader.php";
//set token & secret
$api_key = "987d89c9904b1600b61f2c8b97dae737d1afdf643a2f91871d";
$api_secret = "A9Ns5Cac0G6Dk";

// G's account
// $api_key = "e87c03fc320ab9fd509a9d32505491262d133987bdfa64af53";
// $api_secret = "A9SByZ3cS/qpE";

//authetnicate
testLog("Authenticating");

try {
	$sg = SurveyGizmo\SurveyGizmoAPI::auth($api_key,$api_secret);
} catch (Exception $e) {
	testLog("Error Authenticating", $e);
	die;
}
// if($sg != true){
// 	testLog("Error Authenticating",$sg);
// 	die;
// }
// $filter = new SurveyGizmo\Filter();
// $fiterItem = new SurveyGizmo\FilterItem('field','=','x');
// $filter->add($filterItem);

// testLog("Getting surveys with paging");
// testDump(SurveyGizmo\Survey::fetch(null, array(
// 	'page' => 3,
// 	'limit' => 100
// )));

testLog("Getting Surveys");
$filter = new SurveyGizmo\Filter();
$filter_item = new SurveyGizmo\FilterItem();
$filter_item->setField('title');
$filter_item->setOperator('=');
$filter_item->setCondition('TEST from API');
$filter->addFilterItem($filter_item);
$surveys = SurveyGizmo\Survey::fetch($filter);

// testLog("got Surveys",$surveys);

$survey = $surveys->data[0];
$sid = $survey->id;
testLog("Updating Survey " . $sid);
$survey->title = "TEST from API";
$survey->save();

$sid = 1078944;
testLog("Getting Survey " . $sid);
$survey = SurveyGizmo\Survey::get($sid);
// testLog("got Survey",$survey);

testLog("Getting Responses for survey " . $sid);
// $responses = $survey->getResponses();
$response = $survey->getResponse(3118);
testLog("got Response ", $response);
$response->survey_data[2]['answer'] = 'BOB';
$ret = $response->save();
testLog("saved Response ", $ret);

testLog("Getting Reports for survey " . $sid);
$reports = $survey->getReports();
testLog("got Reports ",$reports);

testLog("Getting one report for survey " . $sid);
$report = SurveyGizmo\Report::get($sid, 450421);
testLog("got report",$report);

testLog("Updating Survey Page 1 title for survey " . $sid);
$page = $survey->pages[0];
$page->title = "API PAGE TITLE";
$page->save();

testLog("Creating a new survey");
$survey = new SurveyGizmo\Survey();
$survey->title = "NEW FROM API";
$results = $survey->save();
testLog("Survey created",$results->data);

testLog("Deleting our new survey " . $survey->id);
$results = $survey->delete();
testDump($results);

testLog("Getting account");
$account = SurveyGizmo\Account::get();
testDump($account);

// testLog("Getting account users");
// $response = SurveyGizmo\User::fetch();
// testDump($response);

// testLog("Getting one user");
// $user = SurveyGizmo\User::get(126904);
// testDump($user);

// $user = new SurveyGizmo\User();
// $user->email = 'garrett+apitest@sgizmo.com';
// $user->password = '123qwe';
// $user->username = 'Works?';
// $user->team = 223388;
// var_dump($user->save());

// testLog("Getting teams");
// $team = SurveyGizmo\Team::get(224885);
// testDump(SurveyGizmo\Team::fetch());
// testDump($team);
// $team->delete();
// $team = new SurveyGizmo\Team();
// $team = SurveyGizmo\Team::get(235681);
// $team->teamname = 'Team Awesome';
// $team->description = 'Team Awesome is awesome too';
// testDump($team);
// $team->save();
?>