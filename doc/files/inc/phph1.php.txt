<?php
/**
* PHPH1 is a PHP class used to send JSON requests to the Harmony Node API
* and return the data in an array/JSON format.
*
* The PHPH1 class can also be invoked by a single PHP page hosted locally
* that will use GET data to fetch a result. The output can also be converted to JSON data (see phph1_call.php) with PHP's 
* json_encode() method and returned to the page for remote queries using scripting languages such as Javascript. This file, What is in the inc/boot.php file, and inc/config.php must be included in your project before invoking the PHPH1 class, for example, require_once('inc/config.php'); require_once('inc/phph1.php');. Once included the phph1 class can be invoked by setting a handle. In this project, inc/boot.php is included and invokes everything, checks if the Explorer settings have been changed, and validates most major required inputs prior to using any time/cycles to check any other input and sending the API call. You can use boot.php as an example to integrate things into your own custom project.
*
* @filesource
*/


/**
* The PHPH1 wrapper class.
*
* <p>When invoking the class there are certain variables that must be passed to the class for operation. All variables are required and are located in <a href='https://phph1.app/doc/files/inc-config.html'>inc/config.php</a> which means before invoking the class you will most likely want to require_once() the config file or set the configurations in your project somehow.</p>
* <p>See the <a href='https://phph1.app/doc/classes/phph1.html#method___construct'>__construct()</a> function for more information.</p>
*/
class phph1{
	
	// Try to keep this stuff in alphabetical order so it is easier to find
	
	/** @var integer $dorequest dorequest is a placeholder so the whole class knows the request has passed the first validation step of sending $_GET['dorequest'] in the method request url. This should help filter out some of the dumber bots. It is set to 0 by default and cannot be null */
	private int $dorequest = 0;
	
	/** @var string $lastjson lastjson is set while generating a method. It is stored to use later when the explorer displays its method results */
	private string $lastjson;
	
	/** @var integer $validinput is set while validating user input and is used to determine whether the method being used should be run or not. */
	private int $validinput = 0;	

	/** @var string $apiaddr The API address being used during this session. It is set during __construct by applying the $network and $shard inputs to the function getapiaddr(). It is set during __construct */
	private string $apiaddr;
	
	/** @var integer $default_pagesize Sets the default page size for methods that output multiple pages of data. It is set during __construct */
	private int $default_pagesize;
	
	/** @var array $goodinputs An array of validated input generated when validating method inputs. This is later used to populate any field forms after the request, if all fields are good, all fields get populated. */
	private array $goodinputs = array();
	
	/** @var array $errors An array of errors generated when creating the class handle and validating method inputs. This is later used to output any errors to the explorer method output page. */
	private array $errors = array();
	
	/** @var integer $max_pagesize Sets the maximum page size a multi-paged method output can output. This is mostly used to prevent a call from a user asking for a huge page size which could slow things down due to memory and network usage */
	private int $max_pagesize;
	
	/** @var string $network This sets the network currently being used for the API calls during __construct and is one from the $phph1_apiaddresses array set in inc/config.php. example "mainnet" */
	private string $network;
	
	/** @var booleen $phph1_debug Determines whether debug output is displayed in the explorer when a method is run. It is set during __construct */
	private int $phph1_debug;
	
	/** @var booleen $rpc_call Determines whether whether the current method being called is an rpc call. If set to 1, the explorer knows to not output anything but the raw json output from the API Node. inc/boot.php has the check and set for this varibale in it. The variable is usually set at the top of a page. You can see it inaction in phph1_call.php */
	private int $rpc_call = 0;
	
	/** @var string $rpc_url When a method is called and run, it generates the RPC URL and sets it here for output later on */
	private string $rpc_url;
	
	/** @var string $rpc_url When a method is called and run, it generates the RPC URL and sets it here for output later on */
	private array $rpc_posturl = [];
	
	//* @var integer $shard This is the index number of the shard from the $network array set during __construct. The shard MUST be defined in the <a href='https://phph1.app/doc/files/inc-config.html'>inc/config.php</a> $phph1_apiaddresses array. example: If 'mainnet' were selected for $network and we wanted to use shard 0, the value for this would be 0.
	private int $shard;
	
	/** @var array $phph1_apiaddresses This is set during _construct when the class is invoked and is defined in inc/config.php. This is a multi-dimensional array that holds the node and shard information. */
	private array $phph1_apiaddresses;
	
	/** @var array $phph1_methods This is set during __construct when the class is invoked and holds all available networks and shards in an array. It is defined in inc/config.php and set when creating the class handle in inc/boot.php */
	private array $phph1_methods;
	
	/** @var string $phph1_method The current method being used. It is set while validating input in inc/boot.php */
	private string $phph1_method;
	
	/** @var array $phph1_blockedaddr An array of blocked IP addresses set in inc/config.php This is set during __construct when the class is invoked. This gets ignored if the $phph1_allowedaddr array is not empty */
	private array $phph1_blockedaddr;
	
	/** @var array $phph1_allowedaddr An array of allowed IP addresses set in inc/config.php This is set during __construct when the class is invoked. When this is set, only the hpst addresses in the array are allowed to retrieve data. */
	private array $phph1_allowedaddr;
	
	/** @var phph1_allowbigdata Some requests have a page index (page number) option included in some of those options is the ability to use -1 as the index page. When using -1 the data set returned could possibly be huge causing a massive load on the server. By default using the -1 option is disabled to prevent this from happening. You can enable -1 page requests here by setting $phph1_allowbigdata to 1 in inc/config.php. UPDATE 2022-5-3: When last tested, none of the methods that are supposed to be able to use -1 according to the Harmony doc are not working and return an error. Since discovering this, I have staticly set this to 0 and and changing it in inc/config.php will not change anything. */
	private int $phph1_allowbigdata;
									
	/**
	* The __construct function is used to set PHPH1 configurations settings when invoking the class. The parameters are all REQUIRED when invoking the class
	*
	* @param array $phph1_apiaddresses This is set in <a href='https://phph1.app/doc/files/inc-config.html'>inc/config.php</a> and is an array of arrays, each array item is the network "name" such as "mainnet" and is an array itself of addresses used as shards for that network. For example $phph1_apiaddresses['mainnet'][0] would be an address for shard 0 on the mainnet network.
	*
	* @param array $phph1_methods This is set in <a href='https://phph1.app/doc/files/inc-config.html'>inc/config.php</a> and is an array of available methods by name. The array is used to verify that the method being called upon is a valid method. If the method is not in the array, all actions can be stopped before any input is used. You can also comment out methods in the <a href='https://phph1.app/doc/files/inc-config.html'>inc/config.php</a> to limit which methods are used in your project. This can also be extended with custom methods added to the phph1 class.
	*
	* @param integer $phph1_debug Set in <a href='https://phph1.app/doc/files/inc-config.html'>inc/config.php</a> and sets whether debugging output is on or off. Debugging output will present information concerning how the JSON call is being created through the process to aid in development. In most cases, this should be set to 0 to diable debugging.
	*
	* @param integer $max_pagesize This sets the maximum number of return items per page on API calls that return multiple pages of data in the explorer or your project. This is helpful in preventing huge return data sets which could present a heavy load on the web server or the web servers data throughput.
	*
	* @param integer $default_pagesize This sets the default page size for API calls that return pages of data. This is helpful in the Explorer and can also be used in your project when not using the explorer.
	*
	* @param string $network This sets the network currently being used for the API calls and is one from the $phph1_apiaddresses array set in inc/config.php. example "mainnet"
	*
	* @param integer $shard This is the index number of the shard from the $network array. The shard MUST be defined in the <a href='https://phph1.app/doc/files/inc-config.html'>inc/config.php</a> $phph1_apiaddresses array. example: If 'mainnet' were selected for $network above and we wanted to use chard 0, the value for this would be 0.
	*
	* @param array $phph1_blockedaddr This is a one per line array of IP addresses that should not be allowed to run methods. The array is set in <a href='https://phph1.app/doc/files/inc-config.html'>inc/config.php</a> and if left empty will block nobody. This array is ignored if the $phph1_allowedaddr array is not empty.
	*
	* @param array $phph1_allowedaddr This is a one per line array of IP addresses that are the only addresses allowed to run methods. The array is set in <a href='https://phph1.app/doc/files/inc-config.html'>inc/config.php</a> and if left empty will not be used. If this array is not empty, $phph1_blockedaddr will be ignored (due to redundancy).
	*
	* @param integer $phph1_allowbigdata Some requests have a page index (page number) option included in some of those options is the ability to use -1 as the index page. When using -1 the data set returned could possibly be huge causing a massive load on the server. By default using the -1 option is disabled to prevent this from happening. You can enable -1 page requests here by setting $phph1_allowbigdata to 1 in inc/config.php. UPDATE 2022-5-3: When last tested, none of the methods that are supposed to be able to use -1 according to the Harmony doc are not working and return an error. Since discovering this, I have staticly set this to 0 and and changing it in inc/config.php will not change anything.
	*
	* @return void
	*
	*/
	function __construct(array $phph1_apiaddresses, array $phph1_methods , int $phph1_debug, int $max_pagesize, int $default_pagesize, string $network, int $shard, ?array $phph1_blockedaddr, ?array $phph1_allowedaddr, int $phph1_allowbigdata){
		$this->phph1_apiaddresses = $phph1_apiaddresses;
		$this->apiaddr = $this->getapiaddr($network, $shard, $phph1_apiaddresses);
		$this->phph1_methods = $phph1_methods;
		$this->phph1_debug = $phph1_debug;
		$this->max_pagesize = $max_pagesize;
		$this->default_pagesize = $default_pagesize;
		$this->network = $network;
		$this->shard = $shard;
		$this->phph1_blockedaddr = $phph1_blockedaddr;
		$this->phph1_allowedaddr = $phph1_allowedaddr;
		// Currently disabled because the official nodes currently not allowing the -1 option
		// $this->phph1_allowbigdata = $phph1_allowbigdata;
		$this->phph1_allowbigdata = 0;		
	}
	
	/**
	* getapiaddr() is used to set the Node API host address during __construct. It gets the address using the network name and shard from $phph1_apiaddresses which is also set during __construct using settings from inc/config.php
	*
	* @param string $network The network name from the $phph1_apiaddresses array, default is mainnet
	* @param number $shard The network shard for the network we will be using, default is shard 0
	*
	* @return string The URL for the API Node that was selected
	*/
	function getapiaddr(string $network, int $shard, $phph1_apiaddresses){
		return $this->phph1_apiaddresses[$network][$shard];
	}
	
	/**
	* setrpc() is used to set the rpc_call variable that determines whether we are making a remote rpc call or using the explorer interface
	*
	* @param integer $rpc_call Accepts a value of 1(yes this is an rpc call) or 0 (data will be used in the explorer interface)
	*
	* @return booleen 1 = success, 0 = failure (in this case we should only have success)
	*/
	function set_rpc(int $rpc_call = 0){
		if($rpc_call == 0 OR $rpc_call == 1){
			$this->rpc_call = $rpc_call;
		}else{
			$this->rpc_call = 0;
		}
		return 1;
	}
	
	/**
	* set_booterrors() is used to import any pre class instantiation errors to the class errors array
	*
	* @param array $boot_errors An array or boot time errors created in boot.php
	*
	* @return booleen 1 = success, 0 = failure (in this case we should only have success)
	*/
	function set_booterrors(?array $boot_errors){
		if(!empty($boot_errors)){
			foreach($boot_errors as $anerror){
				array_push($this->errors, $anerror);
			}
		}
		return 1;
	}
	
	/**
	* phph1_reset() resets all dynamic class information after a request has been finished.
	* This is intended to be used for custom built applications using the class
	* so it can make multiple requests using a single class handle for a single page load
	*
	* @return booleen 1 = success
	*/
	function phph1_reset(){
		$this->lastjson = null;
		$this->validinput = 0;
		$this->goodinputs = array();
		$this->errors = array();
		$this->phph1_method = null;
		return 1;
	}
	
	/**
	* set_validinput() is used to set the validinput bit 1 (valid) or 0(not)
	* This is set after validating the input data for methods so the class knows if it is okay to make the RPC call
	*
	* @param integer $valid 1 = we have validated input, 0 = we an an invalid userinput in the request
	*
	* @return booleen 1 = all inputs are validated and valid, 0 = there was an invalid input for the requested method
	*/
	function set_validinput($valid){
		if($valid == 1 OR $valid == 0){
			$this->validinput = $valid;
		}else{
			$this->validinput = 0;
		}
	}
	
	/**
	* get_sessionnetwork() is used to get the current network we are working on
	* The network is set when creating a class handle in _construct and the settings are found in inc/config.php
	*
	* @return string The current network name the class is using (example: mainnet)
	*/
	function get_sessionnetwork(){
		if(!empty($this->network)){
			return $this->network;
		}else{
			return 0;
		}
	}
	
	/**
	* get_sessionshard() is used to get the current network shard we are working on
	* The network shard is set when creating a class handle in _construct and the settings array is found in inc/config.php
	*
	* @return string The current network shard the class is using (example: 0)
	*/
	function get_sessionshard(){
		return $this->shard;
	}
	
	/**
	* get_lastjson() is used to get the last (current) json request generated for a method
	* This is used later in the Method Explorer for educational output
	*
	* @return string The last (current) generated JSON request
	*/
	function get_lastjson(){
		if(!empty($this->lastjson)){
			return $this->lastjson;
		}else{
			return 0;
		}
	}
	
	/**
	* get_apiaddr() is used to get the currently used Node API address
	* The API address is set during _construct using the supplied network and shard information
	*
	* @return string The API address currently being used (example: https://a.api.s0.t.hmny.io/)
	*/
	function get_apiaddr(){
		if(!empty($this->apiaddr)){
			return $this->apiaddr;
		}else{
			return 0;
		}
	}
	
	/**
	* get_errors() is used to get the current array of errors from inc/boot.php and method requests
	* The error array is generated during the validation of method inputs
	*
	* @return array A list of errors from the currently run method
	*/
	function get_errors(){
		if(!empty($this->errors)){
			return $this->errors;
		}else{
			return 0;
		}
	}
	
	/**
	* get_methods() is used to get the current array of available methods which was set during _construct
	* The methods array is set in inc/config.php
	*
	* @return array A list of available methods
	*/
	function get_methods(){
		if(!empty($this->phph1_methods)){
			return $this->phph1_methods;
		}else{
			return 0;
		}
	}
	
	/**
	* get_currentmethod() is used to get the current method
	* The current method is set during _contruct when creating a class handle
	*
	* @return string Current method being used
	*/
	function get_currentmethod(){
		if(!empty($this->phph1_method)){
			return $this->phph1_method;
		}else{
			return 0;
		}
	}
	
	/**
	* get_rpcstatus() is used to check the current rpc status bit which is set when creating a class handle
	* This is used by the Method Explorer to determine what output to show, either graphical or raw json output for
	* RPC calls from external scripting languages
	*
	* @return integer Current RPC status
	*/
	function get_rpcstatus(){
		if(!empty($this->rpc_call)){
			return $this->rpc_call;
		}else{
			return 0;
		}
	}
	
	/**
	* get_rpcurl() is used to retrieve the current RPC URL.
	* The URL is set in _construct when creating the class handle
	* and is determined from the $phph1_apiaddresses array using 
	* the network and hsard settings in inc/config.php unless
	* settings have been set in the Method Explorer interface
	*
	* @return string Current RPC URL
	*/
	function get_rpcurl(){
		if(!empty($this->rpc_url)){
			return $this->rpc_url;
		}else{
			return 0;
		}
	}
	
	/**
	* get_rpcurl() is used to retrieve the current RPC URL.
	* The URL is set in _construct when creating the class handle
	* and is determined from the $phph1_apiaddresses array using 
	* the network and hsard settings in inc/config.php unless
	* settings have been set in the Method Explorer interface
	*
	* @return string Current RPC URL
	*/
	function get_rpcposturl(){
		if(!empty($this->rpc_posturl)){
			return $this->rpc_posturl;
		}else{
			return 0;
		}
	}
	
	/**
	* get_validinput() is used to retrieve the current input validation status
	* The validation status bit is set when validating user input
	*
	* @return integer Current input status 1 = good input, 0 = bad input
	*/
	function get_validinput(){
		if(!empty($this->validinput)){
			return $this->validinput;
		}else{
			return 0;
		}
	}
	
	/**
	* get_debugstatus() is used to determine if the script is running in debug mode or not 
	* The debug bit in the PHPH1 class is set during _construct and can be turned on and off in inc/config.php
	*
	* @return integer Current input status 1 = debugging on, 0 = debugging off
	*/
	function get_debugstatus(){
		if(!empty($this->phph1_debug)){
			return $this->phph1_debug;
		}else{
			return 0;
		}
	}
	
	/**
	* get_goodinput() gets a validated value from user input. 
	* When user input is being validated, every user form input that passes validation is
	* set in the goodinputs array. When repopulating a form after submission
	* only fields with valid input will populate from this list
	*
	* @return string Current value for the requested form field
	*/
	function get_goodinput($inputname){
		if(isset($this->goodinputs[$inputname])){
			return $this->goodinputs[$inputname];
		}else{
			return 0;
		}
	}
	
	/**
	* chk_goodinput() checks if a form field has successfully passed validation
	* by checking the goodinputs array which is filled during validation methods.
	* This is used to check before using get_goodinput() to retrieve the data.
	*
	* @return booleen 1 = the form field data has been validated and is good, 0 = bad input
	*/
	function chk_goodinput($inputname){
		if(isset($this->goodinputs[$inputname])){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* chk_dorequest() is used to check if we have form data submitted anf the request is valid enough to move forward
	*
	* @return booleen 1 = the form has been submitted, 0 = The form has not been submitted
	*/
	function chk_dorequest(){
		if($this->dorequest == 1){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* phph1_prepinput() is used to prepare userinput for validation
	*
	* @return string he requested input value
	*/
	function phph1_prepinput($forminput, $datatype){

		if(isset($_POST[$forminput])){
			$output = $_POST[$forminput];
		}elseif(isset($_GET[$forminput])){
			$output = $_GET[$forminput];
		}else{
			$output = null;
		}
		if($datatype == 'bool'){
			if($output == '1'){
				$output = true;
			}elseif($output == '0' OR empty($output)){
				$output = (bool)false;
			}
		}
		//echo $forminput.":".$_GET[$forminput].":".$output."<br />";
		return $output;
	}
	
	/** 
	* Check if we have a valid method input and make sure $_GET['method'] is in $phph1_methods array in the phph1 class
	* The methods array is set in config.php and loaded to the class in boot.php when the class handle is created
	* THEN it checks if $_POST['dorequest'] which is a hidden field in every method formis set and sets the class
	* variable $dorequest so it is known everywhere that a method form has been submitted
	*
	* @return booleen 1 = the form has been submitted, 0 = The form has not been submitted
	*/
	function chk_request(){
		// Check if we have a method input and make sure $_GET['method'] is in $phph1_methods array in the phph1 class
		// The methods array is set in config.php and loaded to the class in boot.php when the class handle is created
		if(isset($this->phph1_methods) && isset($_GET['method']) && in_array($_GET['method'], $this->phph1_methods)){
			$this->phph1_method = $_GET['method'];

			// Making sure we start at 0, no request
			$this->dorequest = 0;
			
			// See if we have submitted a method form. 
			// $_POST['dorequest'] will only ever have a single valid setting of 1
			// Otherwise somebody is trying to mess around and we need to kick their whole request immediately
			// This is mostly to prevent the dumber spam bots and such from loading the webserver down with requests.
			// dorequest is a hidden field in all method forms
			if((isset($_POST['dorequest']) && $_POST['dorequest'] == "1") OR (isset($_GET['dorequest']) && $_GET['dorequest'] == "1")){
				$this->dorequest = 1;
				return 1;
			}elseif((isset($_POST['dorequest']) && $_POST['dorequest'] != "1") OR (isset($_GET['dorequest']) && $_GET['dorequest'] != "1")){
				array_push($this->errors, 'Invalid Request');
				unset($_POST['dorequest']);
				$this->dorequest = 0;
				return 0;
			}
			
		}else{
			return 0;
		}
	}
	
	/** 
	* Check the client and report whether they are allowed to connect and make requests
	*
	* @return booleen 1 = the client is allowed access, 0 = The client is denied access
	*/
	function chk_access(){
		if(!empty($this->phph1_allowedaddr) && !in_array($_SERVER['REMOTE_ADDR'], $this->phph1_allowedaddr)){
			return 0;
		}elseif(!empty($this->phph1_blockedaddr) && in_array($_SERVER['REMOTE_ADDR'], $this->phph1_blockedaddr)){
			return 0;
		}else{
			return 1;
		}
	}
	
	/**
	* docurlrequest() takes the generated json request for the current method from genjsonrequest() and
	* makes the call to the API RPC Node. If rpc_call is set to 0, it generates a data object for output.
	* If rpc_call is set to 1, it returns the raw json output from API RPC Node.
	*
	* @param string $thisjson The JSON API request generated by genjsonrequest()
	*
	* @return object An object containing the output data
	*/
	function docurlrequest(string $thisjson){
		
		$requesthdr = [
				'Content-Type: application/json'
				];
		$apicon = curl_init($this->apiaddr);
		curl_setopt($apicon, CURLOPT_POSTFIELDS, $thisjson);
		curl_setopt($apicon, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($apicon, CURLOPT_HTTPHEADER, $requesthdr);
		$data = curl_exec($apicon);
		if($e = curl_error($apicon)) {
			return $e;
		}elseif($this->rpc_call == 1){
			if(!empty($data)){
				return $data;
			}else{
				return 0;
			}
		}else{
			$output = $data;
			if(!empty($output)){
				return $output;
			}else{
				return 0;
			}
		}
		curl_close($apicon);
		
	}
	
	/**
	* genjsonrequest() is used by the method functions to generate the JSON request for the Node API host
	*
	* @param string $method The method being used in this request. example: hmyv2_getBalance
	* @param array $paramsarr This is an array of the parameters for the method being called. It is formatted in each method function in this class
	*
	* @return string The formatted json data for this method request
	*/
	function genjsonrequest(string $method, array $paramsarr){
		
		if($this->phph1_debug == 1){
			echo "<p>PHPH1 FUNCTION genjsonrequest input array (paramsarr):</p><pre class='debugtext'>";
			print_r($paramsarr);
			echo "</pre>";
		}
		if(!empty($paramsarr)){
			$rdata = array(
				'jsonrpc' => "2.0",
				'id' => 1,
				'method' => $method,
				'params' => $paramsarr
			);
		}else{
			$rdata = array(
				'jsonrpc' => "2.0",
				'id' => 1,
				'method' => $method,
				'params' => [],
			);
		}
		if($this->phph1_debug == 1){
			echo "<p>PHPH1 FUNCTION genjsonrequest request data (rdata):</p><pre class='debugtext''>";
			print_r($rdata);
			echo "</pre>";
		}
		$thisjson = json_encode($rdata);
		$this->lastjson = $thisjson;
		if($this->phph1_debug == 1){
			echo "<p>PHPH1 FUNCTION genjsonrequest JSON request (thisjson):</p><pre class='debugtext''>";
			print_r($thisjson);
			echo "</pre>";
		}
		return $thisjson;
		
	}
	
	/**
	* genrequesturl() is used by the method functions to generate the PHPH1 request url for a method request
	*
	* @param string $method The method being used in this request. example: hmyv2_getBalance
	* @param array $paramsarr This is an array of the parameters for the method being called. It is formatted in each method function in this class
	*
	* @return string The URL to call from the method explorer page
	*/
	function genrequesturl(string $method, array $paramsarr){
		
		$thisrequesturl = 'phph1_call.php?dorequest=1&method='.$method;
		$thispostrequesturl = 'phph1_call.php?method='.$method;
		
		if(!empty($paramsarr)){
			foreach($paramsarr as $key => $value){
				if(is_array($value)){
					foreach($value as $key1 => $value1){
						$thisrequesturl = $thisrequesturl.'&'.$key1.'='.$value1;
					}
				}else{
					$thisrequesturl = $thisrequesturl.'&'.$key.'='.$value;
				}
			}
		}
		
		$this->rpc_posturl = array(
								'url' => $thispostrequesturl,
								'values' => $paramsarr
						);
		$this->rpc_url = $thisrequesturl;
		return 1;
	}
	
######################
### SMART CONTRACT ###
######################
	
	/**
	* hmyv2_call() Executes a new message call immediately, without creating a transaction on the block chain. The hmyv2_call method can be used to query internal contract state, to execute validations coded into a contract or even to test what the effect of a transaction would be without running it live.
	*
	* See <a href='/index.php?method=hmyv2_call'>Explorer method page</a> or <a href='https://api.hmny.io/#d34b1f82-9b29-4b68-bac7-52fa0a8884b1'>Harmony API Documentation</a> for output details.
	*
	* @param string $scaddress The ETH address the transaction was sent to
	* @param string $from The ETH address the transaction was sent from (optional)
	* @param string $gas Gas to execute the smart contract call (optional)
	* @param string $gasprice Gas price to execute smart contract call (optional)
	* @param string $value Value sent with the smart contract call (optional)
	* @param string $data Hash of smart contract method and parameters (optional)
	* @param number $blocknum Block number
	*
	* @return string Return value of the executed smart contract. 
	*/
	function hmyv2_call(string $scaddress, $from, $gas, $gasprice, $value, $data, int $blocknum){
		$method = "hmyv2_call";
		$urlparams = [
				
				'scaddress' => $scaddress,
				'from' => $from,
				'gas' => $gas,
				'gasPrice' => $gasprice,
				'value' => $value,
				'data' => $data,
				'blocknum' => $blocknum
			];
		$this->genrequesturl($method, $urlparams);
		$params = [
				[
				'to' => $scaddress,
				'from' => $from,
				'gas' => $gas,
				'gasPrice' => $gasprice,
				'value' => $value,
				'data' => $data
				],
				$blocknum
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* val_call() Validates user input for hmyv2_call()
	*
	* @param string $scaddress The ETH address the transaction was sent to
	* @param string $from The ETH address the transaction was sent from (optional)
	* @param string $gas Gas to execute the smart contract call (optional)
	* @param string $gasprice Gas price to execute smart contract call (optional)
	* @param string $value Value sent with the smart contract call (optional)
	* @param string $data Hash of smart contract method and parameters (optional)
	* @param number $blocknum Block number
	*
	* @return booleen 1 = Good input, 0 = bad input
	*/
	function val_call($scaddress, $fromaddr, $gas, $gasprice, $value, $data, $blocknum){
		
		$notvalid = 0;
		
		if(is_null($scaddress) OR (!is_null($scaddress) && $this->val_scaddress($scaddress) == 0)){
			$notvalid = 1; 
			array_push($this->errors, 'smart contract address is invalid');
		}else{
			$this->goodinputs['scaddress'] = $scaddress;
		}
		if(!is_null($fromaddr) && $this->val_ethaddr($fromaddr) == 0){
			$notvalid = 1; 
			array_push($this->errors, 'from address is invalid');
		}else{
			$this->goodinputs['fromaddr'] = $fromaddr;
		}
		if(!is_null($gas) && !preg_match( '/^0x[a-f0-9]+$/', $gas)){
			$notvalid = 1; 
			array_push($this->errors, 'gas value is invalid (hex required)');
		}else{
			$this->goodinputs['gas'] = $gas;
		}
		if(!is_null($gasprice) && !preg_match( '/^0x[a-f0-9]+$/', $gasprice)){
			$notvalid = 1; 
			array_push($this->errors, 'gasprice value is invalid (hex required)');
		}else{
			$this->goodinputs['gasprice'] = $gasprice;
		}
		if(!is_null($value) && !preg_match( '/^0x[a-f0-9]+$/', $value)){
			$notvalid = 1; 
			array_push($this->errors, 'value is invalid (hex required)');
		}else{
			$this->goodinputs['value'] = $value;
		}
		if(!is_null($data) && !preg_match( '/^0x[a-f0-9]+$/', $data)){
			$notvalid = 1; 
			array_push($this->errors, 'data value is invalid (hex required)');
		}else{
			$this->goodinputs['data'] = $data;
		}
		if(is_null($blocknum) OR (!is_null($blocknum) && !$this->val_blocknum($blocknum))){
			$notvalid = 1; 
			array_push($this->errors, 'block number is invalid');
		}else{
			$this->blocknum = $to;
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if($notvalid == 0){
			$this->set_validinput(1);
			return 1;
		}else{
			$this->set_validinput(0);
			return 0;
		}
	}
	
	/**
	* hmyv2_estimateGas() Generates and returns an estimate of how much gas is necessary to allow the transaction to complete. The transaction will not be added to the blockchain. Note that the estimate may be significantly more than the amount of gas actually used by the transaction, for a variety of reasons including EVM mechanics and node performance.
	*
	* See <a href='/index.php?method=hmyv2_estimateGas'>Explorer method page</a> or <a href='https://api.hmny.io/#b9bbfe71-8127-4dda-b26c-ff95c4c22abd'>Harmony API Documentation</a> for output details.
	*
	* @param string $toaddr The ETH wallet address the transaction would be sent to (required)
	* @param string $from The ETH wallet address the transaction would be sent from (optional)
	* @param string $gas Gas to execute the transaction (optional)
	* @param string $gasprice Gas price to execute the transaction (optional)
	* @param string $value Value sent with the transaction (optional)
	* @param string $data Hash of transaction method and parameters (optional)
	*
	* @return string Hex value of estimated gas price for the transaction.
	*/
	function hmyv2_estimateGas($toaddr, $from, $gas, $gasprice, $value, $data){
		$method = "hmyv2_estimateGas";
		$urlparams = [
				
				'toaddr' => $toaddr,
				'from' => $from,
				'value' => $value,
				'gas' => $gas,
				'gasPrice' => $gasprice,
				'data' => $data
				
			];
		$this->genrequesturl($method, $urlparams);
		$params = [
				[
				'to' => $toaddr,
				'from' => $from,
				'value' => $value,
				'gas' => $gas,
				'gasPrice' => $gasprice,
				'data' => $data
				]
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* val_estimateGas() Validates the user input for hmyv2_estimateGas()
	*
	* @param string $toaddr The ETH smart contract address the transaction would be sent to
	* @param string $from The ETH address the transaction would be sent from (optional)
	* @param string $gas Gas to execute the smart contract call (optional)
	* @param string $gasprice Gas price to execute smart contract call (optional)
	* @param string $value Value sent with the smart contract call (optional)
	* @param string $data Hash of smart contract method and parameters (optional)
	*
	* @return booleen 1 = Good input, 0 = bad input
	*/
	function val_estimateGas($toaddr, $fromaddr, $gas, $gasprice, $value, $data){
		$notvalid = 0;
		if(is_null($toaddr) OR !$this->val_ethaddr($toaddr)){
			$notvalid = 1; 
			array_push($this->errors, 'to address input is invalid');
			echo "bad";
		}else{
			$this->goodinputs['toaddr'] = $toaddr;
		}
		if(!empty($fromaddr) && !$this->val_ethaddr($fromaddr)){
			$notvalid = 1; 
			array_push($this->errors, 'from address input is invalid');
		}else{
			$this->goodinputs['fromaddr'] = $fromaddr;
		}
		if(!empty($gas) && !preg_match( '/^0x[a-f0-9]+$/', $gas)){
			$notvalid = 1; 
			array_push($this->errors, 'gas value input is invalid');
		}else{
			$this->goodinputs['gas'] = $gas;
		}
		if(!empty($gasprice) && !preg_match( '/^0x[a-f0-9]+$/', $gasprice)){
			$notvalid = 1; 
			array_push($this->errors, 'gasprice value input is invalid');
		}else{
			$this->goodinputs['gasprice'] = $gasprice;
		}
		if(!empty($value) && !preg_match( '/^0x[a-f0-9]+$/', $value)){
			$notvalid = 1; 
			array_push($this->errors, 'value input is invalid');
		}else{
			$this->goodinputs['value'] = $value;
		}
		if(!empty($data) && !preg_match( '/^0x[a-f0-9]+$/', $data)){
			$notvalid = 1; 
			array_push($this->errors, 'data value input is invalid');
		}else{
			$this->goodinputs['data'] = $data;
		}
		if($notvalid == 0){
			$this->set_validinput(1);
			return 1;
		}else{
			$this->set_validinput(0);
			return 0;
		}
	}
	
	/**
	* This method can be used to distinguish between contract addresses and wallet addresses.
	* Will return contract code if it's a contract and nothing (0x) if it's a wallet
	*
	* See <a href='/index.php?method=hmyv2_getCode'>Explorer method page</a> or <a href='https://api.hmny.io/#e13e9d78-9322-4dc8-8917-f2e721a8e556'>Harmony API Documentation</a> for output details.
	*
	* @param string $scaddress Smart contract address
	*
	* @param integer $blocknum Block number
	*
	* @return string Return value of the executed smart contract. 
	*/
	function hmyv2_getCode($scaddress, $blocknum){
		$method = "hmyv2_getCode";
		$urlparams = [
				'scaddress' => $scaddress,
				'blocknum' => $blocknum
				];
		$this->genrequesturl($method, $urlparams);
		$params = [
				$scaddress,
				$blocknum
				];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validates hmyv2_getCode input
	*
	* @param string $scaddress Smart contract address
	* @param integer $blocknum Block number
	*
	* @return string Return value of the executed smart contract. 
	*/
	function val_getCode($scaddress, $blocknum){
		$notvalid = 0;
		if(!$this->val_scaddress($scaddress)){
			$notvalid = 1; 
			array_push($this->errors, 'smart contract address is invalid');
		}else{
			$this->goodinputs['scaddress'] = $scaddress;
		}
		if(!$this->val_blocknum($blocknum)){
			$notvalid = 1; 
			array_push($this->errors, 'block number is invalid');
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Returns the value from a storage position at a given address, or in other words,
	* returns the state of the contract's storage, which may not be exposed via the contract's methods.
	*
	* See <a href='/index.php?method=hmyv2_getStorageAt'>Explorer method page</a> or <a href='https://api.hmny.io/#fa8ac8bd-952d-4149-968c-857ca76da43f'>Harmony API Documentation</a> for output details.
	*
	* @param string $scaddress Smart contract address
	* @param string $stlocation Hex representation of storage location
	* @param number $blocknum Block number
	*
	* @return string Data stored at the smart contract location. 
	*/
	function hmyv2_getStorageAt($scaddress, $stlocation, $blocknum){
		$method = "hmyv2_getStorageAt";
		$urlparams = [
				'scaddress' => $scaddress,
				'stlocation' => $stlocation,
				'blocknum' => $blocknum
				];
		$this->genrequesturl($method, $urlparams);
		$params = [
				$scaddress,
				$stlocation,
				$blocknum
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validation function for hmyv2_getStorageAt()
	*
	* @param string $scaddress Smart contract address
	* @param string $stlocation Hex representation of storage location
	* @param number $blocknum Block number
	*
	* @return booleen 1 = Good input, 0 = bad input
	*/
	function val_getStorageAt($scaddress, $stlocation, $blocknum){
		$notvalid = 0;
		if(!$this->val_scaddress($scaddress)){
			$notvalid = 1; 
			array_push($this->errors, 'smart contract address is invalid');
		}else{
			$this->goodinputs['scaddress'] = $scaddress;
		}
		if(!preg_match( '/^0x[a-f0-9]+$/', $stlocation)){
			$notvalid = 1; 
			array_push($this->errors, 'storage location hex value is invalid');
		}else{
			$this->goodinputs['stlocation'] = $stlocation;
		}
		if(!$this->val_blocknum($blocknum)){
			$notvalid = 1; 
			array_push($this->errors, 'block number is invalid');
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}

###############
### STAKING ###
###############

#############################
### STAKING -> DELEGATION ###
#############################
	
	/**
	* Get delegations by delegator address
	*
	* See <a href='/index.php?method=hmyv2_getDelegationsByDelegator'>Explorer method page</a> or <a href='https://api.hmny.io/#454b032c-6072-4ecb-bf24-38b3d6d2af69'>Harmony API Documentation</a> for output details.
	*
	* @param string $deladdr Delegator address
	*
	* @return array 
	*/
	function hmyv2_getDelegationsByDelegator($deladdr){
		$method = "hmyv2_getDelegationsByDelegator";
		$urlparams = ['oneaddr' => $deladdr];
		$this->genrequesturl($method, $urlparams);
		$params = [$deladdr];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validation function for hmyv2_getDelegationsByDelegator()
	*
	* @param string $oneaddr delegate ONE address
	*
	* @return booleen 1 = Good input, 0 = bad input
	*/
	function val_getDelegationsByDelegator($oneaddr){
		$notvalid = 0;
		if(!$this->val_oneaddr($oneaddr)){
			$notvalid = 1; 
			array_push($this->errors, 'delegator address value is invalid');
		}else{
			$this->goodinputs['oneaddr'] = $oneaddr;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Get delegations using delegator address and block number
	*
	* See <a href='/index.php?method=hmyv2_getDelegationsByDelegatorByBlockNumber'>Explorer method page</a> or <a href='https://api.hmny.io/#8ce13bda-e768-47b9-9dbe-193aba410b0a'>Harmony API Documentation</a> for output details.
	*
	* @param string $deladdr Delegator address
	* @param string $blocknum Block Number
	*
	* @return array 
	*/
	function hmyv2_getDelegationsByDelegatorByBlockNumber($oneaddr, $blocknum){
		$method = "hmyv2_getDelegationsByDelegatorByBlockNumber";
		$urlparams = [
			'oneaddr' => $oneaddr,
			'blocknum' => $blocknum
			];
		$this->genrequesturl($method, $urlparams);
		
		$params = [
			$oneaddr,
			$blocknum
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validation function for hmyv2_getDelegationsByDelegatorByBlockNumber()
	*
	* @param string $oneaddr Delegator address
	* @param string $blocknum Block Number
	*
	* @return integer good data = 1, bad data = 0
	*/
	function val_getDelegationsByDelegatorByBlockNumber($oneaddr, $blocknum){
		$notvalid = 0;
		if(!$this->val_oneaddr($oneaddr)){
			$notvalid = 1; 
			array_push($this->errors, 'delegator address value is invalid');
		}else{
			$this->goodinputs['oneaddr'] = $oneaddr;
		}
		if(!$this->val_blocknum($blocknum)){
			$notvalid = 1; 
			array_push($this->errors, 'block number value is invalid');
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Get delegations using validator address
	*
	* See <a href='/index.php?method=hmyv2_getDelegationsByDelegatorByBlockNumber'>Explorer method page</a> or <a href='https://api.hmny.io/#2e02d8db-8fec-41d9-a672-2c9862f63f39'>Harmony API Documentation</a> for output details.
	*
	* @param string $oneaddr Validator wallet address. This is validated in boot.php
	*
	* $return array List of delegations for the provided validator address
	*/
	function hmyv2_getDelegationsByValidator($oneaddr){
		$method = "hmyv2_getDelegationsByValidator";
		$urlparams = ['oneaddr' => $oneaddr];
		$this->genrequesturl($method, $urlparams);
		$params = [$oneaddr];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validation function for hmyv2_getDelegationsByValidator()
	*
	* @param string $oneaddr Validator address
	*
	* @return integer good data = 1, bad data = 0
	*/
	function val_getDelegationsByValidator($oneaddr){
		$notvalid = 0;
		if(is_null($oneaddr) OR !$this->val_oneaddr($oneaddr)){
			$notvalid = 1; 
			array_push($this->errors, 'validator address value is invalid');
		}else{
			$this->goodinputs['oneaddr'] = $oneaddr;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}

############################
### STAKING -> VALIDATOR ###
############################

	/**
	* Gets a list of wallet addresses that have created validators on the network.
	*
	* See <a href='/index.php?method=hmyv2_getAllValidatorAddresses'>Explorer method page</a> or <a href='https://api.hmny.io/#69b93657-8d3c-4d20-9c9f-e51f08c9b3f5'>Harmony API Documentation</a> for output details.
	*
	* @return array List of wallet addresses that have created validators on the network. 
	*/
	function hmyv2_getAllValidatorAddresses(){
		$method = "hmyv2_getAllValidatorAddresses";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Gets all information for all validators.
	*
	* See <a href='/index.php?method=hmyv2_getAllValidatorInformation'>Explorer Method Page</a> or <a href='https://api.hmny.io/#df5f1631-7397-48e8-87b4-8dd873235b9c'>Harmony API Documentation</a> for output details.
	*
	* @param number $pagenum Page to request (page size is 100), -1 for all validators (needs to be added to explorer)
	*
	* @return array List of all validator detailed information. 
	*/
	// FIXME This function uses a page variable. When using -1 to get all information, it uses a TON of memory. There is no way of knowing how many pages there are
	function hmyv2_getAllValidatorInformation(int $pagenum){
		$method = "hmyv2_getAllValidatorInformation";
		$urlparams = ['pagenum' => $pagenum];
		$this->genrequesturl($method, $urlparams);
		/*
		-1 is Currently disabled
		
		if($pagenum == -1){
			$pageindex = $pagenum;
		}else{
			$pageindex = $pagenum - 1;
		}
		*/
		$pageindex = $pagenum - 1;
		$params = [$pageindex];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validation function for hmyv2_getAllValidatorInformation()
	*
	* @param integer $pagenum Page number to display
	*
	* @return integer good data = 1, bad data = 0
	*/
	function val_getAllValidatorInformation($pagenum){
		$notvalid = 0;
		//if(preg_match( '/^[1-9]+[0-9]*$/', $pagenum) OR ($this->phph1_allowbigdata && $pagenum == -1)){
		// -1 is disabled on the offical nodes
		if(preg_match( '/^[1-9]+[0-9]*$/', $pagenum)){
			$this->goodinputs['pagenum'] = $pagenum;
		}else{
			$notvalid = 1; 
			array_push($this->errors, 'invalid page number');
		}
		if($notvalid == 0){
			$this->set_validinput(1);;
			return 1;
		}else{
			$this->set_validinput(0);;
			return 0;
		}
	}
	
	/**
	* Get all validator information by block number
	*
	* See <a href='/index.php?method=hmyv2_getAllValidatorInformationByBlockNumber'>Explorer Method Page</a> or <a href='https://api.hmny.io/#a229253f-ca76-4b9d-88f5-9fd96e40d583'>Harmony API Documentation</a> for output details.
	*
	* @param number $page Page to request (page size is 100), -1 for all validators (needs to be added to explorer)
	*
	* @param number $blocknum Block number
	*
	* @return array List of all validator detailed information. 
	*/
	function hmyv2_getAllValidatorInformationByBlockNumber(int $pagenum,int $blocknum){
		// -1 is disabled on the harmony nodes
		/*
		if($pagenum == -1){
			$pageindex = $pagenum;
		}else{
			$pageindex = $pagenum - 1;
		}
		*/
		$pageindex = $pagenum - 1;
		$method = "hmyv2_getAllValidatorInformationByBlockNumber";
		$urlparams = [
			'pagenum' => $pagenum,
			'blocknum' => $blocknum
			];
		$this->genrequesturl($method, $urlparams);
		$params = [
			$pageindex, 
			$blocknum
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validation function for hmyv2_getAllValidatorInformationByBlockNumber
	*
	* @param string $blocknum Block number
	*
	* @return integer good data =1, bad data = 0 
	*/
	function val_getAllValidatorInformationByBlockNumber(int $pagenum, int $blocknum){
		$notvalid = 0;
		if(is_null($blocknum) OR !$this->val_blocknum($blocknum)){
			$notvalid = 1; 
			array_push($this->errors, 'block number value is invalid');
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		// -1 is currently disabled on Harmony nodes
		// if(preg_match( '/^[1-9]+[0-9]*$/', $pagenum) OR ($this->phph1_allowbigdata && $pagenum == -1)){
		if(preg_match( '/^[1-9]+[0-9]*$/', $pagenum)){
			$this->goodinputs['pagenum'] = $pagenum;
		}else{
			$notvalid = 1; 
			array_push($this->errors, 'invalid page number');
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Get all elected Validator addresses
	*
	* See <a href='/index.php?method=hmyv2_getElectedValidatorAddresses'>Explorer Method Page</a> or <a href='https://api.hmny.io/#e90a6131-d67c-4110-96ef-b283d452632d'>Harmony API Documentation</a> for output details.
	*
	* @return array List of wallet addresses that are currently elected. 
	*/
	function hmyv2_getElectedValidatorAddresses(){
		$method = "hmyv2_getElectedValidatorAddresses";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Get all information for a validator
	*
	* See <a href='/index.php?method=hmyv2_getValidatorInformation'>Explorer Method Page</a> or <a href='https://api.hmny.io/#659ad999-14ca-4498-8f74-08ed347cab49'>Harmony API Documentation</a> for output details.
	*
	* @param string $valaddr The validator's wallet address
	*
	* @return array Array of validator detailed information. 
	*/
	function hmyv2_getValidatorInformation($valaddr){
		$method = "hmyv2_getValidatorInformation";
		$urlparams = ['oneaddr' => $valaddr];
		$this->genrequesturl($method, $urlparams);
		$params = [$valaddr];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validation function for hmyv2_getValidatorInformation
	*
	* @param string $oneaddr The validator's wallet address
	*
	* @return integer good data =1, bad data = 0 
	*/
	function val_getValidatorInformation($oneaddr){
		$notvalid = 0;
		if(is_null($oneaddr) OR !$this->val_oneaddr($oneaddr)){
			$notvalid = 1; 
			array_push($this->errors, 'validator address value is invalid');
		}else{
			$this->goodinputs['oneaddr'] = $oneaddr;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}

##########################
### STAKING -> NETWORK ###
##########################

	/**
	* Retrieves the current utility metrics
	*
	* See <a href='/index.php?method=hmyv2_getCurrentUtilityMetrics'>Explorer Method Page</a> or <a href='https://api.hmny.io/#78dd2d94-9ff1-4e0c-bbac-b4eec1cdf10b'>Harmony API Documentation</a> for output details.
	*
	* @return array Array of current utility metrics. 
	*/
	function hmyv2_getCurrentUtilityMetrics(){
		$method = "hmyv2_getCurrentUtilityMetrics";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Retrieves the median raw stake snapshot
	*
	* See <a href='/index.php?method=hmyv2_getMedianRawStakeSnapshot'>Explorer Method Page</a> or <a href='https://api.hmny.io/#bef93b3f-6763-4121-9c17-f0b0d9e5cc40'>Harmony API Documentation</a> for output details.
	*
	* @return array Array of current utility metrics. 
	*/
	function hmyv2_getMedianRawStakeSnapshot(){
		$method = "hmyv2_getMedianRawStakeSnapshot";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Retrieves current network staking information
	*
	* See <a href='/index.php?method=hmyv2_getStakingNetworkInfo'>Explorer Method Page</a> or <a href='https://api.hmny.io/#4a10fce0-2aa4-4583-bdcb-81ee0800993b'>Harmony API Documentation</a> for output details.
	*
	* @return array Array of current utility metrics. 
	*/
	function hmyv2_getStakingNetworkInfo(){
		$method = "hmyv2_getStakingNetworkInfo";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Retrieves current super committee information
	*
	* See <a href='/index.php?method=hmyv2_getSuperCommittees'>Explorer Method Page</a> or <a href='https://api.hmny.io/#8eef2fc4-92db-4610-a9cd-f7b75cfbd080'>Harmony API Documentation</a> for output details.
	*
	* @return array Array of current utility metrics. 
	*/
	function hmyv2_getSuperCommittees(){
		$method = "hmyv2_getSuperCommittees";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

###################
### TRANSACTION ###
###################

##################################
### TRANSACTION -> CROSS SHARD ###
##################################

	/**
	* Query the CX receipt hash on the receiving shard endpoint
	*
	* See <a href='/index.php?method=hmyv2_getCXReceiptByHash'>Explorer Method Page</a> or <a href='https://api.hmny.io/#3d6ad045-800d-4021-aeb5-30a0fbf724fe'>Harmony API Documentation</a> for output details.
	*
	* @param string $blockhash Cross shard receipt block hash
	*
	* @return array 
	*/
	function hmyv2_getCXReceiptByHash($txhash){
		$method = "hmyv2_getCXReceiptByHash";
		$urlparams = ['txhash' => $txhash];
		$this->genrequesturl($method, $urlparams);
		$params = [$txhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate the CX receipt transaction hash input for hmyv2_getCXReceiptByHash
	*
	* @param string $txhash Cross shard receipt transaction hash
	*
	* @return booleen good input = 1, bad input = 0
	*/
	function val_getCXReceiptByHash($txhash){
		$notvalid = 0;
		if(is_null($txhash) OR !$this->val_cxtxhash($txhash)){
			$notvalid = 1; 
			array_push($this->errors, 'cross shard receipt transaction hash input is invalid');
		}else{
			$this->goodinputs['txhash'] = $txhash;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Retrieves a list of currently pending cross shard transaction receipts
	*
	* See <a href='/index.php?method=hmyv2_getPendingCXReceipts'>Explorer Method Page</a> or <a href='https://api.hmny.io/#fe60070d-97b4-458d-9365-490b44c18851'>Harmony API Documentation</a> for output details.
	*
	* @return array Array of currently pending cross shard transaction receipts. 
	*/
	function hmyv2_getPendingCXReceipts(){
		$method = "hmyv2_getPendingCXReceipts";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Use this API call to resend the cross shard receipt to the receiving shard to re-process if the transaction did not pay out
	*
	* See <a href='/index.php?method=hmyv2_resendCx'>Explorer Method Page</a> or <a href='https://api.hmny.io/#fe60070d-97b4-458d-9365-490b44c18851'>Harmony API Documentation</a> for output details.
	*
	* @return bool If cross shard receipt was successfully resent (true) or not (false)
	*/
	function hmyv2_resendCx($txhash){
		$method = "hmyv2_resendCx";
		$urlparams = ['txhash' => $txhash];
		$this->genrequesturl($method, $urlparams);
		$params = [$txhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate the cross transaction receipt transaction hash input for hmyv2_resendCx
	*
	* @param string $txhash Cross shard receipt transaction hash
	*
	* @return booleen good input = 1, bad input = 0
	*/
	function val_resendCx($txhash){
		$notvalid = 0;
		if(is_null($txhash) OR !$this->val_cxtxhash($txhash)){
			$notvalid = 1; 
			array_push($this->errors, 'cross shard transaction hash input is invalid');
		}else{
			$this->goodinputs['txhash'] = $txhash;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}

#######################################
### TRANSACTION -> TRANSACTION POOL ###
#######################################

	/**
	* Retrieves current transaction pool stats
	*
	* See <a href='/index.php?method=hmyv2_getPoolStats'>Explorer Method Page</a> or <a href='https://api.hmny.io/#7c2b9395-8f5e-4eb5-a687-2f1be683d83e'>Harmony API Documentation</a> for output details.
	*
	* @return array Array of current transaction pool stats. 
	*/
	function hmyv2_getPoolStats(){
		$method = "hmyv2_getPoolStats";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Retrieves a list of currently pending staking transactions
	*
	* See <a href='/index.php?method=hmyv2_pendingStakingTransactions'>Explorer Method Page</a> or <a href='https://api.hmny.io/#de0235e4-f4c9-4a69-b6d2-b77dc1ba7b12'>Harmony API Documentation</a> for output details.
	*
	* @return array Array of currently pending staking transactions. 
	*/
	// FIXME TEST TO SEE WHAT IS WRONG
	function hmyv2_pendingStakingTransactions(){
		$method = "hmyv2_pendingStakingTransactions";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

	/**
	* Retrieves a list of currently pending transactions
	*
	* See <a href='/index.php?method=hmyv2_pendingTransactions'>Explorer Method Page</a> or <a href='https://api.hmny.io/#de6c4a12-fa42-44e8-972f-801bfde1dd18'>Harmony API Documentation</a> for output details.
	*
	* @return array Array of currently pending transactions. 
	*/
	function hmyv2_pendingTransactions(){
		$method = "hmyv2_pendingTransactions";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

##############################
### TRANSACTION -> STAKING ###
##############################

	/**
	* Retrieves a list of transaction errors currently in the staking error sink
	*
	* See <a href='/index.php?method=hmyv2_getCurrentStakingErrorSink'>Explorer Method Page</a> or <a href='https://api.hmny.io/#bdd00e0f-2ba0-480e-b996-2ef13f10d75a'>Harmony API Documentation</a> for output details.
	*
	* @return array Array of current transaction errors in the staking error sink. 
	*/
	function hmyv2_getCurrentStakingErrorSink(){
		$method = "hmyv2_getCurrentStakingErrorSink";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Use this API call to retrieve a staking transaction info using block number and transaction index
	*
	* See <a href='/index.php?method=hmyv2_getStakingTransactionByBlockNumberAndIndex'>Explorer Method Page</a> or <a href='https://api.hmny.io/#fb41d717-1645-4d3e-8071-6ce8e1b65dd3'>Harmony API Documentation</a> for output details.
	*
	* @param integer $blocknum Block number
	*
	* @param integer $txindex Staking transaction index
	*
	* @return array 
	*/
	function hmyv2_getStakingTransactionByBlockNumberAndIndex($blocknum,$txindex){
		$method = "hmyv2_getStakingTransactionByBlockNumberAndIndex";
		$urlparams = [
			'blocknum' => $blocknum,
			'txindex' => $txindex
			];
		$this->genrequesturl($method, $urlparams);
		$params = [
			$blocknum,
			$txindex
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for val_getStakingTransactionByBlockNumberAndIndex (blocknum is validated in boot.php)
	*
	* @param integer $blocknum Block number
	*
	* @param integer $txindex Staking transaction index
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_getStakingTransactionByBlockNumberAndIndex($blocknum,$txindex){
		$notvalid = 0;
		if(is_null($blocknum) OR !$this->val_blocknum($blocknum)){
			$notvalid = 1; 
			array_push($this->errors, 'block number value is invalid');
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if(!$this->val_txindex($txindex)){
			$notvalid = 1; 
			array_push($this->errors, 'transaction index value is invalid');
		}else{
			$this->goodinputs['txindex'] = $txindex;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Use this API call to retrieve a staking transaction info using block hash and transaction index
	*
	* See <a href='/index.php?method=hmyv2_getStakingTransactionByBlockHashAndIndex'>Explorer Method Page</a> or <a href='https://api.hmny.io/#ba96cf61-61fe-464a-aa06-2803bb4b'>Harmony API Documentation</a> for output details.
	*
	* @param string $blockhash Block number
	*
	* @param integer $txindex Staking transaction index
	*
	* @return array 
	*/
	//FIXME method handler crashed
	function hmyv2_getStakingTransactionByBlockHashAndIndex($blockhash,$txindex){
		//echo "txindex_method:".$txindex;
		$method = "hmyv2_getStakingTransactionByBlockHashAndIndex";
		$urlparams = [
			'blockhash' => $blockhash,
			'txindex' => $txindex
			];
		$this->genrequesturl($method, $urlparams);
		$params = [
			$blockhash,
			$txindex
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for hmyv2_getStakingTransactionByBlockHashAndIndex (blockhash is validated in boot.php)
	*
	* @param string $blockhash Block hash
	*
	* @param string $txindex Staking transaction index
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_getStakingTransactionByBlockHashAndIndex($blockhash,$txindex){
		$notvalid = 0;
		if(!$this->val_blockhash($blockhash)){
			$notvalid = 1; 
			array_push($this->errors, 'block hash input is invalid');
		}else{
			$this->goodinputs['blockhash'] = $blockhash;
		}
		if(!$this->val_txindex($txindex)){
			$notvalid = 1; 
			array_push($this->errors, 'transaction index value is invalid');
		}else{
			$this->goodinputs['txindex'] = $txindex;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Use this API call to retrieve a staking transaction info using the staking transaction hash (stkhash is validated in boot.php)
	*
	* See <a href='/index.php?method=hmyv2_getStakingTransactionByHash'>Explorer Method Page</a> or <a href='https://api.hmny.io/#296cb4d0-bce2-48e3-bab9-64c3734edd27'>Harmony API Documentation</a> for output details.
	*
	* @param string $hash Staking transaction hash
	*
	* @return array 
	*/
	function hmyv2_getStakingTransactionByHash($hash){
		$method = "hmyv2_getStakingTransactionByHash";
		$urlparams = ['hash' => $hash];
		$this->genrequesturl($method, $urlparams);
		$params = [$hash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for hmyv2_getStakingTransactionByHash
	*
	* @param string $hash Staking transaction hash
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_getStakingTransactionByHash($hash){
		if($this->val_hash($hash)){
			$this->goodinputs['hash'] = $hash;
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			array_push($this->errors, 'hash value is invalid');
			return 0;
		}
	}
	
	/**
	* Send a raw staking transaction using the hex representation of a signed staking transaction
	*
	* See <a href='/index.php?method=hmyv2_sendRawStakingTransaction'>Explorer Method Page</a> or <a href='https://api.hmny.io/#e8c17fe9-e730-4c38-95b3-6f1a5b1b9401'>Harmony API Documentation</a> for output details.
	*
	* @param string $transhex Hex representation of signed staking transaction
	*
	* @return string if successful returns staking transaction hash. If failed it returns an error
	*/
	// FIXME Needs tested
	function hmyv2_sendRawStakingTransaction($transhex){
		$method = "hmyv2_sendRawStakingTransaction";
		$urlparams = ['transhex' => $transhex];
		$this->genrequesturl($method, $urlparams);
		$params = [$transhex];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for hmyv2_sendRawStakingTransaction
	*
	* @param string $transhex Hex representation of signed staking transaction
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_sendRawStakingTransaction($transhex){
		if(preg_match('/^(0x|0X)?[a-fA-F0-9]+$/',$transhex)){
			$this->goodinputs['transhex'] = $transhex;
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			array_push($this->errors, 'transaction hex value is invalid');
			return 0;
		}
	}

###############################
### TRANSACTION -> TRANSFER ###
###############################

	/**
	* Retrieves a list of transaction errors currently in the transaction error sink
	*
	* See <a href='/index.php?method=hmyv2_getCurrentTransactionErrorSink'>Explorer Method Page</a> or <a href='https://api.hmny.io/#9aedbc22-6262-44b1-8276-cd8ae19fa600'>Harmony API Documentation</a> for output details.
	*
	* @return array Array of current errors in the transaction error sink. 
	*/
	function hmyv2_getCurrentTransactionErrorSink(){
		$method = "hmyv2_getCurrentTransactionErrorSink";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Use this API call to retrieve transaction info using block hash and transaction index (blockhash is validated in boot.php)
	*
	* See <a href='/index.php?method=hmyv2_getTransactionByBlockHashAndIndex'>Explorer Method Page</a> or <a href='https://api.hmny.io/#7c7e8d90-4984-4ebe-bb7e-d7adec167503'>Harmony API Documentation</a> for output details.
	*
	* @param string $blocknum Block blockhash
	*
	* @param integer $txindex Staking transaction index
	*
	* @return array 
	*/
	function hmyv2_getTransactionByBlockHashAndIndex($blockhash,$txindex){
		$method = "hmyv2_getTransactionByBlockHashAndIndex";
		$urlparams = [
			'blockhash' => $blockhash, 
			'txindex' => $txindex
			];
		$this->genrequesturl($method, $urlparams);
		$params = [
			$blockhash,
			$txindex
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for val_getTransactionByBlockHashAndIndex (blockhash is validated in boot.php)
	*
	* @param string $blockhash Block hash
	*
	* @param string $txindex Transaction index
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	// FIXME TXINDEX IS HANDLED WRONG
	function val_getTransactionByBlockHashAndIndex($blockhash,$txindex){
		$notvalid = 0;
		if(!$this->val_blockhash($blockhash)){
			$notvalid = 1; 
			array_push($this->errors, 'block hash input is invalid');
		}else{
			$this->goodinputs['blockhash'] = $blockhash;
		}
		if(!$this->val_txindex($txindex)){
			$notvalid = 1; 
			array_push($this->errors, 'transaction index value is invalid');
		}else{
			$this->goodinputs['txindex'] = $txindex;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Use this API call to retrieve transaction info using block number and transaction index
	*
	* See <a href='/index.php?method=hmyv2_getTransactionByBlockNumberAndIndex'>Explorer Method Page</a> or <a href='https://api.hmny.io/#bcde8b1c-6ab9-4950-9835-3c7564e49c3e'>Harmony API Documentation</a> for output details.
	*
	* @param integer $blocknum Block number
	*
	* @param integer $txindex Transaction index
	*
	* @return array 
	*/
	function hmyv2_getTransactionByBlockNumberAndIndex($blocknum,$txindex){
		$method = "hmyv2_getTransactionByBlockNumberAndIndex";
		$urlparams = [
			'blocknum' => $blocknum, 
			'txindex' => $txindex
			];
		$this->genrequesturl($method, $urlparams);
		$params = [$blocknum,$txindex];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for hmyv2_getTransactionByBlockNumberAndIndex (blocknum is validated in boot.php)
	*
	* @param integer $blocknum Block number
	*
	* @param integer $txindex Staking transaction index
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_getTransactionByBlockNumberAndIndex($blocknum,$txindex){
		$notvalid = 0;
		if(!$this->val_blocknum($blocknum)){
			$notvalid = 1; 
			array_push($this->errors, 'block number input value is invalid');
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if(!$this->val_txindex($txindex)){
			$notvalid = 1; 
			array_push($this->errors, 'transaction index input value is invalid');
		}else{
			$this->goodinputs['txindex'] = $txindex;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Use this API call to retrieve transaction info using the transaction hash
	*
	* See <a href='/index.php?method=hmyv2_getTransactionByHash'>Explorer Method Page</a> or <a href='https://api.hmny.io/#117e84f6-a0ec-444e-abe0-455701310389'>Harmony API Documentation</a> for output details.
	*
	* @param string $hash Transaction hash
	*
	* @return array 
	*/
	function hmyv2_getTransactionByHash($hash){
		$method = "hmyv2_getTransactionByHash";
		$urlparams = ['hash' => $hash];
		$this->genrequesturl($method, $urlparams);
		$params = [$hash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for hmyv2_getTransactionByHash
	*
	* @param integer $hash hash
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_getTransactionByHash($hash){
		$notvalid = 0;
		if(!$this->val_hash($hash)){
			$notvalid = 1; 
			array_push($this->errors, 'hash input value is invalid');
		}else{
			$this->goodinputs['hash'] = $hash;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Use this API call to retrieve transaction info using the transaction hash
	*
	* See <a href='/index.php?method=hmyv2_getTransactionByHash'>Explorer Method Page</a> or <a href='https://api.hmny.io/#117e84f6-a0ec-444e-abe0-455701310389'>Harmony API Documentation</a> for output details.
	*
	* @param string $transhash Transaction hash
	*
	* @return array 
	*/
	function hmyv2_getTransactionReceipt($hash){
		$method = "hmyv2_getTransactionReceipt";
		$urlparams = ['hash' => $hash];
		$this->genrequesturl($method, $urlparams);
		$params = [$hash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for hmyv2_getTransactionReceipt
	*
	* @param integer $hash hash
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_getTransactionReceipt($hash){
		$notvalid = 0;
		if(!$this->val_hash($hash)){
			$notvalid = 1; 
			array_push($this->errors, 'hash input value is invalid');
		}else{
			$this->goodinputs['hash'] = $hash;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Send a raw transaction using the hex representation of a signed transaction
	*
	* See <a href='/index.php?method=hmyv2_sendRawTransaction'>Explorer Method Page</a> or <a href='https://api.hmny.io/#f40d124a-b897-4b7c-baf3-e0dedf8f40a0'>Harmony API Documentation</a> for output details.
	*
	* @param string $transhex Hex representation of signed staking transaction
	*
	* @return string if successful returns staking transaction hash. If failed it returns an error
	*/
	// FIXME Needs tested, I don't think the Harmony docs are accurate with this one
	function hmyv2_sendRawTransaction($transhex){
		$method = "hmyv2_sendRawTransaction";
		$urlparams = ['transhex' => $transhex];
		$this->genrequesturl($method, $urlparams);
		$params = [$transhex];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for hmyv2_sendRawTransaction
	*
	* @param string $transhex Hex representation of signed staking transaction
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_sendRawTransaction($transhex){
		if(preg_match('/^(0x|0X)?[a-fA-F0-9]+$/',$transhex)){
			$this->goodinputs['transhex'] = $transhex;
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			array_push($this->errors, 'transaction hex value is invalid');
			return 0;
		}
	}

##################
### BLOCKCHAIN ###
##################

#############################
### BLOCKCHAIN -> NETWORK ###
#Need Finished:
#hmyv2_getLastCrossLinks - no return data?
#############################

	/**
	* Get the current block number
	*
	* See <a href='/index.php?method=hmyv2_blockNumber'>Explorer Method Page</a> or <a href='https://api.hmny.io/#2602b6c4-a579-4b7c-bce8-85331e0db1a7'>Harmony API Documentation</a> for output details.
	*
	* @return integer Current block number. 
	*/
	function hmyv2_blockNumber(){
		$method = "hmyv2_blockNumber";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Get the current circulating supply of tokens in ONE
	*
	* See <a href='/index.php?method=hmyv2_getCirculatingSupply'>Explorer Method Page</a> or <a href='https://api.hmny.io/#8398e818-ac2d-4ad8-a3b4-a00927395044'>Harmony API Documentation</a> for output details.
	*
	* @return integer Circulation supply of tokens in ONE. 
	*/
	function hmyv2_getCirculatingSupply(){
		$method = "hmyv2_getCirculatingSupply";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Get the current epoch
	*
	* See <a href='/index.php?method=hmyv2_getEpoch'>Explorer Method Page</a> or <a href='https://api.hmny.io/#8398e818-ac2d-4ad8-a3b4-a00927395044'>Harmony API Documentation</a> for output details.
	*
	* @return integer The current epoch. 
	*/
	function hmyv2_getEpoch(){
		$method = "hmyv2_getEpoch";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Get the last block for a specified epoch
	*
	* See <a href='/index.php?method=hmyv2_epochLastBlock'>Explorer Method Page</a> or <a href='https://api.hmny.io/#bd63c3aa-44cb-4f7d-8db2-50fb17e29d05'>Harmony API Documentation</a> for output details.
	*
	* @param integer $epoch Epoch number
	*
	* @return integer Last block of the given epoch 
	*/
	function hmyv2_epochLastBlock(int $epoch){
		$method = "hmyv2_epochLastBlock";
		$urlparams = ['epoch' => $epoch];
		$this->genrequesturl($method, $urlparams);
		$params = [$epoch];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for hmyv2_epochLastBlock
	*
	* @param integer $epoch Epoch number
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_epochLastBlock($epoch){
		$notvalid = 0;
		if(!$this->val_epoch($epoch)){
			$notvalid = 1; 
			array_push($this->errors, 'epoch input value is invalid');
		}else{
			$this->goodinputs['epoch'] = $epoch;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Get the current information on the last crosslinks
	*
	* See <a href='/index.php?method=hmyv2_getLastCrossLinks'>Explorer Method Page</a> or <a href='https://api.hmny.io/#4994cdf9-38c4-4b1d-90a8-290ddaa3040e'>Harmony API Documentation</a> for output details.
	*
	* @return array current information on the last crosslinks. 
	*/
	function hmyv2_getLastCrossLinks(){
		$method = "hmyv2_getLastCrossLinks";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Get the wallet address of current leader
	*
	* See <a href='/index.php?method=hmyv2_getLeader'>Explorer Method Page</a> or <a href='https://api.hmny.io/#8b08d18c-017b-4b44-a3c3-356f9c12dacd'>Harmony API Documentation</a> for output details.
	*
	* @return string Wallet address of current leader.
	*/
	function hmyv2_getLeader(){
		$method = "hmyv2_getLeader";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Gets the current average gas price of transactions
	*
	* See <a href='/index.php?method=hmyv2_gasPrice'>Explorer Method Page</a> or <a href='https://api.hmny.io/#1d53fd59-a89f-436c-a171-aec9d9623f48'>Harmony API Documentation</a> for output details.
	*
	* @return integer Current average gas price of transactions. 
	*/
	function hmyv2_gasPrice(){
		$method = "hmyv2_gasPrice";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Get a list of all shards and their information
	*
	* See <a href='/index.php?method=hmyv2_getShardingStructure'>Explorer Method Page</a> or <a href='https://api.hmny.io/#9669d49e-43c1-47d9-a3fd-e7786e5879df'>Harmony API Documentation</a> for output details.
	*
	* @return array Current shards on the network and their information. 
	*/
	function hmyv2_getShardingStructure(){
		$method = "hmyv2_getShardingStructure";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Get the total number of pre-mined tokens
	*
	* See <a href='/index.php?method=hmyv2_getTotalSupply'>Explorer Method Page</a> or <a href='https://api.hmny.io/#3dcea518-9e9a-4a20-84f4-c7a0817b2196'>Harmony API Documentation</a> for output details.
	*
	* @return integer Total number of pre-mined tokens. 
	*/
	function hmyv2_getTotalSupply(){
		$method = "hmyv2_getTotalSupply";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Get validator information from epoch number
	*
	* See <a href='/index.php?method=hmyv2_getValidators'>Explorer Method Page</a> or <a href='https://api.hmny.io/#4dfe91ad-71fa-4c7d-83f3-d1c86a804da5'>Harmony API Documentation</a> for output details.
	*
	* @param integer $epoch Epoch number (default is epoch 1 or everything)
	*
	* @return array Array of validators ONE addresses and some of their information. 
	*/
	function hmyv2_getValidators(int $epoch){
		$method = "hmyv2_getValidators";
		$urlparams = ['epoch' => $epoch];
		$this->genrequesturl($method, $urlparams);
		$params = [$epoch];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for hmyv2_getValidators
	*
	* @param integer $epoch Epoch number
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_getValidators($epoch){
		$notvalid = 0;
		if(!$this->val_epoch($epoch)){
			$notvalid = 1; 
			array_push($this->errors, 'epoch input value is invalid');
		}else{
			$this->goodinputs['epoch'] = $epoch;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Get validator information from epoch number
	*
	* See <a href='/index.php?method=hmyv2_getValidatorKeys'>Explorer Method Page</a> or <a href='https://api.hmny.io/#1439b580-fa3c-4d44-a79d-303390997a8c'>Harmony API Documentation</a> for output details.
	*
	* @param integer $epoch Epoch number (default is epoch 1 or everything)
	*
	* @return array List of public BLS keys in the elected committee. 
	*/
	function hmyv2_getValidatorKeys(int $epoch){
		$method = "hmyv2_getValidatorKeys";
		$urlparams = ['epoch' => $epoch];
		$this->genrequesturl($method, $urlparams);
		$params = [$epoch];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for hmyv2_getValidatorKeys
	*
	* @param integer $epoch Epoch number
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_getValidatorKeys($epoch){
		$notvalid = 0;
		if(!$this->val_epoch($epoch)){
			$notvalid = 1; 
			array_push($this->errors, 'epoch input value is invalid');
		}else{
			$this->goodinputs['epoch'] = $epoch;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}

##########################
### BLOCKCHAIN -> NODE ###
##########################
	
	/**
	* Gets a list of bad blocks in node memory
	*
	* See <a href='/index.php?method=hmyv2_getCurrentBadBlocks'>Explorer Method Page</a> or <a href='https://api.hmny.io/#0ba3c7b6-6aa9-46b8-9c84-f8782e935951'>Harmony API Documentation</a> for output details. NOTE: This method currently has known issues with the RPC not returning correctly.
	*
	* @return array List of bad blocks in node memory 
	*/
	function hmyv2_getCurrentBadBlocks(){
		$method = "hmyv2_getCurrentBadBlocks";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Gets the current node metadata.
	*
	* See <a href='/index.php?method=hmyv2_getNodeMetadata'>Explorer Method Page</a> or <a href='https://api.hmny.io/#03c39b56-8dfc-48ce-bdad-f85776dd8aec'>Harmony API Documentation</a> for output details.
	*
	* @return array List of bad blocks in node memory 
	*/
	function hmyv2_getNodeMetadata(){
		$method = "hmyv2_getNodeMetadata";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Gets the current network protocol version.
	*
	* See <a href='/index.php?method=hmyv2_protocolVersion'>Explorer Method Page</a> or <a href='https://api.hmny.io/#cab9fcc2-e3cd-4bc9-b62a-13e4e046e2fd'>Harmony API Documentation</a> for output details.
	*
	* @return number Protocol version
	*/
	function hmyv2_protocolVersion(){
		$method = "hmyv2_protocolVersion";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Gets the current number of peers on the network in the form of a hex string.
	*
	* See <a href='/index.php?method=net_peerCount'>Explorer Method Page</a> or <a href='https://api.hmny.io/#09287e0b-5b61-4d18-a0f1-3afcfc3369c1'>Harmony API Documentation</a> for output details.
	*
	* @return number Protocol version in hex
	*/
	function net_peerCount(){
		$method = "net_peerCount";
		$params = [];
		$this->genrequesturl('net_peercount', $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

############################
### BLOCKCHAIN -> BLOCKS ###
#Need Adjusted:
#hmyv2_getBlockSigners
############################

	/**
	* Gets block information on a series of blocks between two block numbers.
	*
	* See <a href='/index.php?method=hmyv2_getBlocks'>Explorer Method Page</a> or <a href='https://api.hmny.io/#ab9bdc59-e482-436c-ab2f-10df215cd0bd'>Harmony API Documentation</a> for output details.
	*
	* @param integer $strtblocknum Starting block number
	*
	* @param integer $endblocknum Ending block number
	*
	* @param booleen $fulltx Include full transaction data
	*
	* @param booleen $withsigners Include the block signers information
	*
	* @param booleen $inclstaking Include staking transactions
	*
	* @return array List of blocks and the information for each block searched
	*/
	function hmyv2_getBlocks($blocknum,$blocknum2,$fulltx,$withsigners,$inclstaking){
		$method = "hmyv2_getBlocks";
		$urlparams = [
				'blocknum1' => $blocknum,
				'blocknum2' => $blocknum2,
				'fulltx' => $fulltx,
				'withsigners' => $withsigners,
				'inclstaking' => $inclstaking
			];
		$this->genrequesturl($method, $urlparams);
		$params = [
				$blocknum,
				$blocknum2,
				[
				'fullTx' => $fulltx,
				'withSigners' => $withsigners,
				'inclStaking' => $inclstaking
				]
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validates the input for hmyv2_getBlocks().
	*
	* @param integer $blocknum Starting block number
	* @param integer $endblocknum Ending block number
	* @param booleen $fulltxt Include full transaction data
	* @param booleen $withsigners Include the block signers information
	* @param booleen $inclstaking Include staking transactions
	*
	* @return booleen 1 = good data, 0 = bad data
	*/
	function val_getBlocks($blocknum,$blocknum2,$fulltx,$withsigners,$inclstaking){
		$notvalid = 0;
		if(!$this->val_blocknum($blocknum)){
			$notvalid = 1; 
			array_push($this->errors, 'starting block number value is invalid');
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if(!$this->val_blocknum($blocknum2)){
			$notvalid = 1; 
			array_push($this->errors, 'ending block number value is invalid');
		}else{
			$this->goodinputs['blocknum2'] = $blocknum2;
		}
		if($fulltx != 'TRUE' && $fulltx != FALSE){
			$notvalid = 1; 
			array_push($this->errors, 'fulltx value is invalid');
		}else{
			$this->goodinputs['fulltx'] = $fulltx;
		}
		if($inclstaking != 'TRUE' && $inclstaking != FALSE){
			$notvalid = 1; 
			array_push($this->errors, 'inclstaking value is invalid');
		}else{
			$this->goodinputs['inclstaking'] = $inclstaking;
		}
		if($withsigners != 'TRUE' && $withsigners != FALSE){
			$notvalid = 1; 
			array_push($this->errors, 'withsigners value is invalid');
		}else{
			$this->goodinputs['withsigners'] = $withsigners;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}

	/**
	* Gets block information using the specified block number.
	*
	* See <a href='/index.php?method=hmyv2_getBlockByNumber'>Explorer Method Page</a> or <a href='https://api.hmny.io/#52f8a4ce-d357-46f1-83fd-d100989a8243'>Harmony API Documentation</a> for output details.
	*
	* @param integer $blocknum Block number
	*
	* @param booleen $fulltxt Include full transaction data
	*
	* @param booleen $incltx Include regular transactions
	*
	* @param booleen $withsigners Include the block signers information
	*
	* @param booleen $inclstaking Include staking transactions
	*
	* @return array The block information
	*/
	function hmyv2_getBlockByNumber($blocknum, $fulltx, $incltx, $withsigners, $inclstaking){
		$method = "hmyv2_getBlockByNumber";
		$urlparams = [
				'blocknum' => $blocknum,
				'fulltx' => $fulltx,
				'incltx' => $incltx,
				'inclstaking' => $inclstaking,
				'withsigners' => $withsigners
				];
		$this->genrequesturl($method, $urlparams);
		$params = [
				$blocknum,
				[
				'fullTx' => $fulltx,
				'inclTx' => $incltx,
				'inclStaking' => $inclstaking,
				'withSigners' => $withsigners
				]
				];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validates the input data for hmyv2_getBlockByNumber().
	*
	* @param integer $blocknum Block number
	*
	* @param booleen $fulltxt Include full transaction data
	*
	* @param booleen $incltx Include regular transactions
	*
	* @param booleen $withsigners Include the block signers information
	*
	* @param booleen $inclstaking Include staking transactions
	*
	* @return booleen 1 = good data, 0 = bad data
	*/
	function val_getBlockByNumber($blocknum,$fulltx,$incltx,$withsigners,$inclstaking){
		$notvalid = 0;
		if(!$this->val_blocknum($blocknum)){
			$notvalid = 1; 
			array_push($this->errors, 'block number value is invalid');
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if($fulltx != 'TRUE' && $fulltx != FALSE){
			$notvalid = 1; 
			array_push($this->errors, 'fulltx value is invalid');
		}else{
			$this->goodinputs['fulltx'] = $fulltx;
		}
		if($incltx != 'TRUE' && $incltx != FALSE){
			$notvalid = 1; 
			array_push($this->errors, 'incltx value is invalid');
		}else{
			$this->goodinputs['incltx'] = $incltx;
		}
		if($inclstaking != 'TRUE' && $inclstaking != FALSE){
			$notvalid = 1; 
			array_push($this->errors, 'inclstaking value is invalid');
		}else{
			$this->goodinputs['inclstaking'] = $inclstaking;
		}
		if($withsigners != 'TRUE' && $withsigners != FALSE){
			$notvalid = 1; 
			array_push($this->errors, 'withsigners value is invalid');
		}else{
			$this->goodinputs['withsigners'] = $withsigners;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Gets block information using the specified block hash.
	*
	* See <a href='/index.php?method=hmyv2_getBlockByHash'>Explorer Method Page</a> or <a href='https://api.hmny.io/#6a49ec47-1f74-4732-9f04-e5d76160bd5c'>Harmony API Documentation</a> for output details.
	*
	* @param string $blockhash Block hash
	*
	* @param booleen $fulltx Include full transaction data
	*
	* @param booleen $incltx Include regular transactions
	*
	* @param booleen $withsigners Block hash
	*
	* @param booleen $inclstaking Include staking transactions
	*
	* @return array Block information. 
	*/
	function hmyv2_getBlockByHash($blockhash,$fulltx,$incltx,$withsigners,$inclstaking){
		$method = "hmyv2_getBlockByHash";
		$urlparams = [
				'blockhash' => $blockhash,
				'fulltx' => $fulltx,
				'incltx' => $incltx,
				'withsigners' => $withsigners,
				'inclstaking' => $inclstaking
				];
		$this->genrequesturl($method, $urlparams);
		$params = [
				$blockhash,
				[
				'fullTx' => $fulltx,
				'inclTx' => $incltx,
				'withSigners' => $withsigners,
				'inclStaking' => $inclstaking
				]
				];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validates the input data for hmyv2_getBlockByHash()
	*
	* @param string $blockhash Block hash
	*
	* @param booleen $fulltx Include full transaction data
	*
	* @param booleen $incltx Include regular transactions
	*
	* @param booleen $withsigners Block hash
	*
	* @param booleen $inclstaking Include staking transactions
	*
	* @return booleen 1 = good data, 0 = bad data
	*/
	function val_getBlockByHash($blockhash,$fulltx,$incltx,$withsigners,$inclstaking){
		$notvalid = 0;
		if(!$this->val_blockhash($blockhash)){
			$notvalid = 1; 
			array_push($this->errors, 'block hash value is invalid');
		}else{
			$this->goodinputs['blockhash'] = $blockhash;
		}
		if($fulltx != 'true' && $fulltx != false){
			$notvalid = 1; 
			array_push($this->errors, 'fulltx value is invalid');
		}else{
			$this->goodinputs['fulltx'] = $fulltx;
		}
		if($incltx != 'true' && $incltx != false){
			$notvalid = 1; 
			array_push($this->errors, 'incltx value is invalid');
		}else{
			$this->goodinputs['incltx'] = $incltx;
		}
		if($withsigners != 'true' && $withsigners != false){
			$notvalid = 1; 
			array_push($this->errors, 'withsigners value is invalid');
		}else{
			$this->goodinputs['withsigners'] = $withsigners;
		}
		if($inclstaking != 'true' && $inclstaking != false){
			$notvalid = 1; 
			array_push($this->errors, 'inclstaking value is invalid');
		}else{
			$this->goodinputs['inclstaking'] = $inclstaking;
		}		
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Gets a list of block signer wallet addresses using the specified block number.
	*
	* See <a href='/index.php?method=hmyv2_getBlockSigners'>Explorer Method Page</a> or <a href='https://api.hmny.io/#1e4b5f41-9db6-4dea-92fb-4408db78e622'>Harmony API Documentation</a> for output details.
	*
	* @param string $blockhash Block number
	*
	* @return array List of block signer wallet addresses. 
	*/
	function hmyv2_getBlockSigners($blocknum){
		$method = "hmyv2_getBlockSigners";
		$urlparams = ['blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		$params = [$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validates the input data for hmyv2_getBlockSigners()
	*
	* @param string $blocknum Block number
	*
	* @return booleen 1 = good data, 0 = bad data
	*/
	function val_getBlockSigners($blocknum){
		$notvalid = 0;
		if(!$this->val_blocknum($blocknum)){
			$notvalid = 1; 
			array_push($this->errors, 'block number value is invalid');
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}

	/**
	* Gets block signer BLS keys using the specified block number.
	*
	* See <a href='/index.php?method=hmyv2_getBlockSignerKeys'>Explorer Method Page</a> or <a href='https://api.hmny.io/#9f9c8298-1a4e-4901-beac-f34b59ed02f1'>Harmony API Documentation</a> for output details.
	*
	* @param string $blocknum Block number
	*
	* @return array List of block signer public BLS keys. 
	*/
	function hmyv2_getBlockSignerKeys($blocknum){
		$method = "hmyv2_getBlockSignerKeys";
		$urlparams = ['blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		$params = [$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validates the input data for hmyv2_getBlockSignerKeys().
	*
	* @param integer $blocknum Block number
	*
	* @return booleen 1 = good data, 0 = bad data
	*/
	function val_getBlockSignerKeys($blocknum){
		$notvalid = 0;
		if(!$this->val_blocknum($blocknum)){
			$notvalid = 1; 
			array_push($this->errors, 'block number value is invalid');
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Gets the number of transactions in a block using the specified block number.
	*
	* See <a href='/index.php?method=hmyv2_getBlockTransactionCountByNumber'>Explorer Method Page</a> or <a href='https://api.hmny.io/#26c5adfb-d757-4595-9eb7-c6efef63df32'>Harmony API Documentation</a> for output details.
	*
	* @param string $blocknum Block number
	*
	* @return number  Number of transactions in the block
	*/
	function hmyv2_getBlockTransactionCountByNumber($blocknum){
		$method = "hmyv2_getBlockTransactionCountByNumber";
		$urlparams = ['blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		$params = [$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validates the input data for hmyv2_getBlockTransactionCountByNumber().
	*
	* @param integer $blocknum Block number
	*
	* @return booleen 1 = good data, 0 = bad data
	*/
	function val_getBlockTransactionCountByNumber($blocknum){
		$notvalid = 0;
		if(!$this->val_blocknum($blocknum)){
			$notvalid = 1; 
			array_push($this->errors, 'block number value is invalid');
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Gets the number of transactions in a block using the specified block hash.
	*
	* See <a href='/index.php?method=hmyv2_getBlockTransactionCountByHash'>Explorer Method Page</a> or <a href='https://api.hmny.io/#66c68844-0208-49bb-a83b-08722bc113eb'>Harmony API Documentation</a> for output details.
	*
	* @param string $blockhash Block hash
	*
	* @return number Number of transactions in the block
	*/
	function hmyv2_getBlockTransactionCountByHash($blockhash){
		$method = "hmyv2_getBlockTransactionCountByHash";
		$urlparams = ['blockhash' => $blockhash];
		$this->genrequesturl($method, $urlparams);
		$params = [$blockhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validates the input data for hmyv2_getBlockTransactionCountByHash()
	*
	* @param string $blockhash Block hash
	*
	* @return booleen 1 = good data, 0 = bad data
	*/
	function val_getBlockTransactionCountByHash($blockhash){
		$notvalid = 0;
		if(!$this->val_blockhash($blockhash)){
			$notvalid = 1; 
			array_push($this->errors, 'block hash value is invalid');
		}else{
			$this->goodinputs['blockhash'] = $blockhash;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}

	/**
	* Gets the block header data for the specified block number.
	*
	* See <a href='/index.php?method=hmyv2_getHeaderByNumber'>Explorer Method Page</a> or <a href='https://api.hmny.io/#01148e4f-72bb-426d-a123-718a161eaec0'>Harmony API Documentation</a> for output details.
	*
	* @param string $blocknum Block number
	*
	* @return array Block header data
	*/
	function hmyv2_getHeaderByNumber($blocknum){
		$method = "hmyv2_getHeaderByNumber";
		$urlparams = ['blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		$params = [$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validates the input data for hmyv2_getHeaderByNumber()
	*
	* @param string $blocknum Block number
	*
	* @return booleen 1 = good data, 0 = bad data
	*/
	function val_getHeaderByNumber($blocknum){
		$notvalid = 0;
		if(!$this->val_blocknum($blocknum)){
			$notvalid = 1; 
			array_push($this->errors, 'block number value is invalid');
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}

	/**
	* Gets a list of the latest beacon chain headers and their related information.
	*
	* See <a href='/index.php?method=hmyv2_getLatestChainHeaders'>Explorer Method Page</a> or <a href='https://api.hmny.io/#7625493d-16bf-4611-8009-9635d063b4c0'>Harmony API Documentation</a> for output details.
	*
	* @return array Chain header data
	*/
	function hmyv2_getLatestChainHeaders(){
		$method = "hmyv2_getLatestChainHeaders";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

	/**
	* Gets the current blockchain header information.
	*
	* See <a href='/index.php?method=hmyv2_latestHeader'>Explorer Method Page</a> or <a href='https://api.hmny.io/#73fc9b97-b048-4b85-8a93-4d2bf1da54a6'>Harmony API Documentation</a> for output details.
	*
	* @return array Current blockchain header information
	*/
	function hmyv2_latestHeader(){
		$method = "hmyv2_latestHeader";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

################
### ACCOUNT ###
################

	/**
	* Gets the current balance in atto for the specified wallet
	*
	* @param string $oneaddr The ONE address of the wallet
	*
	* @return number Current wallet balance in atto. See <a href='/index.php?method=hmyv2_getBalance'>Explorer Method Page</a> or <a href='https://api.hmny.io/#da8901d2-d237-4c3b-9d7d-10af9def05c4'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getBalance($oneaddr){
		$method = "hmyv2_getBalance";
		$urlparams = ['oneaddr' => $oneaddr];
		$this->genrequesturl($method, $urlparams);
		$params = [$oneaddr];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for hmyv2_getBalance
	*
	* @param string $oneaddr The ONE address of the wallet
	*
	* @return number 0 = bad input, 1 = good input
	*/
	function val_getBalance($oneaddr){
		if(!$this->val_oneaddr($oneaddr)){
			$this->set_validinput(0);
			array_push($this->errors, 'Invalid wallet address');
			return 0;
		}else{
			$this->set_validinput(1);
			$this->goodinputs['oneaddr'] = $oneaddr;
			return 1;
		}
	}
	
	/**
	* Gets the current balance in atto for the specified wallet at the specified block number
	*
	* @param string $oneaddr The ONE address of the wallet
	*
	* @param number $blocknum The block number to get the wallet balance from
	*
	* @return number Current wallet balance in atto. See <a href='/index.php?method=hmyv2_getBalanceByBlockNumber'>Explorer Method Page</a> or <a href='https://api.hmny.io/#9aeae4b8-1a09-4ed2-956b-d7c96266dd33'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getBalanceByBlockNumber($oneaddr, $blocknum){
		$method = "hmyv2_getBalanceByBlockNumber";
		$urlparams = ['oneaddr' => $oneaddr,'blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		$params = [$oneaddr,$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validate input for hmyv2_getBalanceByBlockNumber
	*
	* @param string $oneaddr The ONE address of the wallet
	* @param string $blocknum Block number
	*
	* @return number 0 = bad input, 1 = good input
	*/
	function val_getBalanceByBlockNumber($oneaddr, $blocknum){
		$notvalid = 0;
		if(!$this->val_oneaddr($oneaddr)){
			array_push($this->errors, 'Invalid wallet address');
			$notvalid = 1; 
		}else{
			$this->goodinputs['oneaddr'] = $oneaddr;
		}
		if(!$this->val_blocknum($blocknum)){
			array_push($this->errors, 'Invalid block number');
			$notvalid = 1; 
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if($notvalid == 0){
			$this->set_validinput(1);
			return 1;
		}else{
			$this->set_validinput(0);
			return 0;
		}
	}
	
	/**
	* Gets the number of staking transactions for the specified ONE wallet address.
	*
	* See <a href='/index.php?method=hmyv2_getStakingTransactionsCount'>Explorer Method Page</a> or <a href='https://api.hmny.io/#ddc1b029-f341-4c4d-ba19-74b528d6e5e5'>Harmony API Documentation</a> for output details.
	*
	* @param string $oneaddr The ONE address of the wallet
	*
	* @param string $txtype The transaction type to count (ALL, SENT, RECEIVED)
	*
	* @return number Number of staking transactions. 
	*/
	function hmyv2_getStakingTransactionsCount($oneaddr, $txtype){
		$method = "hmyv2_getStakingTransactionsCount";
		$urlparams = [
			'oneaddr' => $oneaddr,
			'txtype' => $txtype
			];
		$this->genrequesturl($method, $urlparams);
		$params = [
			$oneaddr,
			$txtype
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validates the input for hmyv2_getStakingTransactionsCount().
	*
	* @param string $oneaddr The ONE address of the wallet
	*
	* @param string $txtype The transaction type to count (ALL, SENT, RECEIVED)
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_getStakingTransactionsCount($oneaddr,$txtype){
		$notvalid = 0;
		$types = array('SENT','RECEIVED','ALL');
		if(!$this->val_oneaddr($oneaddr)){
			$notvalid = 1; 
			array_push($this->errors, 'Invalid ONE Address');
		}else{
			$this->goodinputs['oneaddr'] = $oneaddr;
		}
		if(!in_array($txtype,$types)){
			$notvalid = 1; 
			array_push($this->errors, 'invalid transaction type');
		}else{
			$this->goodinputs['txtype'] = $txtype;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Gets staking transactions history for a specified ONE wallet.
	*
	* See <a href='/index.php?method=hmyv2_getStakingTransactionsHistory'>Explorer Method Page</a> or <a href='https://api.hmny.io/#c5d25b36-57be-4e43-a23b-17ace350e322'>Harmony API Documentation</a> for output details.
	*
	* @param string $oneaddr The ONE address of the wallet
	*
	* @param number $pagenum Which page of transactions to retrieve
	*
	* @param number $pagesize Number of transactions per page
	*
	* @param booleen $fulltx return full transaction data or just transaction hashes
	*
	* @param string $txtype Which type of transactions to display (ALL, RECEIVED, or SENT)
	*
	* @param string $order Sort transactions in ascending or descending order based on timestamp (ASC or DESC)
	*
	* @return string List of transaction hashes
	*/
	function hmyv2_getStakingTransactionsHistory(string $oneaddr,int $pagenum,int $pagesize, bool $fulltx, string $txtype, string $order){
		settype($fulltx, 'bool');
		if($pagenum == -1){
			$pageindex = $pagenum;
		}else{
			$pageindex = $pagenum - 1;
		}
		$method = "hmyv2_getStakingTransactionsHistory";
		$urlparams = [
					'oneaddr' => $oneaddr,
					'pagenum' => $pagenum,
					'pagesize' => $pagesize,
					'fulltx' => $fulltx,
					'txtype' => $txtype,
					'order' => $order
					];
		$this->genrequesturl($method, $urlparams);
		$params = array(
					[
					'address' => $oneaddr,
					'pageIndex' => $pageindex,
					'pageSize' => $pagesize,
					'fullTx' => $fulltx,
					'txType' => $txtype,
					'order' => $order
					]
					);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validates the input data for hmyv2_getStakingTransactionsHistory().
	*
	* @param string $oneaddr The ONE address of the wallet
	*
	* @param number $pagenum Which page number of transactions to retrieve
	*
	* @param number $pagesize Number of transactions per page
	*
	* @param booleen $fulltx return full transaction data or just transaction hashes
	*
	* @param string $txtype Which type of transactions to display (ALL, RECEIVED, or SENT)
	*
	* @param string $order Sort transactions in ascending or descending order based on timestamp (ASC or DESC)
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_getStakingTransactionsHistory($oneaddr,int $pagenum,int $pagesize,$fulltx,$txtype,$order){
		$notvalid = 0;
		$txtypes = array('SENT','RECEIVED','ALL');
		
		if(!$this->val_oneaddr($oneaddr)){
			$notvalid = 1; 
			array_push($this->errors, 'invalid one address');
		}else{
			$this->goodinputs['oneaddr'] = $oneaddr;
		}
		
		if(preg_match( '/^[1-9]+[0-9]*$/', $pagenum) OR ($this->phph1_allowbigdata && $pagenum == -1)){
			$this->goodinputs['pagenum'] = $pagenum;
		}else{
			$notvalid = 1; 
			array_push($this->errors, 'invalid page number');
		}
		
		if(!preg_match( '/^[1-9]+[0-9]*$/', $pagesize) OR $pagesize > $this->max_pagesize){
			$notvalid = 1;
			array_push($this->errors, 'invalid page size');
		}else{
			$this->goodinputs['pagesize'] = $pagesize;
		}
		
		if(!in_array($txtype, $txtypes)){
			$notvalid = 1; 
			array_push($this->errors, 'invalid transaction type');
		}else{
			$this->goodinputs['txtype'] = $txtype;
		}
		
		if($order != 'DESC' && $order != 'ASC'){
			$notvalid = 1; 
			array_push($this->errors, 'invalid order');
		}else{
			$this->goodinputs['order'] = $order;
		}
		
		if($fulltx != '1' && $fulltx != '0'){
			$notvalid = 1;
			array_push($this->errors, 'full transaction value is invalid');
		}else{
			$this->goodinputs['fulltx'] = $fulltx;
		}
		
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Gets the number of transactions for the specified ONE wallet address.
	*
	* See <a href='/index.php?method=hmyv2_getTransactionsCount'>Explorer Method Page</a> or <a href='https://api.hmny.io/#fc97aed2-e65e-4cf4-bc01-8dadb76732c0'>Harmony API Documentation</a> for output details.
	*
	* @param string $oneaddr The ONE address of the wallet
	*
	* @param string $txtype The transaction type to count (ALL, SENT, RECEIVED)
	*
	* @return number Number of transactions. 
	*/
	function hmyv2_getTransactionsCount($oneaddr,?string $txtype = 'ALL'){
		$method = "hmyv2_getTransactionsCount";
		$urlparams = [
			'oneaddr' => $oneaddr,
			'txtype' => $txtype
			];
		$this->genrequesturl($method, $urlparams);
		$params = [
			$oneaddr,
			$txtype
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validates the input for hmyv2_getTransactionsCount().
	*
	* @param string $oneaddr The ONE address of the wallet
	*
	* @param string $txtype The transaction type to count (ALL, SENT, RECEIVED)
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_getTransactionsCount($oneaddr,$txtype){
		$notvalid = 0;
		$txtypes = array('SENT','RECEIVED','ALL');
		if(!$this->val_oneaddr($oneaddr)){
			$notvalid = 1; 
			array_push($this->errors, 'invalid one address');
		}else{
			$this->goodinputs['oneaddr'] = $oneaddr;
		}
		if(!in_array($txtype, $txtypes)){
			$notvalid = 1; 
			array_push($this->errors, 'invalid transaction type');
		}else{
			$this->goodinputs['txtype'] = $txtype;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}
	
	/**
	* Gets transactions history for a specified ONE wallet.
	*
	* See <a href='/index.php?method=hmyv2_getTransactionsHistory'>Explorer Method Page</a> or <a href='https://api.hmny.io/#2200a088-81b5-4420-a291-312a7c6d880e'>Harmony API Documentation</a> for output details.
	*
	* @param string $oneaddr The ONE address of the wallet
	*
	* @param number $pagenum Which page of transactions to retrieve
	*
	* @param number $pagesize Number of transactions per page
	*
	* @param booleen $fulltx return full transaction data or just transaction hashes
	*
	* @param string $txtype Which type of transactions to display (ALL, RECEIVED, or SENT)
	*
	* @param string $order Sort transactions in ascending or descending order based on timestamp (ASC or DESC)
	*
	* @return string List of transaction hashes
	*/
	function hmyv2_getTransactionsHistory($oneaddr,int $pagenum,int $pagesize,bool $fulltx,string $txtype,string $order){
		settype($fulltx, 'bool');
		if($pagenum == -1){
			$pageindex = $pagenum;
		}else{
			$pageindex = $pagenum - 1;
		}
		$method = "hmyv2_getTransactionsHistory";
		$urlparams = [					
					'oneaddr' => $oneaddr,
					'pagenum' => $pagenum,
					'pagesize' => $pagesize,
					'fulltx'=> $fulltx,
					'txtype' => $txtype,
					'order' => $order
					];
		$this->genrequesturl($method, $urlparams);
		$params = array(
					[
					'address' => $oneaddr,
					'pageIndex' => $pageindex,
					'pageSize' => $pagesize,
					'fullTx' => $fulltx,
					'txType' => $txtype,
					'order' => $order
					]
					);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validates the input data for hmyv2_getTransactionsHistory().
	*
	* @param string $oneaddr The ONE address of the wallet
	*
	* @param number $pagenum Which page of transactions to retrieve
	*
	* @param number $pagesize Number of transactions per page
	*
	* @param booleen $fulltx return full transaction data or just transaction hashes
	*
	* @param string $txtype Which type of transactions to display (ALL, RECEIVED, or SENT)
	*
	* @param string $order Sort transactions in ascending or descending order based on timestamp (ASC or DESC)
	*
	* @return booleen 1 = good input, 0 = bad input
	*/
	function val_getTransactionsHistory($oneaddr,int $pagenum,int $pagesize,$fulltx,$txtype,$order){
		$notvalid = 0;
		$txtypes = array('SENT','RECEIVED','ALL');
		if(!$this->val_oneaddr($oneaddr)){
			$notvalid = 1; 
			array_push($this->errors, 'invalid one address');
		}else{
			$this->goodinputs['oneaddr'] = $oneaddr;
		}
		if(!in_array($txtype, $txtypes)){
			$notvalid = 1; 
			array_push($this->errors, 'invalid transaction type');
		}else{
			$this->goodinputs['txtype'] = $txtype;
		}
		if(preg_match( '/^[1-9]+[0-9]*$/', $pagenum) OR ($this->phph1_allowbigdata && $pagenum == -1)){
			$this->goodinputs['pagenum'] = $pagenum;
		}else{
			$notvalid = 1; 
			array_push($this->errors, 'invalid page number');
		}
		if(!preg_match( '/^[0-9]+$/', $pagesize) OR $pagesize > $this->max_pagesize){
			$notvalid = 1; 
			array_push($this->errors, 'Invalid Page Size');
		}else{
			$this->goodinputs['pagesize'] = $pagesize;
		}
		if($order != 'DESC' && $order != 'ASC'){
			$notvalid = 1; 
			array_push($this->errors, 'Invalid Order');
		}else{
			$this->goodinputs['order'] = $order;
		}
		if($fulltx != '1' && $fulltx != '0'){
			$notvalid = 1;
			array_push($this->errors, 'Full transaction value is invalid');
		}else{
			$this->goodinputs['fulltx'] = $fulltx;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}

###################################################
## THESE ARE NOT IN THE LATEST API DOCUMENTATION ##
###################################################

	/**
	* Gets whether specified ONE address is a block signer for a specified block number.
	*
	* See <a href='/index.php?method=hmyv2_isBlockSigner'>Explorer Method Page</a> for output details.
	*
	* @param string $oneaddr The ONE address of the validator
	*
	* @param number $blocknum Block number
	*
	* @return booleen Returns 1 if address is a block signer
	*/
	function hmyv2_isBlockSigner($oneaddr,$blocknum){
		$method = "hmyv2_isBlockSigner";
		$urlparams = [
			'oneaddr' => $oneaddr,
			'blocknum' => $blocknum
			];
		$this->genrequesturl($method, $urlparams);
		
		$params = [
			$blocknum,
			$oneaddr
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Validation for hmyv2_isBlockSigner
	*
	* @param string $oneaddr The ONE address of the validator
	* @param number $blocknum Block number
	*
	* @return booleen good data = 1, bad data = 0
	*/
	function val_isBlockSigner($oneaddr,$blocknum){
		$notvalid = 0;
		if(!$this->val_oneaddr($oneaddr)){
			$notvalid = 1; 
			array_push($this->errors, 'validator address input value is invalid');
		}else{
			$this->goodinputs['oneaddr'] = $oneaddr;
		}
		if(!$this->val_blocknum($blocknum)){
			$notvalid = 1; 
			array_push($this->errors, 'block number input value is invalid');
		}else{
			$this->goodinputs['blocknum'] = $blocknum;
		}
		if($notvalid == 0){
			$this->validinput = 1;
			return 1;
		}else{
			$this->validinput = 0;
			return 0;
		}
	}

	/*
	NOT IMPLEMENTED YET
	
	function hmyv2_getPendingCrossLinks(){
		// Params:
		// NONE
		
		$method = "hmyv2_getPendingCrossLinks";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	*/

#################################
### INPUT VALIDATION REQUESTS ###
#################################
	
	/**
	* Converts numbers in atto to decimal
	*
	* @param number The atto value to convert
	*
	* @return number The converted atto number in decimal format
	*/
	function convert_atto($attonum){
		return ($attonum / 1e+18);
	}
	
	/**
	* Validates a ONE wallet address
	*
	* @param string The ONE wallet address to validate
	*
	* @return booleen 1 = good address, 0 = bad address
	*/
	function val_oneaddr($oneaddr){
		if(preg_match( '/^one1[a-z0-9]{38}$/', $oneaddr)){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Validates an ETH wallet address
	*
	* @param string The ETH wallet address to validate
	*
	* @return booleen 1 = good address, 0 = bad address
	*/
	function val_ethaddr($addr){
		if(preg_match( '/^0x[a-fA-F0-9]{40}$/', $addr)){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Validates a block number
	*
	* @param number The block number to validate
	*
	* @return booleen 1 = good address, 0 = bad address
	*/
	function val_blocknum($blocknum){
		if(preg_match( '/^[1-9]+[0-9]*$/', $blocknum)){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Validates a block hash
	*
	* @param string The block hash to validate
	*
	* @return booleen 1 = good address, 0 = bad address
	*/
	function val_blockhash($blockhash){
		if(preg_match( '/^0x[a-z0-9]{64}+$/', $blockhash)){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Validates an epoch
	*
	* @param number The epoch to validate
	*
	* @return booleen 1 = good address, 0 = bad address
	*/
	function val_epoch($epoch){
		if(preg_match( '/^[1-9]+[0-9]*$/', $epoch)){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Validates a hash
	*
	* @param string The hash to validate
	*
	* @return booleen 1 = good address, 0 = bad address
	*/
	function val_hash($hash){
		if(preg_match( '/^0x([A-Fa-f0-9]{64})$/', $hash)){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Validates a smart contract address
	*
	* @param string $scaddress The smart contract address
	*
	* @return booleen 1 = good address, 0 = bad address
	*/
	function val_scaddress($scaddress){
		if(preg_match( '/^0x[a-fA-F0-9]{40}$/', $scaddress)){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Validates a cross shard transaction hash
	*
	* @param string $trhash The cross shard transaction hash
	*
	* @return booleen 1 = good address, 0 = bad address
	*/
	function val_cxtxhash($trhash){
		if(preg_match( '/^0x[a-fA-F0-9]{64}$/', $trhash)){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Validates storage location
	*
	* @param string $stlocation The storage location hash
	*
	* @return booleen 1 = good address, 0 = bad address
	*/
	function val_stlocation($stlocation){
		if(preg_match( '/^0x[a-zA-Z0-9]+$/', $stlocation) && strlen($stlocation) <= 66){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Validates transaction index
	*
	* @param integer $txindex The transaction index
	*
	* @return booleen 1 = good transaction index, 0 = bad transaction index
	*/
	function val_txindex($txindex){
		$goodinput = 0;
		if(preg_match( '/^[0-9]+$/', $txindex) OR (!empty($txindex) && $txindex == 0)){
			return 1;
		}else{
			return 0;
		}
	}
}

?>
