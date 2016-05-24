# Official PHP library for SurveyGizmo API

## Summary
The library is intended to make integrating with SurveyGizmo easier and quicker than using the API directly.  The following objects are support via this library and are all namespaced under SurveyGizmo (eg; SurveyGizmo\Survey).

##### Supported Objects
- Survey
  - Responses
  - Questions
  - Pages 
  - Statistics
  - Reports
- Account
  - Users
  - Teams
- Contacts
- Contact Lists
	- Contacts


####All objects use the following standard functions:

```
<OBJECT>::fetch(<FILTERS>,<OPTIONS>);
```
> Returns an array of objects based on filter and paging options.

```
<OBJECT>::get($id);
```
> Returns a single object based on id

```
<OBJECT>->save();
```
> Saves a newly created or updated instance of an object

```
<OBJECT>->delete();
```
> Deletes an instance of an object


## Code Examples

#### Auto Loading & Authenticating
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
### Surveys

###### Fetching Surveys
See filter and paging below.
```php
$surveys = SurveyGizmo\Survey::fetch(<FILTER>,<OPTIONS>);
```

###### Getting a Single Survey
```php
$survey_id = <SURVEY_ID>;
$survey = SurveyGizmo\Survey::get(survey_id);
```

###### Updating a Survey
```php
$survey->title = "TEST UPDATE FROM API LIBRARY";
$survey->save();
```

###### Creating a Survey
```php
$survey = new SurveyGizmo\Survey();
$survey->title = "NEW SURVEY";
$results = $survey->save();
```

###### Deleting a Survey
```php
$survey = $survey->delete();
```
### Survey Helper Functions
The Survey object provides a few help functions to easily access related collections and objects.

```php
	//get questions
	$survey->getQuestions(<FILTER>,<PAGE>);
	$survey->getQuestion($sku);
	//get responses
	$survey->getResponses(<FILTER>,<PAGE>);
	$survey->getResponse($id);
	//get reports
	$survey->getReports(<FILTER>,<PAGE>);
	$survey->getReport($id);
	//get statistics
	$survey->getStatistics();
	$survey->getQuestionStatistics($sku);
```

### Questions
To access the questions on a survey you'll need an instance of a SurveyGizmo\Survey object. 

###### Get all Survey Questions
```php
$questions = $survey->getQuestions();
```

###### Getting and Updating a Survey Question
```php
$question = $survey->getQuestion(<QUESTION SKU>);
$question->title->English = "LIBRARY TEST";
$ret = $question->save();
```

### Responses
To access the responses for a survey you'll need an instance of a SurveyGizmo\Survey object. See filter and paging below.

###### Get all Survey Responses
```php
$responses = $survey->getResponses(<FILTER>,<OPTIONS>);
```

###### Get a Single Responses
```php
$responses = $survey->getResponse(<RESPONSE_ID);
```

###### Update a Responses
```php
$response->survey_data[2]['answer'] = 'YES';
$ret = $response->save();
```


#### Filtering & Paging Objects
All fetch methods take both optional $filter and $options arguments. 

###### Filtering
```php
$filter = new SurveyGizmo\Filter();
$filter_item = new SurveyGizmo\FilterItem();
$filter_item->setField('title');
$filter_item->setOperator('=');
$filter_item->setCondition('TEST from API');
$filter->addFilterItem($filter_item);
$surveys = SurveyGizmo\Survey::fetch($filter);
```

###### Paging Collections
Sometimes you will need to page through collecitons of objects.  To accomidate this use tha optional $options agrument on any fetch method;
```php
$options = array( 'page' => 3, 'limit' => 100 );
$surveys = SurveyGizmo\Survey::fetch($filter,$options);
```

### ERROR Message & Responses
In the case of an error we will return the following responses and status codes:
```
Method not implemented (404)
Method not supported (405)
Not Authorized (401)
```

## Dependencies


## Installation
1. Download the Lirbary and add it to your project.
2. Include the Autoloader.php file
```php
require_once "<LIBRARY_PATH>/SurveyGizmoAutoLoader.php";
```
3. Authenticate using your SurveyGizmo [API Key and Secret](https://apihelp.surveygizmo.com/help/article/link/authentication).
```php
//set your key & secret
$api_key = "<YOUR API_KEY>";
$api_secret = "<YOUR API_SECRET>";

try {
	$sg = SurveyGizmo\SurveyGizmoAPI::auth($api_key,$api_secret);
} catch (Exception $e) {
	die("Error Authenticating");
}
```

## API Reference
This Library uses the version 5 SurveyGizmo API.  [API Documentation](https://apihelp.surveygizmo.com).


## Tests


## Contributors
The library was developed and is maintained by the [SurveyGizmo](http://www.surveygizmo.com) Product Development Team.

## License
