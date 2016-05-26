<?php
namespace SurveyGizmo\Helpers;
use SurveyGizmo\Helpers\FilterItem;

/**
 * Filter class. Used to filter fetch requests.
 */
class Filter
{

	/**
	 * Array of SurveyGizmo\Helpers\FilterItem
	 */
	private $items;

	/**
	 * Add FilterItem to items collection.
	 * @param $filterItem SurveyGizmo\Helpers\FilterItem
	 * @return void
	 */
	public function addFilterItem(FilterItem $filter_item)
	{
		$this->items[] = $filter_item;
	}

	/**
	 * Return the collection of filter items.
	 * @return Array $items
	 */
	public function returnItems()
	{
		return is_array($this->items) ? $this->items : array();
	}

	/**
	 * Build query string for request.
	 * @return string
	 */
	public function buildRequestQuery()
	{
		$query_string = '';
		foreach ($this->returnItems() as $index => $item) {
			$query_string .= '&' . $item->toQueryString($index++);
		}
		return $query_string;
	}
}
