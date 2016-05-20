<?php
namespace SurveyGizmo;

use SurveyGizmo\ApiResource;

class ContactList extends ApiResource
{

	static $path = "/contactlist/{id}";

	public function __set($name, $value)
	{
		$this->{$name} = $value;
		if ($name == 'contacts') {
			$this->formatContacts();
		}
	}

	public function save()
	{
		// Only create allowed
		if ($this->exists()) {
			throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED, 'Update not supported');
		}
		return $this->_save(array(
			'id' => '',
		));
	}

	public static function get($id)
	{
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

	protected function formatContacts ()
	{
		for ($i = 0, $c = count($this->contacts); $i < $c; $i++) {
			$this->contacts[$i] = self::_formatObject("SurveyGizmo\\Contact", $this->contacts[$i]);
		}
	}
}
