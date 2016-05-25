<?php
namespace SurveyGizmo\Tests;

use SurveyGizmo\Helpers\Filter;
use SurveyGizmo\Helpers\FilterItem;

class FilterTest extends TestCase
{

/*======= TestSuite Setup ======*/

/*======== End of Setup ========*/

    public function testIsTrue()
    {
        $this->assertSame(1, 1);
    }

    public function testparseJson()
    {
      $expected = null;
      $genericJSON = array(
          "filter"=>"items",
          "operator"=>"equals",
          "condition"=>"eggs",
          "result"=> "french toast"
        );

      $genericJSON = json_encode(array('item' => $genericJSON), JSON_FORCE_OBJECT);
      $filter = new Filter();
      $result = $filter->parseJson($genericJSON);
      $this->assertEquals($expected, $result); // make sure json parsing doesn't error

    }
    /*
    * technically more of an integration test - covers a bunch of stuff.
    *@covers addFilterItem
    @covers returnItems
    *@covers buildRequestQuery
    */

    public function  testBuildRequestQuery()
    {
      $expected = "&filter%5Bfield%5D%5B0%5D=turtle&filter%5Boperator%5D%5B0%5D=equals&filter%5Bvalue%5D%5B0%5D=Donatello";
      $param->Field = "turtle";
      $param->Operator = "equals" ;
      $param->Condition = "Donatello";
      $param = json_encode($param);

      $filter = new Filter;
      $filter->data = new FilterItem($param);

      $query = $filter->addFilterItem($filter->data);
      $this->assertTrue($query);
      $addeds = $filter->returnItems();
      $addeds = $addeds[0];
      $this->assertInstanceOf('SurveyGizmo\Helpers\FilterItem', $addeds);
      $actual = $filter->buildRequestQuery();
      $this->assertEquals($expected, $actual);

    }

    public function  testBuildRequestQueryEmpty()
    {
      $expected = "&filter%5Bfield%5D%5B0%5D=&filter%5Boperator%5D%5B0%5D=&filter%5Bvalue%5D%5B0%5D=";
      $param->Field = "";
      $param->Operator = "" ;
      $param->Condition = "";
      $param = json_encode($param);

      $filter = new Filter;
      $filter->data = new FilterItem($param);

      $query = $filter->addFilterItem($filter->data);
      $this->assertTrue($query);
      $addeds = $filter->returnItems();
      $addeds = $addeds[0];
      $this->assertInstanceOf('SurveyGizmo\Helpers\FilterItem', $addeds);
      $actual = $filter->buildRequestQuery();
      $this->assertEquals($expected, $actual);

    }

    public function  testBuildRequestQueryFilterCreatedButNotPopulated()
    {
      //$expected = "&filter%5Bfield%5D%5B0%5D=&filter%5Boperator%5D%5B0%5D=&filter%5Bvalue%5D%5B0%5D=";
      $filter = new Filter;
      $filter->data = new FilterItem();
      $query = $filter->addFilterItem($filter->data);
      $this->assertTrue($query);
      $addeds = $filter->returnItems();
      $addeds = $addeds[0];
      $this->assertInstanceOf('SurveyGizmo\Helpers\FilterItem', $addeds);
      $actual = $filter->buildRequestQuery();
      $this->assertEquals('&', $actual);
    }

    public function  testBuildRequestQueryWithoutFilterItemObject()
    {
      //$expected = "&filter%5Bfield%5D%5B0%5D=&filter%5Boperator%5D%5B0%5D=&filter%5Bvalue%5D%5B0%5D=";
      $filter = new Filter;
      #$filter->data = new FilterItem();
      $actual = $filter->buildRequestQuery();
      $this->assertEquals('', $actual);
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
