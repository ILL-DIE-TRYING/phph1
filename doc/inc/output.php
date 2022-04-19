<?php
/**
* output.php is included from every method page
* It is used to keep all method output consistent
* Anything edited here will affect the output of every method
*/

/**
* Show the explorer output if this is not an rpc call
*/
if($validinput == 1 && $phph1->rpc_call == 0){
	echo "<div id='datadiv'>\n";
	echo "<div id='datacontent'>\n";
	
	// FIXME Move style to CSS
	// If this method has multiple page output, show how many pages are available
	if(isset($trpages)){
		echo "<p style='padding:5px;margin:0px 0px 10px 0px;background-color:#ccc;border-radius: 5px;'>Number of Pages: <span style='color:#000;padding:0px;margin:0px 0px 15px 0px;'>".$trpages."</span></p>\n";
	}
	
	// FIXME Move style to CSS
	// This is the current API JSON request that was sent to the Node API host
	if(isset($phph1->lastjson)){
		echo "<p style='padding:5px;margin:0px 0px 10px 0px;background-color:#ccc;border-radius: 5px;'>Harmony Node JSON RPC Request:</p>\n<p style='color:green;padding:0px;margin:0px 0px 15px 0px;'>".$phph1->lastjson."</p>\n";
	}
	
	// FIXME Move style to CSS
	// This is what you would send to phph1_call.php to get the same results for a remote call
	if(isset($phph1->rpc_url)){
		echo "<p style='padding:5px;margin:0px 0px 10px 0px;background-color:#ccc;border-radius: 5px;'>PHPH1 request URL for this method:</p>\n<p style='color:green;padding:0px;margin:0px 0px 15px 0px;'><a href='".$phph1->rpc_url."' target='_blank'>".$phph1->rpc_url."</a></p>\n";
	}
	
	// FIXME Move style to CSS
	echo "<p style='padding:5px;margin:0px 0px 10px 0px;background-color:#ccc;border-radius: 5px;'>PHP Array output of Harmony returned data:</p>\n";
	echo "<pre>";
	// Print the API returned data as a PHP array
	print_r($hmyv2_data);
	echo "</pre>\n";
	echo "</div>\n</div>\n";

// Otherwise return raw JSON data to the page for remote requests
}else{
	echo $hmyv2_data;	
}
?>
