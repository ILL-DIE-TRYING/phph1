<?php
/**
* output.php is included from every method page
* It is used to keep all method output consistent
* Anything edited here will affect the output of every method
*/

/**
* Show the explorer output if this is not an rpc call
*/
if($phph1->get_validinput() && !$phph1->get_rpcstatus()){
	echo "<div id='datadiv'>\n";
	echo "<div id='datacontent'>\n";
	
	// FIXME Move style to CSS AND INTERNALIZE $trpages
	// If this method has multiple page output, show how many pages are available
	if(isset($trpages)){
		echo "<p style='padding:5px;margin:0px 0px 10px 0px;background-color:#ccc;border-radius: 5px;'>Number of Pages: <span style='color:#000;padding:0px;margin:0px 0px 15px 0px;'>".$trpages."</span></p>\n";
	}
	
	// FIXME Move style to CSS
	// This is the current API JSON request that was sent to the Harmony Node API host
	if($phph1->get_lastjson()){
		echo "<p style='padding:5px;margin:0px 0px 10px 0px;background-color:#ccc;border-radius: 5px;'>Harmony Node JSON RPC Request:</p>\n<p style='color:green;padding:0px;margin:0px 0px 15px 0px;'>".$phph1->get_lastjson()."</p>\n";
	}
	
	// FIXME Move style to CSS
	// This is what you would send to phph1_call.php to get the same results for a remote call
	if($phph1->get_rpcurl()){
		echo "<p style='padding:5px;margin:0px 0px 10px 0px;background-color:#ccc;border-radius: 5px;'>PHPH1 request URL for this method:</p>\n<p style='color:green;padding:0px;margin:0px 0px 15px 0px;'><a href='".$phph1->get_rpcurl()."' target='_blank'>".$phph1->get_rpcurl()."</a></p>\n";
	}
	
	// FIXME Move style to CSS
	echo "<p style='padding:5px;margin:0px 0px 10px 0px;background-color:#ccc;border-radius: 5px;'>JSON return data:</p>\n";
	echo "<pre id='phph1_pre'><code>";
	// This is where the JSON Object is pretty displayed for viewing using the javascript at the bottom of this file
	// This was done because converting a JSON object to an array using json_decode uses a LOT of server memory
	// Using the JSON object data and javascript lowers the server memory load immensly and speeds things up quite a bit for the smaller return data
	echo "</code></pre>\n";
	echo "</div>\n</div>\n";
?>
	<!-- This makes the JSON return data pretty for viewing -->
	<script>
		var precontainer = document.getElementById("phph1_pre");
		var obj = <?= $hmyv2_data ?>;
		precontainer.innerHTML = JSON.stringify(obj, 'result', 2);
	</script>
<?php
// Otherwise return raw JSON data to the page for remote requests
}elseif($phph1->get_validinput() && $phph1->get_rpcstatus()){
	echo $hmyv2_data;	
}
?>

