<?php
namespace SurveyGizmo\Tests;

use SurveyGizmo\ApiRequest;

class ApiRequestTest extends TestCase
{

/*======= TestSuite Setup ======*/

/*======== End of Setup ========*/

    public function testIsTrue()
    {
        $this->assertSame(1, 1);
    }

    /*
     *
     * @covers buildPayload
     */
    public function testBuildPayloadBasic()
    {
      $expected = "test=i+am+a+property&property=this+is+a+test";
      $test = new ApiRequest();
      $test->data = new \stdClass();
      $test->data->test = "i am a property";
      $test->data->property = "this is a test";
      $payload = $this->invokeMethod($test, 'getPostData');
      $this->assertEquals($expected, $payload);
    }
    /*
     *
     * @covers buildPayload
     */
    public function testBuildPayloadEmpty()
    {
      $expected = "";
      $test = new ApiRequest();
      $test->data = new \stdClass();
      $payload = $this->invokeMethod($test, 'getPostData');
      $this->assertEquals($expected, $payload);
    }
    /*
     *
     * @covers buildPayload
     */
    public function testBuildPayloadNotReturnEmpty()
    {
      $notExpected = "";
      $test = new ApiRequest();
      $test->data = new \stdClass();
      $test->data->test = "i am a property";
      $test->data->property = "this is a test";
      $payload = $this->invokeMethod($test, 'getPostData');
      $this->assertNotEquals($notExpected, $payload);
    }

    /*
     *
     * @covers buildPayload
     */
     public function testBuildPayloadForeignCharacters()
     {
       $expected = "test=%C3%93%C3%98%CB%86%C2%A8%C3%81%CB%87%E2%80%B0%C2%B4%E2%80%9E%C3%85%C5%92%E2%80%9E%C2%B4";
       $test = new ApiRequest();
       $test->data = new \stdClass();
       $test->data->test = "ÓØˆ¨Áˇ‰´„ÅŒ„´";
       $payload = $this->invokeMethod($test, 'getPostData');
       $this->assertEquals($expected, $payload);
     }
    /*
     *
     * @covers buildURI
     */
    public function testbuildURI()
    {

      $test = new ApiRequest();
      $test->data = new \stdClass();
      $test->path = 'this is a string';
      $creds = array(
        "AuthToken"=>"testing",
        "AuthSecret"=>"sauce"
        );
      $uri = $this->invokeMethod($test, 'getCompleteUrl', $creds);
      //$this->assertEquals($expected, $uri);

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
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, array($parameters));
    }

}
