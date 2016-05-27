<?php
namespace SurveyGizmo\Helpers;

/**
 * FilterItem class. Used with the Filter class to filter fetch requests.
 */
class FilterItem
{

	/**
	 * Field value.
	 * @var string
	 */
	private $field;

	/**
	 * Operator value.
	 * @var string
	 */
	private $operator;

	/**
	 * Condition value.
	 * @var string
	 */
	private $condition;

	/**
	 * Constructor: optionally pass the values here for simplicity.
	 * @param $field string null
	 * @param $operator string null
	 * @param $condition string null
	 * @return void
	 */
	public function __construct ($field = null, $operator = null, $condition = null) {
		$this->setField($field);
		$this->setOperator($operator);
		$this->setCondition($condition);
	}

	/**
	 * Set the field value.
	 * @param $field string
	 * @return void
	 */
	public function setField($field)
	{
		$this->field = $field;
	}

	/**
	 * Set the operator value.
	 * @param $operator string
	 * @return void
	 */
	public function setOperator($operator)
	{
		$this->operator = $operator;
	}

	/**
	 * Set the condition value.
	 * @param $condition string
	 * @return void
	 */
	public function setCondition($condition)
	{
		$this->condition = $condition;
	}

	/**
	 * Getter for field property
	 * @return string
	 */
	public function getField()
	{
		return $this->field;
	}

	/**
	 * Getter for operator property
	 * @return string
	 */
	public function getOperator()
	{
		return $this->operator;
	}

	/**
	 * Getter for condition property
	 * @return string
	 */
	public function getCondition()
	{
		return $this->condition;
	}

	/**
	 * Serialize filter item for request. Used by SurveyGizmo\Helpers\Filter.
	 * @param $index int - filter index
	 * @return string
	 */
	public function toQueryString($index)
	{
		$filter_prefix = 'filter';
		$filter_postfix = '[' . $index . ']';
		$parts = array(
			$filter_prefix . '[field]' . $filter_postfix => $this->getField(),
			$filter_prefix . '[operator]' . $filter_postfix => $this->getOperator(),
			$filter_prefix . '[value]' . $filter_postfix => $this->getCondition(),
		);
		return http_build_query($parts);
	}
}
