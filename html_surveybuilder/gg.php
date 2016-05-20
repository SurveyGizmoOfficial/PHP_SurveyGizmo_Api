<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 1);
function testLog($message, $dump = null)
{
	echo "<h3>" . $message . "</h3>";
	if ($dump) {
		dump($dump);
	}
}
function dump($dump)
{
	echo "<pre>";
	var_dump($dump);
	echo "</pre>";
}
testLog("TESTING Library");
require_once "../SurveyGizmoAutoLoader.php";

// G's account
$api_key = "e87c03fc320ab9fd509a9d32505491262d133987bdfa64af53";
$api_secret = "A9SByZ3cS/qpE";

testLog("Authenticating");
try {
	$sg = SurveyGizmo\SurveyGizmoAPI::auth($api_key, $api_secret);
} catch (Exception $e) {
	testLog("Error Authenticating", $e);
	die;
}

// testLog("Getting account");
// $account = SurveyGizmo\Account::get();
// dump($account);

// testLog("Getting contact lists");
// $account = SurveyGizmo\ContactList::fetch();
// dump($account);

// testLog("Creating contact list");
// $account = new SurveyGizmo\ContactList();
// $account->list_name = 'Test from API';
// $result = $account->save();
// dump($account);
// dump($result);

// testLog("Getting single list");
// $account = SurveyGizmo\ContactList::get(31);
// dump($account);

// testLog("Getting first contact");
// $account = $account->contacts[0];

// testLog("Updating first contact");
// $account->semailaddress = 'garrett@sgizmo.com';
// $account->sfirstname = 'garrett2';
// $account->slastname = 'g-man';
// $result = $account->save();
// dump($account);
// dump($result);

// testLog("Creating contact");
// $account = new SurveyGizmo\Contact();
// $account->iGroupID = 31;
// $account->semailaddress = 'garrett+pleasework2@sgizmo.com';
// $account->sfirstname = 'garrett5';
// $account->slastname = 'g-man-2';
// $result = $account->save();
// dump($account);
// dump($result);

// --------------------------- Teams ---------------------------
// testLog("Getting teams");
// dump(SurveyGizmo\Team::fetch());
// $team = SurveyGizmo\Team::get(235682);
// $team = new SurveyGizmo\Team();
// $team = SurveyGizmo\Team::get(235681);
// $team->team_name = 'Team Awesome NOW';
// $team->description = 'Team Awesome is awesome too - API';
// dump($team);
// $result = $team->save();
// $result = $team->delete();
// dump($team);
// dump($result);

// --------------------------- Users ---------------------------
testLog("Getting users");
dump(SurveyGizmo\User::fetch());
// $user = SurveyGizmo\User::get(141104);
// $user = new SurveyGizmo\User();
// $user->email = 'garrett+pleaseapiwork@sgizmo.com';
// $user->username = 'Honey Beam';
// $user->password = '123qwe';
// dump($user);
// $result = $user->save();
// $result = $user->delete();
// dump($user);
// dump($result);
?>