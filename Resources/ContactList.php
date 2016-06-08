<?php
namespace SurveyGizmo\Resources;

use SurveyGizmo\ApiResource;
use SurveyGizmo\Helpers\SurveyGizmoException;
use SurveyGizmo\Resources\ContactList\Contact;

/**
 * Class for ContactList API object
 */
class ContactList extends ApiResource
{
	/**
	 * API call path 
	 */
	static $path = "/contactlist/{id}";

	/**
	 * Saves the contact list instance. Performs an update/insert.
	 * @access public
	 * @return SurveyGizmo\ApiResponse Object with SurveyGizmo\ContactList Object
	 */
	public function save()
	{
		return $this->_save(array(
			'id' => $this->id
		));
	}

	/**
	 * Deletes the contact list instance. Requires an existing object.
	 * @access public
	 * @return SurveyGizmo\ApiResponse Object
	 */
	public function delete()
	{
		return self::_delete(array(
			'id' => $this->id
		));
	}

	/**
	 * Fetches a single contact list instance. Requires a positive integer ID.
	 * @access public
	 * @static
	 * @param $id int - Contact list ID
	 * @return SurveyGizmo\ContactList Object
	 */
	public static function get($id)
	{
		$id = (int) $id;
		if ($id < 1) {
			throw new SurveyGizmoException(500, "Contact List ID required");
		}
		return self::_get(array(
			'id' => $id
		));
	}

	/**
	 * Fetches a collection of contact lists belonging to the account.
	 * @access public
	 * @static
	 * @param $filters SurveyGizmo\Filter - filter instance
	 * @param $options array
	 * @return SurveyGizmo\ApiResponse with SurveyGizmo\ContactList objects
	 */
	public static function fetch($filter = null, $options = null)
	{
		return self::_fetch(array(
			'id' => ''
		), $filter, $options);
	}

	/**
	 * Fetches a collection of contacts belonging to this contact list.
	 * @access public
	 * @static
	 * @param $filters SurveyGizmo\Filter - filter instance
	 * @param $options array
	 * @return SurveyGizmo\ApiResponse with SurveyGizmo\ContactList\Contact objects
	 */
	public function getContacts ($filter = null, $options = null)
	{
		if ($this->exists()) {
			if (!is_array($options)) {
				$options = array();
			}
			$options['list_id'] = $this->id;
			return Contact::fetch($this->id, $filter, $options);
		}
		return false;
	}
}
