<?php
namespace SurveyGizmo;

use SurveyGizmo\ApiRequest;
use SurveyGizmo\Helpers\SurveyGizmoException;

/**
 * Base class for all API objects, builds requests and formats responses.
 */
class ApiResource
{
	/**
	 * Fetches a list of resources using a HTTP GET request.
	 * @access public
	 * @static
	 * @param $params array (the parameters for the path, default null)
	 * @param $filter SurveyGizmo\Helpers\Filter (optional)
	 * @param $options array ('class' => class name to instantiate, optional)
	 * @return SurveyGizmo\Helpers\ApiResponse
	 */
	public static function _fetch($params = null, $filter = null, $options = null)
	{
		// Get the URL string
		$path = self::_mergePath(static::$path, $params);

		// New request instance
		$request = new ApiRequest("GET");
		$request->path = $path;
		$request->filter = $filter;
		// Add options such as `page`, `limit` to request
		$request->setOptions($options);
		// Execute request
		$request->execute();

		// Instance of SurveyGizmo\Helpers\ApiResponse
		$response = $request->getResponse();

		// Process the return
		if ($response->data) {
			// Determine the name of the class that will be instantiated
			$class_name = is_array($options) && isset($options['class']) ? $options['class'] : get_called_class();
			// Form objects from the data returned from the API
			$response->data = self::_parseObjects($class_name, $response->data);
			// Add extra parameters to each instance (e.g. survey_id)
			if (is_array($params)) {
				foreach ($response->data as $object) {
					foreach ($params as $key => $value) {
						if (!empty($value) && !isset($object->{$key})) {
							$object->{$key} = $value;
						}
					}
				}
			}
		}
		// Return the modified ApiResponse
		return $response;
	}

	/**
	 * Returns the specific instance of a resource using an HTTP GET.
	 * @access public
	 * @static
	 * @param $params array (the parameters for the path, default null)
	 * @param $options array ('class' => class name to instantiate, optional)
	 * @return mixed (instance of the called class or false if not found)
	 */
	public static function _get($params = null, $options = null)
	{
		// Get the URL string
		$path = self::_mergePath(static::$path, $params);

		// New GET request
		$request = new ApiRequest("GET");
		$request->path = $path;
		// Execute request
		$request->execute();

		// Instance of SurveyGizmo\Helpers\ApiResponse
		$response = $request->getResponse();

		// If the API returns an array of resources, fetch the first one
		if (is_array($response->data)) {
			$response->data = $response->data[0];
		}

		// Determine the name of class from the static function call
		$class_name = is_array($options) && $options['class'] ? $options['class'] : get_called_class();

		// Create the resource instance
		$object = self::_formatObject($class_name, $response->data);

		// If the resource was found, add extra parameters on the instance
		if ($object->exists()) {
			// Add extra parameters to the instance if the resource was found
			// E.g. survey_id
			if (is_array($params)) {
				foreach ($params as $key => $value) {
					if (!empty($value) && !isset($object->{$key})) {
						$object->{$key} = $value;
					}
				}
			}

			// Return resource instance
			return $object;
		}
		// Resource not found
		return false;
	}

	/**
	 * Performs an HTTP POST/PUT to update/insert the resource to the API.
	 * Method is called on a instance.
	 * @access public
	 * @param $params array (the parameters for the path, default null)
	 * @return SurveyGizmo\Helpers\ApiResponse
	 */
	public function _save($params = null)
	{
		// Get the URL string
		$path = self::_mergePath(static::$path, $params);

		// New request (POST if update, PUT if insert)
		$request = new ApiRequest($this->exists() ? 'POST' : 'PUT');
		$request->path = $path;
		// The request class pulls the data from this reference
		$request->data = get_object_vars($this);
		// Execute request
		$request->execute();

		// Instance of SurveyGizmo\Helpers\ApiResponse
		$response = $request->getResponse();

		// Update the current instance with the data from the API
		$this->_formatObject($this, $response->data);

		// Return the ApiResponse
		return $response;
	}

	/**
	 * Deletes the resource instance through the API. The object must exists first.
	 * Method is called on a instance.
	 * @access public
	 * @param $params array (the parameters for the path, default null)
	 * @return SurveyGizmo\Helpers\ApiResponse
	 */
	public function _delete($params = null)
	{
		// Determine whether this object actually exists in the API. Override the `exists`
		// method in the resource classes to change the behavior
		if (!$this->exists()) {
			throw new SurveyGizmoException(500, "Resource does not exist");
		}
		// Get the URL string
		$path = self::_mergePath(static::$path, $params);

		// New request HTTP DELETE
		$request = new ApiRequest('DELETE');
		$request->path = $path;
		// Execute request
		$request->execute();

		// Return ApiResponse
		return $request->getResponse();
	}

	/**
	 * Replaces the merge codes in a URL with the value from $options.
	 * @access public
	 * @static
	 * @param $path string (the URL)
	 * @param $options array (the array of merge code keys to value)
	 * @return string
	 */
	public static function _mergePath($path, array $options = null)
	{
		if (is_array($options)) {
			foreach ($options as $key => $value) {
				$path = str_replace('{' . $key . '}', $value, $path);
			}
		}
		return $path;
	}

	/**
	 * Loops through an array to create a collection of objects of type $type.
	 * @access protected
	 * @static
	 * @param $type string (name of class)
	 * @param $data array (data source)
	 * @return array
	 */
	protected static function _parseObjects($type, $data)
	{
		$return = array();
		if (is_array($data)) {
			foreach ($data as $item) {
				$return[] = self::_formatObject($type, $item);
			}
		}
		return $return;
	}

	/**
	 * Creates/updates the properties of a resource with the data from $item.
	 * @access protected
	 * @static
	 * @param $type mixed (name/instance of class)
	 * @param $attrs array/stdClass (data source)
	 * @return mixed (class instance)
	 */
	protected static function _formatObject($type, $attrs)
	{
		$obj = is_string($type) ? new $type : $type;
		if (is_object($attrs) || is_array($attrs)) {
			foreach ($attrs as $property => $value) {
				$obj->{$property} = $value;
			}
		}
		return $obj;
	}

	/**
	 * Helper function to determine if this instance has been loaded.
	 * @access public
	 * @return bool
	 */
	public function exists()
	{
		return isset($this->id) && $this->id > 0;
	}

	//BASE FUNCTIONS

	/**
	 * Method to retrieve a list of resources. By default this method is not supported.
	 * Extend in order to change behavior.
	 * @access public
	 * @static
	 * @return SurveyGizmo\Helpers\ApiResponse
	 */
	public static function fetch()
	{
		throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
	}

	/**
	 * Method to retrieve a single resource instance. By default this method is not supported.
	 * Extend in order to change behavior.
	 * @access public
	 * @static
	 * @param (ID's to request resources)
	 * @return mixed
	 */
	public static function get()
	{
		throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
	}

	/**
	 * Save the instance of this resource. By default this method is not supported.
	 * Extend in order to change behavior.
	 * @access public
	 * @return SurveyGizmo\Helpers\ApiResponse
	 */
	public function save()
	{
		throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
	}

	/**
	 * Deletes the instance of this resource. By default this method is not supported.
	 * Extend in order to change behavior.
	 * @access public
	 * @return SurveyGizmo\Helpers\ApiResponse
	 */
	public function delete()
	{
		throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
	}

}
