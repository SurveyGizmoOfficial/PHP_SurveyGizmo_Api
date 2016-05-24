<?php
namespace SurveyGizmo;
use SurveyGizmo\ApiResource;

/**
 * Class for EmailMessage API objects
 * EmailMessages are a sub-object of Campaigns
 */
class EmailMessage extends ApiResource
{
	/**
	 * API call path 
	 */
	static $path = "/survey/{survey_id}/surveycampaign/{campaign_id}/emailmessage/{id}";

	/**
	 * Fetch list of SurveyGizmo EmailMessage Objects
	 * @access public
	 * @param int $survey_id - Survey ID
	 * @param int $campaign_id - parent Survey Campaign ID
	 * @param SurveyGizmo\Filter $filters - filter object
	 * @param Array $options
	 * @return SurveyGizmo\APIResponse object
	 */
	public static function fetch($survey_id, $campaign_id, $filters = null, $options = null) {
		if ($campaign_id < 1 && $survey_id < 1) {
			throw new SurveyGizmoException(500, "Missing campaign or survey ID");
		}
		$response = self::_fetch(array('id' => '', 'survey_id' => $survey_id, 'campaign_id' => $campaign_id,), $filter, $options);
		return $response;
	}

	/**
	 * Get Campaign Obj by survey id, campaign id and email message id
	 * @access public
	 * @param int $survey_id - survey id
	 * @param int $campaign_id - campaign id
	 * @param int $id - email id
	 * @return SurveyGizmo\EmailMessage object
	 */
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

	/**
	 * Save current EmailMessage Obj
	 * @access public
	 * @return SurveyGizmo\APIResponse object
	 */
	public function save()
	{
		return $this->_save(array(
			'campaign_id' => $this->campaign_id,
			'survey_id' => $this->survey_id,
			'id' => $this->exists() ? $this->id : ''
		));
	}

	/**
	 * Delete current EmailMessage Obj
	 * @access public
	 * @return SurveyGizmo\APIResponse object
	 */
	public function delete(){
		return self::_delete(array(
			'campaign_id' => $this->campaign_id,
			'survey_id' => $this->survey_id,
			'id' => $this->id,
		));
	}
}
