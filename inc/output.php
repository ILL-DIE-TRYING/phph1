<?php
/**
* output.php is included from every method page
* It is used to keep all method output consistent
* Anything edited here will affect the output of every method
*/
/*
echo "	<div class='info_container'>\n";
echo "		<div class='infoRow'>\n";
echo "			<button type='button' class='collapsibleInfo'></button>\n";
echo "			<div id='infoContent' class='infoContent'>\n";

echo "			</div>\n";
echo "		</div>\n";
echo "	</div>\n";
*/

/**
* Show the explorer output if this is not an rpc call
*/
if($phph1->get_validinput() && !$phph1->get_rpcstatus()){
	echo "\n<div id='datadiv'>\n";
	echo "<div id='datacontent'>\n\n";

	// If this method has multiple page output, show how many pages are available
	if(isset($trpages)){
		echo "	<div class='info_container'>\n";
		echo "		<div class='infoRow'>\n";
		echo "			<button type='button' class='collapsibleInfo'></button>\n";
		echo "			<div id='pagesContent' class='infoContent'>\n";
		echo "			<div class='pages_div'>\n";
		echo "				<p>".$trpages."</p>\n";
		echo "			</div>\n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "	</div>\n";
	}

	// This is the current API JSON request that was sent to the Harmony Node API host
	if($phph1->get_lastjson()){
		echo "	<div class='info_container'>\n";
		echo "		<div class='infoRow'>\n";
		echo "			<button type='button' class='collapsibleInfo'>Harmony Node API JSON Formatted Request:</button>\n";
		echo "			<div id='jsonContent' class='infoContent'>\n";
		echo "			<pre><code class='language-json'>";
		echo $phph1->get_lastjson()."";
		echo "			</code></pre>\n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "	</div>\n";
	}

	// This is what you would send to a ahrmony node for a direct api request
	if($phph1->get_rpcposturl()){

		$rpcpostdata = $phph1->get_rpcposturl();

		echo "	<div class='info_container'>\n";
		echo "		<div class='infoRow'>\n";
		echo "			<button type='button' class='collapsibleInfo'>A <u><em>BASIC</em></u> Harmony Node API POST request using Javascript:</button>\n";
		echo "			<div id='postContent' class='infoContent'>\n";
		echo "	<pre class='line-numbers'><code class='language-javascript'>\n";

		$numvalues = count($rpcpostdata['values']);

		echo "&lt;script&gt;\n";
		echo "// In a production environment this function should probably be expanded with response and error checks etc.\n";
		echo "async function getHMYV2Data(){\n";
		echo "	// This URL is for ".$phph1->get_sessionnetwork()." shard ".$phph1->get_sessionshard()."\n";
		echo "  let response = await fetch('".$phph1->get_apiaddr()."', {\n";
		echo "    method: &quot;POST&quot;,\n";
		echo "    body: '".$phph1->get_lastjson()."',\n";
		echo "    headers: { &quot;Content-type&quot;: &quot;application/json&quot; }\n";
		echo "  });\n\n";

		echo "  let mydata = await response.json();\n\n";

		echo "  // Check the console for output\n";
		echo "  console.log(&quot;method data:&quot; + JSON.stringify(mydata));\n";
		echo "  // What you do with the returned data after this is up to you\n";
		echo "}\n\n";
		echo "// Run the getHMYV2Data function\n";
		echo "getHMYV2Data();\n";
		echo "&lt;/script&gt;\n";

		echo "	</code></pre>\n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "	</div>\n";
	}

	// This is a GET request you would send to phph1_call.php to get the same results for a remote call
	if($phph1->get_rpcurl()){

		echo "	<div class='info_container'>\n";
		echo "		<div class='infoRow'>\n";
		echo "			<button type='button' class='collapsibleInfo'>PHPH1 GET request URL for this method:</button>\n";
		echo "			<div id='rpcGetContent' class='infoContent'>\n";
		echo "			<div class='get_div'>\n";
		echo "			<p class='language-none'>\n";
		echo "			<a class='geturl' href='".$phph1->get_rpcurl()."' target='_blank'>".$phph1->get_rpcurl()."</a>\n";
		echo "			</p>\n";
		echo "			</div>\n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "	</div>\n";
	}

	// This is what you would send to phph1_call.php to get the same results for a remote call
	if($phph1->get_rpcposturl()){

		$rpcpostdata = $phph1->get_rpcposturl();

		echo "	<div class='info_container'>\n";
		echo "		<div class='infoRow'>\n";
		echo "			<button type='button' class='collapsibleInfo'>A <u><em>BASIC</em></u> PHPH1 POST request using Javascript:</button>\n";
		echo "			<div id='rpcPostContent' class='infoContent'>\n";
		echo "	<pre class='line-numbers'><code class='language-javascript'>\n";

		$numvalues = count($rpcpostdata['values']);

		echo "&lt;script&gt;\n";
		echo "// You can reuse this function with multiple methods\n";
		echo "// In a production environment this function should probably be expanded with response and error checks etc.\n";
		echo "async function getPHPH1Data(url, formdata){\n";
		echo "  let response = await fetch(url, {\n";
		echo "    method: &quot;POST&quot;,\n";
		echo "    body: formdata,\n";
		echo "    headers: { &quot;Content-type&quot;: &quot;application/x-www-form-urlencoded&quot; }\n";
		echo "  });\n\n";

		echo "  let mydata = await response.json();\n\n";

		echo "  // Check the console for output\n";
		echo "  console.log(&quot;method data:&quot; + JSON.stringify(mydata));\n";
		echo "  // What you do with the returned data after this is up to you\n";
		echo "}\n\n";

		echo "// This is the call URL. It will always require the method being used to be sent in the URL\n";
		echo "// Depending on your setup, you may need to adjust the path to this url\n";
		echo "// For example: /your/path/to/phph1/".$rpcpostdata['url']."\n";
		echo "var url = &quot;".$rpcpostdata['url']."&quot;;\n\n";

		echo "// The formdata variable is always set\n";
		echo "// Even if there is no form data we need the dorequest sent\n";
		echo "var formdata = &quot;dorequest=1&quot;;\n";
		
		foreach($rpcpostdata['values'] as $item => $value){
			echo "formdata += &quot;&amp;".$item."=".$value."&quot;;\n";
		}

		
		echo "\n// Run the getPHPH1Data function\n";
		echo "getPHPH1Data(url, formdata);\n";
		echo "&lt;/script&gt;\n";

		echo "	</code></pre>\n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "	</div>\n";
	}

	echo "	<div class='info_container'>\n";
	echo "		<div class='infoRow'>\n";
	echo "			<button type='button' class='collapsibleInfo'>JSON return data:</button>\n";
	echo "			<div id='outputContent' class='infoContent'>\n";
	echo "			<div id='code_div' class='code_div'>";

	// This is where the JSON Object is pretty displayed for viewing using the javascript at the bottom of this file
	// This was done because converting a JSON object to an array using json_decode uses a LOT of server memory
	// Using the JSON object data and javascript lowers the server memory load immensly and speeds things up quite a bit for the smaller return data
	echo "			</div>\n\n";
	echo "			</div>\n";
	echo "		</div>\n";
	echo "	</div></div></div>\n";
?>
	
	<!-- This makes the JSON return data pretty for viewing -->

	<script>
		var precontainer = document.getElementById("code_div");
		var obj = <?=$hmyv2_data?>;
		precontainer.innerHTML = "<pre class='no-line-numbers'><code class='language-json'>" + JSON.stringify(obj, 'result', 2) + "</code></pre>";
	</script>


<?php
// Otherwise return raw JSON data to the page for remote requests
}elseif($phph1->get_validinput() && $phph1->get_rpcstatus()){
	echo $hmyv2_data;	
}
?>