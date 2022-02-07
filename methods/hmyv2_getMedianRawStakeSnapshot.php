<?php


/*
Nothing to validate so set this to 1
*/
$validinput = 1;



// unset the boothandle
unset($phph1_boothandle);

// Get the transactions
$hmyv2_getMedianRawStakeSnapshot_data = $phph1->hmyv2_getMedianRawStakeSnapshot();

if($phph1_debug == 1){
	
	echo "<p style='color:blue;'>";
	
	echo "<br />DO WE HAVE VALID INPUT?: ".$validinput."<br />";
	
	echo "</p>";
}


?>

<p>NO INPUTS REQUIRED</p>

<br />

<?php
if($validinput == 1){
	
	// You can view the raw array here
	echo "<h2>GET MEDIAN RAW STAKE ARRAY</h2>";
	if(isset($phph1->lastjson)){
		echo "<p style='color:green;'>This JSON RPC Request:<br />".$phph1->lastjson."</p>";
	}
	echo "<pre>";
	print_r($hmyv2_getMedianRawStakeSnapshot_data);
	echo "</pre>";
	
}
?>

