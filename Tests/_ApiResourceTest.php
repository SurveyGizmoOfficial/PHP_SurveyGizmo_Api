<?php

namespace SurveyGizmo;

class ApiResourceTest extends TestCase
{
    public function testIsTrue()
    {
        $this->assertSame(1, 1);
    }


    public function test_getPath()
    {
        $expected = "this/is-a-path/that-looks-somewhat/normal/it-sure-looks-normal/to-me";
        $tester = new ApiResource();
        $path = "this/is-a-path/that-looks-somewhat/normal";
        $append = "it-sure-looks-normal/to-me";
        $actual = $tester->_getPath($path, $append);
        $this->assertEquals($expected, $actual);
    }

    public function test_getPathNoAppend()
    {
        $expected = "this/is-a-path/that-looks-somewhat/normal";
        $tester = new ApiResource();
        $path = "this/is-a-path/that-looks-somewhat/normal";
        $actual = $tester->_getPAth($path);
        $this->assertEquals($expected, $actual);

    }

    public function test_mergePath()
    {
      $expected = '/survey/1234/surveyresponse';
      $tester = new ApiResource();
      $path = "/survey/{survey_id}/surveyresponse";
      $options = array (
        'survey_id' => '1234'
      );
      $result = $tester->_mergePath($path, $options);
      //var_dump($result); die;
      $this->assertEquals($expected, $result);
    }

    public function test_mergePathWithRandomStuff()
    {
      $expected = '/survey/1234/surveyresponse/1/something-else/is_yummy';
      $tester = new ApiResource();
      $path = "/survey/{survey_id}/surveyresponse/{response_id}/something-else/{bacon}";
      $options = array (
        'survey_id' => '1234',
        'response_id' => 1,
        'bacon' => 'is_yummy'
      );
      $result = $tester->_mergePath($path, $options);
      //var_dump($result); die;
      $this->assertEquals($expected, $result);
    }

    public function test_mergePathWithoutsomethingToReplace()
    {
      $expected = '/survey/surveyresponse/something-else/';
      $tester = new ApiResource();
      $path = "/survey/surveyresponse/something-else/";
      $options = array (
        'survey_id' => '1234',
        'response_id' => 1,
        'bacon' => 'is_yummy'
      );
      $result = $tester->_mergePath($path, $options);
      //var_dump($result); die;
      $this->assertEquals($expected, $result);
    }
/*
    public function test_parseObjects()
        {
          $type = 'survey';
          $data = array (
          $id = 123,
          $title = "Example survey",
          );
          $resource = new ApiResource;
          $test = array ($type, $data);
          //var_dump($test);die;
            //parseObjects requires $type, $data
          $payload = $this->invokeMethod($resource, $test, '_parseObjects');
          var_dump($payload);die;

        }
  */
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
