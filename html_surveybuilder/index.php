<?php
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
$api_key = "c6712a67ee7663540626170e39792fbc8bc57263ab8c885fdc";
$api_secret = "A9KD2rvur1M/U";

// $api_key = "e87c03fc320ab9fd509a9d32505491262d133987bdfa64af53";
// $api_secret = "A9SByZ3cS%2FqpE";
//authetnicate
testLog("Authenticating");

$sg = SurveyGizmo\SurveyGizmoAPI::auth($api_key,$api_secret);
if($sg != true){
	testLog("Error Authenticating",$sg);
	die;
}
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

testLog("Getting Survey " . $sid);
$survey = SurveyGizmo\Survey::get($sid);
testLog("got Survey",$survey);

testLog("Getting Responses for survey " . $sid);
$responses = $survey->getResponses();
testLog("got Responses ",$responses->data[0]);

testLog("Getting Reports for survey " . $sid);
$reports = $survey->getReports();
testLog("got Reports ",$reports->data[0]);

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
?>