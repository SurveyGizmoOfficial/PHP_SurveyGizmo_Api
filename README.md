# Official PHP library for SurveyGizmo API

## Summary


## Code Examples

###### Authenticating
```php
require_once "<LIBRARY_PATH>/SurveyGizmoAutoLoader.php";
//set your key & secret
$api_key = "<YOUR API_KEY>";
$api_secret = "<YOUR API_SECRET>";

try {
	$sg = SurveyGizmo\SurveyGizmoAPI::auth($api_key,$api_secret);
} catch (Exception $e) {
	die("Error Authenticating");
}
```
###### Filtering & Fetching Surveys
```php
$filter = new SurveyGizmo\Filter();
$filter_item = new SurveyGizmo\FilterItem();
$filter_item->setField('title');
$filter_item->setOperator('=');
$filter_item->setCondition('TEST from API');
$filter->addFilterItem($filter_item);

$surveys = SurveyGizmo\Survey::fetch($filter);
```

###### Updating a Survey
```php
$survey = $surveys->data[0];
$sid = $survey->id;
$survey->title = "TEST UPDATE FROM API LIBRARY";
$survey->save();
```

## Dependencies


## Installation


## API Reference
This Library uses the version 5 SurveyGizmo API.  [API Documentation](https://apihelp.surveygizmo.com).

## Tests


## Contributors


## License
