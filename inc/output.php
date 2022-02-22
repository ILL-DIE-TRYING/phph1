<?php
/**
* Show the explorer output if this is not an rpc call
*/
if($validinput == 1 && $phph1->rpc_call == 0){
	echo '<div id="datadiv">';
	echo '<div id="datacontent">';
	#echo "<p>Total Number Of Transactions: ".$trcount;
	#echo "<br />Total Number Of Pages Available: ".$trpages."</p>";
	
	// You can view the raw array here
	if(isset($phph1->lastjson)){
		echo "<p style='padding:5px;margin:0px 0px 10px 0px;background-color:#ccc;border-radius: 5px;'>Harmony Node JSON RPC Request:</p><p style='color:green;padding:0px;margin:0px 0px 15px 0px;'>".$phph1->lastjson."</p>";
	}
	
	// You can view the raw array here
	if(isset($phph1->rpc_url)){
		echo "<p style='padding:5px;margin:0px 0px 10px 0px;background-color:#ccc;border-radius: 5px;'>PHPH1 request URL for this method:</p><p style='color:green;padding:0px;margin:0px 0px 15px 0px;'><a href='".$phph1->rpc_url."' target='_blank'>".$phph1->rpc_url."</a></p>";
	}
	
	
	echo "<p style='padding:5px;margin:0px 0px 10px 0px;background-color:#ccc;border-radius: 5px;'>PHP Array output of Harmony returned data:</p>";
	echo "<pre>";
	print_r($hmyv2_data);
	echo "</pre>";
	echo '</div></div>';
/**
* Show the rpc output is this is an rpc call
*/
}else{
	echo $hmyv2_data;	
}
?>
