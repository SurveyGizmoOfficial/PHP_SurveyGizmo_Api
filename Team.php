<?php
namespace SurveyGizmo;
use SurveyGizmo\ApiResource;

/**
 * Class for Team API object
 */
class Team extends ApiResource
{
	/**
	 * API call path 
	 */
	static $path = "/accountteams/{id}";

	/**
	 * Saves the team instance. Performs an update/insert.
	 * @access public
	 * @return SurveyGizmo\APIResponse Object with SurveyGizmo\Team Object
	 */
	public function save()
	{
		return $this->_save(array(
			'id' => $this->id
		));
	}

	/**
	 * Deletes the team instance. Requires an existing object.
	 * @access public
	 * @return SurveyGizmo\APIResponse Object
	 */
	public function delete()
	{
		return self::_delete(array(
			'id' => $this->id,
		));
	}

	/**
	 * Fetches a single team instance. Requires a positive integer ID.
	 * @access public
	 * @static
	 * @param $id int - Team ID
	 * @return SurveyGizmo\Team Object
	 */
	public static function get($id)
	{
		$id = (int) $id;
		if ($id < 1) {
			throw new SurveyGizmoException(500, "Team ID required");
		}
		return self::_get(array(
			'id' => $id
		));
	}

	/**
	 * Fetches a collection of teams belonging to the account.
	 * @access public
	 * @static
	 * @param $filters SurveyGizmo\Filter - filter instance
	 * @param $options array
	 * @return SurveyGizmo\APIResponse
	 */
	public static function fetch($filter = null, $options = null)
	{
		return self::_fetch(array(
			'id' => ''
		), $filter, $options);
	}
}
