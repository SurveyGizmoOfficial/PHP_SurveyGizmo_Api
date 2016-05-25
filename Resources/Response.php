<?php
namespace SurveyGizmo\Resources;

use SurveyGizmo\ApiResource;
use SurveyGizmo\Helpers\SurveyGizmoException;

/**
 * Class for Survey Response API objects
 * Response is a sub-object of Surveys
 */
class Response extends ApiResource {

	/**
	 * API call path 
	 */
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
	 * @return SurveyGizmo\ApiResponse with SurveyGizmo\Response Object
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
	 * @return SurveyGizmo\Response Object
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
	 * @return SurveyGizmo\ApiResponse with SurveyGizmo\Response Object
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
	 * @return SurveyGizmo\ApiResponse
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
		//loop through each question 
		foreach ($survey_data as $question_sku => $question_data) {

			//Sub-questions (Tables, Custom Groups, etc.)
			if(isset($question_data['subquestions'])){
				foreach ($question_data['subquestions'] as $sub_question_sku => $sub_question_data) {
					//Account for slight differences in subquestion formatting
					if(!isset($sub_question_data['sku'])){
						$data_to_process = array($sub_question_sku => array('options' => $sub_question_data));
					}
					else{
						$data_to_process = array($sub_question_sku => $sub_question_data);
					}
					//process subquestions as if they are normal questions
					$process_sub_data = $this->processSurveyData($data_to_process);

					//certain complex questions (like some tables) will have sub_question that should be grouped on the parent sku
					if($sub_question_sku > 10000){
						$payload_data[$question_sku][$sub_question_sku] = array_pop($process_sub_data);
					}
					else{
						$payload_data[$sub_question_sku] = array_pop($process_sub_data);
					}
				}
			}
			//Options (checkbox, list of textbox, etc.)
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