<?php
/**
* PHPH1 is a PHP class used to send JSON requests to the Harmony Node API
* and return the data in an array/JSON format.
*
* The PHPH1 class can also be invoked by a single PHP page hosted locally
* that will use GET data to fetch a result. The output can also be converted to JSON data (see phph1_call.php) with PHP's 
* json_encode() method and returned to the page for remote queries using scripting languages such as Javascript. This file and inc/config.php must be included in your project before invoking the PHPH1 class, for example, require_once('inc/config.php'); require_once('inc/phph1.php');. Once included the phph1 class can be invoked by setting a handle. In this project, inc/boot.php is included and invokes everything, checks if the Explorer settings have been changed, and validates most major required inputs prior to using any time/cycles to check any other input and sending the API call. You can use boot.php as an example to integrate things into your own custom project.
*
* @filesource
*/


/**
* The PHPH1 wrapper class.
*
* <p>When invoking the class there are certain variables that must be passed to the class for operation. All variables are required and are located in <a href='https://one.saddlerockit.com/doc/files/inc-config.html'>inc/config.php</a> which means before invoking the class you will most likely want to require_once() the config file or set the configurations in your project somehow.</p>
* <p>See the <a href='https://one.saddlerockit.com/doc/classes/phph1.html#method___construct'>__construct()</a> function for more information.</p>
*/
class phph1{
	
	/** @var string $apiaddr The API address being used during this session. It is set during __construct by applying the $network and $shard inputs to the function getapiaddr() */
	public ?string $apiaddr;
	
	/** @var string $blockaddr The block address is set depending on whether the current method being used requires it. It is set while validating input in inc/boot.php */
	public ?string $blockaddr;
	
	/** @var integer $blocknum The block number is set depending on whether the current method being used requires it. It is set while validating input in inc/boot.php */
	public ?string $blocknum;
	
	/** @var integer $blocknum2 The second block number is used for mthods requiring a starting block number and an ending block number. It is set while validating input in inc/boot.php */
	public ?string $blocknum2;
	
	/** @var string $blockhash The block hash is set depending on whether the current method being used requires it. It is set while validating input in inc/boot.php. Blok hash is also used when a method requires a standard hash */
	public ?string $blockhash;
	
	/** @var string $scaddress The Smart Contract Address is set depending on whether the current method being used requires it. It is set while validating input in inc/boot.php */
	public ?string $scaddress;
	
	/** @var string $oneaddr The ONE Address is set depending on whether the current method being used requires it. It is set while validating input in inc/boot.php */
	public ?string $oneaddr;
	
	/** @var string $lastjson lastjson is set while generating a method. It is stored to use later when the explorer displays its method results */
	public ?string $lastjson;
	/** @var booleen $phph1_debug Detrmines whether debug output is displayed in the explorer when a method is run. It is set during __construct */
	public ?int $phph1_debug;
	
	/** @var booleen $rpc_call Determines whether whether the current method being called is an rpc call. If set to 1, the explorer knows to not output anything but the raw json output from the API Node. inc/boot.php has the check and set for this varibale in it */
	public ?int $rpc_call = 0;
	
	/** @var string $rpc_url When a method is called and run, it generates the RPC URL and sets it here for output later on */
	public ?string $rpc_url;
	
	/** @var array $errors An array of errors generated when validating method inputs. This is later used to output any errors to the explorer method output page */
	public ?array $errors = array();
	
	/** @var integer $max_pagesize Sets the maximum page size a multipage method output can output. This is mostly used to prevent a call from a user asking for a huge page size which could slow things down due to memory and network usage */
	public ?int $max_pagesize;
	
	/** @var integer $max_pagesize Sets the default page size for methods that output multiple pages of data */
	public ?int $default_pagesize;
	
	/** @var string $network This sets the network currently being used for the API calls during __construct and is one from the $phph1_apiaddresses array set in inc/config.php. example "mainnet" */
	public ?string $network;
	
	//* @var integer $shard This is the index number of the shard from the $network array set during __construct. The shard MUST be defined in the <a href='https://one.saddlerockit.com/doc/files/inc-config.html'>inc/config.php</a> $phph1_apiaddresses array. example: If 'mainnet' were selected for $network above and we wanted to use shard 0, the value for this would be 0.
	public ?int $shard;
	
	/** @var array $phph1_apiaddresses This is set during _construct when the class is invoked */
	public ?array $phph1_apiaddresses;
	
	/** @var array $phph1_methods This is set during __construct when the class is invoked and holds all available networks and shards in an array */
	public ?array $phph1_methods;
									
	/**
	* The __construct function is used to set PHPH1 configurations settings when invoking the class. The parameters are all REQUIRED when invoking the class
	*
	* @param array $phph1_apiaddresses This is set in <a href='https://one.saddlerockit.com/doc/files/inc-config.html'>inc/config.php</a> and is an array of arrays, each array item is the network "name" such as "mainnet" and is an array itself of addresses used as shards for that network. For example $phph1_apiaddresses['mainnet'][0] would be an address for shard 0 on the mainnet network.
	*
	* @param array $phph1_methods This is set in <a href='https://one.saddlerockit.com/doc/files/inc-config.html'>inc/config.php</a> and is an array of available methods by name. The array is used to verify that the method being called upon is a valid method. If the method is not in the array, all actions can be stopped before any input is used. You can also comment out methods in the <a href='https://one.saddlerockit.com/doc/files/inc-config.html'>inc/config.php</a> to limit which methods are used in your project. This can also be extended with custom methods added to the phph1 class.
	*
	* @param integer $phph1_debug Set in <a href='https://one.saddlerockit.com/doc/files/inc-config.html'>inc/config.php</a> and sets whether debugging output is on or off. Debugging output will present information concerning how the JSON call is being created through the process to aid in development. In most cases, this should be set to 0 to diable debugging.
	*
	* @param integer $max_pagesize This sets the maximum number of return items per page on API calls that return multiple pages of data in the explorer or your project. This is helpful in preventing huge return data sets which could present a heavy load on the web server or the web servers data throughput.
	*
	* @param integer $default_pagesize This sets the default page size for API calls that return pages of data. This is helpful in the Explorer and can also be used in your project when not using the explorer.
	*
	* @param string $network This sets the network currently being used for the API calls and is one from the $phph1_apiaddresses array set in inc/config.php. example "mainnet"
	*
	* @param integer $shard This is the index number of the shard from the $network array. The shard MUST be defined in the <a href='https://one.saddlerockit.com/doc/files/inc-config.html'>inc/config.php</a> $phph1_apiaddresses array. example: If 'mainnet' were selected for $network above and we wanted to use chard 0, the value for this would be 0.
	*
	* @return void
	*
	*/
	function __construct(?array $phph1_apiaddresses, $phph1_methods , ?int $phph1_debug, ?int $max_pagesize, ?int $default_pagesize, ?string $network, ?int $shard ){
		$this->phph1_apiaddresses = $phph1_apiaddresses;
		$this->apiaddr = $this->getapiaddr($network, $shard, $phph1_apiaddresses);
		$this->phph1_methods = $phph1_methods;
		$this->phph1_debug = $phph1_debug;
		$this->max_pagesize = $max_pagesize;
		$this->default_pagesize = $default_pagesize;
		$this->network = $network;
		$this->shard = $shard;
	}
	
	/**
	* getapiaddr() is used to set the Node API host address during __construct. It gets the address from $phph1_apiaddresses which is set during __construct using settings from inc/config.php by using the netwrok name and shard
	*
	* @param string $network The network name from the $phph1_apiaddresses array, default is mainnet
	*
	* @param number $shard The network shard for the network we will be using, default is shard 0
	*
	* @return string The URL for the API Node that was selected
	*/
	function getapiaddr(?string $network = 'mainnet', ?int $shard = 0){
		return $this->phph1_apiaddresses[$network][$shard];
	}
	
	/**
	* docurlrequest() takes the generated json request for the current method from genjsonrequest() and makes the call to the API RPC Node. If rpc_call is set to 0, it generates a PHP array for output. If rpc_call is set to 1, it returns the raw json output from API RPC Node.
	*
	* @param string $thisjson The JSON API request generated by genjsonrequest()
	*
	* @return array A PHP array of the returned data converted using PHP's json_decode()
	*/
	function docurlrequest($thisjson){
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
			$output = json_decode($data,true);
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
	*
	* @param array $paramsarr This is an array of the parameters for the method being called. It is formatted in each method function in this class
	*
	* @return string The formatted json data for this method request
	*/
	function genjsonrequest($method, $paramsarr){
		if($this->phph1_debug == 1){
			echo "<pre style='color:blue;'>PHPH1 FUNCTION genjsonrequest paramsarr: <br/>";
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
			echo "<pre style='color:blue;'>PHPH1 FUNCTION genjsonrequest rdata: <br/>";
			print_r($rdata);
			echo "</pre>";
		}
		$thisjson = json_encode($rdata);
		$this->lastjson = $thisjson;
		if($this->phph1_debug == 1){
			echo "<pre style='color:blue;'>PHPH1 FUNCTION genjsonrequest thisjson: <br />";
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
	function genrequesturl($method, $paramsarr){
		
		$thisrequesturl = '/phph1_call.php?do=1&method='.$method;
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
			
		$this->rpc_url = $thisrequesturl;
		return 1;
	}
	
######################
### SMART CONTRACT ###
######################
	
	/**
	* hmyv2_call() Executes a new message call immediately, without creating a transaction on the block chain. The hmyv2_call method can be used to query internal contract state, to execute validations coded into a contract or even to test what the effect of a transaction would be without running it live.
	*
	* @param string $to The ETH address the transaction was sent to
	* @param string $from The ETH address the transaction was sent from (optional)
	* @param string $gas Gas to execute the smart contract call (optional)
	* @param string $gasprice Gas price to execute smart contract call (optional)
	* @param string $value Value sent with the smart contract call (optional)
	* @param string $data Hash of smart contract method and parameters (optional)
	* @param number $blocknum Block number
	*
	* @return string Return value of the executed smart contract. See <a href='/index.php?method=hmyv2_call'>Explorer method page</a> or <a href='https://api.hmny.io/#d34b1f82-9b29-4b68-bac7-52fa0a8884b1'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_call($to, $from, $gas, $gasprice, $value, $data, $blocknum){
		$method = "hmyv2_call";
		$urlparams = [
				[
				'scaddress' => $to,
				'from' => $from,
				'gas' => $gas,
				'gasPrice' => $gasprice,
				'value' => $value,
				'data' => $data
				],
				'blocknum' => $blocknum
			];
		$this->genrequesturl($method, $urlparams);
		$params = [
				[
				'to' => $to,
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
	* @param string $to The ETH address the transaction was sent to
	* @param string $from The ETH address the transaction was sent from (optional)
	* @param string $gas Gas to execute the smart contract call (optional)
	* @param string $gasprice Gas price to execute smart contract call (optional)
	* @param string $value Value sent with the smart contract call (optional)
	* @param string $data Hash of smart contract method and parameters (optional)
	* @param number $blocknum Block number
	*
	* @return booleen 1 = Good input, 0 = bad input
	*/
	function val_call($to, $from, $gas, $gasprice, $value, $data, $blocknum){
		
		$notvalid = 0;
		
		if(!is_null($from) && $this->val_ethaddr($from) == 0){
			$notvalid = 1; 
			array_push($this->errors, 'from address is invalid');
		}
		if(!is_null($gas) && !preg_match( '/^0x[a-f0-9]+$/', $gas)){
			$notvalid = 1; 
			array_push($this->errors, 'gas value is invalid (hex required)');
		}
		if(!is_null($gasprice) && !preg_match( '/^0x[a-f0-9]+$/', $gasprice)){
			$notvalid = 1; 
			array_push($this->errors, 'gasprice value is invalid (hex required)');
		}
		if(!is_null($value) && !preg_match( '/^0x[a-f0-9]+$/', $value)){
			$notvalid = 1; 
			array_push($this->errors, 'value is invalid (hex required)');
		}
		if(!is_null($data) && !preg_match( '/^0x[a-f0-9]+$/', $data)){
			$notvalid = 1; 
			array_push($this->errors, 'data value is invalid (hex required)');
		}		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* hmyv2_estimateGas() Generates and returns an estimate of how much gas is necessary to allow the transaction to complete. The transaction will not be added to the blockchain. Note that the estimate may be significantly more than the amount of gas actually used by the transaction, for a variety of reasons including EVM mechanics and node performance.
	*
	* @param string $to The ETH smart contract address the transaction was sent to
	* @param string $from The ETH address the transaction was sent from (optional)
	* @param string $gas Gas to execute the smart contract call (optional)
	* @param string $gasprice Gas price to execute smart contract call (optional)
	* @param string $value Value sent with the smart contract call (optional)
	* @param string $data Hash of smart contract method and parameters (optional)
	* @param number $blocknum Block number (not working presently)
	*
	* @return string Hex value of estimated gas price for the smart contract call. See <a href='/index.php?method=hmyv2_estimateGas'>Explorer method page</a> or <a href='https://api.hmny.io/#b9bbfe71-8127-4dda-b26c-ff95c4c22abd'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_estimateGas($to, $from, $gas, $gasprice, $value, $data, $blocknum){
		$method = "hmyv2_estimateGas";
		$urlparams = [
				[
				'scaddress' => $to,
				'from' => $from,
				'value' => $value,
				'gas' => $gas,
				'gasPrice' => $gasprice,
				'data' => $data
				],
				//'blocknum' => $blocknum
			];
		$this->genrequesturl($method, $urlparams);
		$params = [
				[
				'to' => $to,
				'from' => $from,
				'value' => $value,
				'gas' => $gas,
				'gasPrice' => $gasprice,
				'data' => $data
				],
				//$blocknum
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* val_estimateGas() Validates the user input for hmyv2_estimateGas()
	*
	* @param string $to The ETH smart contract address the transaction was sent to
	* @param string $from The ETH address the transaction was sent from (optional)
	* @param string $gas Gas to execute the smart contract call (optional)
	* @param string $gasprice Gas price to execute smart contract call (optional)
	* @param string $value Value sent with the smart contract call (optional)
	* @param string $data Hash of smart contract method and parameters (optional)
	* @param number $blocknum Block number (not working presently)
	*
	* @return booleen 1 = Good input, 0 = bad input
	*/
	function val_estimateGas($to, $from, $gas, $gasprice, $value, $data, $blocknum){
		$notvalid = 0;
		if(!is_null($from) && !$this->val_hash($from)){
			$notvalid = 1; 
			array_push($this->errors, 'from address is invalid');
		}
		if(!is_null($gas) && !preg_match( '/^0x[a-f0-9]+$/', $gas)){
			$notvalid = 1; 
			array_push($this->errors, 'gas value is invalid');
		}
		if(!is_null($gasprice) && !preg_match( '/^0x[a-f0-9]+$/', $gasprice)){
			$notvalid = 1; 
			array_push($this->errors, 'gasprice value is invalid');
		}
		if(!is_null($value) && !preg_match( '/^0x[a-f0-9]+$/', $value)){
			$notvalid = 1; 
			array_push($this->errors, 'value is invalid');
		}
		if(!is_null($data) && !preg_match( '/^0x[a-f0-9]+$/', $data)){
			$notvalid = 1; 
			array_push($this->errors, 'data value is invalid');
		}		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	
	/**
	* This method can be used to distinguish between contract addresses and wallet addresses.
	* Will return contract code if it's a contract and nothing (0x) if it's a wallet
	*
	* @param string $to Smart contract address
	*
	* @param integer $blocknum Block number
	*
	* @return string Return value of the executed smart contract. See <a href='/index.php?method=hmyv2_getCode'>Explorer method page</a> or <a href='https://api.hmny.io/#e13e9d78-9322-4dc8-8917-f2e721a8e556'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getCode($to, $blocknum){
		$method = "hmyv2_getCode";
		$urlparams = [
				'scaddress' => $to,
				'blocknum' => $blocknum
				];
		$this->genrequesturl($method, $urlparams);
		$params = [
				$to,
				$blocknum
				];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Returns the value from a storage position at a given address, or in other words,
	* returns the state of the contract's storage, which may not be exposed via the contract's methods.
	*
	* @param string $scaddress Smart contract address
	* @param string $stlocation Hex representation of storage location
	* @param number $blocknum Block number
	*
	* @return string Data stored at the smart contract location. See <a href='/index.php?method=hmyv2_getStorageAt'>Explorer method page</a> or <a href='https://api.hmny.io/#fa8ac8bd-952d-4149-968c-857ca76da43f'>Harmony API Documentation</a> for output details.
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
		if(is_null($stlocation) && !preg_match( '/^0x[a-f0-9]+$/', $stlocation)){
			$notvalid = 1; 
			array_push($this->errors, 'storage location hex value is invalid');
		}
		if($notvalid == 0){
			return 1;
		}else{
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
	* @param string $deladdr Delegator address
	*
	* @return array See <a href='/index.php?method=hmyv2_getDelegationsByDelegator'>Explorer method page</a> or <a href='https://api.hmny.io/#454b032c-6072-4ecb-bf24-38b3d6d2af69'>Harmony API Documentation</a> for output details.
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
	* Get delegations using delegator address and block number
	*
	* @param string $deladdr Delegator address
	* @param string $blocknum Block Number
	*
	* @return array See <a href='/index.php?method=hmyv2_getDelegationsByDelegatorByBlockNumber'>Explorer method page</a> or <a href='https://api.hmny.io/#8ce13bda-e768-47b9-9dbe-193aba410b0a'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getDelegationsByDelegatorByBlockNumber($deladdr, $blocknum){
		$method = "hmyv2_getDelegationsByDelegatorByBlockNumber";
		$urlparams = [
			'oneaddr' => $deladdr,
			'blocknum' => $blocknum
			];
		$this->genrequesturl($method, $urlparams);
		
		$params = [
			$deladdr,
			$blocknum
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Get delegations using validator address
	*
	* @param string $valaddr Validator wallet address. This is validated in boot.php
	*
	* $return array See <a href='/index.php?method=hmyv2_getDelegationsByDelegatorByBlockNumber'>Explorer method page</a> or <a href='https://api.hmny.io/#2e02d8db-8fec-41d9-a672-2c9862f63f39'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getDelegationsByValidator($valaddr){
		$method = "hmyv2_getDelegationsByValidator";
		$urlparams = ['oneaddr' => $valaddr];
		$this->genrequesturl($method, $urlparams);
		$params = [$valaddr];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

############################
### STAKING -> VALIDATOR ###
############################

	/**
	* Gets a list of wallet addresses that have created validators on the network.
	*
	* @return array List of wallet addresses that have created validators on the network. See <a href='/index.php?method=hmyv2_getAllValidatorAddresses'>Explorer method page</a> or <a href='https://api.hmny.io/#69b93657-8d3c-4d20-9c9f-e51f08c9b3f5'>Harmony API Documentation</a> for output details.
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
	* @param number $page Page to request (page size is 100), -1 for all validators (needs to be added to explorer)
	*
	* @return array List of all validator detailed information. See <a href='/index.php?method=hmyv2_getAllValidatorInformation'>Explorer Method Page</a> or <a href='https://api.hmny.io/#df5f1631-7397-48e8-87b4-8dd873235b9c'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getAllValidatorInformation($page = 0){
		$method = "hmyv2_getAllValidatorInformation";
		$urlparams = ['page' => $page];
		$this->genrequesturl($method, $urlparams);
		$params = [$page];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Get all validator information by block number
	*
	* @param number $page Page to request (page size is 100), -1 for all validators (needs to be added to explorer)
	*
	* @param number $blocknum Block number
	*
	* @return array List of all validator detailed information. See <a href='/index.php?method=hmyv2_getAllValidatorInformationByBlockNumber'>Explorer Method Page</a> or <a href='https://api.hmny.io/#a229253f-ca76-4b9d-88f5-9fd96e40d583'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getAllValidatorInformationByBlockNumber($page = -1, $blocknum){
		$method = "hmyv2_getAllValidatorInformationByBlockNumber";
		$urlparams = [
			'page' => $page,
			'blocknum' => $blocknum
			];
		$this->genrequesturl($method, $urlparams);
		$params = [
			$page, 
			$blocknum
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Get all elected Validator addresses
	*
	* @return array List of wallet addresses that are currently elected. See <a href='/index.php?method=hmyv2_getElectedValidatorAddresses'>Explorer Method Page</a> or <a href='https://api.hmny.io/#e90a6131-d67c-4110-96ef-b283d452632d'>Harmony API Documentation</a> for output details.
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
	* @param string $valaddr The validator's wallet address
	*
	* @return array Array of validator detailed information. See <a href='/index.php?method=hmyv2_getValidatorInformation'>Explorer Method Page</a> or <a href='https://api.hmny.io/#659ad999-14ca-4498-8f74-08ed347cab49'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getValidatorInformation($valaddr){
		$method = "hmyv2_getValidatorInformation";
		$urlparams = ['oneaddr' => $valaddr];
		$this->genrequesturl($method, $urlparams);
		$params = [$valaddr];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

##########################
### STAKING -> NETWORK ###
##########################

	/**
	* Retrieves the current utility metrics
	*
	* @return array Array of current utility metrics. See <a href='/index.php?method=hmyv2_getCurrentUtilityMetrics'>Explorer Method Page</a> or <a href='https://api.hmny.io/#78dd2d94-9ff1-4e0c-bbac-b4eec1cdf10b'>Harmony API Documentation</a> for output details.
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
	* @return array Array of current utility metrics. See <a href='/index.php?method=hmyv2_getMedianRawStakeSnapshot'>Explorer Method Page</a> or <a href='https://api.hmny.io/#bef93b3f-6763-4121-9c17-f0b0d9e5cc40'>Harmony API Documentation</a> for output details.
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
	* @return array Array of current utility metrics. See <a href='/index.php?method=hmyv2_getStakingNetworkInfo'>Explorer Method Page</a> or <a href='https://api.hmny.io/#4a10fce0-2aa4-4583-bdcb-81ee0800993b'>Harmony API Documentation</a> for output details.
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
	* @return array Array of current utility metrics. See <a href='/index.php?method=hmyv2_getSuperCommittees'>Explorer Method Page</a> or <a href='https://api.hmny.io/#8eef2fc4-92db-4610-a9cd-f7b75cfbd080'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getSuperCommittees(){
		$method = "hmyv2_getSuperCommittees";
		$params = [];
		$this->genrequesturl($method, $urlparams);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

###################
### TRANSACTION ###
###################

##################################
### TRANSACTION -> CROSS SHARD ###
# DONE!
##################################

	/**
	* Query the CX receipt hash on the receiving shard endpoint
	*
	* @param string $ctxhash Cross shard receipt hash
	*
	* @return array See <a href='/index.php?method=hmyv2_getCXReceiptByHash'>Explorer Method Page</a> or <a href='https://api.hmny.io/#3d6ad045-800d-4021-aeb5-30a0fbf724fe'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getCXReceiptByHash($ctxhash){
		$method = "hmyv2_getCXReceiptByHash";
		$urlparams = ['blockhash' => $ctxhash];
		$this->genrequesturl($method, $urlparams);
		$params = [$ctxhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Retrieves a list of currently pending cross shard transaction receipts
	*
	* @return array Array of currently pending cross shard transaction receipts. See <a href='/index.php?method=hmyv2_getPendingCXReceipts'>Explorer Method Page</a> or <a href='https://api.hmny.io/#fe60070d-97b4-458d-9365-490b44c18851'>Harmony API Documentation</a> for output details.
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
	* @param string $ctxhash Cross shard receipt hash
	*
	* @return array See <a href='/index.php?method=hmyv2_resendCx'>Explorer Method Page</a> or <a href='https://api.hmny.io/#c658b56b-d20b-480d-b71a-b0bc505d2164'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_resendCx($ctxhash){
		$method = "hmyv2_resendCx";
		$urlparams = ['blockhash' => $ctxhash];
		$this->genrequesturl($method, $urlparams);
		$params = [$ctxhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

#######################################
### TRANSACTION -> TRANSACTION POOL ###
#Need Finished:
#hmyv2_pendingStakingTransactions
#######################################

	/**
	* Retrieves current transaction pool stats
	*
	* @return array Array of current transaction pool stats. See <a href='/index.php?method=hmyv2_getPoolStats'>Explorer Method Page</a> or <a href='https://api.hmny.io/#7c2b9395-8f5e-4eb5-a687-2f1be683d83e'>Harmony API Documentation</a> for output details.
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
	* @return array Array of currently pending staking transactions. See <a href='/index.php?method=hmyv2_pendingStakingTransactions'>Explorer Method Page</a> or <a href='https://api.hmny.io/#de0235e4-f4c9-4a69-b6d2-b77dc1ba7b12'>Harmony API Documentation</a> for output details.
	*/
	//FIXME
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
	* @return array Array of currently pending transactions. See <a href='/index.php?method=hmyv2_pendingTransactions'>Explorer Method Page</a> or <a href='https://api.hmny.io/#de6c4a12-fa42-44e8-972f-801bfde1dd18'>Harmony API Documentation</a> for output details.
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
#Need Finished:
#hmyv2_sendRawStakingTransaction
#check into:
#hmyv2_getStakingTransactionByBlockNumberAndIndex
#hmyv2_getStakingTransactionByBlockHashAndIndex
##############################

	/**
	* Retrieves a list of transaction errors currently in the staking error sink
	*
	* @return array Array of current transaction errors in the staking error sink. See <a href='/index.php?method=hmyv2_getCurrentStakingErrorSink'>Explorer Method Page</a> or <a href='https://api.hmny.io/#bdd00e0f-2ba0-480e-b996-2ef13f10d75a'>Harmony API Documentation</a> for output details.
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
	* @param integer $blocknum Block number
	*
	* @param integer $txindex Staking transaction index
	*
	* @return array See <a href='/index.php?method=hmyv2_getStakingTransactionByBlockNumberAndIndex'>Explorer Method Page</a> or <a href='https://api.hmny.io/#fb41d717-1645-4d3e-8071-6ce8e1b65dd3'>Harmony API Documentation</a> for output details.
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
		if(!preg_match( '/^[0-9]+$/', $txindex)){
			$notvalid = 1; 
			array_push($this->errors, 'transaction index value is invalid');
		}
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Use this API call to retrieve a staking transaction info using block hash and transaction index
	*
	* @param string $blockhash Block number
	*
	* @param integer $txindex Staking transaction index
	*
	* @return array See <a href='/index.php?method=hmyv2_getStakingTransactionByBlockHashAndIndex'>Explorer Method Page</a> or <a href='https://api.hmny.io/#ba96cf61-61fe-464a-aa06-2803bb4b'>Harmony API Documentation</a> for output details.
	*/
	//FIXME method handler crashed
	function hmyv2_getStakingTransactionByBlockHashAndIndex($blockhash,$txindex){
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
		if(!preg_match( '/^[0-9]+$/', $txindex)){
			$notvalid = 1; 
			array_push($this->errors, 'transaction index value is invalid');
		}
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Use this API call to retrieve a staking transaction info using the staking transaction hash (stkhash is validated in boot.php)
	*
	* @param string $sthash Staking transaction hash
	*
	* @return array See <a href='/index.php?method=hmyv2_getStakingTransactionByHash'>Explorer Method Page</a> or <a href='https://api.hmny.io/#296cb4d0-bce2-48e3-bab9-64c3734edd27'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getStakingTransactionByHash($stkhash){
		$method = "hmyv2_getStakingTransactionByHash";
		$urlparams = ['blockhash' => $stkhash];
		$this->genrequesturl($method, $urlparams);
		$params = [$stkhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/*
	//FIXME
	function hmyv2_sendRawStakingTransaction($trcencbyt,$rawtranhash){
		$method = "hmyv2_sendRawStakingTransaction";
		$params = [$trcencbyt,$rawtranhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	*/

###############################
### TRANSACTION -> TRANSFER ###
###############################

	/**
	* Retrieves a list of transaction errors currently in the transaction error sink
	*
	* @return array Array of current errors in the transaction error sink. See <a href='/index.php?method=hmyv2_getCurrentTransactionErrorSink'>Explorer Method Page</a> or <a href='https://api.hmny.io/#9aedbc22-6262-44b1-8276-cd8ae19fa600'>Harmony API Documentation</a> for output details.
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
	* @param string $blocknum Block blockhash
	*
	* @param integer $txindex Staking transaction index
	*
	* @return array See <a href='/index.php?method=hmyv2_getTransactionByBlockHashAndIndex'>Explorer Method Page</a> or <a href='https://api.hmny.io/#7c7e8d90-4984-4ebe-bb7e-d7adec167503'>Harmony API Documentation</a> for output details.
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
	function val_getTransactionByBlockHashAndIndex($blockhash,$tindex){
		$notvalid = 0;
		if(isset($tindex) && is_numeric($tindex) &&  !preg_match( '/^[0-9]+$/', $tindex)){
			$notvalid = 1; 
			array_push($this->errors, 'tindex value is invalid');
		}
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Use this API call to retrieve transaction info using block number and transaction index
	*
	* @param integer $blocknum Block number
	*
	* @param integer $txindex Transaction index
	*
	* @return array See <a href='/index.php?method=hmyv2_getTransactionByBlockNumberAndIndex'>Explorer Method Page</a> or <a href='https://api.hmny.io/#bcde8b1c-6ab9-4950-9835-3c7564e49c3e'>Harmony API Documentation</a> for output details.
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
	function val_getTransactionByBlockNumberAndIndex($blocknum,$tindex){
		$notvalid = 0;
		if(isset($tindex) && is_numeric($tindex) &&  !preg_match( '/^[0-9]+$/', $tindex)){
			$notvalid = 1; 
			array_push($this->errors, 'tindex value is invalid');
		}
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Use this API call to retrieve transaction info using the transaction hash
	*
	* @param string $transhash Transaction hash
	*
	* @return array See <a href='/index.php?method=hmyv2_getTransactionByHash'>Explorer Method Page</a> or <a href='https://api.hmny.io/#117e84f6-a0ec-444e-abe0-455701310389'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getTransactionByHash($transhash){
		$method = "hmyv2_getTransactionByHash";
		$urlparams = ['blockhash' => $transhash];
		$this->genrequesturl($method, $urlparams);
		$params = [$transhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Use this API call to retrieve transaction info using the transaction hash
	*
	* @param string $transhash Transaction hash
	*
	* @return array See <a href='/index.php?method=hmyv2_getTransactionByHash'>Explorer Method Page</a> or <a href='https://api.hmny.io/#117e84f6-a0ec-444e-abe0-455701310389'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getTransactionReceipt($transhash){
		$method = "hmyv2_getTransactionReceipt";
		$urlparams = ['blockhash' => $transhash];
		$this->genrequesturl($method, $urlparams);
		$params = [$transhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	// NEED INFO
	/*
	function hmyv2_sendRawTransaction($trcencbyt,$rawtranhash){
		// Params:
		// $trcencbyt = Transaction encoded in bytes
		// $rawtranhash = Raw transaction's hash
		
		$method = "hmyv2_sendRawTransaction";
		$params = [$trcencbyt,$rawtranhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	*/

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
	* @return integer Current block number. See <a href='/index.php?method=hmyv2_blockNumber'>Explorer Method Page</a> or <a href='https://api.hmny.io/#2602b6c4-a579-4b7c-bce8-85331e0db1a7'>Harmony API Documentation</a> for output details.
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
	* @return integer Circulation supply of tokens in ONE. See <a href='/index.php?method=hmyv2_getCirculatingSupply'>Explorer Method Page</a> or <a href='https://api.hmny.io/#8398e818-ac2d-4ad8-a3b4-a00927395044'>Harmony API Documentation</a> for output details.
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
	* @return integer The current epoch. See <a href='/index.php?method=hmyv2_getEpoch'>Explorer Method Page</a> or <a href='https://api.hmny.io/#8398e818-ac2d-4ad8-a3b4-a00927395044'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getEpoch(){
		$method = "hmyv2_getEpoch";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Get the current information on the last crosslinks
	*
	* @return array current information on the last crosslinks. See <a href='/index.php?method=hmyv2_getLastCrossLinks'>Explorer Method Page</a> or <a href='https://api.hmny.io/#4994cdf9-38c4-4b1d-90a8-290ddaa3040e'>Harmony API Documentation</a> for output details.
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
	* @return string Wallet address of current leader. See <a href='/index.php?method=hmyv2_getLeader'>Explorer Method Page</a> or <a href='https://api.hmny.io/#8b08d18c-017b-4b44-a3c3-356f9c12dacd'>Harmony API Documentation</a> for output details.
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
	* @return integer Current average gas price of transactions. See <a href='/index.php?method=hmyv2_gasPrice'>Explorer Method Page</a> or <a href='https://api.hmny.io/#1d53fd59-a89f-436c-a171-aec9d9623f48'>Harmony API Documentation</a> for output details.
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
	* @return array Current shards on the network and their information. See <a href='/index.php?method=hmyv2_getShardingStructure'>Explorer Method Page</a> or <a href='https://api.hmny.io/#9669d49e-43c1-47d9-a3fd-e7786e5879df'>Harmony API Documentation</a> for output details.
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
	* @return integer Total number of pre-mined tokens. See <a href='/index.php?method=hmyv2_getTotalSupply'>Explorer Method Page</a> or <a href='https://api.hmny.io/#3dcea518-9e9a-4a20-84f4-c7a0817b2196'>Harmony API Documentation</a> for output details.
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
	* @param integer $epoch Epoch number (default is epoch 1 or everything)
	*
	* @return array Array of validators ONE addresses and some of their information. See <a href='/index.php?method=hmyv2_getValidators'>Explorer Method Page</a> or <a href='https://api.hmny.io/#4dfe91ad-71fa-4c7d-83f3-d1c86a804da5'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getValidators(?int $epoch = 1){
		$method = "hmyv2_getValidators";
		$urlparams = ['epoch' => $epoch];
		$this->genrequesturl($method, $urlparams);
		$params = [$epoch];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* Get validator information from epoch number
	*
	* @param integer $epoch Epoch number (default is epoch 1 or everything)
	*
	* @return array List of public BLS keys in the elected committee. See <a href='/index.php?method=hmyv2_getValidatorKeys'>Explorer Method Page</a> or <a href='https://api.hmny.io/#1439b580-fa3c-4d44-a79d-303390997a8c'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getValidatorKeys(?int $epoch = 1){
		$method = "hmyv2_getValidatorKeys";
		$urlparams = ['epoch' => $epoch];
		$this->genrequesturl($method, $urlparams);
		$params = [$epoch];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

##########################
### BLOCKCHAIN -> NODE ###
##########################
	
	function hmyv2_getCurrentBadBlocks(){
		$method = "hmyv2_getCurrentBadBlocks";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getNodeMetadata(){
		$method = "hmyv2_getNodeMetadata";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	

	function hmyv2_protocolVersion(){
		$method = "hmyv2_protocolVersion";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function net_peerCount(){
		$method = "net_peerCount";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

############################
### BLOCKCHAIN -> BLOCKS ###
#Need Adjusted:
#hmyv2_getBlockSigners
############################

	function hmyv2_getBlocks($strtblocknum,$endblocknum,$fulltxt = TRUE,$withsigners = FALSE,$inclstaking = FALSE){
		$method = "hmyv2_getBlocks";
		$urlparams = [
				'blocknum' => $strtblocknum,
				'blocknum2' => $endblocknum,
				[
				'fullTx' => $fulltxt,
				'withSigners' => $withsigners,
				'inclStaking' => $inclstaking
				]
			];
		$this->genrequesturl($method, $urlparams);
		$params = [
				$strtblocknum,
				$endblocknum,
				[
				'fullTx' => $fulltxt,
				'withSigners' => $withsigners,
				'inclStaking' => $inclstaking
				]
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function val_getBlocks($blocknum1,$blocknum2,$fulltx,$withsigners,$inclstaking){
		$notvalid = 0;
		if(isset($fulltx) && $fulltx != TRUE && $fulltx != FALSE && !is_bool($fulltx)){
			$notvalid = 1; 
			array_push($this->errors, 'fulltx value is invalid');
		}
		if(isset($inclstaking) && $inclstaking != TRUE && $inclstaking != FALSE && !is_bool($inclstaking)){
			$notvalid = 1; 
			array_push($this->errors, 'inclstaking value is invalid');
		}
		if(isset($withsigners) && $withsigners != TRUE && $withsigners != FALSE && !is_bool($withsigners)){
			$notvalid = 1; 
			array_push($this->errors, 'withsigners value is invalid');
		}
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}

	function hmyv2_getBlockByNumber($blocknum, $fulltx=true, $incltx=false, $withsigners=false, $inclstaking=false){
		$method = "hmyv2_getBlockByNumber";
		$urlparams = [
				'blocknum' => $blocknum,
				[
				'fulltx' => $fulltx,
				'incltx' => $incltx,
				'inclstaking' => $inclstaking,
				'withsigners' => $withsigners
				]
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
	
	function val_getBlockByNumber($blocknum,$fulltx,$incltx,$withsigners,$inclstaking){
		$notvalid = 0;
		if(isset($fulltx) && $fulltx != TRUE && $fulltx != FALSE && !is_bool($fulltx)){
			$notvalid = 1; 
			array_push($this->errors, 'fulltx value is invalid');
		}
		if(isset($incltx) && $incltx != TRUE && $incltx != FALSE && !is_bool($incltx)){
			$notvalid = 1; 
			array_push($this->errors, 'incltx value is invalid');
		}
		if(isset($inclstaking) && $inclstaking != TRUE && $inclstaking != FALSE && !is_bool($inclstaking)){
			$notvalid = 1; 
			array_push($this->errors, 'inclstaking value is invalid');
		}
		if(isset($withsigners) && $withsigners != TRUE && $withsigners != FALSE && !is_bool($withsigners)){
			$notvalid = 1; 
			array_push($this->errors, 'withsigners value is invalid');
		}
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* Gets block information using the specified block hash.
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
	* @return array Block information. See <a href='/index.php?method=hmyv2_getBlockByHash'>Explorer Method Page</a> or <a href='https://api.hmny.io/#6a49ec47-1f74-4732-9f04-e5d76160bd5c'>Harmony API Documentation</a> for output details.
	*/
	function hmyv2_getBlockByHash($blockhash,$fulltx = true,$incltx=false,$withsigners = false,$inclstaking = false){
		$method = "hmyv2_getBlockByHash";
		$urlparams = [
				'blockhash' => $blockhash,
				[
				'fulltx' => $fulltx,
				'incltx' => $incltx,
				'withsigners' => $withsigners,
				'inclstaking' => $inclstaking
				]
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
	
	function val_getBlockByHash($blockhash,$fulltx,$inclTx,$withsigners,$inclstaking){
		$notvalid = 0;
		if(isset($fulltx) && $fulltx != TRUE && $fulltx != FALSE && !is_bool($fulltx)){
			$notvalid = 1; 
			array_push($this->errors, 'fulltx value is invalid');
		}
		if(isset($incltx) && $incltx != TRUE && $incltx != FALSE && !is_bool($incltx)){
			$notvalid = 1; 
			array_push($this->errors, 'incltx value is invalid');
		}
		if(isset($inclstaking) && $inclstaking != TRUE && $inclstaking != FALSE && !is_bool($inclstaking)){
			$notvalid = 1; 
			array_push($this->errors, 'inclstaking value is invalid');
		}
		if(isset($withsigners) && $withsigners != TRUE && $withsigners != FALSE && !is_bool($withsigners)){
			$notvalid = 1; 
			array_push($this->errors, 'withsigners value is invalid');
		}
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function hmyv2_getBlockSigners($blocknum){
		$method = "hmyv2_getBlockSigners";
		$urlparams = ['blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		$params = [$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

	
	function hmyv2_getBlockSignerKeys($blocknum){
		$method = "hmyv2_getBlockSignerKeys";
		$urlparams = ['blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		$params = [$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getBlockTransactionCountByNumber($blocknum){
		$method = "hmyv2_getBlockTransactionCountByNumber";
		$urlparams = ['blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		$params = [$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getBlockTransactionCountByHash($blockhash){
		$method = "hmyv2_getBlockTransactionCountByHash";
		$urlparams = ['blockhash' => $blockhash];
		$this->genrequesturl($method, $urlparams);
		$params = [$blockhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

	function hmyv2_getHeaderByNumber($blocknum){
		$method = "hmyv2_getHeaderByNumber";
		$urlparams = ['blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		$params = [$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

	function hmyv2_getLatestChainHeaders(){
		$method = "hmyv2_getLatestChainHeaders";
		$params = [];
		$this->genrequesturl($method, $params);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

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
	
	
	function hmyv2_getStakingTransactionsCount($oneaddr, $txtype = 'ALL'){
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
	
	function val_getStakingTransactionsCount($oneaddr,$txtype){
		$notvalid = 0;
		if(isset($txtype) && $txtype != 'SENT' && $txtype != 'RECEIVED' && $txtype != 'ALL'){
			$notvalid = 1; 
			array_push($this->errors, 'Invalid Transaction Type');
		}
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function hmyv2_getStakingTransactionsHistory($oneaddr,?int $pageindex = 1,?int $pagesize = 10, ?bool $fulltx = true, ?string $txtype = 'ALL', ?string $order = 'DESC'){
		settype($fulltx, 'bool');
		$method = "hmyv2_getStakingTransactionsHistory";
		$urlparams = array(
					[
					'oneaddr' => $oneaddr,
					'pageindex' => $pageindex-1,
					'pagesize' => $pagesize,
					'fulltx' => $fulltx,
					'txtype' => $txtype,
					'order' => $order
					]
					);
		$this->genrequesturl($method, $urlparams);
		$params = array(
					[
					'address' => $oneaddr,
					'pageIndex' => $pageindex-1,
					'pageSize' => $pagesize,
					'fullTx' => $fulltx,
					'txType' => $txtype,
					'order' => $order
					]
					);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function val_getStakingTransactionsHistory($oneaddr,$pageindex,$pagesize,$fulltx,$txtype,$order){
		$notvalid = 0;
		if(isset($pageindex) && !preg_match( '/^[0-9]+$/', $pageindex)){
			$notvalid = 1; 
			array_push($this->errors, 'Invalid Page Index Number');
		}
		if(isset($pagesize) && !preg_match( '/^[0-9]+$/', $pagesize) && $pagesize <= 200){
			$notvalid = 1;
			array_push($this->errors, 'Invalid Page Size');
		}
		if(isset($txtype) && $txtype != 'SENT' && $txtype != 'RECEIVED' && $txtype != 'ALL'){
			$notvalid = 1; 
			array_push($this->errors, 'Invalid Transaction Type');
		}
		if(isset($order) && $order != 'DESC' && $order != 'ASC'){
			$notvalid = 1; 
			array_push($this->errors, 'Invalid Order');
		}
		if(isset($fulltx) && $fulltx != '1' && $fulltx != '0'){
			$notvalid = 1;
			array_push($this->errors, 'Full transaction value is invalid');
		}
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
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
	
	function val_getTransactionsCount($oneaddr,$txtype){
		$notvalid = 0;
		if(isset($txtype) && $txtype != 'SENT' && $txtype != 'RECEIVED' && $txtype != 'ALL'){
			$notvalid = 1; 
			array_push($this->errors, 'Invalid Transaction Type');
		}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function hmyv2_getTransactionsHistory($oneaddr,?int $page = 1,?int $pagesize = 10, ?bool $fulltx = true, ?string $txtype = 'ALL', ?string $order = 'DESC'){
		settype($fulltx, 'bool');
		$method = "hmyv2_getTransactionsHistory";
		$urlparams = array(
					[
					'oneaddr' => $oneaddr,
					'pageIndex' => $page-1,
					'pageSize' => $pagesize,
					'fullTx' => $fulltx,
					'txType' => $txtype,
					'order' => $order
					]
					);
		$this->genrequesturl($method, $urlparams);
		$params = array(
					[
					'address' => $oneaddr,
					'pageIndex' => $page-1,
					'pageSize' => $pagesize,
					'fullTx' => $fulltx,
					'txType' => $txtype,
					'order' => $order
					]
					);
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function val_getTransactionsHistory($oneaddr,$page,$pagesize,$fulltx,$txtype,$order){
		$notvalid = 0;
		if(isset($page) && !preg_match( '/^[0-9]+$/', $page)){
			$notvalid = 1; 
			array_push($this->errors, 'Invalid Page Number');
		}
		if(isset($pagesize) && !preg_match( '/^[0-9]+$/', $pagesize) && $pagesize <= 200){
			$notvalid = 1; 
			array_push($this->errors, 'Invalid Page Size');
		}
		if(isset($txtype) && $txtype != 'SENT' && $txtype != 'RECEIVED' && $txtype != 'ALL'){
			$notvalid = 1; 
			array_push($this->errors, 'Invalid Transaction Type');
		}
		if(isset($order) && $order != 'DESC' && $order != 'ASC'){
			$notvalid = 1; 
			array_push($this->errors, 'Invalid Order');
		}
		if(isset($fulltx) && $fulltx != '1' && $fulltx != '0'){
			$notvalid = 1;
			array_push($this->errors, 'Full transaction value is invalid');
		}
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}

###################################################
## THESE ARE NOT IN THE LATEST API DOCUMENTATION ##
###################################################

	function hmyv2_isBlockSigner($valaddr,$blocknum){
		$method = "hmyv2_isBlockSigner";
		$urlparams = [
			'oneaddr' => $valaddr,
			'blocknum' => $blocknum
			];
		$this->genrequesturl($method, $urlparams);
		
		$params = [
			$blocknum,
			$valaddr
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
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
	
	function convert_atto($attonum){
		return ($attonum / 1e+18);
	}
	
	function val_oneaddr($addr){
		if(isset($addr) && preg_match( '/^one1[a-z0-9]+$/', $addr) && strlen($addr) == 42){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_ethaddr($addr){
		if(isset($addr) && preg_match( '/^0x[a-zA-Z0-9]+$/', $addr) && substr($addr, 0, 2) == "0x" && strlen($addr) == 42){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_blockaddr($blockaddr){
		if(isset($blockaddr) && preg_match( '/^[0-9]+$/', $blockaddr) && strlen($blockaddr) <= 20){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_blocknum($blocknum){
		if(isset($blocknum) && preg_match( '/^[0-9]+$/', $blocknum) && strlen($blocknum) <= 200){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_blockhash($blockhash){
		if(isset($blockhash) && preg_match( '/^0x[a-z0-9]+$/', $blockhash) && strlen($blockhash) <= 66){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_epoch($epoch){
		if(isset($epoch) && preg_match( '/^[0-9]+$/', $epoch) && strlen($epoch) <= 100){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_hash($hash){
		if(isset($hash) && preg_match( '/^0x[a-f0-9]+$/', $hash) && strlen($hash) <= 66){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_scaddress($scaddress){
		if(isset($scaddress) && preg_match( '/^0x[a-zA-Z0-9]+$/', $scaddress) && strlen($scaddress) <= 66){
			return 1;
		}else{
			return 0;
		}
	}
	
	
	function val_stlocation($stlocation){
		if(isset($stlocation) && preg_match( '/^0x[a-zA-Z0-9]+$/', $stlocation) && strlen($stlocation) <= 66){
			return 1;
		}else{
			return 0;
		}
	}
	
}

?>
