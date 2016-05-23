<?php
namespace SurveyGizmo;

use SurveyGizmo\ApiResource;

class User extends ApiResource
{

	static $path = "/accountuser/{id}";

	public function save()
	{
		return $this->_save(array(
			'id' => $this->id,
		));
	}

	public static function get($id)
	{
		if ($id < 1) {
			throw new SurveyGizmoException(500, "User ID required");
		}
		return self::_get(array(
			'id' => $id,
		));
	}

	public function delete()
	{
		return self::_delete(array(
			'id' => $this->id,
		));
	}

	public static function fetch($filter = null, $options = null)
	{
		return self::_fetch(array('id' => ''), $filter, $options);
	}
}
