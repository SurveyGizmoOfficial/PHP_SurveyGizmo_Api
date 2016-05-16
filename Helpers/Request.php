<?php namespace SurveyGizmo;
class Request{

	private $baseuri = 'trunk.qa.devo.boulder.sgizmo.com/services/rest/v4';

	function __construct($method = "GET"){
		$this->method = $method;
	}

	public function makeRequest(){

		$returnVal = null;
		try{
			//get creds

			$creds = SurveyGizmoAPI::getAuth();
			$this->uri = $this->buildURI($creds);
			//TODO: look at moving to guzzle at some point
			//var_dump($this->uri,$this->AuthToken,$this->AuthSecret);
			if(!empty($this->uri) && $this->AuthToken && $this->AuthSecret){
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $this->uri);
				curl_setopt($ch, CURLOPT_NOPROGRESS, 1);
				curl_setopt($ch, CURLOPT_VERBOSE, 0);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
				if($this->method == "PUT" || $this->method == "POST"){
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $this->buildPayload());
				}
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

				$buffer = curl_exec($ch);
				if ($buffer === false) {
					return false;
				}
				curl_close($ch);
				return json_decode($buffer);

			}
		}catch(Exception $ex){
			//throw our custom excpetion
		}
		return $returnVal;
	}

	private function buildPayload(){
		if($this->data){
			$post_data = http_build_query(get_object_vars($this->data));
			return $post_data;
		}else{
			return "";
		}
	}

	private function buildURI(array $creds){
//SurveyGizmoAPI::getAuth();
	//var_dump($creds);die;
		if($this->path && $creds['AuthToken'] && $creds['AuthSecret']){
			$this->AuthToken = $creds['AuthToken'];
			$this->AuthSecret = $creds['AuthSecret'];
			$uri = $this->baseuri . $this->path . ".json?api_token=" . urlencode($this->AuthToken) . "&api_token_secret=" . urlencode($this->AuthSecret) . "&_method=" . $this->method;
			//add filters if they exist
			if($this->filter){
			$uri .= $this->filter->buildRequestQuery();
			}
		}
		return $uri;
	}
}
?>
