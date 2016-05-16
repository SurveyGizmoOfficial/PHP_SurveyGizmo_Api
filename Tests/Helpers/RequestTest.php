<?php

namespace SurveyGizmo;
#namespace Tests\SurveyTest;
//use Helpers\Request;

class RequestTest extends TestCase
{

/*======= TestSuite Setup ======*/

  // Include with all test classes.  Does not need to be changed.
/*
protected $resource;

/**
 * Setup needed data
 *
 */
 /*
protected function setUp()
{
  require_once 'Survey.php';
  $this->resource = new Survey();
}

require_once "../SurveyGizmoAutoLoader.php";
//set token & secret
$token = "e87c03fc320ab9fd509a9d32505491262d133987bdfa64af53";
$secret = "A9SByZ3cS%2FqpE";
//authetnicate
testLog("Authenticating");

$sg = SurveyGizmo\SurveyGizmoAPI::auth($token,$secret);








*/
/*======== End of Setup ========*/

    public function testIsTrue()
    {
        $this->assertSame(1, 1);
    }

    public function testmakeRequest()
    {
      //$test = new Request();
        /*var_dump($test);die;
        private $baseuri =>
        string(56) "app2.garrett.restapi.boulder.sgizmo.com/services/rest/v4"
        public $method =>
        string(3) "GET"
        */
      //$results = $test->makeRequest();
      //var_dump($results); die;
      //returns null


      //returns null
    }

    public function testBuildPayloadBasic()
    {
      $expected = "test=i+am+a+property&property=this+is+a+test";
      $test = new Request();
      $test->data = new \stdClass();
      $test->data->test = "i am a property";
      $test->data->property = "this is a test";
      $payload = $this->invokeMethod($test, 'buildPayload');
      $this->assertEquals($expected, $payload);
    }

    public function testBuildPayloadEmpty()
    {
      $expected = "";
      $test = new Request();
      $test->data = new \stdClass();
      $payload = $this->invokeMethod($test, 'buildPayload');
      $this->assertEquals($expected, $payload);
    }

    public function testBuildPayloadNotReturnEmpty()
    {
      $notExpected = "";
      $test = new Request();
      $test->data = new \stdClass();
      $test->data->test = "i am a property";
      $test->data->property = "this is a test";
      $payload = $this->invokeMethod($test, 'buildPayload');
      $this->assertNotEquals($notExpected, $payload);
    }

    public function testbuildURI()
    {

      $expected = "app2.garrett.restapi.boulder.sgizmo.com/services/rest/v4this is a string.json?api_token=testing&api_token_secret=sauce&_method=GET";
/*
      $response = new \stdClass();
      $response->approved = true;
      //for Return of Auth to be true
      $mockAuth = $this->getMockBuilder('\SurveyGizmoAPI')
      ->getMock();

      $mockAuth->expects($this->any())
      ->method('auth');
*/
      $test = new Request();
      $test->data = new \stdClass();
      $test->path = 'this is a string';
      $creds = array(
        "AuthToken"=>"testing",
        "AuthSecret"=>"sauce"
        );
      //$results = $test->makeRequest();

      //var_dump($results); die;
      $uri = $this->invokeMethod($test, 'buildURI', $creds);
      $this->assertEquals($expected, $uri);
      //var_dump($uri);die;

      //returns null
    }



    /**
 * Call protected/private method of a class.
 *
 * @param object &$object    Instantiated object that we will run method on.
 * @param string $methodName Method name to call
 * @param array  $parameters Array of parameters to pass into method.
 *
 * @return mixed Method return.
 */
public function invokeMethod(&$object, $methodName, array $parameters = array())
{
    //var_dump($parameters); die;
    $reflection = new \ReflectionClass(get_class($object));
    $method = $reflection->getMethod($methodName);
    $method->setAccessible(true);
    //var_dump($parameters); die;
    return $method->invokeArgs($object, array($parameters));
}

}
