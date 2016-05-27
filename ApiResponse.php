<?php
namespace SurveyGizmo;

/**
 * ApiResponse class stores the response of an API request.
 */
class ApiResponse
{

	/**
	 * Status.
	 * @var bool
	 */
	public $result_ok;

	/**
	 * Response code.
	 * @var int
	 */
	public $code;

	/**
	 * Error message.
	 * @var string
	 */
	public $message;

	/**
	 * Total # of records.
	 * @var int
	 */
	public $total_count;

	/**
	 * Page # of response.
	 * @var int
	 */
	public $page;

	/**
	 * Total # of pages available.
	 * @var int
	 */
	public $total_pages;

	/**
	 * Number of items per page.
	 * @var int
	 */
	public $results_per_page;

	/**
	 * Response data.
	 * @var stdClass
	 */
	public $data;

	/**
	 * Response HTTP code.
	 * @var int
	 */
	public $http_code;

	/**
	 * Takes the JSON decoded response from the ApiRequest class and sets the data
	 * on this instance.
	 * @access public
	 * @param $json_obj stdClass
	 * @return void
	 */
	public function parseBuffer($json_obj)
	{
		if (is_object($json_obj)) {
			$this->result_ok = $json_obj->result_ok;
			$this->code = $json_obj->code;
			$this->message = $json_obj->message;
			// Add meta data
			if (isset($json_obj->total_count)) {
				$this->total_count = $json_obj->total_count;
				$this->page = $json_obj->page;
				$this->total_pages = $json_obj->total_pages;
				$this->results_per_page = $json_obj->results_per_page;
			}
			$this->data = $json_obj->data;
		}
	}

}
