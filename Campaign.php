<?php
namespace SurveyGizmo;

use SurveyGizmo\ApiResource;

class Campaign extends ApiResource
{
	static $path = "/survey/{survey_id}/surveycampaign/{id}";

	public function save()
	{
		return $this->_save(array(
			'survey_id' => $this->survey_id,
			'id' => $this->exists() ? $this->id : ''
		));
	}

	public static function get($survey_id, $id){
		var_dump($survey_id,$id);
		if ($id < 1 && $survey_id < 1) {
			throw new SurveyGizmoException(500, "IDs required");
		}
		return self::_get(array(
			'survey_id' => $survey_id,
			'id' => $id,
		));
	}

	public function delete(){
		return self::_delete(array(
			'survey_id' => $survey_id,
			'id' => $this->id,
		));
	}

	public static function fetch($survey_id, $filters = null, $options = null) {
		if ($survey_id < 1) {
			throw new SurveyGizmoException(500, "Missing survey ID");
		}
		$response = self::_fetch(array('id' => '', 'survey_id' => $survey_id), $filter, $options);
		return $response;
	}

	public function getEmailMessages($filter = null)
	{
		return $this->getSubObjects("SurveyGizmo\\EmailMessage", $filter);
	}

	public function getEmailMessage($email_id)
	{
		return $this->getSubObject("SurveyGizmo\\EmailMessage", $email_id);
	}

	/*HELPERS*/
	private function getSubObjects($type, $filter = null, $options = null)
	{
		var_dump($this->survey_id, $this->id);
		$options = array("survey_id" => $this->survey_id, 'campaign_id' => $this->id);
		return $type::fetch($this->survey_id, $this->id, $filter, $options);
	}

	/*HELPERS*/
	private function getSubObject($type, $id)
	{
		return $type::get($this->survey_id, $this->id, $id);
	}

}
