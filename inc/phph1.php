<?php
/**
* PHPH1 is a PHP class used to send JSON requests to the Harmony Node API
* and return the data in an array format.
*
* The PHPH1 class can also be invoked by a single PHP page hosted locally or remotely
* that will use GET data to fetch a result. The output can also be converted to JSON data with PHP's 
* json_encode() method and returned to the page for remote queries using scripting languages such as Javascript.
*
*/


/**
* The PHPH1 class
*
* The PHPH1 Class requires a small set of variables when invoked.
* $hmyv2_apiaddresses	A small array that includes the url to the nodes being used to query
*										The array format should be similar to the example below.
*										$MyNodesArray = array(
*												'mainnet' => [
*													0 => 'https://a.api.s0.t.hmny.io/',
*													1 => 'https://rpc.s1.t.hmny.io/',
*													2 => 'https://rpc.s2.t.hmny.io/',
*													3 => 'https://rpc.s3.t.hmny.io/'	
*												],
*												'testnet' => [
*													0 => 'https://rpc.s0.b.hmny.io//',
*													1 => 'https://rpc.s1.b.hmny.io/',
*													2 => 'https://rpc.s2.b.hmny.io/',
*													3 => 'https://rpc.s3.b.hmny.io/'	
*												],
*											);
*/
class phph1{
	
	public ?string $apiaddr;
	public ?string $blockaddr;
	public ?string $blocknum;
	public ?string $blocknum2;
	public ?string $blockhash;
	public ?string $scaddress;
	public ?string $oneaddr;
	public ?string $lastjson;
	public ?int $phph1_debug;
	public ?int $rpc_call = 0;
	public ?string $rpc_url;
	public ?array $errors = array();
	public ?int $max_pagesize;
	public ?int $default_pagesize;
	public ?string $network;
	public ?int $shard;
	public ?array $phph1_apiaddresses;
	public ?array $phph1_methods;
								
	
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
	
	function getapiaddr(?string $network = 'mainnet', ?int $shard = 0){
		return $this->phph1_apiaddresses[$network][$shard];
	}
	
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
#Needs Finished:
#hmyv2_estimateGas - POSSIBLY BROKEN ON THE HARMONY SIDE SAVED FOR LAST
#hmyv2_getCode
#hmyv2_getStorageAt
######################
	
	/**
	* NEEDS TESTING
	*/
	function hmyv2_call($to, $from, $gas, $gasprice, $value, $data, $blocknum){
		/*
		Params:
		*/
		
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
	
	function val_call($to, $from, $gas, $gasprice, $value, $data, $blocknum){
		$notvalid = 0;
	
		if(!is_null($from) && !$this->val_oneaddr($from)){$notvalid = 1; array_push($this->errors, 'from address is invalid');}
		if(!is_null($gas) && is_numeric($gas) &&  !preg_match( '/^[+-]?([0-9]+\.?[0-9]*|\.[0-9]+)$/', $gas)){$notvalid = 1; array_push($this->errors, 'gas value is invalid');}
		if(!is_null($gasprice) && is_numeric($gasprice) &&  !preg_match( '/^[+-]?([0-9]+\.?[0-9]*|\.[0-9]+)$/', $gasprice)){$notvalid = 1; array_push($this->errors, 'gasprice value is invalid');}
		if(!is_null($value) && is_numeric($value) &&  !preg_match( '/^[0-9]+$/', $value)){$notvalid = 1; array_push($this->errors, 'value is invalid');}
		if(!is_null($data) && !preg_match( '/^[a-z0-9]+$/', $data)){$notvalid = 1; array_push($this->errors, 'data value is invalid');}
		
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	/*
	* FIXME
	*/
	function hmyv2_estimateGas($to, $from){
		/*
		Params:
		*/
		$method = "hmyv2_estimateGas";
		
		$urlparams = [
				[
				'scaddress' => $to,
				'from' => $from
				/*,
				'gas' => $gas,
				'gasPrice' => $gasprice,
				'value' => $value,
				'data' => $data
				],
				'blocknum' => $blocknum
				*/
				]
			];
		$this->genrequesturl($method, $urlparams);
		
		$params = [
				[
				'to' => $to
				/*,
				'from' => $from
				/*
				,
				'gas' => $gas,
				'gasPrice' => $gasprice,
				'value' => $value,
				'data' => $data
				
				],
				$blocknum*/
				]
			];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function val_estimateGas($to, $from, $gas, $gasprice, $value, $data, $blocknum){
		$notvalid = 0;
	
		if(!is_null($from) && !$this->val_hash($from)){$notvalid = 1; array_push($this->errors, 'from address is invalid');}
		if(!is_null($gas) && is_numeric($gas) &&  !preg_match( '/^[+-]?([0-9]+\.?[0-9]*|\.[0-9]+)$/', $gas)){$notvalid = 1; array_push($this->errors, 'gas value is invalid');}
		if(!is_null($gasprice) && is_numeric($gasprice) &&  !preg_match( '/^[+-]?([0-9]+\.?[0-9]*|\.[0-9]+)$/', $gasprice)){$notvalid = 1; array_push($this->errors, 'gasprice value is invalid');}
		if(!is_null($value) && is_numeric($value) &&  !preg_match( '/^[0-9]+$/', $value)){$notvalid = 1; array_push($this->errors, 'value is invalid');}
		if(!is_null($data) && !preg_match( '/^[a-z0-9]+$/', $data)){$notvalid = 1; array_push($this->errors, 'data value is invalid');}
		
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* DONE
	*/
	function hmyv2_getCode($to, $blocknum){
		/*
		Params:
		*/
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
	
	
	function hmyv2_getStorageAt($scaddress, $stlocation, $blocknum){
		/*
		Params:
		*/
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
	
	function val_getStorageAt($scaddress, $stlocation, $blocknum){
		$notvalid = 0;

		if(is_null($stlocation) && !preg_match( '/^[a-z0-9]+$/', $stlocation)){$notvalid = 1; array_push($this->errors, 'storage location hex value is invalid');}
		
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
	
	function hmyv2_getDelegationsByDelegator($deladdr){
		/*
		Params:
		$deladdr = The delegator's ONE Address		
		*/
		$method = "hmyv2_getDelegationsByDelegator";
		
		$urlparams = ['oneaddr' => $deladdr];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$deladdr];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getDelegationsByDelegatorByBlockNumber($deladdr, $blocknum){
		/*
		Params:
		$deladdr = The delegator's ONE Address		
		*/
		$method = "hmyv2_getDelegationsByDelegatorByBlockNumber";
		
		$urlparams = [
					'oneaddr' => $deladdr,
					'blocknum' => $blocknum
					];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$deladdr, $blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getDelegationsByValidator($valaddr){
		/*
		Params:
		$valaddr = The validator's ONE Address		
		*/
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

	function hmyv2_getAllValidatorAddresses(){
		$method = "hmyv2_getAllValidatorAddresses";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getAllValidatorInformation($page = 0){
		$method = "hmyv2_getAllValidatorInformation";
		
		$urlparams = ['page' => $page];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$page];
		$thisjson = $this->genjsonrequest($method, $params);
		
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getAllValidatorInformationByBlockNumber($page = -1, $blocknum){
		$method = "hmyv2_getAllValidatorInformationByBlockNumber";
		
		$urlparams = ['page' => $page, 'blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$page, $blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getElectedValidatorAddresses(){
		$method = "hmyv2_getElectedValidatorAddresses";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getValidatorInformation($valaddr){
		/*
		Params:
		$valaddr = The validator's ONE Address		
		*/
		$method = "hmyv2_getValidatorInformation";
		
		$urlparams = ['oneaddr' => $valaddr];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$valaddr];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

##########################
### STAKING -> NETWORK ###
# DONE!
##########################

	function hmyv2_getCurrentUtilityMetrics(){
		// Params:
		// NONE
		$method = "hmyv2_getCurrentUtilityMetrics";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getMedianRawStakeSnapshot(){
		// Params:
		// NONE
		
		$method = "hmyv2_getMedianRawStakeSnapshot";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getStakingNetworkInfo(){
		// Params:
		// NONE
		
		$method = "hmyv2_getStakingNetworkInfo";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

	function hmyv2_getSuperCommittees(){
		// Params:
		// NONE
		
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

	function hmyv2_getCXReceiptByHash($ctxhash){
		// Params:
		// $ctxhash = transactions hash for cx receipt
		
		$method = "hmyv2_getCXReceiptByHash";
		
		$urlparams = ['blockhash' => $ctxhash];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$ctxhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getPendingCXReceipts(){
		// Params:
		// NONE
		
		$method = "hmyv2_getPendingCXReceipts";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_resendCx($ctxhash){
		// Params:
		// $ctxhash = transactions hash for cx receipt
		
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

	function hmyv2_getPoolStats(){
		$method = "hmyv2_getPoolStats";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	/**
	* FIXME - RETURNS EMPTY ARRAY
	*/
	function hmyv2_pendingStakingTransactions(){
		$method = "hmyv2_pendingStakingTransactions";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

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

	function hmyv2_getCurrentStakingErrorSink(){
		// Params:
		// NONE
		
		$method = "hmyv2_getCurrentStakingErrorSink";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getStakingTransactionByBlockNumberAndIndex($blocknum,$txindex){
		
		$method = "hmyv2_getStakingTransactionByBlockNumberAndIndex";
		
		//FIXME
		$urlparams = ['blocknum' => $blocknum, 'txindex' => $txindex];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$blocknum,$txindex];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function val_getStakingTransactionByBlockNumberAndIndex($blocknum,$txindex){
		$notvalid = 0;

		if(!preg_match( '/^[0-9]+$/', $txindex)){$notvalid = 1; array_push($this->errors, 'transaction index value is invalid');}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
			
		}
	}
	
	function hmyv2_getStakingTransactionByBlockHashAndIndex($blockhash,$txindex){
		// Params:
		// $blockhash = The block hash
		// $txindex = The staking transactions index position
		
		$method = "hmyv2_getStakingTransactionByBlockHashAndIndex";
		
		//FIXME
		$urlparams = ['blockhash' => $blockhash, 'txindex' => $txindex];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$blockhash,$txindex];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function val_getStakingTransactionByBlockHashAndIndex($blockhash,$txindex){
		$notvalid = 0;

		if(!preg_match( '/^[0-9]+$/', $txindex)){$notvalid = 1; array_push($this->errors, 'transaction index value is invalid');}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
			
		}
	}
	
	function hmyv2_getStakingTransactionByHash($stkhash){
		// Params:
		// $stkhash = The staking transaction hash
		
		$method = "hmyv2_getStakingTransactionByHash";
		
		$urlparams = ['blockhash' => $stkhash];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$stkhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	// NEED INFO
	/*
	function hmyv2_sendRawStakingTransaction($trcencbyt,$rawtranhash){
		// Params:
		// $trcencbyt = Transaction encoded in bytes
		// $rawtranhash = Raw transaction's hash
		
		$method = "hmyv2_sendRawStakingTransaction";
		$params = [$trcencbyt,$rawtranhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	*/

###############################
### TRANSACTION -> TRANSFER ###
###############################

	function hmyv2_getCurrentTransactionErrorSink(){
		// Params:
		// NONE
		
		$method = "hmyv2_getCurrentTransactionErrorSink";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getTransactionByBlockHashAndIndex($blockhash,$txindex){
		/*
		Params:
		$blockhash = The blockhash
		$txindex = The transaction index number
		*/
		$method = "hmyv2_getTransactionByBlockHashAndIndex";
		
		$urlparams = ['blockhash' => $blockhash, 'txindex' => $txindex];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$blockhash,$txindex];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function val_getTransactionByBlockHashAndIndex($blockhash,$tindex){
		$notvalid = 0;
		if(isset($tindex) && is_numeric($tindex) &&  !preg_match( '/^[0-9]+$/', $tindex)){$notvalid = 1; array_push($this->errors, 'tindex value is invalid');}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function hmyv2_getTransactionByBlockNumberAndIndex($blocknum,$txindex){
		/*
		Params:
		$blocknum = The block number
		$txindex = The transaction index number
		*/
		$method = "hmyv2_getTransactionByBlockNumberAndIndex";
		
		$urlparams = ['blocknum' => $blocknum, 'txindex' => $txindex];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$blocknum,$txindex];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function val_getTransactionByBlockNumberAndIndex($blocknum,$tindex){
		$notvalid = 0;
		if(isset($tindex) && is_numeric($tindex) &&  !preg_match( '/^[0-9]+$/', $tindex)){$notvalid = 1; array_push($this->errors, 'tindex value is invalid');}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function hmyv2_getTransactionByHash($transhash){
		/*
		Params:
		$transhash = The transaction hash
		*/
		$method = "hmyv2_getTransactionByHash";
		
		$urlparams = ['blockhash' => $transhash];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$transhash];
		$thisjson = $this->genjsonrequest($method, $params);
		
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getTransactionReceipt($transhash){
		/*
		Params:
		$transhash = The transaction hash
		*/
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
#hmyv2_getLastCrossLinks
#hmyv2_getLeader
#hmyv2_getShardingStructure
#hmyv2_getValidatorKeys
#############################

	function hmyv2_blockNumber(){
		/*
		Params:
		NONE
		*/
		$method = "hmyv2_blockNumber";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getCirculatingSupply(){
		// Params:
		// NONE
		
		$method = "hmyv2_getCirculatingSupply";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getEpoch(){
		/*
		Params:
		NONE
		*/
		$method = "hmyv2_getEpoch";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getLastCrossLinks(){
		/*
		Params:
		NONE
		*/
		$method = "hmyv2_getLastCrossLinks";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getLeader(){
		/*
		Params:
		NONE
		*/
		$method = "hmyv2_getLeader";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_gasPrice(){
		/*
		Params:
		NONE
		*/
		$method = "hmyv2_gasPrice";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getShardingStructure(){
		/*
		Params:
		NONE
		*/
		$method = "hmyv2_getShardingStructure";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getTotalSupply(){
		// Params:
		// NONE
		
		$method = "hmyv2_getTotalSupply";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getValidators(?int $epoch = 1){
		/*
		Params:
		$epoch = 		
		*/
		$method = "hmyv2_getValidators";
		
		$urlparams = ['epoch' => $epoch];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$epoch];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getValidatorKeys(?int $epoch = 1){
		/*
		Params:
		$epoch = 		
		*/
		$method = "hmyv2_getValidatorKeys";
		
		$urlparams = ['epoch' => $epoch];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$epoch];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

##########################
### BLOCKCHAIN -> NODE ###
#Need Finished:
#hmyv2_getCurrentBadBlocks
#hmyv2_getNodeMetadata
#net_peerCount
##########################
	
	function hmyv2_getCurrentBadBlocks(){
		/*
		Params:
		NONE
		*/
		$method = "hmyv2_getCurrentBadBlocks";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getNodeMetadata(){
		/*
		Params:
		NONE
		*/
		$method = "hmyv2_getNodeMetadata";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	

	function hmyv2_protocolVersion(){
		/*
		Params:
		NONE
		*/
		$method = "hmyv2_protocolVersion";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function net_peerCount(){
		/*
		Params:
		NONE
		*/
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
#Need Finished:
#hmyv2_getBlockSignersKeys
#hmyv2_getHeaderByNumber
#hmyv2_getLatestChainHeaders
############################

	function hmyv2_getBlocks($strtblocknum,$endblocknum,$fulltxt = TRUE,$withsigners = FALSE,$inclstaking = FALSE){
		/*
		Params:
		$strtblocknum = The starting block number
		$endblocknum = The ending block number
		$fulltxt = To show full tx or not (TRUE or FALSE)
		$withsigners = Include block signes in blocks or not (TRUE or FALSE)
		$inclstaking = To show staking txs or not (TRUE or FALSE)
		*/
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
		//if(isset($blocknum) && !preg_match( '/^[0-9]+$/', $blocknum)){$notvalid = 1; echo '<br />$blocknum:'.$blocknum;}
		if(isset($fulltx) && $fulltx != TRUE && $fulltx != FALSE && !is_bool($fulltx)){$notvalid = 1; array_push($this->errors, 'fulltx value is invalid');}
		//if(isset($incltx) && $incltx != TRUE && $incltx != FALSE && !is_bool($incltx)){$notvalid = 1; echo '<br />$incltx:'.$incltx;}
		if(isset($inclstaking) && $inclstaking != TRUE && $inclstaking != FALSE && !is_bool($inclstaking)){$notvalid = 1; array_push($this->errors, 'inclstaking value is invalid');}
		if(isset($withsigners) && $withsigners != TRUE && $withsigners != FALSE && !is_bool($withsigners)){$notvalid = 1; array_push($this->errors, 'withsigners value is invalid');}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}

	function hmyv2_getBlockByNumber($blocknum, $fulltx=true, $incltx=false, $withsigners=false, $inclstaking=false){
		/*
		Params:
		$blocknum = The block number
		$fulltx = To show full tx or not (TRUE or FALSE)
		$incltx = Include block signers in blocks or not (TRUE or FALSE)
		$inclstaking =  Include regular transactions (TRUE or FALSE)
		*/
		//echo "withsigners:".$withsigners;
		
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
		//if(isset($blocknum) && !preg_match( '/^[0-9]+$/', $blocknum)){$notvalid = 1; echo '<br />$blocknum:'.$blocknum;}
		if(isset($fulltx) && $fulltx != TRUE && $fulltx != FALSE && !is_bool($fulltx)){$notvalid = 1; array_push($this->errors, 'fulltx value is invalid');}
		if(isset($incltx) && $incltx != TRUE && $incltx != FALSE && !is_bool($incltx)){$notvalid = 1; array_push($this->errors, 'incltx value is invalid');;}
		if(isset($inclstaking) && $inclstaking != TRUE && $inclstaking != FALSE && !is_bool($inclstaking)){$notvalid = 1; array_push($this->errors, 'inclstaking value is invalid');}
		if(isset($withsigners) && $withsigners != TRUE && $withsigners != FALSE && !is_bool($withsigners)){$notvalid = 1; array_push($this->errors, 'withsigners value is invalid');}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function hmyv2_getBlockByHash($blockhash,$fulltx = true,$incltx=false,$withsigners = false,$inclstaking = false){
		/*
		Params:
		$blocknum = The block hash
		$fulltxt = To show full tx or not (TRUE or FALSE)
		$withsigners = Include block signes in blocks or not (TRUE or FALSE)
		$inclstaking = To show staking txs or not (TRUE or FALSE)
		*/
		#$xparams = array($fulltxt,$withsigners,$inclstaking);
		
		$method = "hmyv2_getBlockByHash";
		
		$urlparams = [
				'blockhash' => $blockhash,
				[
				'fullTx' => $fulltx,
				'inclTx' => $incltx,
				'withSigners' => $withsigners,
				'inclStaking' => $inclstaking
				]
				];
				
		$this->genrequesturl($method, $urlparams);
		
		
		$params = [
				$blockhash,
				[
				'fulltx' => $fulltx,
				'incltx' => $incltx,
				'withsigners' => $withsigners,
				'inclstaking' => $inclstaking
				]
				];
				
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function val_getBlockByHash($blockhash,$fulltx,$inclTx,$withsigners,$inclstaking){
		$notvalid = 0;
		if(isset($fulltx) && $fulltx != TRUE && $fulltx != FALSE && !is_bool($fulltx)){$notvalid = 1; array_push($this->errors, 'fulltx value is invalid');}
		if(isset($incltx) && $incltx != TRUE && $incltx != FALSE && !is_bool($incltx)){$notvalid = 1; array_push($this->errors, 'incltx value is invalid');}
		if(isset($inclstaking) && $inclstaking != TRUE && $inclstaking != FALSE && !is_bool($inclstaking)){$notvalid = 1; array_push($this->errors, 'inclstaking value is invalid');}
		if(isset($withsigners) && $withsigners != TRUE && $withsigners != FALSE && !is_bool($withsigners)){$notvalid = 1; array_push($this->errors, 'withsigners value is invalid');}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function hmyv2_getBlockSigners($blocknum){
		// Params:
		// $startingblocknum = Starting block number
		// $endingblocknum = Ending block number
		
		$method = "hmyv2_getBlockSigners";
		
		$urlparams = ['blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);

		return $this->docurlrequest($thisjson);
	}
	
	
	function hmyv2_getBlockSignersKeys($blocknum){
		// Params:
		// $startingblocknum = Starting block number
		// $endingblocknum = Ending block number
		
		$method = "hmyv2_getBlockSignersKeys";
		
		$urlparams = ['blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getBlockTransactionCountByNumber($blocknum){
		/*
		Params:
		$blocknum = The block number
		*/
		$method = "hmyv2_getBlockTransactionCountByNumber";
		
		$urlparams = ['blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getBlockTransactionCountByHash($blockhash){
		/*
		Params:
		$blockhash = The block hash
		*/
		$method = "hmyv2_getBlockTransactionCountByHash";
		
		$urlparams = ['blockhash' => $blockhash];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$blockhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

	function hmyv2_getHeaderByNumber($blocknum){
		/*
		Params:
		$blocknum = The block number
		*/
		$method = "hmyv2_getHeaderByNumber";
		
		$urlparams = ['blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

	function hmyv2_getLatestChainHeaders(){
		/*
		Params:
		$blocknum = The block number
		*/
		$method = "hmyv2_getLatestChainHeaders";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

	function hmyv2_latestHeader(){
		/*
		Params:
		NONE
		*/
		$method = "hmyv2_latestHeader";
		$params = [];
		
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

################
### ACCOUNT ###
#Needs Finished:
#hmyv2_getStakingTransactionsCount
#hmyv2_getStakingTransactionsHistory

################

	function hmyv2_getBalance($oneaddr){
		/*
		Params:
		$oneaddr = The ONE address
		*/
		$method = "hmyv2_getBalance";
		
		$urlparams = ['oneaddr' => $oneaddr];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$oneaddr];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getBalanceByBlockNumber($oneaddr, $blocknum){
		/*
		Params:
		$oneaddr = The ONE address
		$blocknum = The block number
		*/
		$method = "hmyv2_getBalanceByBlockNumber";
		
		$urlparams = ['oneaddr' => $oneaddr,'blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$oneaddr,$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	
	function hmyv2_getStakingTransactionsCount($oneaddr, $txtype = 'ALL'){
		/*
		Params:
		$oneaddr = The ONE address
		$txtype = Transaction type ('SENT', 'RECEIVED', 'ALL')
		*/
		$method = "hmyv2_getStakingTransactionsCount";
		
		$urlparams = ['oneaddr' => $oneaddr, 'txtype' => $txtype];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$oneaddr,$txtype];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getStakingTransactionsHistory($oneaddr,?int $page = 1,?int $pagesize = 10, ?bool $fulltx = true, ?string $txtype = 'ALL', ?string $order = 'DESC'){
		/*
		Params:
		$oneaddr = The ONE Address
		$page = The Page number of requests (use the REAL page number, our pages never start at 0)
		$order = The order of the results by date. Options are ASC (ascending) or DESC (descending)
		$txtype = The transaction direction. Options are SENT (returns transactions sent by ONE address), RECEIVED (returns transactions sent by ONE address), or ALL (Get all transactions)
		*/
		settype($fulltx, 'bool');
		
		$method = "hmyv2_getStakingTransactionsHistory";
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
					
		$this->genrequesturl($method, $params);
		
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getTransactionsCount($oneaddr,?string $txtype = 'ALL'){
		/*
		Params:
		$oneaddr = The ONE address
		$txtype = Choice is 'ALL' or 'SENT' or 'RECEIVED'
		*/
		$method = "hmyv2_getTransactionsCount";
		
		$urlparams = ['oneaddr' => $oneaddr,'txtype' => $txtype];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$oneaddr,$txtype];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function val_getTransactionsCount($oneaddr,$txtype){
		$notvalid = 0;

		if(isset($txtype) && $txtype != 'SENT' && $txtype != 'RECEIVED' && $txtype != 'ALL'){$notvalid = 1; array_push($this->errors, 'Invalid Transaction Type');}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function hmyv2_getTransactionsHistory($oneaddr,?int $page = 1,?int $pagesize = 10, ?bool $fulltx = true, ?string $txtype = 'ALL', ?string $order = 'DESC'){
		/*
		Params:
		$oneaddr = The ONE Address
		$page = The Page number of requests (use the REAL page number, our pages never start at 0)
		$order = The order of the results by date. Options are ASC (ascending) or DESC (descending)
		$txtype = The transaction direction. Options are SENT (returns transactions sent by ONE address), RECEIVED (returns transactions sent by ONE address), or ALL (Get all transactions)
		*/
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

		if(isset($page) && !preg_match( '/^[0-9]+$/', $page)){$notvalid = 1; array_push($this->errors, 'Invalid Page Number');}
		if(isset($pagesize) && !preg_match( '/^[0-9]+$/', $pagesize) && $pagesize <= 200){$notvalid = 1; array_push($this->errors, 'Invalid Page Size');}
		if(isset($txtype) && $txtype != 'SENT' && $txtype != 'RECEIVED' && $txtype != 'ALL'){$notvalid = 1; array_push($this->errors, 'Invalid Transaction Type');}
		if(isset($order) && $order != 'DESC' && $order != 'ASC'){$notvalid = 1; array_push($this->errors, 'Invalid Order');}
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
		/*
		Params:
		$blocknum = The block number
		$valaddr = The validator's ONE Address		
		*/
		$method = "hmyv2_isBlockSigner";
		
		$urlparams = ['oneaddr' => $valaddr, 'blocknum' => $blocknum];
		$this->genrequesturl($method, $urlparams);
		
		$params = [$blocknum,$valaddr];
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
		if(isset($addr) && preg_match( '/^[a-z0-9]+$/', $addr) && substr($addr, 0, 4) == "one1" && strlen($addr) == 42){
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
		if(isset($blockhash) && preg_match( '/^[a-z0-9]+$/', $blockhash) && strlen($blockhash) <= 66){
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
		if(isset($hash) && preg_match( '/^[a-z0-9]+$/', $hash) && strlen($hash) <= 66){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_scaddress($scaddress){
		if(isset($scaddress) && preg_match( '/^[a-zA-Z0-9]+$/', $scaddress) && strlen($scaddress) <= 66){
			return 1;
		}else{
			return 0;
		}
	}
	
	
	function val_stlocation($stlocation){
		if(isset($stlocation) && preg_match( '/^[a-zA-Z0-9]+$/', $stlocation) && strlen($stlocation) <= 66){
			return 1;
		}else{
			return 0;
		}
	}

}

?>
