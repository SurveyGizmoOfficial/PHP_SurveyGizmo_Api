<?php namespace SurveyGizmo;
use SurveyGizmo\ApiResource;
use SurveyGizmo\iBaseInterface;
class Response extends ApiResource implements iBaseInterface{

	static $path = "/survey/{survey_id}/surveyresponse";

	/**
	 * Saves current Response Object
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Response Object
	 */
	public function save(){
		return parent::_save();
	}

	/**
	 * Get response object by response ID
	 * @param int $id - response id
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Response Object
	 */
	public static function get($id){
		return parent::_get(get_class($this),$id);
	}

	/**
	 * Delete current Response Object
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Response Object
	 */
	public function delete(){
		return parent::_delete();
	}

	/**
	 * Return a list of Response Objects
	 * @return SurveyGizmo\APIResponse with SurveyGizmo\Response Object
	 */
	public static function fetch($filters=null, $options=null){
		if(!$options['survey_id']){
			return new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
		}
		self::setPath($options);
		$path = self::getPath();
		$response = parent::_makeRequest($path, $filter);
		if(isset($response)){
			$type = get_class($this);
			$response->data = self::_parseResponse($type,$response->data);
			return $response;
		}else{
			return null;
		}
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
		return $return;
	}

	/**
	 * Parse response object and set object properties, bypasses parents version
	 * so that we can set survey_data as an array
	 * @param String $type object type
	 * @param Array|Object $data object data
	 * @return SurveyGizmo\Response Object
	 */
	private static function _formatData($type, $item){
		$obj = new $type;
		foreach ($item as $property => $value) {
			if($property == 'survey_data'){
				$obj->$property = json_decode(json_encode($value),1);
			}
			else{
		   		$obj->$property = $value;
		   	}
		}
		return $obj;
	}

	/**
	 * Get api call path
	 * @param String $append append uri
	 * @return String path
	 */
	public static function getPath($append = ""){
		return parent::_getPath(self::$path,$append);
	}

	/**
	 * Set api call path
	 * @param Array $options
	 */
	private static function setPath($options){
		self::$path = parent::_mergePath(self::$path,$options);
	}


	private function buildPayload()
	{
		if ($this->data) {
			$post_data = http_build_query(get_object_vars($this->data));
			return $post_data;
		} else {
			return "";
		}
	}
}
?>