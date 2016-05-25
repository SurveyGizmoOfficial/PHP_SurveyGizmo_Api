<?php
namespace SurveyGizmo;
use SurveyGizmo\ApiResource;

/**
 * Class for ContactListContact API object
 */
class ContactListContact extends ApiResource
{
	/**
	 * API call path 
	 */
	static $path = "/contactlist/{list_id}/contactlistcontact/{id}";

	/**
	 * Saves the contact instance. Performs an update/insert. Requires an email address
	 * and contact list reference ID.
	 * @access public
	 * @return SurveyGizmo\APIResponse Object with SurveyGizmo\ContactListContact Object
	 */
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

	/**
	 * Deletes the contact instance. Requires an existing object and a contact list reference ID.
	 * @access public
	 * @return SurveyGizmo\APIResponse Object
	 */
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

	/**
	 * Fetches a single contact instance. Requires a positive integer ID for the contact list and contact.
	 * @access public
	 * @static
	 * @param $list_id int - Contact list ID
	 * @param $id int - Contact ID
	 * @return SurveyGizmo\ContactListContact Object
	 */
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

	/**
	 * Fetches a collection of contacts belonging to a contact list specified by the ID.
	 * @access public
	 * @static
	 * @param $list_id int - Contact list ID
	 * @param $filters SurveyGizmo\Filter - filter instance
	 * @param $options array
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\ContactListContact objects
	 */
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
