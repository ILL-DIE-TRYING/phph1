<?php

/**
*	Setting this will add debugging output when run
*	The debugging output is ugly and minimal currently (2022-2-5)
*	BE CAREFUL!
*	DO NOT LEAVE DEBUGGING ON IN A PRODUCTION ENVIRONMENT!
*/
$phph1_debug = 0;

/**
* Enables or Disables Debugging
* WARNING!! DANGEROUS ON PUBLIC FACING SYSTEMS
*/
if($phph1_debug == 1){
	echo "<h2 style='color:red;'>DEBUGGING IS ON!<br />DO NOT ALLOW PUBLIC ACCESS WHILE DEBUGGING IS ON!!</h2>";
}

/**
*	ARRAY OF API ADDRESSES
*	This can be extended/shortened to your liking.
*/
$phph1_apiaddresses = array(
	'mainnet' => [
		0 => 'https://a.api.s0.t.hmny.io/',
		1 => 'https://rpc.s1.t.hmny.io/',
		2 => 'https://rpc.s2.t.hmny.io/',
		3 => 'https://rpc.s3.t.hmny.io/'	
	],
	'testnet' => [
		0 => 'https://rpc.s0.b.hmny.io/',
		1 => 'https://rpc.s1.b.hmny.io/',
		2 => 'https://rpc.s2.b.hmny.io/',
		3 => 'https://rpc.s3.b.hmny.io/'	
	],
	/*
	This is how you would extend the node addresses
	There can be any number of shards and they do not have to start with 0
	The port numbers are just random and can be whatever you use, if necessary
	*/
	
	/*
	'customnet' => [
		0 => 'https://localhost:10443',
		1 => 'https://192.168.50.4:65447/'	
	],
	*/
);

/**
* Default network to use
*/
$default_network = 'mainnet';

/**
* Default Shard on the default network
*/
$default_shard = 0;

/**
*	Default number of results per page
*/
$default_pagesize = 10;

/**
*	Maximum number of results per page
*/
$max_pagesize = 50;

/**
*	Array of available methods
*/
$phph1_methods = array(
	'hmyv2_getTransactionsHistory',
	'hmyv2_getEpoch',
	'hmyv2_protocolVersion',
	'hmyv2_gasPrice',
	'hmyv2_getCirculatingSupply',
	'hmyv2_getTotalSupply',
	'hmyv2_getAllValidatorAddresses',
	'hmyv2_blockNumber',
	'hmyv2_getElectedValidatorAddresses',
	'hmyv2_getCurrentUtilityMetrics',
	'hmyv2_getStakingNetworkInfo',
	'hmyv2_getCurrentStakingErrorSink',
	'hmyv2_getBalance',
	'hmyv2_getAllValidatorInformation',
	'hmyv2_getValidatorInformation',
	'hmyv2_getBalanceByBlockNumber',
	'hmyv2_getBlockByHash',
	'hmyv2_getBlockByNumber',
	'hmyv2_getBlocks',
	'hmyv2_getBlockSigners',
	'hmyv2_getBlockTransactionCountByHash',
	'hmyv2_getBlockTransactionCountByNumber',
	'hmyv2_getCXReceiptByHash',
	'hmyv2_getDelegationsByDelegator',
	'hmyv2_getDelegationsByValidator',
	'hmyv2_getMedianRawStakeSnapshot',
	'hmyv2_getPendingCXReceipts',
	'hmyv2_getStakingTransactionByHash',
	'hmyv2_getTransactionByHash',
	'hmyv2_getSuperCommittees',
	'hmyv2_getTransactionReceipt',
	'hmyv2_getTransactionsCount',
	'hmyv2_getValidators',
	'hmyv2_isBlockSigner',
	'hmyv2_latestHeader',
	'hmyv2_pendingTransactions',
	'hmyv2_resendCx',
	'hmyv2_call',
	'hmyv2_getCode',
	'hmyv2_getStorageAt',
	'hmyv2_getPoolStats',
	'hmyv2_pendingStakingTransactions',
	'hmyv2_getStakingTransactionByBlockNumberAndIndex',
	'hmyv2_getStakingTransactionByBlockHashAndIndex',
	'hmyv2_getLastCrossLinks'
	
	/* 'hmyv2_estimateGas'  THIS IS BROKEN ON HARMONY SIDE I THINK. SAVE FOR LAST */
	
	/*
	,
	'hmyv2_getTransactionByBlockNumberAndIndex',
	'hmyv2_getTransactionByBlockHashAndIndex',
	'hmyv2_getValidatorInformation',
	'hmyv2_getStakingTransactionByBlockNumberAndIndex',
	'hmyv2_getStakingTransactionByBlockHashAndIndex'
	*/
);

/**
* Sorting methods alphabetically
*/
$sorted_Methods = $phph1_methods;
asort($sorted_Methods);
?>