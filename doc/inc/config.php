<?php
/*
* This file contains all the settings required to invoke the PHPH1 class
* The config.php should be included in your project (or the settings in your project's configuration file) before invoking the PHPH1 class
*/

// Enables or disables API Explorer PHP debugging 
$phph1_debug = 0;

// Tosses a big ugly warning if debugging is enabled
if($phph1_debug == 1){
	echo "<h2 style='color:red;'>DEBUGGING IS ON!<br />DO NOT ALLOW PUBLIC ACCESS WHILE DEBUGGING IS ON!!</h2>";
}

// ARRAY OF API ADDRESSES
// This can be extended/shortened to your liking
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
	
	//This is how you would extend the node addresses
	//There can be any number of shards and they do not have to start with 0
	//The port numbers are just random and can be whatever you use, if necessary
	// You can also remove the officia harmony API addresses and only use your own
	// Just be sure to set $default_network and $default_shard appropriately as well
	/*
	
	'customnet' => [
		0 => 'https://localhost:10443',
		1 => 'https://192.168.50.4:65447/'	
	],
	
	*/
);


// Default network to use from $phph1_apiaddresses
$default_network = 'mainnet';

// Default shard on the default network set above
$default_shard = 0;

// Default number of results per page when an API call returns data in pages
$default_pagesize = 10;

// Maximum number of results per page
// Limits the number of results per page
$max_pagesize = 50;

// Array of available methods
// Don't mess with this unless you know what your are doing
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
	'hmyv2_getLastCrossLinks',
	'hmyv2_getLeader',
	'hmyv2_getShardingStructure',
	'hmyv2_getValidatorKeys',
	'hmyv2_getCurrentBadBlocks',
	'hmyv2_getNodeMetadata',
	'net_peercount',
	'hmyv2_getBlockSignerKeys',
	'hmyv2_getHeaderByNumber',
	'hmyv2_getLatestChainHeaders',
	'hmyv2_getStakingTransactionsCount',
	'hmyv2_getStakingTransactionsHistory',
	'hmyv2_getTransactionByBlockNumberAndIndex',
	'hmyv2_getTransactionByBlockHashAndIndex',
	'hmyv2_getDelegationsByDelegatorByBlockNumber',
	'hmyv2_estimateGas'
	
	/* 

	hmyv2_sendRawTransaction
	hmyv2_sendRawStakingTransaction

	*/

);

// Sorting methods alphabetically
$sorted_Methods = $phph1_methods;
asort($sorted_Methods);
?>