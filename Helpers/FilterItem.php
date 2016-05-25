<?php
namespace SurveyGizmo\Helpers;

class FilterItem{

	private $Field;
	private $Operator;
	private $Condition;
	
	public function __construct($filterJson){
		$this->setLogic($filterJson);
	}	

	/**
	 * setLogic
	 * set logic properties from json string
	 * @param $filterJson string json string for logic
	 * @return boolean 
	 */
	public function setLogic($filterJson)
	{
		$FilterParts = json_decode($filterJson);
		$this->setField($FilterParts->Field);
		$this->setOperator($FilterParts->Operator);
		$this->setCondition($FilterParts->Condition);
		return $this->isValid();
	}

	/**
	 * setter for field property
	 * @param String $field
	 */
	public function setField($field){
		$this->Field = $field;
	}

	/**
	 * setter for operator property
	 * @param String $operator
	 */
	public function setOperator($operator){
		$this->Operator = $operator;
	}

	/**
	 * setter for condition property
	 * @param String $condition
	 */
	public function setCondition($condition){
		$this->Condition = $condition;
	}

	/**
	 * getter for field property
	 */
	public function getField(){
		return $this->Field;
	}

	/**
	 * getter for operator property
	 */
	public function getOperator(){
		return $this->Operator;
	}

	/**
	 * getter for condition property
	 */
	public function getCondition(){
		return $this->Condition;
	}

	/**
	 * check if filter is a valid filter
	 * @return boolean
	 */
	public function checkIsValid()
	{
		return $this->isValid();
	}

	/**
	 * prepare filter item for request
	 * @param $index int filter index
	 * @return string 
	 */
	public function toQueryString($index = 0){
		$filterPrefix = 'filter';
		$filterPostfix = '[' . $index . ']';
		$parts = array(
						$filterPrefix . '[field]' . $filterPostfix		=> $this->getField(),
						$filterPrefix . '[operator]' . $filterPostfix	=> $this->getOperator(),
						$filterPrefix . '[value]' . $filterPostfix		=> $this->getCondition()
					);
		return http_build_query($parts);
	}

	/**
	 * check if items are valid
	 */
	private function isValid(){
		//check for valid items?
		return true;
	}
}
?>