<?php
namespace SurveyGizmo;

use SurveyGizmo\ApiResource;

class ContactList extends ApiResource
{

	static $path = "/contactlist/{id}";

	public function save()
	{
		return $this->_save(array(
			'id' => $this->id
		));
	}

	public function delete()
	{
		return self::_delete(array(
			'id' => $this->id
		));
	}

	public static function get($id)
	{
		$id = (int) $id;
		if ($id < 1) {
			throw new SurveyGizmoException(500, "ID required");
		}
		return self::_get(array(
			'id' => $id,
		));
	}

	public static function fetch($filter = null, $options = null)
	{
		return self::_fetch(array('id' => ''), $filter, $options);
	}

	public function getContacts ($filter = null, $options = null)
	{
		if ($this->exists()) {
			$options = array("list_id" => $this->id);
			return ContactListContact::fetch($this->id, $filter, $options);
		}
		return false;
	}
}
