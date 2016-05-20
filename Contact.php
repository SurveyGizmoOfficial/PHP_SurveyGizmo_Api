<?php
namespace SurveyGizmo;

use SurveyGizmo\ApiResource;

class Contact extends ApiResource
{

	static $path = "/contactlist/{id}";

	public function save()
	{
		// Only update allowed
		if (!$this->exists()) {
			throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED, 'Create not supported');
		}
		return $this->_save(array(
			'id' => $this->iGroupID,
		));
	}

	public function exists()
	{
		return $this->iCustomerContactID > 0 && $this->iGroupID > 0;
	}
}
