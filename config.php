<?php

/*
Setting this will add debugging output when run
The debugging output is ugly and minimal currently (2022-2-5)
BE CAREFUL!
DO NOT LEAVE DEBUGGING ON IN A PRODUCTION ENVIRONMENT!
*/
$phph1_debug = 0;

// SHOW WARNING IF DEBUGGING IS ON
if($phph1_debug == 1){
	echo "<h2 style='color:red;'>DEBUGGING IS ON!<br />DO NOT ALLOW PUBLIC ACCESS WHILE DEBUGGING IS ON!!</h2>";
}

// Which net to use. 0 = testnet, 1 = mainnet
$usemainnet = 1;

// Which shard to use
// This should become Dynamic via a form return
// Options are 0, 1, 2, 3
$phph1_shard = 0;

if($usemainnet == 1){
	//echo "<h4 style='background-color:red;color:white;'>USING MAINNET SHARD:".$phph1_shard."</h4>";
	if($phph1_shard == 0){
		$apiaddr = 'https://a.api.s0.t.hmny.io/';
	}elseif($phph1_shard == 1){
		$apiaddr = 'https://rpc.s1.t.hmny.io/';		
	}elseif($phph1_shard == 2){
		$apiaddr = 'https://rpc.s2.t.hmny.io/';		
	}elseif($phph1_shard == 3){
		$apiaddr = 'https://rpc.s3.t.hmny.io/';	
	}
}else{
	//echo "<h4 style='background-color:green;color:white;'>USING TESTNET</h4>";
	if($phph1_shard == 0){
		$apiaddr = 'https://rpc.s0.b.hmny.io/';
	}elseif($phph1_shard == 1){
		$apiaddr = 'https://rpc.s1.b.hmny.io/';		
	}elseif($phph1_shard == 2){
		$apiaddr = 'https://rpc.s2.b.hmny.io/';		
	}elseif($phph1_shard == 3){
		$apiaddr = 'https://rpc.s3.b.hmny.io/';	
	}
}

/*
Default number of results per page
*/
$def_pagesize = 10;

/*
Maximum number of results per page
*/
$max_pagesize = 20;

/* Array of available methods */
$hmyv2_methods = array(
	'hmyv2_getTransactionsHistory',
	'hmyv2_getBlockByNumber',
	'hmyv2_getBalance',
	'hmyv2_getBalanceByBlockNumber',
	'hmyv2_getTransactionsCount',
	'hmyv2_protocolVersion',
	'hmyv2_getEpoch',
	'hmyv2_gasPrice',
	'hmyv2_getBlockByHash',
	'hmyv2_getBlocks',
	'hmyv2_getBlockTransactionCountByHash',
	'hmyv2_getBlockTransactionCountByNumber',
	'hmyv2_latestHeader',
	'hmyv2_blockNumber',
	'hmyv2_getTransactionByHash',
	'hmyv2_getTransactionReceipt',
	'hmyv2_getTransactionByBlockNumberAndIndex',
	'hmyv2_getTransactionByBlockHashAndIndex',
	'hmyv2_pendingTransactions',
	'hmyv2_getValidators',
	'hmyv2_getAllValidatorAddresses',
	'hmyv2_getAllValidatorInformation',
	'hmyv2_getElectedValidatorAddresses',
	'hmyv2_getValidatorInformation',
	'hmyv2_isBlockSigner',
	'hmyv2_getDelegationsByValidator',
	'hmyv2_getDelegationsByDelegator',
	'hmyv2_getStakingTransactionByHash',
	'hmyv2_getStakingTransactionByBlockNumberAndIndex',
	'hmyv2_getStakingTransactionByBlockHashAndIndex',
	'hmyv2_getCurrentUtilityMetrics',
	'hmyv2_getSuperCommittees',
	'hmyv2_getStakingNetworkInfo',
	'hmyv2_getMedianRawStakeSnapshot',
	'hmyv2_getCirculatingSupply',
	'hmyv2_getTotalSupply',
	'hmyv2_getCurrentStakingErrorSink',
	'hmyv2_getPendingCXReceipts',
	'hmyv2_getCXReceiptByHash',
	'hmyv2_getBlockSigners'
	);
?>