<?php
/**
* Start debug info display area
*/
if($phph1->phph1_debug == 1){
	echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
}

/**
* NO INPUT TO VALIDATE SET TO 1
*/
$validinput = 1;

// unset the boothandle
unset($phph1_boothandle);

// Get the transactions
$hmyv2_data = $phph1->hmyv2_getElectedValidatorAddresses();


/**
* End debug info display area
*/
if($phph1->phph1_debug == 1){
	echo "<p class='hmyv2_debug_notify'>### END DEBUGGING INFORMATION ###</p>";
}

/**
* Check if this is a RPC call
* If not show the html output of the method explorer
*/
if($phph1->rpc_call != 1){

?>

	<div class="info_container" >
		<div class="infoRow">
			<button type="button" class="collapsibleInfo"><?=$phph1_method?> :: Params/Returns</button>
			<div id="infoContent" class="infoContent">
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
					<li class="infoObjectNoBul"><h4>No Parameters Required</h4></li>
				</ul>
				
				<h3 class="infoHeader">Returns</h3>
				<ul class="infoObjects">
					<li><div class="ioobjectWrap"><span >Array</span> of <span>String</span></div> 
					<div class="iodefWrap">List of wallet addresses that are currently elected.</div></li>
				</ul>
			</div>
		</div>
	</div>

<?php

/**
* ends the rpc call check
*/
}

require_once('inc/output.php');
?>

