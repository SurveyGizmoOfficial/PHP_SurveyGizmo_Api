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

testLog("Getting account");
$account = SurveyGizmo\Resources\Account::get();
dump($account);

// --------------------------- Contact Lists ---------------------------
testLog("Getting contact lists");
$lists  = SurveyGizmo\Resources\ContactList::fetch();
dump($lists);

// testLog("Creating contact list");
// $account = new SurveyGizmo\Resources\ContactList();
// $account->list_name = 'Test from API';
// $result = $account->save();
// dump($account);
// dump($result);

testLog("Getting single list");
$list = SurveyGizmo\Resources\ContactList::get(31);
dump($list);

testLog("Getting list contacts");
dump($list->getContacts());

testLog("Getting one contact");
$contact = SurveyGizmo\Resources\ContactList\Contact::get(31, 100039746);
dump($contact);

testLog("Updating one contact");
$contact->first_name = 'works 2?';
dump($contact->save());

testLog("Creating contact");
$contact = new SurveyGizmo\Resources\ContactList\Contact();
$g = uniqid();
$contact->first_name = 'Garrett ' . $g;
$contact->email_address = 'garrett' . $g . '@sgizmo.com';
$contact->list_id = 31;
dump($contact->save());
dump($contact);

testLog("Deleting new contact");
dump($contact->delete());

return;
// --------------------------- Teams ---------------------------
testLog("Getting teams");
dump(SurveyGizmo\Resources\Team::fetch());
$team = SurveyGizmo\Resources\Team::get(235682);
// $team = new SurveyGizmo\Resources\Team();
// $team = SurveyGizmo\Resources\Team::get(235681);
// $team->team_name = 'Team Awesome NOW';
// $team->description = 'Team Awesome is awesome too - API';
dump($team);
// $result = $team->save();
// $result = $team->delete();
// dump($team);
// dump($result);

// --------------------------- Users ---------------------------
testLog("Getting users");
dump(SurveyGizmo\Resources\User::fetch());
$user = SurveyGizmo\Resources\User::get(141104);
// $user = new SurveyGizmo\Resources\User();
// $user->email = 'garrett+pleaseapiwork@sgizmo.com';
// $user->username = 'Honey Beam';
// $user->password = '123qwe';
dump($user);
// $result = $user->save();
// $result = $user->delete();
// dump($user);
// dump($result);
?>
