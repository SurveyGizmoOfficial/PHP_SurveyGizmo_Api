<?php
function testLog($message, $dump = null){
	echo "<h1>". $message . "</h1>";
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
require "../SurveyGizmoAutoLoader.php";
//set token & secret
$token = "e87c03fc320ab9fd509a9d32505491262d133987bdfa64af53";
$secret = "A9SByZ3cS%2FqpE";
//authetnicate
testLog("Authenticating");

$sg = SurveyGizmo\SurveyGizmoAPI::auth($token,$secret);

if($sg != true){
	testLog("Error Authenticating",$sg);
}
//$sg->auth($token);
// $filter = new SurveyGizmo\Filter();
// $fiterItem = new SurveyGizmo\FilterItem('field','=','x');
// $filter->add($filterItem);
testLog("Getting Surveys");

$surveys = SurveyGizmo\Survey::fetch();

testLog("got Surveys",$surveys);

$survey = $surveys->data[0];
$sid = $survey->id;
testLog("Updating Survey " . $sid);
$survey->title = "TEST from API";
$survey->save();

// testLog("Updating Survey Page 1 title for survey " . $sid);
// $page = $survey->pages[0];
// $page->title = "API PAGE TITLE";
//$page->save();

testLog("Getting Survey " . $sid);
$survey = SurveyGizmo\Survey::get($sid);
testLog("got Survey",$survey);

testLog("Getting Responses for survey " . $sid);
$responses = $survey->getResponses();
testLog("got Responses ",$responses->data[0]);


testLog("Getting Reports for survey " . $sid);
$reports = $survey->getReports();
testLog("got Reports ",$reports->data[0]);


testLog("Creating a new survey");
$survey = new SurveyGizmo\Survey();
$survey->title = "NEW FROM API";
$results = $survey->save();
testLog("Survey created",$results->data);

testLog("Deleting our new survey " . $survey->id);
$results = $survey->delete();
testDump($results);
?>