<?php
namespace SurveyGizmo;

use SurveyGizmo\ApiResource;

class EmailMessage extends ApiResource
{
	static $path = "/survey/{survey_id}/surveycampaign/{campaign_id}/emailmessage/{id}";

	public function save()
	{
		return $this->_save(array(
			'campaign_id' => $this->campaign_id,
			'survey_id' => $this->survey_id,
			'id' => $this->exists() ? $this->id : ''
		));
	}

	public static function get($survey_id, $campaign_id, $id){
		if ($id < 1 && $survey_id < 1 && $campaign_id < 1) {
			throw new SurveyGizmoException(500, "IDs required");
		}
		return self::_get(array(
			'campaign_id' => $campaign_id,
			'survey_id' => $survey_id,
			'id' => $id,
		));
	}
	
	public function delete(){
		return self::_delete(array(
			'campaign_id' => $this->campaign_id,
			'survey_id' => $this->survey_id,
			'id' => $this->id,
		));
	}

	public static function fetch($survey_id, $campaign_id, $filters = null, $options = null) {
		if ($campaign_id < 1 && $survey_id < 1) {
			throw new SurveyGizmoException(500, "Missing campaign or survey ID");
		}
		var_dump(array('id' => '', 'survey_id' => $survey_id, 'campaign_id' => $campaign_id,), $filter, $options);
		$response = self::_fetch(array('id' => '', 'survey_id' => $survey_id, 'campaign_id' => $campaign_id,), $filter, $options);
		return $response;
	}
}
