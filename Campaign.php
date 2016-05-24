<?php
namespace SurveyGizmo;
use SurveyGizmo\ApiResource;

/**
 * Class for SurveyCampaign API objects
 */
class Campaign extends ApiResource
{
	/**
	 * API call path 
	 */
	static $path = "/survey/{survey_id}/surveycampaign/{id}";

	/**
	 * Fetch list of SurveyGizmoCampaign Objects
	 * @access public
	 * @param int $survey_id - Survey ID
	 * @param SurveyGizmo\Filter $filters - filter object
	 * @param Array $options
	 * @return SurveyGizmo\APIResponse object
	 */
	public static function fetch($survey_id, $filters = null, $options = null) {
		if ($survey_id < 1) {
			throw new SurveyGizmoException(500, "Missing survey ID");
		}
		$response = self::_fetch(array('id' => '', 'survey_id' => $survey_id), $filter, $options);
		return $response;
	}

	/**
	 * Get Campaign Obj by survey id and campaign id
	 * @access public
	 * @param int $survey_id - survey id
	 * @param int $id - campaign id
	 * @return SurveyGizmo\Campaign object
	 */
	public static function get($survey_id, $id){
		if ($id < 1 && $survey_id < 1) {
			throw new SurveyGizmoException(500, "IDs required");
		}
		return self::_get(array(
			'survey_id' => $survey_id,
			'id' => $id,
		));
	}

	/**
	 * Save current Campaign Obj
	 * @access public
	 * @return SurveyGizmo\APIResponse object
	 */
	public function save()
	{
		return $this->_save(array(
			'survey_id' => $this->survey_id,
			'id' => $this->exists() ? $this->id : ''
		));
	}

	/**
	 * Delete current Campaign Obj
	 * @access public
	 * @return SurveyGizmo\APIResponse object
	 */
	public function delete(){
		return self::_delete(array(
			'survey_id' => $this->survey_id,
			'id' => $this->id,
		));
	}

	/**
	 * Fetch list of SurveyGizmo EmailMessage Objects by Campaign
	 * @access public
	 * @param SurveyGizmo\Filter $filter - SG Filter Object
	 * @return SurveyGizmo\APIResponse object
	 */
	public function getEmailMessages($filter = null)
	{
		return $this->getSubObjects("SurveyGizmo\\EmailMessage", $filter);
	}

	/**
	 * Get SurveyGizmo EmailMessage by id and Campaign
	 * @access public
	 * @param Int $email_id - email message id
	 * @return SurveyGizmo\EmailMessage object 
	 */
	public function getEmailMessage($email_id)
	{
		return $this->getSubObject("SurveyGizmo\\EmailMessage", $email_id);
	}

	/**
	 * Helper function to get Campaign sub objects
	 * @access private
	 * @param String $type - class name of object requested
	 * @param SurveyGizmo\Filter $filter - filter object
	 * @param Array $options
	 * @return SurveyGizmo\APIResponse Object
	 */
	private function getSubObjects($type, $filter = null, $options = null)
	{
		$options = array("survey_id" => $this->survey_id, 'campaign_id' => $this->id);
		return $type::fetch($this->survey_id, $this->id, $filter, $options);
	}

	/**
	 * Helper function to get single Campaign sub object
	 * @access private
	 * @param String $type - class name of object requested
	 * @param Int $id - sub object id
	 * @return SurveyGizmo\{$type} Object
	 */
	private function getSubObject($type, $id)
	{
		return $type::get($this->survey_id, $this->id, $id);
	}

}
