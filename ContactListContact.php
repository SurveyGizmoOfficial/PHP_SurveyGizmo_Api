<?php
namespace SurveyGizmo;

use SurveyGizmo\ApiResource;

class ContactListContact extends ApiResource
{

	static $path = "/contactlist/{list_id}/contactlistcontact/{id}";

	public function save()
	{
		if ((int) $this->list_id < 1) {
			throw new SurveyGizmoException(500, "Contact needs to belong to a contact list");
		}
		if (empty($this->email_address)) {
			throw new SurveyGizmoException(500, "Contact requires an email");
		}
		return $this->_save(array(
			'id' => $this->id,
			'list_id' => $this->list_id
		));
	}

	public function delete()
	{
		if ((int) $this->list_id < 1) {
			throw new SurveyGizmoException(500, "Contact needs to belong to a contact list");
		}
		return self::_delete(array(
			'id' => $this->id,
			'list_id' => $this->list_id
		));
	}

	public static function get($list_id, $id)
	{
		$list_id = (int) $list_id;
		$id = (int) $id;
		if ($id < 1 || $list_id < 1) {
			throw new SurveyGizmoException(500, "Contact list ID and contact ID required");
		}
		return self::_get(array(
			'id' => $id,
			'list_id' => $list_id
		));
	}

	public static function fetch($list_id, $filter = null, $options = null)
	{
		$list_id = (int) $list_id;
		if ($list_id < 1) {
			throw new SurveyGizmoException(500, "Contact list ID required");
		}
		return self::_fetch(array(
			'id' => '',
			'list_id' => $list_id
		), $filter, $options);
	}
}
