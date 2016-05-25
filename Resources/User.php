<?php
namespace SurveyGizmo\Resources;

use SurveyGizmo\ApiResource;
use SurveyGizmo\Helpers\SurveyGizmoException;

/**
 * Class for User API object
 */
class User extends ApiResource
{
	/**
	 * API call path 
	 */
	static $path = "/accountuser/{id}";

	/**
	 * Saves the user instance. Performs an update/insert.
	 * @access public
	 * @return SurveyGizmo\ApiResponse Object with SurveyGizmo\User Object
	 */
	public function save()
	{
		return $this->_save(array(
			'id' => $this->id
		));
	}

	/**
	 * Deletes the user instance. Requires an existing object.
	 * @access public
	 * @return SurveyGizmo\ApiResponse Object
	 */
	public function delete()
	{
		return self::_delete(array(
			'id' => $this->id,
		));
	}

	/**
	 * Fetches a single user instance. Requires a positive integer ID.
	 * @access public
	 * @static
	 * @param $id int - User ID
	 * @return SurveyGizmo\User Object
	 */
	public static function get($id)
	{
		$id = (int) $id;
		if ($id < 1) {
			throw new SurveyGizmoException(500, "User ID required");
		}
		return self::_get(array(
			'id' => $id
		));
	}

	/**
	 * Fetches a collection of users belonging to the account.
	 * @access public
	 * @static
	 * @param $filters SurveyGizmo\Filter - filter instance
	 * @param $options array
	 * @return SurveyGizmo\ApiResponse
	 */
	public static function fetch($filter = null, $options = null)
	{
		return self::_fetch(array(
			'id' => ''
		), $filter, $options);
	}
}
