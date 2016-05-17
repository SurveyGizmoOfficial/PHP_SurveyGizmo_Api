<?php
namespace SurveyGizmo;

class RequestTest extends TestCase
{

/*======= TestSuite Setup ======*/

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

    /*
     *
     * @covers buildPayload
     */
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
    /*
     *
     * @covers buildPayload
     */
    public function testBuildPayloadEmpty()
    {
      $expected = "";
      $test = new Request();
      $test->data = new \stdClass();
      $payload = $this->invokeMethod($test, 'buildPayload');
      $this->assertEquals($expected, $payload);
    }
    /*
     *
     * @covers buildPayload
     */
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
    /*
     *
     * @covers buildURI
     */
    public function testbuildURI()
    {

      $expected = "trunk.qa.devo.boulder.sgizmo.com/services/rest/v4this is a string.json?api_token=testing&api_token_secret=sauce&_method=GET";

      $test = new Request();
      $test->data = new \stdClass();
      $test->path = 'this is a string';
      $creds = array(
        "AuthToken"=>"testing",
        "AuthSecret"=>"sauce"
        );
      $uri = $this->invokeMethod($test, 'buildURI', $creds);
      $this->assertEquals($expected, $uri);

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
