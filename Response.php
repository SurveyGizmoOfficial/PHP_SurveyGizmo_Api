<?php
namespace SurveyGizmo;
use SurveyGizmo\ApiResource;

class Response extends ApiResource {

	static $path = "/survey/{survey_id}/surveyresponse/{id}";

	/**
	 * set magic function to keep survey_data formatted the way we want
	 * @access public
	 * @param String $name - property name
	 * @param Mixed $value - property value
	 */
	public function __set($name, $value)
	{
		if ($name == 'survey_data') {
			$this->{$name} = json_decode(json_encode($value), 1);
		} else {
			$this->{$name} = $value;
		}
	}

	/**
	 * Fetch list of SurveyGizmo Response Objects by survey id
	 * @access public
	 * @param int $survey_id - Survey ID
	 * @param SurveyGizmo\Filter $filters - filter object
	 * @param Array $options
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Response Object
	 */
	public static function fetch($survey_id, $filters = null, $options = null) {
		if ($survey_id < 1) {
			throw new SurveyGizmoException(500, "Missing survey ID");
		}
		$response = self::_fetch(array('id' => '', 'survey_id' => $survey_id), $filter, $options);
		return $response;
	}

	/**
	 * Get Response object by survey id and response id
	 * @access public
	 * @param int $survey_id - survey id
	 * @param int $id - response id
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Response Object
	 */
	public static function get($survey_id, $id){
		return self::_get(array(
			'survey_id' => $survey_id,
			'id' => $id
		));
	}
	
	/**
	 * Saves current Response Object
 	 * @access public
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Response Object
	 */
	public function save(){
		$this->buildSaveDataPayload();
		return $this->_save(array(
			'survey_id' => $this->survey_id,
			'id' => $this->exists() ? $this->id : ''
		));
	}

	/**
	 * Delete current Response Object
	 * @access public
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Response Object
	 */
	public function delete(){
		return self::_delete(array(
			'survey_id' => $this->survey_id,
			'id' => $this->id
		));
	}

	/**
	 * Format survey_data into the data property so that it will post correctly
	 * @access private
	 * @param Array $survey_data - Response survey_data property
	 * @return Array $payload_data - formatted data. 
	 */
	private function processSurveyData($survey_data){
		$payload_data = array();
		foreach ($survey_data as $question_sku => $question_data) {
			if(isset($question_data['subquestions'])){
				foreach ($question_data['subquestions'] as $sub_question_sku => $sub_question_data) {
					if(!isset($sub_question_data['sku'])){
						$data_to_process = array($sub_question_sku => array('options' => $sub_question_data));
					}
					else{
						$data_to_process = array($sub_question_sku => $sub_question_data);
					}
					$process_sub_data = $this->processSurveyData($data_to_process);
					if($sub_question_sku > 10000){
						$payload_data[$question_sku][$sub_question_sku] = array_pop($process_sub_data);
					}
					else{
						$payload_data[$sub_question_sku] = array_pop($process_sub_data);
					}
				}
			}
			elseif (isset($question_data['options'])) {
				foreach ($question_data['options'] as $option_sku => $option_data) {
					$payload_data[$question_sku][$option_sku] = isset($option_data['answer']) ? $option_data['answer'] : null;
				}
			}
			else{
				$payload_data[$question_sku] = isset($question_data['answer']) ? $question_data['answer'] : null;
			}
		}
		return $payload_data;
	}

	/**
	 * Update save/POST payload to match API's expected format
	 * @access private
	 * @return void
	 */
	private function buildSaveDataPayload()
	{
		$data = $this->survey_data;
		$payload_data = $this->processSurveyData($data);
		unset($this->survey_data);
		$this->data = $payload_data;
	}

}
?>