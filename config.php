<?php

/*
Setting this will add debugging output when run
The debugging output is ugly and minimal currently (2022-2-5)
BE CAREFUL!
DO NOT LEAVE DEBUGGING ON IN A PRODUCTION ENVIRONMENT!
*/
$phph1_debug = 0;

/*
Show the $_GET request data
BE CAREFUL!
DO NOT LEAVE DEBUGGING ON IN A PRODUCTION ENVIRONMENT!
A malicious request could result in an attack on your server
*/ 
if($phph1_debug == 1){
	echo "<pre>";
	print_r($_GET);
	echo "</pre>";
}

// Which net to use. 0 = testnet, 1 = mainnet
$usemainnet = 1;

// Which shard to use
// This should become Dynamic via a form return
// Options are 0, 1, 2, 3
$phph1_shard = 0;

if($usemainnet == 1){
	echo "<h4 style='background-color:red;color:white;'>USING MAINNET SHARD:".$phph1_shard."</h4>";
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
	echo "<h4 style='background-color:green;color:white;'>USING TESTNET</h4>";
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
?>