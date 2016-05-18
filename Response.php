<?php
namespace SurveyGizmo;
use SurveyGizmo\ApiResource;

class Response extends ApiResource {

	static $path = "/survey/{survey_id}/surveyresponse/{id}";

	public function __set($name, $value)
	{
		if ($name == 'survey_data') {
			$this->{$name} = json_decode(json_encode($value), 1);
		} else {
			$this->{$name} = $value;
		}
	}

	/**
	 * Saves current Response Object
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Response Object
	 */
	public function save(){
		// return parent::_save();
		return $this->_save(array(
			'survey_id' => $this->survey_id,
			'id' => $this->exists() ? $this->id : ''
		));
	}

	/**
	 * Get response object by response ID
	 * @param int $id - response id
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Response Object
	 */
	public static function get($survey_id, $id){
		// return parent::_get(get_class($this),$id);
		return self::_get(array(
			'survey_id' => $survey_id,
			'id' => $id
		));
	}
	

	/**
	 * Delete current Response Object
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Response Object
	 */
	public function delete(){
		// return parent::_delete();
		return self::_delete(array(
			'survey_id' => $this->survey_id,
			'id' => $this->id
		));
	}

	/**
	 * Return a list of Response Objects
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Response Object
	 */
	public static function fetch($survey_id, $filters = null, $options = null) {
		if ($survey_id < 1) {
			throw new SurveyGizmoException(500, "Missing survey ID");
		}
		$response = self::_fetch(array('id' => '', 'survey_id' => $survey_id), $filter, $options);
		return $response;
	}

	private function processSurveyData($survey_data){
		$payload_data = array();
		foreach ($survey_data as $question_sku => $question_data) {
			if(isset($question_data['subquestions'])){
				foreach ($question_data['subquestions'] as $sub_question_sku => $sub_question_data) {
					$data_to_process = array($sub_question_sku => array('options' => $sub_question_data));
					$process_sub_data = $this->processSurveyData($data_to_process);
					$payload_data[$sub_question_sku] = array_pop($process_sub_data);
				}
			}
			elseif (isset($question_data['options'])) {
				foreach ($question_data['options'] as $option_sku => $option_data) {
					$payload_data[$question_sku][$option_sku] = isset($option_data['answer']) ? $question_data['answer'] : null;
				}
			}
			else{
				$payload_data[$question_sku] = isset($question_data['answer']) ? $question_data['answer'] : null;
			}
		}
		return $payload_data;
	}

	/**
	 * Parse response object and set object properties, bypasses parents version
	 * so that we can set survey_data as an array
	 * @param String $type object type
	 * @param Array|Object $data object data
	 * @return Array $return array of SurveyGizmo\Response Object
	 */
	private static function _parseResponse($type, $data){
		$return = array();
		if(is_array($data)){
			foreach ($data as $item) {
				$obj = self::_formatData($type, $item);
				$return[] = $obj;
			}
		}
		elseif(is_object($data)){
			$return = self::_formatData($type, $data);
		}
		return $return;
	}

	// /**
	//  * Parse response object and set object properties, bypasses parents version
	//  * so that we can set survey_data as an array
	//  * @param String $type object type
	//  * @param Array|Object $data object data
	//  * @return SurveyGizmo\Response Object
	//  */
	// private static function _formatData($type, $item){
	// 	$obj = new $type;
	// 	foreach ($item as $property => $value) {
	// 		if($property == 'survey_data'){
	// 			$obj->$property = json_decode(json_encode($value),1);
	// 		}
	// 		else{
	// 	   		$obj->$property = $value;
	// 	   	}
	// 	}
	// 	return $obj;
	// }

	private function buildSaveDataPayload()
	{
		$data = $this->survey_data;
		$payload_data = $this->processSurveyData($data);
		unset($this->survey_data);
		$this->data = $payload_data;
	}

}
?>