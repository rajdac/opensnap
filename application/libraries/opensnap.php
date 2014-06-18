<?php

/**
 * Utility DTO for errors
 * @author Rajeev Singh
 *
 */
class ApiError{

    private $code;
    private $description;

    function __construct($_code){
        $this->code = $_code;
        $this->description = $this->getErrorDescriptionByCode( $this->code);
    }

    /**
     * Returns a string representation of the error in the requested forma
     * @param $format response format (json|xml)
     * @return string
     */
    function get($format='xml'){
        
        // don't bother: if not 'json', then 'xml!!
        if($format == 'json'){
            return $this->getAsJson();
        }
        return $this->getAsXml();
    }

    /**
     * composes json error message
     * @return String json error message
     */
    private function getAsJson(){
        $res = "{\"response\":{".
                "\"error\" :{\"code\" : \"$this->code\",".
              "\"description\" : \"$this->description\"}}}";
        return $res;
    }

    /**
     * composes xml error message
     * @return String xml error message
     */
    private function getAsXml(){
        $res = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>".
               "$this->code".
               "$this->description".
               "";

        return $res;
    }
     
    /**
     * Returns error description by code
     * Note: method takes into account only errors
     * that may be identified prior the api call
     * (see Errors page for updated codes) 
     * @param $errorCode
     * @return string: error description
     */
    private function getErrorDescriptionByCode($errorCode){
        $errorTable = array(		
			'400' => 'The request was not understood. Used for example when a required parameter was omitted.',
			'400' => 'Forbidden',
			'406' => 'The requested format isn’t available',
			'503' => 'The API is temporarily unavailable.',
			'500' => 'Internal Server Error', 
			'10010' => 'Missing parameter',
			'10020' => 'Invalid parameter', 
			'10040' => 'Too many parameters as primary key',
			'10050' => 'Too many mutual exclusive parameters',
			'14030' => 'Permission denied',
			'14040' => 'API not found'
        );
        if($errorTable[$errorCode]){
            return $errorTable[$errorCode];
        }
        return $errorCode;

    }
}
	
class CacheRequest {

    public static $cacheDir;
    public static $useCache;
	public static $cacheFilePrefix;
	
    public static function getCache($filepath, $hours = 1) 
    {
        if (!self::$useCache || !is_dir(self::$cacheDir) || !file_exists($filepath))     
            return false;

        $currentTime = time(); 
        $expireTime = $hours * 60 * 60; 
        $fileTime = filemtime($filepath);

        if ($currentTime - $expireTime < $fileTime)       
            return file_get_contents($filepath);
               
        // try to remove old file
        unlink($filepath);
        return false; // Expired. Get new.
    }

    public static function saveCache($filepath, $content)
    {
        if (self::$useCache && is_dir(self::$cacheDir))       
            return file_put_contents($filepath, $content);
        
    }

}

class RestRequest
{
	protected $url;
	protected $verb;
	protected $requestBody;
	protected $requestLength;
	protected $username;
	protected $password;
	protected $contentType;
	protected $acceptType;
	protected $responseBody;
	protected $responseInfo;
	
	public function __construct ($url = null, $verb = 'GET',$response_type='json', $requestBody = null)
	{
	    $this->response_type  = $response_type;
		$this->url            = $url;
		$this->verb           = $verb;
		$this->requestBody    = $requestBody;
		$this->requestLength  = 0;
		$this->username       = null;
		$this->password       = null;		
		$this->responseBody   = null;
		$this->responseInfo   = null;   

        if($response_type == 'xml'){
		 
			$this->contentType    = 'application/xml';
			$this->acceptType     = 'application/xml';
         
        }elseif($response_type == 'json'){
		 
			$this->contentType    = 'application/json';
			$this->acceptType     = 'application/json';
         
        }
          	
	}
  
	public function flush ()
	{
		$this->requestBody    = null;
		$this->requestLength  = 0;
		$this->verb        	  = 'GET';
		$this->responseBody   = null;
		$this->responseInfo   = null;
	}
  
    public function execute ()
    {
		$ch = curl_init();
		$this->setAuth($ch);
		
		try
		{
			switch (strtoupper($this->verb))
			{
				case 'GET':
				  $this->executeGet($ch);
				  break;
				case 'POST':
				  $this->executePost($ch);
				  break;
				case 'POSTFILE':
				  $this->executePostFile($ch);
				  break;
				case 'PUT':
				  $this->executePut($ch);
				  break;
				case 'DELETE':
				  $this->executeDelete($ch);
				  break;
				default:
				  throw new InvalidArgumentException('Current verb (' . $this->verb . ') is an invalid REST verb.');
			}
		}
		catch (InvalidArgumentException $e)
		{
		  curl_close($ch);
		  throw $e;
		}
		catch (Exception $e)
		{
		  curl_close($ch);
		  throw $e;
		}
    
    }

    protected function fetchFromCache($ch)
	{ 
	   
        $delimiter = (substr(CacheRequest::$cacheDir, -1) != "/") ? "/" : "";
        $filepath =   CacheRequest::$cacheDir . $delimiter . CacheRequest::$cacheFilePrefix .'GET_'. md5($url) .'.json';
		
		if(file_exists($filepath))
		{			
			$content = CacheRequest::getCache( $filepath);

			if (trim($content) != '' || $content != false )
			{
				$this->responseBody = $content;
				$this->responseInfo = 'cached';
				return;
			}
		}
		
		$this->doExecute($ch); 		
		$this->doExecute($ch); 		
	    CacheRequest::saveCache($filepath, $this->responseBody);
	} 
     
	protected function executeGet($ch)
	{ 
	   if(CacheRequest::$useCache)
		$this->fetchFromCache($ch);
	   else
		$this->doExecute($ch); 
		  
	}
  
	protected function executePost ($ch)
	{    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestBody);
		curl_setopt($ch, CURLOPT_POST, 1);
		if($this->response_type == 'xml')
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/xml', 'Content-Type: application/xml'));
        else
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
		$this->doExecute($ch);  
	}

	protected function executePostFile ($ch)
	{    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestBody);
		if($this->response_type == 'xml')
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/xml', 'Content-Type: application/octet-stream'));
        else
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/octet-stream'));
		
		curl_setopt($ch, CURLOPT_POST, 1);
    
		$this->doExecute($ch);      
	}
  
	protected function executePut ($ch)
	{
		$this->requestLength = strlen($this->requestBody);
    
		$fh = fopen('php://memory', 'rw');
		fwrite($fh, $this->requestBody);
		rewind($fh);
    
		curl_setopt($ch, CURLOPT_INFILE, $fh);
		curl_setopt($ch, CURLOPT_INFILESIZE, $this->requestLength);
		curl_setopt($ch, CURLOPT_PUT, true);
		if($this->response_type == 'xml')
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/xml', 'Content-Type: application/xml'));
        else
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
    
		$this->doExecute($ch);
    
		fclose($fh);
	}
  
	protected function executeDelete ($ch)
	{
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		if($this->response_type == 'xml')
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/xml', 'Content-Type: application/xml'));
        else
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
    
		$this->doExecute($ch);
	}
  
	protected function doExecute (&$curlHandle)
	{
		$this->setCurlOpts($curlHandle);
		$this->responseBody = curl_exec($curlHandle);
		$this->responseInfo = curl_getinfo($curlHandle);
		curl_close($curlHandle);
	}
  
	protected function setCurlOpts (&$curlHandle)
	{  
		curl_setopt($curlHandle, CURLOPT_TIMEOUT, 10);
		curl_setopt($curlHandle, CURLOPT_URL, trim($this->url));
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlHandle, CURLOPT_HEADER, true);
		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, !preg_match("!^https!i",$this->url));
	}
  
	protected function setAuth (&$curlHandle)
	{
		if ($this->username !== null && $this->password !== null)
		{
			curl_setopt($curlHandle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curlHandle, CURLOPT_USERPWD, $this->username . ':' . $this->password);
		}
	}
  
	public function getAcceptType ()
	{
		return $this->acceptType;
	} 
  
	public function setAcceptType ($acceptType)
	{
		$this->acceptType = $acceptType;
	} 
  
	public function getPassword ()
	{
		return $this->password;
	} 
  
	public function setPassword ($password)
	{
		$this->password = $password;
	} 
  
	public function getResponseBody ()
	{
		return $this->responseBody;
	} 
  
	public function getResponseInfo ()
	{
		return $this->responseInfo;
	} 
  
	public function getUrl ()
	{
		return $this->url;
	} 
  
	public function setUrl ($url)
	{
		$this->url = $url;
	} 
  
	public function getUsername ()
	{
		return $this->username;
	} 
  
	public function setUsername ($username)
	{
		$this->username = $username;
	} 
  
	public function getVerb ()
	{
		return $this->verb;
	} 
  
	public function setVerb ($verb)
	{
		$this->verb = $verb;
	} 

	public function getRequestBody ()
	{
		return $this->requestBody;
	} 
  
	public function setRequestBody ($body)
	{
		$this->requestBody = $body;
	} 

}

/**
 * OpenSnap - The ultimate PHP Wrapper to the Open Rice API
 *
 * Copyright (C) 2014 OpenRice
 *
 * <pre>
 *   This program is owned by openrice.
 
 * </pre>
 *
 * This is the controller class.
 * With an object of this class you may search or lookup detailed information
 * about a dishes or restaurant.
 *
 * Caching is activated per default. To deactivate id, change USE_CACH to false.
 * Change cache directory in the CACHE_DIR constant.
 *
 * If the Openrice URLS should change somehow, you can alter these in the constants
 * SERVICE_BASE_URL_SEARCH and SERVICE_BASE_URL_LOOKUP.
 * 
 * Example:
 * <code>
 * $opensnap = OpenSnap::getInstance();
 * $dishinfo = $opensnap->getDishes("location");
 * echo "First result: " . $dishinfo[0]->getTitle() . " by " . 
 *  $song[0]->getArtistAsString();
 * // Will result in:
 * // First result: The Dive by Superfamily
 * </code>
 *
 * <b>OpenSnap Disclaimer</b>
 * <i>This product uses a OPENRICE API but is not endorsed, certified or otherwise
 * approved in any way by openrice. Opensnap is the registered trade mark of the
 * Openrice Group.</i>
 *
 * @todo caching added - Alot of data cached? Flush capabillities?
 * @copyright OpenRice 2014
 * @author Rajeev Singh <rajdac@gmail.com>
 * @version 1.0
 * @package OpenRice
 */

if ( !class_exists('Opensnap') ) {

	if (session_id() == "") {
	
		@session_start();
	}
 
	class Opensnap {
	 		
		 /**
		 * The REST request object
		 *
		 * @var object
		 */
		 protected $request;
	  
		/**
		   * The base URL for API calls.
		   * example:
		   * http://mycompany.basecamphq.com/
		   *
		   * @var string
		   */
		protected $baseUri;

		/**
		  * The returned data format.
		  * possible values:
		  * <ul>
		  *  <li>simplexml -> return a SimpleXMLElement PHP object (default)</li>
		  *  <li>xml -> return an XML string</li>
		  * </ul>
		*
		 * @var string
		*/
	 
		protected $format;

		/**
		 * The API login username
		 *
		 * @var string
		*/
		protected $username;
	  
		/**
		 * The API login password
		 *
		 * @var string
		*/
		protected $password;

		/**
		 * The body of the API request
		 *
		 * @var string
		 */
		protected $request_body;
		
		/**
		 * Get allowed API methods, sorted by GET or POST
		 * Watch out for multiple-method "account/settings"!
		 *
		 * @return array $apimethods
		 */
		public function getApiMethods()
		{
			static $apimethods = array(
				'GET' => array(
					// Timelines
					'api/ApiGetPhotoListLatest',
					'api/ApiGetPhotoListTop',
					'api/ApiGetPhotoDetail',
					'api/ApiGetSearchTipFromSolr',
			        'api/api'
				),
				'POST' => array(
				 
					// OAuth
					'oauth/access_token',
					'oauth/request_token',
					'oauth2/token',
					'oauth2/invalidate_token'
				)
			);
			return $apimethods;
		}
		
			
		
		private $list = array();

	    /**
		  * The API endpoint to use
		*/
		protected static $_endpoint = 'http://android.azsg.api.opensnap.com';

	  
	   /**
		 * The current singleton instance
		 */
		private static $_instance = null;
		
		 /**
		 * The api consumer key of your registered app
		 */
		protected  $api_consumer_key = null;

		/**
		 * The corresponding consumer secret
		 */
		protected  $api_consumer_secret = null;
		
		 /**
		 * The corresponding consumer secret
		 */
		public $token;
		

		// Singelton-patterned class. No need to make an instance of this object 
		// outside it self. 
	    function __construct()
		{
		  $this->initCache();
		  $this->setBaseUri(SERVICE_BASE_URL);
		  $this->setFormat('json');
		}
		
		/**
		 * Sets the api consumer key and secret (App key)
		 *
		 * @param string $key    api consumer key
		 * @param string $secret api secret
		 *
		 * @return void
		 */
		public  function setConsumerKey($key, $secret)
		{
			$api_consumer_key    = $key;
			$api_consumer_secret = $secret;
		}
		
		
		private function initCache(){
			 
			CacheRequest::$useCache = USE_CACHE;
			CacheRequest::$cacheDir = CACHE_DIR;
			CacheRequest::$cacheFilePrefix = CACHE_FILE_PREFIX; 
			
			if ((!is_dir( CacheRequest::$cacheDir) || !is_writable( CacheRequest::$cacheDir)) && CacheRequest::$useCache) {
				throw new \Exception("No writable cache dir found: " . $cacheDir);
			}

		
		}

		 /**
		 * Returns singleton class instance
		 * Always use this method unless you're working with multiple authenticated users at once
		 *
		 * @return The Opensnap instance
		 */
		public static function getInstance()
		{
			if (self::$_instance == null) {
				self::$_instance = new self;
			}
			return self::$_instance;
		}

		/**
		 * Prevents cloning
		 * Cloning not allowed in a singelton patterned class
		 */
		public function __clone()
		{
			trigger_error('Clone is not allowed.', E_USER_ERROR);
		}
		  
		 /**
			* sleep every so often so openrice
			* doesn't complain about flooding.
			*
			* @return string $username
		*/  
		private function sleeper()
		{
			static $counter = 0;
		
			if($counter > 2) {
				sleep(1);
				$counter = 0;
			} else {
				$counter++;
			}
		}  
	  
		/* setters and getters */  
	  
		/**
		 * GetbaseUri
		 * @param $_baseUri = base URI for openrice API
		 */
		function setBaseUri($serviceurl){
		
			if(empty($serviceurl))
				throw new InvalidArgumentException("Api service URL/endpoint cannot be empty.");
			$this->baseUri = $serviceurl;
			$test = '/';
			if(! $check = substr_compare($this->baseUri , $test, -strlen($test), strlen($test)) == 0){
				$this->baseUri .= '/';
			}
		  
		}
		
		/**
		 * get baseuri
		 *
		 * @return string $baseurl
		*/  
		public function getBaseUri()
		{
			return $this->baseurl;
		}
		
		/**
		  * Sets the OAuth request or access token and secret (User key)
          *
          * @param string $token  Auth token
          *
          * @return void
        */
		public function setToken ($token) {
			// Sets an authentication token to use instead of the session variable
			$this->token = $token;
		}

		
		/**
		 * get request body
		 *
		 * @return string $request_body
		*/  
		public function getRequestBody()
		{
		  return $this->request_body;
		}

		/**
		 * set request body
		 *
		 * @param string $body
		 */  
		public function setRequestBody($body)
		{
		  $this->request_body = $body;
		}  
		
		/**
		  * get format
		  *
		  * @return string $format
		*/ 	
		public function getFormat()
		{
			return $this->format;
		}

		/**
		 * set format
		 *
		 * @param string $format
		*/  
		public function setFormat($format)
		{
			if(empty($format))
				throw new InvalidArgumentException("format cannot be empty.");
			$format = strtolower($format);
			if(!in_array($format,array('xml','simplexml','json')))
				throw new InvalidArgumentException("'{$format}' is not a valid format.");
			$this->format = $format;
		} 
	  
		/**
		 * get username
		 *
		 * @return string $username
		*/  
		public function getUsername()
		{
		  return $this->username;
		}

		/**
		 * set username
		 *
		 * @param string $username
		*/  
		public function setUsername($username)
		{
			if(empty($username))
				throw new InvalidArgumentException("username cannot be empty.");
			$this->username = $username;
		} 	
		
		/**
		 * get password
		 *
		 * @return string $password
		*/  
		public function getPassword()
		{
			return $this->password;
		}

		/**

		 * set password
		 *
		 * @param string $password
		*/  
		public function setPassword($password)
		{
			if(empty($password))
				throw new InvalidArgumentException("password cannot be empty.");
			$this->password = $password;
		}  
	  	
		
		/**
		 * Main API handler working on any requests you issue
		 *
		 * @param string $fn    The member function you called
		 * @param array $params The parameters you sent along
		 *
		 * @return mixed The API reply encoded in the set return_format
		 */

		public function __call($fn, $params)
		{
			// parse parameters			
			if ( is_array($params) && count($params) > 0) 
			{
				$params = $params[0];
				// remove auto-added slashes if on magic quotes steroids
				if (get_magic_quotes_gpc())
				{
					foreach($params as $key => $value)
					{
						if (is_array($value))
						{
							$params[$key] = array_map('stripslashes', $value);
							
						} else {
						
							$params[$key] = stripslashes($value);
						}
					}
				}
									
				$app_only_auth = FALSE;
				// stringify null and boolean parameters
				foreach ($params as $key => $value)
				{							
					if (! is_scalar($value))
					  continue;
					  
					if (is_null($value))
						$params[$key] = 'null';
					 elseif (is_bool($value)) 
						$params[$key] = $value ? 'true' : 'false';
					
				}
                
				/*
					if ($this->api_consumer_key == null) 
						throw new Exception('To use this api the consumer api key should be set');
						
					if ($this->api_consumer_secret == null) 
						throw new Exception('To use this api the consumer api secret should be set');	
					 
					//Process arguments, including method and login data.
					$params = array_merge(array("api_key" => $this->api_consumer_key,
												"api_token" => $this->api_consumer_secret), 
												$params);
				*/							
				
                $opts = $this->_getDefaultParams();
				
				$params = array_merge($opts,$params); 
				
				$app_only_auth = false;
				if (isset($params['auth_only']) ) {
					$app_only_auth = TRUE;
				}

				// map function name to API method
				$method = array();

				// replace _ by /
				$path = explode('_', $fn);
				
				// check mandatory parameters for any API call
				if(  empty($path[0]) || empty($path[1]) ){
					$error = new ApiError(1);
					return $error->get($format);
				}
				
				$method_template = $path[0].'/'.$path[1];
											
				for ($i = 2; $i < count($path); $i++) 
				   $method[] =  $path[$i];
				   
				$method = implode('.',$method);
			  
				$httpmethod = $this->_detectMethod($method_template);
							
				$multipart  = $this->_detectMultipart($method_template);

				return $this->_callApi(
					$httpmethod,
					$method,
					$method_template,
					$params,
					$multipart,
					$app_only_auth
				);
			
			}else{
			
			
			}
		}
		
		
		protected function _getDefaultParams()
		{
              
			$params['app_type']='snapandroidv1';
			$params['app_ver']='1.2.1';
			$params['auth_token']='CBFFBF92EF3504941E9D1D5B24D57899|igJQggWMyPuLA92ANtlEnzYmuW4=9c56a80817140138003455650830037610148|HK|0037610148';
			$params['lang']='en';
			$params['api_key']='API_TOEKN_SECRET';
			$params['api_token']='i0BKhLvjD3UqzDAWrEmC4Tv7hjs=8b05a90b1714013800144727267';
			$params['response_type']='json';
			$params['api_sig']='snap_web_sig';		
    
            return $params;	
        }		
	
		/**
		 * Calls the API using cURL
		 *
		 * @param string          $httpmethod      The HTTP method to use for making the request
		 * @param string          $method          The API method to call
		 * @param string          $method_template The templated API method to call
		 * @param array  optional $params          The parameters to send along
		 * @param bool   optional $multipart       Whether to use multipart/form-data
		 * @param bool   optional $app_only_auth   Whether to use app-only bearer authentication
		 *
		 * @return mixed The API reply, encoded in the set return_format
		 */

		protected function _callApi($httpmethod, $method, $method_template, $params = array(), $multipart = false, $app_only_auth = false)
		{
			if (! function_exists('curl_init'))		
			  throw new \Exception('To make API requests, the PHP curl extension must be available.');
			 
			$url = $this->_getEndpoint($method,$method_template);
		
			if ($httpmethod == 'GET')
			{          
				$url_with_params = $url;
				
				if (count($params) > 0)
				{				
				   $url_with_params .= '&' . http_build_query($params);
				}
			      
				// $authorization = $this->_sign($httpmethod, $url, $params);
				// $ch = curl_init($url_with_params);	 			
				return $this->fetchUrl($url_with_params,$httpmethod);
				
			}

		}
		
		/**
		 * Calls the Custom API using cURL
		 *
		 * @param string          $endpoint        The Base API URL
		 * @param array  optional $params          The parameters to send along
		 * @param string          $httpmethod      The HTTP method to use for making the request
		 * 
		 *
		 * @return mixed The API reply, encoded in the set return_format
		 */
		function callCustomApi($endpoint, $params,$httpmethod='GET')
		{								
			if (! function_exists('curl_init'))		
			  throw new \Exception('To make API requests, the PHP curl extension must be available.');
			   
			   $opts = $this->_getDefaultParams();			
			   $params = array_merge($opts,$params); // overwrite default params with same keys
			   $url_with_params = $endpoint;
		
			if ($httpmethod == 'GET')
			{          			
				if (count($params) > 0)
				{			
				   $url_with_params .=  '&' . http_build_query($params);
				}
			      
				// $authorization = $this->_sign($httpmethod, $url, $params);
				// $ch = curl_init($url_with_params);	 			
				return $this->fetchUrl($url_with_params,$httpmethod);
				
			}

		}

		/**
		 * Builds the complete API endpoint url
		 *
		 * @param string $method           The API method to call
		 * @param string $method_template  The API method template to call
		 *
		 * @return string The URL to send the request to
		 */
		protected function _getEndpoint($method, $method_template)
		{
		
			$url = self::$_endpoint . '/' . $method_template . '?method='. MODULE_PREFIX .'.'. $method;      
			return $url;
		}	
			
		/**
		 * Detects HTTP method to use for API call
		 *
		 * @param string $method The API method to call
		 * @param array  $params The parameters to send along
		 *
		 * @return string The HTTP method that should be used
		 */
		protected function _detectMethod($method)
		{
			$apimethods = $this->getApiMethods();
			foreach ($apimethods as $httpmethod => $methods) {
				if (in_array($method, $methods)) {
					return $httpmethod;
				}
			}
			throw new \Exception('Can\'t find HTTP method to use for "' . $method . '".');
		}

		/**
		 * Detects if API call should use multipart/form-data
		 *
		 * @param string $method The API method to call
		 *
		 * @return bool Whether the method should be sent as multipart
		 */
		protected function _detectMultipart($method)
		{
			$multiparts = array(
			  
				'account/update_profile_image'
			);
			return in_array($method, $multiparts);
		}
	/*	
	api.snap.hk.openrice.com/api/Sr1ForSnapApi.htm?method=or.poi.getlistforsnap&region_id=0&chain_id=10000052&maplat=&maplng=&city_id=1&keyword=&search_type=&ret_info=default%2Caddr&per_page=20&page=1&lang=en&not_nearby=0&app_type=snapandroidv1&app_ver=1.1.10&api_ver=302&api_key=API_TOEKN_SECRET&api_token=PwXl28R%2BxaqhkBbKt9uOyjA5KKg%3Df3ff91f41714020605150674411&response_type=json&api_sig=D9AFFF0B042FB46EF6821C2A1EDA8DA8


    api.snap.hk.openrice.com/api/Sr1ForSnapApi.htm?method=or.poi.getlistforsnap&region_id=0&app_type=snapandroidv1&app_ver=1.1.10&auth_token=CBFFBF92EF3504941E9D1D5B24D57899%7CigJQggWMyPuLA92ANtlEnzYmuW4%3D9c56a80817140138003455650830037610148%7CHK%7C0037610148&lang=en&api_key=API_TOEKN_SECRET&api_token=i0BKhLvjD3UqzDAWrEmC4Tv7hjs%3D8b05a90b1714013800144727267&response_type=json&api_sig=snap_web_sig&api_ver=302&city_id=1&page=1&per_page=24&free_text_tag=&free_text_tag_id=&photo_poi_type=&snap_poi_id=&or_poi_id=&or_region_id=&photo_sub_type=&dish_name=&cuisine_id=&district_id=&landmark_id=&amenity_id=&dish_id=&maplat=&maplng=&chain_id=10000052&order_by=submittime			
    */	

	/**
		  * executes the api call, chaining input parameters
		  * @param $parameters
		  * @param $request_type GET/PUT/POST/DELETE
		  * @param $format json/xml/simplexml
		  * @return string: the result returned by the service call
		*/
		function fetchUrl($url,$request_type='GET',$format='json')
		{
	       log_message('info', $url);
	      //die($url);  
			$this->request = new RestRequest($url,$request_type,$format);
			// $this->request->setUsername($this->username);
			// $this->request->setPassword($this->password);
		   
			$this->request->setRequestBody($this->request_body);		
			$this->request->execute();
				
			$return['response_info']  = $this->request->getResponseInfo();				
			$return['response_content'] = $this->request->getResponseBody();
			$return['headers'] =   substr($return['response_content'],0,$return['response_info']['header_size']);
			$return['body'] = substr($return['response_content'],$return['response_info']['header_size']);
				
			// grab status from headers
			if(preg_match('!^Status: (.*)$!m',$return['headers'],$match))
				$return['status'] = trim($match[1]);
			else
				$return['status'] = null;

			// grab location from headers
			if(preg_match('!^Location: (.*)$!m',$return['headers'],$match))
				$return['location'] = trim($match[1]);
			else
				$return['location'] = null;
				  
			// set output format
			if(!isset($format))
				$format = $this->format;
				  
			$return['body'] = trim($return['body']);
			if(!empty($return['body']) && $format == 'simplexml') {
				// return simplexml object
				$return['body'] = new SimpleXMLElement($return['body']);
			}
				
			// finished with request, release it
			unset($this->request);
			// clear the request body contents
			$this->request_body = null;
				
			return $return;
				 
			}
			
					
			/**
			  * setup the REST request body
			  *
			  * @param string $body
			*/  
			private function setupRequestBody($body) {
				$request_body = array('request'=>$body);
				$this->setRequestBody($this->createXMLFromArray($request_body));
			}  
			/**
			  * create XML from PHP array (recursive)
			  *
			  * @param array $array php arrays (of arrays) of values
			  * @return string $xml
		   */  
			private function createXMLFromArray($array,$level=0) {
				$xml = '';
				foreach($array as $key=>$val) {
					$attrs = '';
					// separate attributes if any
					if(($spos = strpos($key,' '))!==false) {
					  $attrs = substr($key,$spos);
					  $key = substr($key,0,$spos);
					}
					// hack to take multiple same-named keys :)
					if(($colpos = strpos($key,':'))!==false)
					  $key = substr($key,0,$colpos);
					// add to xml string. if array, recurse.
					$xml .= sprintf("%s<%s>%s</%s>\n",
					  str_repeat('  ',$level),
					  htmlspecialchars($key).$attrs,
					  is_array($val) ? "\n".$this->createXMLFromArray($val,$level+1).str_repeat('  ',$level) : htmlspecialchars($val),
					  htmlspecialchars($key)
					);
				}
				return $xml;
			}

		}

}