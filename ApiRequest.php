<?php
namespace SurveyGizmo;

use SurveyGizmo\ApiResponse;
use SurveyGizmo\Helpers\SurveyGizmoException;
use SurveyGizmo\Helpers\Filter;

/**
 * ApiRequest class: performs the CURL requests to the API.
 */
class ApiRequest
{
	/**
	 * Optional instance of Filter.
	 * @var SurveyGizmo\Helpers\Filter null
	 */
	public $filter;

	/**
	 * Data that will be sent to the API.
	 * @var Array/stdClass null
	 */
	public $data;

	/**
	 * URL string of the SurveyGizmo REST API.
	 * @var string
	 */
	private static $API_URL = 'restapi.surveygizmo.com/v5';

	/**
	 * The JSON decoded return from the API.
	 * @var stdClass null
	 */
	private $request_return;

	/**
	 * HTTP code from API.
	 * @var int null
	 */
	private $request_http_code;

	/**
	 * Method type to use: GET, POST, PUT, DELETE.
	 * @var string null
	 */
	private $method;

	/**
	 * The result page number.
	 * @var int null
	 */
	private $page;

	/**
	 * The number of results to return.
	 * @var int null
	 */
	private $limit;

	/**
	 * Complete URL string.
	 * @var string null
	 */
	private $_url;

	/**
	 * Serialized data to be POSTed to the API.
	 * @var string null
	 */
	private $_post_data;

	/**
	 * Constructor: defaults the method type
	 * @access public
	 * @param $method string "GET"
	 * @return void
	 */
	public function __construct($method = "GET")
	{
		$this->method = $method;
	}

	/**
	 * Sets the URL and optional post data that will be sent to the API. Then calls
	 * the transport method to make the request.
	 * @access public
	 * @return void
	 */
	public function execute()
	{
		// The complete URL string
		$this->_url = $this->getCompleteUrl();
		// String of POST data
		$this->_post_data = $this->getPostData();

		// TODO: add option for transport type (CURL, Guzzle)
		// Default to CURL
		$this->requestByCURL();
	}

	/**
	 * Executes the CURL request to the API. Sets the results of the API call 
	 * on this instance.
	 * @access private
	 * @return void
	 */
	private function requestByCURL () {
		try {
			// Open CURL handle
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->_url);
			curl_setopt($ch, CURLOPT_NOPROGRESS, 1);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
			if ($this->method == "PUT" || $this->method == "POST") {
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_post_data);
			}
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			// Execute CURL request
			$buffer = curl_exec($ch);

			// Check HTTP status code
			$this->request_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			// Close CURL handle
			curl_close($ch);

			if ($buffer !== false) {
				$this->request_return = json_decode($buffer);
			}
		} catch (Exception $e) {
			new SurveyGizmoException(500, "CURL error", $e);
		}
	}

	/**
	 * Returns the serialized data that will be sent to the API by a POST/PUT request.
	 * @access private
	 * @return string
	 */
	private function getPostData () {
		$data = '';
		// Expects an array or stdClass
		if ($this->data) {
			$data = http_build_query($this->data);
		}
		return $data;
	}

	/**
	 * Constructs the complete URL for the API call using the API URL, the resource
	 * path, and the authentication credentials. Validates all parts of the URL are available first.
	 * @access private
	 * @param $creds array
	 * @return string
	 */
	private function getCompleteUrl()
	{
		// The API URL must be set
		if (!self::$API_URL) {
			new SurveyGizmoException(500, "ApiRequest: API URL required");
		}
		// The API resource URL must be set
		if (!$this->path) {
			new SurveyGizmoException(500, "ApiRequest: resource URL required");
		}
		// The request must be one of the 4 types
		if (!in_array($this->method, array('GET', 'POST', 'PUT', 'DELETE'))) {
			new SurveyGizmoException(500, "ApiRequest: invalid method type");
		}
		// The API credentials must be set prior to making a request
		$creds = SurveyGizmoAPI::getAuth();
		if (!$creds['AuthToken'] || !$creds['AuthSecret']) {
			new SurveyGizmoException(500, "ApiRequest: API credentials are required");
		}

		// Construct the array of parameters
		$params = array(
			'api_token' => $creds['AuthToken'],
			'api_token_secret' => $creds['AuthSecret'],
			'_method' => $this->method,
			'page' => $this->page,
			'resultsperpage' => $this->limit,
		);

		$uri = self::$API_URL . $this->path . ".json?" . http_build_query($params);

		// Add filter parameters if available
		if ($this->filter instanceof Filter) {
			$uri .= $this->filter->buildRequestQuery();
		}

		// Return the full URL
		return $uri;
	}

	/**
	 * Returns a new ApiResponse instance using the data returned from this request.
	 * @access public
	 * @return SurveyGizmo\ApiResponse
	 */
	public function getResponse()
	{
		$response = new ApiResponse();
		$response->parseBuffer($this->request_return);
		$response->http_code = $this->request_http_code;
		return $response;
	}

	/**
	 * Sets misc. options on the request, such as the page number and results per page for the API.
	 * Uses the same array that would be passed to a fetch method (e.g. Survey::fetch(null, array()))
	 * @access public
	 * @return void
	 */
	public function setOptions(array $options = null)
	{
		// Page # (default to first)
		if ($options['page'] >= 1) {
			$this->page = $options['page'];
		} else {
			$this->page = 1;
		}

		// Results per page (default to 50)
		if ($options['limit'] >= 1) {
			$this->limit = $options['limit'];
		} else {
			$this->limit = 50;
		}
	}

	/**
	 * Method to change the URL of the REST API domain for development purposes.
	 * SurveyGizmo\ApiRequest::setBaseURI('<DEV environment>/services/rest/v5');
	 * @access public
	 * @static
	 * @return void
	 */
	public static function setBaseURI($path)
	{
		self::$API_URL = $path;
	}

	/**
	 * Helper method for quick calls to the API. Creates a request, executes it, and
	 * returns the response object.
	 * @access public
	 * @static
	 * @param $path string
	 * @param $data null
	 * @param $options array null
	 * @param $filter null
	 * @return SurveyGizmo\ApiResponse
	 */
	public static function call ($path, $data = null, array $options = null, $filter = null) {
		$request = new ApiRequest;
		$request->path = '/' . $path;
		$request->data = $data;
		$request->filter = $filter;
		$request->setOptions($options);
		$request->execute();
		return $request->getResponse();
	}
}
