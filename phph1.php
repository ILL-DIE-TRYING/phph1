<?php


// This stuff would usually go into a config.php or similar file
// It needs to be worked on so we have all shard addresses and shard selection

// Which net to use. 0 = testnet, 1 = mainnet
$usemainnet = 0;
if($usemainnet == 1){
	echo "<h4 style='background-color:red;color:white;'>USING MAINNET</h4>";
	##### MAINNET SHARD 0 #####
	$apiaddr = 'https://a.api.s0.t.hmny.io';
	###################
}else{
	echo "<h4 style='background-color:green;color:white;'>USING TESTNET</h4>";
	##### TESTNET SHARD 0 #####
	$apiaddr = 'https://rpc.s0.b.hmny.io/';
	###################
}


/*

### DUMMY TEST WALLET ###

ONE ADDRESS: one1wumxurmevpqxxksz5azvlhsswx6qj5uc9gt8j3
ETH ADDRESS: 0x71b6810fdd93a1fc8e0ad8bc63ed6f874f91a983

### DUMMY TRANSACTION DATA (FROM TEST WALLET) ###

[blockHash] => 0x1dd65e4247d630cb07efc40e8a86cb3148a3c4602f33401f23defc1577312a72
[blockNumber] => 20898901
[ethHash] => 0x3a8b906d3048bb7b45f43ffc5c9fb3665166d2484fa89a795f53e328ce80e49d
[from] => one1wumxurmevpqxxksz5azvlhsswx6qj5uc9gt8j3
[gas] => 21000
[gasPrice] => 30000000000
[hash] => 0xe090e89a5f1fb360950e4284ef1fa91634b14b419ef7c5a2962a9e59cd15974a
[input] => 0x
[nonce] => 0
[r] => 0x290cc51b32e64fd73d77be58f0c0c79bee966fb8373cf9851edc19627f2b6f57
[s] => 0x69f171643028216a55b5ecfcabd2789f9ea23b90aa34273116ea3b9dfbef0107
[shardID] => 0
[timestamp] => 1643722860
[to] => one1wxmgzr7ajwslers2mz7x8mt0sa8er2vr7qwn08
[toShardID] => 0
[transactionIndex] => 0
[v] => 0xc6afa5e4
[value] => 1.0E+19

### DUMMY STAKING TRANSACTION DATA (FROM OTHER TEST WALLET) ###

## PAY ATTENTION! THE SECOND WALLET ADDRESS! USE one1wxmgzr7ajwslers2mz7x8mt0sa8er2vr7qwn08 ##

[blockHash] => 0xfd2af250314ac90ec610a68e4274c73d821e5173f41ac0dd1fc57c8d961bee99
[blockNumber] => 20913185
[from] => one1wxmgzr7ajwslers2mz7x8mt0sa8er2vr7qwn08
[gas] => 45000
[gasPrice] => 30000000000
[hash] => 0xa90c6a4ed102f615c1f85ba88608d4ff163d38a0b2310a6ae7ea06ad8905fbf6
[msg] => Array
		(
		[amount] => 1.01E+20
		[delegatorAddress] => one1wxmgzr7ajwslers2mz7x8mt0sa8er2vr7qwn08
		[validatorAddress] => one1xjanr7lgulc0fqyc8dmfp6jfwuje2d94xfnzyd
		)

[nonce] => 0
[r] => 0xc7df9ce01919f5d012b1c880085d46e4820e96baec36e470a2a898605813160c
[s] => 0xc290411b3395ce196b3b935458741b12dde7e3fea8ff6c8fbd7ca4541186cbe
[timestamp] => 1643751676
[transactionIndex] => 0
[type] => Delegate
[v] => 0x27

### A NODE API FUNCTION TEMPLATE ###

function REPLACEME($oneaddr){
	// Params:
	// $oneaddr = The ONE address
	
	$method = "REPLACEME";
	$params = [$oneaddr];
	$thisjson = $this->genjsonrequest($method, $params);
	return $this->docurlrequest($thisjson);
}
*/
class phph1{
	
	public ?string $apiaddr;
	public ?string $blockaddr;
	public ?string $oneaddr;
	public ?int $debug;
	public $methods;
	
	function __construct(?string $apiaddr = null,?string $blockaddr = null,?string $oneaddr = null, ?int $debug = 0, $methods = null ){
		$this->apiaddr = $apiaddr;
		$this->blockaddr = $blockaddr;
		$this->oneaddr = $oneaddr;
		$this->debug = $debug;
		$this->methods = $methods;
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
		if($this->debug == 1){
			echo "<p style='color:green;'>";
			print_r($paramsarr);
			echo "</p>";
		}
		
		if(!empty($paramsarr)){
			#echo "ONE";
			$rdata = array(
				'jsonrpc' => "2.0",
				'id' => 1,
				'method' => $method,
				'params' => $paramsarr
			);
		}else{
			#echo "TWO";
			$rdata = array(
				'jsonrpc' => "2.0",
				'id' => 1,
				'method' => $method,
				'params' => [],
			);
		}
		
		if($this->debug == 1){
			echo "<p style='color:green;'>";
			print_r($rdata);
			echo "</p>";
		}
		
		$thisjson = json_encode($rdata);
		
		if($this->debug == 1){
			echo "<p style='color:green;'>";
			print_r($thisjson);
			echo "</p>";
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
	
	
	function hmyv2_getBlockByNumber($blocknum,$fulltxt = true,$withsigners = false,$inclstaking = false){
		/*
		Params:
		$blocknum = The block number
		$fulltxt = To show full tx or not (TRUE or FALSE)
		$withsigners = Include block signers in blocks or not (TRUE or FALSE)
		$inclstaking = To show staking txs or not (TRUE or FALSE)
		*/
		$method = "hmyv2_getBlockByNumber";
		$params = [
				$blocknum,
				[
				'fullText' => $fulltxt,
				'inclTx' => $withsigners,
				'inclStaking' => $inclstaking
				]
				];
		#print_r($xtraparams);
		$thisjson = $this->genjsonrequest($method, $params);
		#print_r($thisjson);
		return $this->docurlrequest($thisjson);
	}
	
	function hmyv2_getBlockByHash($blockhash,$fulltxt = true,$withsigners = false,$inclstaking = false){
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
				'fullText' => $fulltxt,
				'inclTx' => $withsigners,
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
				'fullText' => $fulltxt,
				'inclTx' => $withsigners,
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
	
	function hmyv2_getTransactionsCount($oneaddr,$trtype = 'ALL'){
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
	

	function hmyv2_getTransactionsHistory($oneaddress,$page = 1,$pagesize=10,$txtype='ALL',$order='DESC', $fulltx = true){
		/*
		Params:
		$oneaddress = The ONE Address
		$page = The Page number of requests (use the REAL page number, our pages never start at 0)
		$order = The order of the results by date. Options are ASC (ascending) or DESC (descending)
		$txtype = The transaction direction. Options are SENT (returns transactions sent by ONE address), RECEIVED (returns transactions sent by ONE address), or ALL (Get all transactions)
		*/
		$method = "hmyv2_getTransactionsHistory";
		$params = array(
				[
					'address' => $oneaddress,
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
		return $this->docurlrequest($thisjson);
	}

	########################
	### STAKING REQUESTS ###
	########################
	
	###################################
	### STAKING->VALIDATOR REQUESTS ###
	###################################
	
	function hmyv2_getValidators($epoch = 1){
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

	function chkoneaddr($addr){
		if(isset($addr) && preg_match( '/^[a-z0-9]+$/', $addr) && substr($addr, 0, 4) == "one1" && strlen($addr) == 42){
			return 1;
		}else{
			return 0;
		}
	}
	
	function chkblockaddr($blockaddr){
		if(isset($blockaddr) && preg_match( '/^[0-9]+$/', $blockaddr) && strlen($blockaddr) <= 20){
			return 1;
		}else{
			return 0;
		}
	}
	
	function chkblocknum($blocknum){
		if(isset($blocknum) && preg_match( '/^[0-9]+$/', $blocknum) && strlen($blocknum) <= 20){
			return 1;
		}else{
			return 0;
		}
	}
}

?>
