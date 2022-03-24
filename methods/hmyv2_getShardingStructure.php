<?php
/**
* Start debug info display area
*/
if($phph1->phph1_debug == 1){
	echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
}

/**
* There is no input so no validation required
*/
$validinput = 1;

/**
* Get the sharding structure
*/
$hmyv2_data = $phph1->hmyv2_getShardingStructure();

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
				
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Array</span> of <span>Object</span>:</div></li>
					
					<li><div class="ioobjectWrap"><span>current</span> - <span>Bool</span>:</div>
					<div class="iodefWrap">If this node is currently on this shard ID</div></li>
					
					<li><div class="ioobjectWrap"><span>http</span> - <span>String</span>:</div>
					<div class="iodefWrap">HTTPS API endpoint for this shard ID</div></li>
					
					<li><div class="ioobjectWrap"><span>shardID</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Shard ID</div></li>
					
					<li><div class="ioobjectWrap"><span>ws</span> - <span>String</span>:</div>
					<div class="iodefWrap">Websocket API endpoint for this shard ID</div></li>

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

