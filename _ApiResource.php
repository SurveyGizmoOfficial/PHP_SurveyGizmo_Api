<?php
namespace SurveyGizmo;

class ApiResource
{

	public static function _getPath($path, $append = "")
	{
		$path = !empty($append) ? $path . "/" . $append : $path;
		return $path;
	}

	public static function _mergePath($path, $options)
	{
		if (!is_array($options)) {
			$options = (array) $options;
		}
		foreach ($options as $key => $value) {
			$path = str_replace("{" . $key . "}", $value, $path);
		}
		return $path;
	}

	public static function _fetch($params = null, $filter = null, $options = null)
	{
		$path = self::_mergePath(static::$path, $params);

		$request = new Request("GET");
		$request->path = $path;
		$request->makeRequest();

		$response = $request->getResponse();
		if ($response->data) {
			$class_name = is_array($options) && $options['class'] ? $options['class'] : get_called_class();
			$response->data = self::_parseObjects($class_name, $response->data);
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
		return $response;
	}
	
	public static function _get($params = null, $options = null)
	{
		$path = self::_mergePath(static::$path, $params);

		$request = new Request("GET");
		$request->path = $path;
		$request->makeRequest();

		$response = $request->getResponse();

		$class_name = is_array($options) && $options['class'] ? $options['class'] : get_called_class();

		$object = self::_formatObject($class_name, $response->data);

		if (is_array($params)) {
			foreach ($params as $key => $value) {
				if (!empty($value) && !isset($object->{$key})) {
					$object->{$key} = $value;
				}
			}
		}
		return $object;
	}

	public function _save($params = null)
	{
		var_dump('expression123');//die;
		$path = self::_mergePath(static::$path, $params);
		$request = new Request($this->exists() ? 'POST' : 'PUT');
		$request->path = $path;
		$request->data = $this;
		$request->makeRequest();

		$response = $request->getResponse();

		$this->_formatObject($this, $response->data);

		return $response;
	}

	public function _delete($params = null)
	{
		if (!$this->exists()) {
			throw new SurveyGizmoException(500, "Resource does not exist");
		}
		$path = self::_mergePath(static::$path, $params);

		$request = new Request('DELETE');
		$request->path = $path;
		$request->makeRequest();

		return $request->getResponse();
	}

	private static function _parseObjects($type, $data)
	{
		$return = array();
		if (is_array($data)) {
			foreach ($data as $item) {
				$obj = self::_formatObject($type, $item);
				$return[] = $obj;
			}
		}
		return $return;
	}

	protected static function _formatObject($type, $item)
	{
		$obj = is_string($type) ? new $type : $type;
		foreach ($item as $property => $value) {
			$obj->$property = $value;
		}
		return $obj;
	}

	// protected static function _makeRequest($path, $filter)
	// {
	// 	$request = new Request("get");
	// 	$response = null;
	// 	$request->path = $path;
	// 	$request->filter = $filter;
	// 	$data = $request->makeRequest();
	// 	if (isset($data)) {
	// 		$response = new APIResponse();
	// 		//add meta data
	// 		if (isset($data->total_count)) {
	// 			$response->total_count = $data->total_count;
	// 			$response->page = $data->page;
	// 			$response->total_pages = $data->total_pages;
	// 			$response->results_per_page = $data->results_per_page;
	// 		}
	// 		$response->data = $data->data;
	// 	}
	// 	return $response;
	// }

	public function exists()
	{
		return $this->id > 0;
	}

	//BASE FUNCTIONS
	public static function fetch()
	{
		throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
	}
	public static function get()
	{
		throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
	}
	public function save()
	{
		throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
	}
	public function delete()
	{
		throw new SurveyGizmoException(SurveyGizmoException::NOT_SUPPORTED);
	}

}
