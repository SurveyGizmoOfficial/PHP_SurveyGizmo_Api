<?php namespace SurveyGizmo;
class Request{

	private $baseuri = 'app2.garrett.restapi.boulder.sgizmo.com/services/rest/v4';

	public function makeRequest(){
		$returnVal = null;
		//get creds
		$this->buildURI();
		//TODO: look at moving to guzzle at some point
		var_dump($this->uri,$this->AuthToken,$this->AuthSecret);
		if($this->uri && $this->AuthToken && $this->AuthSecret){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->uri);
			curl_setopt($ch, CURLOPT_NOPROGRESS, 1);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
			curl_setopt($ch, CURLOPT_POST, 0);
			//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$buffer = curl_exec($ch);

			if ($buffer === false) {
				return false;
			}
			curl_close($ch);
			return json_decode($buffer);

		}
		return $returnVal;
	}



	private function buildURI(){
		$creds = SurveyGizmoAPI::getAuth();
		if($this->path && $creds['AuthToken'] && $creds['AuthSecret']){
			$this->AuthToken = $creds['AuthToken'];
			$this->AuthSecret = $creds['AuthSecret'];
			$this->uri = $this->baseuri . $this->path . ".json?api_token=" . $this->AuthToken . "&api_token_secret=" . $this->AuthSecret;
			//add filters if they exist
		}
		return $this->uri;
	}
}
?>