<?php
namespace SurveyGizmo;

class Filter
{

	/**
	 * array of FilterItem
	 */
	private $Items;

	public function __construct($FilterJson = false)
	{
		if ($filter_json) {
			$filter_items = $this->parseJson($FilterJson);
		}
	}

	public function parseJson($FilterJson)
	{
		$parts = json_decode($FilterJson);

		reset($parts);
		$key = key($parts);

		if (is_int($key)) {
			foreach ($parts as $key => $filter_json) {
				$this->addFilterItem(new FilterItem(json_encode($filter_json)));
			}
		} else {
			$this->addFilterItem(new FilterItem($FilterJson));
		}
	}

	/**
	 * Add FilterItem to Items Array
	 * @param $filterItem FilterItem
	 * @return boolean
	 */
	public function addFilterItem(FilterItem $filterItem)
	{
		if ($filterItem instanceof FilterItem) {
			$this->Items[] = $filterItem;
		} else {
			return false;
		}
		return true;
	}

	/**
	 * Return the items properties
	 * @return Array $items
	 */
	public function returnItems()
	{
		return $this->Items;
	}

	/**
	 * build query string for request
	 * @return string
	 */
	public function buildRequestQuery()
	{
		$QueryString = '';
		$index = 0;
		foreach ($this->returnItems() as $key => $item) {
			//ignore invalid objects
			if ($item instanceof FilterItem) {
				$QueryString .= '&' . $item->toQueryString($index);
				$index++;
			}
		}
		return $QueryString;
	}
}
