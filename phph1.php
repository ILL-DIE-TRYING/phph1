<?php

class phph1{
	
	public ?string $apiaddr;
	public ?string $blockaddr;
	public ?string $blocknum;
	public ?string $blocknum2;
	public ?string $blockhash;
	public ?string $hash;
	public ?string $oneaddr;
	public ?string $lastjson;
	public ?int $phph1_debug;
	public ?array $methods;
	public ?int $maxpagesize;
	
	function __construct(?string $apiaddr = null, ?int $phph1_debug = 0 ){
		$this->apiaddr = $apiaddr;
		$this->phph1_debug = $phph1_debug;
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
	
	
	
	#####################################
	### BLOCKCHAIN->PROTOCOL REQUESTS ###
	#####################################
	
	
	function hmyv2_protocolVersion(){
		/*
		Params:
		NONE
		*/
		$method = "hmyv2_protocolVersion";
		$params = [];
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
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	##################################
	### BLOCKCHAIN->BLOCK REQUESTS ###
	##################################
	
	
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
		$params = [
				$blocknum,
				[
				'fullTx' => $fulltx,
				'inclTx' => $incltx,
				'inclStaking' => $inclstaking,
				'withSigners' => $withsigners
				]
				];
		
		if($this->phph1_debug == 1){
			echo "<pre style='color:blue;'><br />hmyv2_getBlockByNumber PARAMS ARRAY:<br />";
			print_r($params);
			echo "</pre>";
		}
		
		$thisjson = $this->genjsonrequest($method, $params);
		
		if($this->phph1_debug == 1){
			echo "<pre style='color:blue;'><br />hmyv2_getBlockByNumber JSON REQUEST:<br />";
			echo $thisjson;
			echo "</pre>";
		}
		
		return $this->docurlrequest($thisjson);
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
		$params = [
				$blockhash,
				[
				'fullTx' => $fulltx,
				'inclTx' => $incltx,
				'withSigners' => $withsigners,
				'inclStaking' => $inclstaking
				]
				];
		#print_r($params);
		$thisjson = $this->genjsonrequest($method, $params);
		#print_r($thisjson);
		return $this->docurlrequest($thisjson);
	}
	
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
	
	function hmyv2_getBlockTransactionCountByHash($blockhash){
		/*
		Params:
		$blockhash = The block hash
		*/
		$method = "hmyv2_getBlockTransactionCountByHash";
		$params = [
				$blockhash
				];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	
	function hmyv2_getBlockTransactionCountByNumber($blocknum){
		/*
		Params:
		$blocknum = The block number
		*/
		$method = "hmyv2_getBlockTransactionCountByNumber";
		$params = [$blocknum];
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
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	
	function hmyv2_blockNumber(){
		/*
		Params:
		NONE
		*/
		$method = "hmyv2_blockNumber";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}


	########################
	### ACCOUNT REQUESTS ###
	########################

	function hmyv2_getBalance($oneaddr){
		echo "address:".$oneaddr;
		/*
		Params:
		$oneaddr = The ONE address
		*/
		$method = "hmyv2_getBalance";
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
		$params = [$oneaddr,$blocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getTransactionsCount($oneaddr,?string $trtype = 'ALL'){
		/*
		Params:
		$oneaddr = The ONE address
		$trtype = Choice is 'ALL' or 'SENT' or 'RECEIVED'
		*/
		$method = "hmyv2_getTransactionsCount";
		$params = [$oneaddr,$trtype];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

	############################
	### TRANSACTION REQUESTS ###
	############################
	
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
	
	
	function hmyv2_getTransactionByHash($transhash){
		/*
		Params:
		$transhash = The transaction hash
		*/
		$method = "hmyv2_getTransactionByHash";
		$params = [ $transhash ];
		$thisjson = $this->genjsonrequest($method, $params);
		if($this->debug == 1){
			echo "<p style='color:green;'>";
			print_r($thisjson);
			echo "</p>";
		}
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getTransactionReceipt($transhash){
		/*
		Params:
		$transhash = The transaction hash
		*/
		$method = "hmyv2_getTransactionReceipt";
		$params = [$transhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	
	function hmyv2_getTransactionByBlockNumberAndIndex($blocknum,$txindex){
		/*
		Params:
		$blocknum = The block number
		$txindex = The transaction index number
		*/
		$method = "hmyv2_getTransactionByBlockNumberAndIndex";
		$params = [$blocknum,$txindex];
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
		$params = [$blockhash,$txindex];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	
	function hmyv2_pendingTransactions(){
		$method = "hmyv2_pendingTransactions";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	

	function hmyv2_getTransactionsHistory($oneaddr,?int $page = 1,?int $pagesize = 10, ?bool $fulltx = TRUE, ?string $txtype = 'ALL', ?string $order = 'DESC'){
		/*
		Params:
		$oneaddr = The ONE Address
		$page = The Page number of requests (use the REAL page number, our pages never start at 0)
		$order = The order of the results by date. Options are ASC (ascending) or DESC (descending)
		$txtype = The transaction direction. Options are SENT (returns transactions sent by ONE address), RECEIVED (returns transactions sent by ONE address), or ALL (Get all transactions)
		*/
		$method = "hmyv2_getTransactionsHistory";
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
					#echo "<br />"; 
					#print_r($params);
		$thisjson = $this->genjsonrequest($method, $params);
		#print_r($thisjson);
		return $this->docurlrequest($thisjson);
	}

	########################
	### STAKING REQUESTS ###
	########################
	
	###################################
	### STAKING->VALIDATOR REQUESTS ###
	###################################
	
	function hmyv2_getValidators(?int $epoch = 1){
		/*
		Params:
		$epoch = 		
		*/
		$method = "hmyv2_getValidators";
		$params = [$epoch];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	
	function hmyv2_getAllValidatorAddresses(){
		$method = "hmyv2_getAllValidatorAddresses";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	
	function hmyv2_getAllValidatorInformation($page = 0){
		$method = "hmyv2_getAllValidatorInformation";
		$params = [$page];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	
	function hmyv2_getElectedValidatorAddresses(){
		$method = "hmyv2_getElectedValidatorAddresses";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	
	function hmyv2_getValidatorInformation($valaddr){
		/*
		Params:
		$valaddr = The validator's ONE Address		
		*/
		$method = "hmyv2_getValidatorInformation";
		$params = [$valaddr];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	
	function hmyv2_isBlockSigner($valaddr,$blocknum){
		/*
		Params:
		$blocknum = The block number
		$valaddr = The validator's ONE Address		
		*/
		$method = "hmyv2_isBlockSigner";
		$params = [$blocknum,$valaddr];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	
	function hmyv2_getDelegationsByValidator($valaddr){
		/*
		Params:
		$valaddr = The validator's ONE Address		
		*/
		$method = "hmyv2_getDelegationsByValidator";
		$params = [$valaddr];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	###################################
	### STAKING->DELEGATOR REQUESTS ###
	###################################
	
	
	function hmyv2_getDelegationsByDelegator($deladdr){
		/*
		Params:
		$deladdr = The delegator's ONE Address		
		*/
		$method = "hmyv2_getDelegationsByDelegator";
		$params = [$deladdr];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	#####################################
	### STAKING->TRANSACTION REQUESTS ###
	#####################################
	
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
	
	function hmyv2_getStakingTransactionByHash($stkhash){
		// Params:
		// $stkhash = The staking transaction hash
		
		$method = "hmyv2_getStakingTransactionByHash";
		$params = [$stkhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getStakingTransactionByBlockNumberAndIndex($stkblockindex,$stktransindex){
		// Params:
		// $stkblockindex = The block's index number in the chain
		// $stktransindex = The staking transactions index position
		
		$method = "hmyv2_getStakingTransactionByBlockNumberAndIndex";
		$params = [$stkblockindex,$stktransindex];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	
	function hmyv2_getStakingTransactionByBlockHashAndIndex($stkblockhash,$stktransindex){
		// Params:
		// $stkblockhash = The block hash
		// $stktransindex = The staking transactions index position
		
		$method = "hmyv2_getStakingTransactionByBlockHashAndIndex";
		$params = [$stkblockhash,$stktransindex];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	#################################
	### STAKING->UTILITY REQUESTS ###
	#################################
	
	function hmyv2_getCurrentUtilityMetrics(){
		// Params:
		// NONE
		
		$method = "hmyv2_getCurrentUtilityMetrics";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getSuperCommittees(){
		// Params:
		// NONE
		
		$method = "hmyv2_getSuperCommittees";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getStakingNetworkInfo(){
		// Params:
		// NONE
		
		$method = "hmyv2_getStakingNetworkInfo";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getMedianRawStakeSnapshot(){
		// Params:
		// NONE
		
		$method = "hmyv2_getMedianRawStakeSnapshot";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getBlockSigners($stkblocknum){
		// Params:
		// $stkblocknum = Stake block number
		
		$method = "hmyv2_getBlockSigners";
		$params = [$stkblocknum];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getCirculatingSupply(){
		// Params:
		// NONE
		
		$method = "hmyv2_getCirculatingSupply";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getTotalSupply(){
		// Params:
		// NONE
		
		$method = "hmyv2_getTotalSupply";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	################################
	### STAKING->ERRORS REQUESTS ###
	################################
	
	
	function hmyv2_getCurrentStakingErrorSink(){
		// Params:
		// NONE
		
		$method = "hmyv2_getCurrentStakingErrorSink";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}

	#########################
	### CONTRACT REQUESTS ###
	#########################
	
	/*
	NONE AVAILABLE
	*/

	############################
	### CROSS SHARD REQUESTS ###
	############################
	
	
	function hmyv2_getPendingCXReceipts(){
		// Params:
		// NONE
		
		$method = "hmyv2_getPendingCXReceipts";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getCXReceiptByHash($ctxhash){
		// Params:
		// $ctxhash = transactions hash for cx receipt
		
		$method = "hmyv2_getCXReceiptByHash";
		$params = [$ctxhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_resendCx($ctxhash){
		// Params:
		// $ctxhash = transactions hash for cx receipt
		
		$method = "hmyv2_resendCx";
		$params = [$ctxhash];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	
	##########################
	### CROSSLINK REQUESTS ###
	##########################
	
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
	
	#######################
	### ERRORS REQUESTS ###
	#######################
	
	function hmyv2_getCurrentTransactionErrorSink(){
		// Params:
		// NONE
		
		$method = "hmyv2_getCurrentTransactionErrorSink";
		$params = [];
		$thisjson = $this->genjsonrequest($method, $params);
		return $this->docurlrequest($thisjson);
	}
	

	#################################
	### INPUT VALIDATION REQUESTS ###
	#################################
	
	function convertsci($scinum){
		return ($scinum / 1e+18);
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
		if(isset($blocknum) && preg_match( '/^[0-9]+$/', $blocknum) && strlen($blocknum) <= 20){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_blockhash($blockhash){
		if(isset($blockhash) && preg_match( '/^[a-z0-9]+$/', $blockhash) && strlen($blockhash) <= 100){
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
		if(isset($hash) && preg_match( '/^[a-z0-9]+$/', $hash) && strlen($hash) <= 100){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_getTransactionsHistory($oneaddr,$page,$pagesize,$fulltx,$txtype,$order){
		$notvalid = 0;
		if(isset($page) && !preg_match( '/^[0-9]+$/', $page)){$notvalid = 1; echo '<br />$page:'.$page;}
		if(isset($pagesize) && !preg_match( '/^[0-9]+$/', $pagesize) && $pagesize <= 50){$notvalid = 1; echo '<br />$pagesize:'.$pagesize;}
		if(isset($txtype) && $txtype != 'SENT' && $txtype != 'RECEIVED' && $txtype != 'ALL'){$notvalid = 1; echo '<br />$txtype:'.$txtype;}
		if(isset($order) && $order != 'DESC' && $order != 'ASC'){$notvalid = 1; echo '<br />$order:'.$order;}
		if(isset($fulltx) && $fulltx != TRUE && $fulltx != FALSE){$notvalid = 1; echo '<br />$fulltx:'.$fulltx;}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_getBlockByNumber($blocknum,$fulltx,$incltx,$withsigners,$inclstaking){
		$notvalid = 0;
		//if(isset($blocknum) && !preg_match( '/^[0-9]+$/', $blocknum)){$notvalid = 1; echo '<br />$blocknum:'.$blocknum;}
		if(isset($fulltx) && $fulltx != TRUE && $fulltx != FALSE && !is_bool($fulltx)){$notvalid = 1; echo '<br />$fulltx:'.$fulltx;}
		if(isset($incltx) && $incltx != TRUE && $incltx != FALSE && !is_bool($incltx)){$notvalid = 1; echo '<br />$incltx:'.$incltx;}
		if(isset($inclstaking) && $inclstaking != TRUE && $inclstaking != FALSE && !is_bool($inclstaking)){$notvalid = 1; echo '<br />$inclstaking:'.$inclstaking;}
		if(isset($withsigners) && $withsigners != TRUE && $withsigners != FALSE && !is_bool($withsigners)){$notvalid = 1; echo '<br />$withsigners:'.$withsigners;}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_getBlocks($blocknum1,$blocknum2,$fulltx,$withsigners,$inclstaking){
		$notvalid = 0;
		//if(isset($blocknum) && !preg_match( '/^[0-9]+$/', $blocknum)){$notvalid = 1; echo '<br />$blocknum:'.$blocknum;}
		if(isset($fulltx) && $fulltx != TRUE && $fulltx != FALSE && !is_bool($fulltx)){$notvalid = 1; echo '<br />$fulltx:'.$fulltx;}
		//if(isset($incltx) && $incltx != TRUE && $incltx != FALSE && !is_bool($incltx)){$notvalid = 1; echo '<br />$incltx:'.$incltx;}
		if(isset($inclstaking) && $inclstaking != TRUE && $inclstaking != FALSE && !is_bool($inclstaking)){$notvalid = 1; echo '<br />$inclstaking:'.$inclstaking;}
		if(isset($withsigners) && $withsigners != TRUE && $withsigners != FALSE && !is_bool($withsigners)){$notvalid = 1; echo '<br />$withsigners:'.$withsigners;}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_getBlockByHash($blockhash,$fulltx,$inclTx,$withsigners,$inclstaking){
		$notvalid = 0;
		if(isset($fulltx) && $fulltx != TRUE && $fulltx != FALSE && !is_bool($fulltx)){$notvalid = 1; echo '<br />$fulltx:'.$fulltx;}
		if(isset($incltx) && $incltx != TRUE && $incltx != FALSE && !is_bool($incltx)){$notvalid = 1; echo '<br />$incltx:'.$incltx;}
		if(isset($inclstaking) && $inclstaking != TRUE && $inclstaking != FALSE && !is_bool($inclstaking)){$notvalid = 1; echo '<br />$inclstaking:'.$inclstaking;}
		if(isset($withsigners) && $withsigners != TRUE && $withsigners != FALSE && !is_bool($withsigners)){$notvalid = 1; echo '<br />$withsigners:'.$withsigners;}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	
	function val_getTransactionByBlockNumberAndIndex($blocknum,$tindex){
		$notvalid = 0;
		if(isset($tindex) && is_numeric($tindex) &&  !preg_match( '/^[0-9]+$/', $tindex)){$notvalid = 1; echo '<br />$tindex:'.$tindex;}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function val_getTransactionByBlockHashAndIndex($blockhash,$tindex){
		$notvalid = 0;
		if(isset($tindex) && is_numeric($tindex) &&  !preg_match( '/^[0-9]+$/', $tindex)){$notvalid = 1; echo '<br />$tindex:'.$tindex;}
		
		if($notvalid == 0){
			return 1;
		}else{
			return 0;
		}
	}
	
}

?>
