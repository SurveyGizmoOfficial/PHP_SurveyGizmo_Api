<?php namespace SurveyGizmo;
class ApiResource{

	public static $obj;

	public static function _getPath($path, $append = ""){
		$path = !empty($append) ? $path . "/" . $append : $path;
		return $path;
	}

	public static function _fetch($type, $filter){
		$path = $type::getPath();
		$response = self::_makeRequest($path, $filter);
		if(isset($response)){
			$response->data = self::_parseObjects($type,$response->data);
			return $response;
		}else{
			return null;
		}
	}

	public static function _get($type, $id){
		$path = $type::getPath($id);
		$response = self::_makeRequest($path);
		if(isset($response)){
			return self::_formatObject($response->data);
		}else{
			return null;
		}
	}

	public function _save(){
		$response =  new Response();
		//determine save method
		$method = isset($this->id) ? "POST" : "PUT";
		$request = new Request($method);
		$request->path = $this->getPath($this->id);
		$request->data = $this;
		$results = $request->makeRequest();
		//format response
		$response->results = $results->result_ok;
		$response->code = $results->code;
		$response->message = $results->message;
		$response->data = $this->_formatObject(get_class($this),$results->data);
		return $response;
	}

	public function _delete(){
		$response =  new Response();
		//determine save method
		$method = "DELETE";
		$request = new Request($method);
		$request->path = $this->getPath($this->id);
		//$request->data = $this;
		$results = $request->makeRequest();
		//format response
		$response->results = $results->result_ok;
		$response->code = $results->code;
		$response->message = $results->message;
		return $response;
	}

	private static function _parseObjects($type, $data){
		$return = array();
		if(is_array($data)){
			foreach ($data as $item) {
				$obj = self::_formatObject($type, $item);
				$return[] = $obj;
			}
		}
		return $return;
	}

	private static function _formatObject($type, $item){
		$obj = new $type;
		foreach ($item as $property => $value) {
		   $obj->$property = $value;
		}
		return $obj;
	}

	private static function _makeRequest($path, $fitler){
		$request = new Request("get");
		$response = null;
		echo "making request";
		$request->path = $path;
		$request->filter = $filter;
		$data = $request->makeRequest();
		if(isset($data)){
			$response = new Response();		
			//add meta data
			if(isset($data->total_count)){
				$response->total_count = $data->total_count;
				$response->page = $data->page;
				$response->total_pages = $data->total_pages;
				$response->results_per_page = $data->results_per_page;
			}
			$response->data = $data->data;
		}
		return $response;
	}
}
?>