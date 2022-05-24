<?php
/**
* This file contains all the settings required to invoke the PHPH1 class
* The config.php should be included in your project (or the settings in your project's configuration file) before invoking the PHPH1 class
*
* Be sure to look below the doc block in the inc/config.php settings for examples.
*
* Settings:
* 
* $phph1_debug - Variable used to enable (set to 1) or disable (set to 0) API Explorer PHP debugging. Enabling this exposes many things to the client, I highly suggest not using it in a production environment unless it is a last resort. It also puts  big ugly warnng header at the top of the pages so you are aware debugging is enabled.
*
* $phph1_blockedaddr - This array is used to block IP addresses if necessary. Just add an IP address to the array like the example and the code will use the $_SERVER['REMOTE_ADDR'] to see if users are blocked. If the $phph1_allowedaddr array is not empty, this array gets ignored
*
* $phph1_allowedaddr - This array is used to only allow specific IP Addresses. Just add an IP address to the array like the example and the code will use the $_SERVER['REMOTE_ADDR'] to make sure the request is allowed by the client. If this array has any values in it, the $phph1_blockedaddr is ingored due to redundancy. REMINDER! Usig this blocks all hosts except the hosts listed in this array.
*
* $phph1_allowbigdata - Some requests have a page index (page number) option. Included insome of those options is the ability to use -1 as the index page. When using -1 the data set returned could possibly be huge causing a massive load on the server. By default using the -1 option is disabled to prevent this from happening. You can enable -1 page requests here by setting $phph1_allowbigdata to 1
*
* $phph1_apiaddresses - This is a multi-dimensional array that holds the node and shard information. By default this array contains the official Harmony nodes but you can comment them out and add your own personal nodes as shown where the array is set. if you do add your own node address, be sure to also set $default_network and $default_shard as well
*
* $default_network - Sets the default network (also the network used by the rpc script). It MUST use a network listed in the $phph1_apiaddresses array. For example by default it is set to use "mainnet".
*
* $default_shard - Sets the default shard (also the shard used by the rpc script). It MUST use a shard listed in the $phph1_apiaddresses array. For example by default it is set to use "0".
*
* $default_pagesize - The default page size for methods that return multiple pages of data
*
* $max_pagesize - This is the maximum number of items per page when a method returns multiple pages of data. This prevents a client from reuesting large datasets in a single call which will put a heavy load on the web server.
*
* $phph1_methods - An array of the available methods. This is used to prevent a client from requesting a method that doesn'teist. You can use a PHP comment out individual lines to disable a method.
*
* $sorted_Methods - This is just the $phph1_methods array that has been sorted alphabetically so the front end dropdown menu makes some sense.
*
*/

// Turns the PHPH1 debugging on or off
$phph1_debug = 0;

// If debugging is on, toss a big ugly warning at the top of the pages
if($phph1_debug == 1){
	echo "<h2 style='color:red;text-align:center;'>DEBUGGING IS ON!<br />DO NOT ALLOW PUBLIC ACCESS WHILE DEBUGGING IS ON!!</h2>";
}

// This array is used to block IP addresses if necessary
// Just add an IP address to the array like the example and
// PHP will use the $_SERVER['REMOTE_ADDR'] to see if users are blocked
// If $phph1_allowedaddr array is not empty, this array gets ignored
$phph1_blockedaddr = array(
			// example blocked ip addresses. Always add to the bottom of the list first
			// so the array doesn't have an extra comma at he end if the last item
			
			//'192.168.50.20', // Second address blocked for being a bad guy
			// '192.168.50.21' // First address blocked for being a bad guy (You can use a comment like this after the entry to comment why)
		);
		
// This array is used to only allow specific IP Addresses
// Just add an IP address to the array like the example and
// PHP will use the $_SERVER['REMOTE_ADDR'] to make sure the request is allowed by the client
// If this array has any values in it, the $phph1_blockedaddr is ingored due to redundancy
// REMINDER! Usig this blocks all hosts except the hosts in this array
$phph1_allowedaddr = array(
			// example allowed ip address. Always add to the bottom of the list first
			// so the array doesn't have an extra comma at he end if the last item
			
			// '192.168.50.20', // Allow this host 
			// '192.168.50.21' // Second host allowed
		);
		
// Some requests have a page index (page number) option
// Included insome of those options is the ability to use -1 as the index page
// When using -1 the data set returned could possibly be huge
// causing a massive load on the server.
// By default using the -1 option is disabled to prevent this from happening
// You can enable -1 page requests here by setting $phph1_allowbigdata to 1
$phph1_allowbigdata = 0;

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
$max_pagesize = 100;

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
	'hmyv2_estimateGas',
	'hmyv2_epochLastBlock',
	'hmyv2_sendRawTransaction',  // currently untested, waiting for information from Harmony
	'hmyv2_sendRawStakingTransaction',  // currently untested, waiting for information from Harmony
	'hmyv2_getAllValidatorInformationByBlockNumber' // The last item in this array should not end with a comma
);

// Sorting methods alphabetically
$sorted_Methods = $phph1_methods;
asort($sorted_Methods);
?>