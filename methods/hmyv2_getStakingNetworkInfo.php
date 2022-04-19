<?php
/**
* Method file for hmyv2_getStakingNetworkInfo() in the phph1.php class file
*/

/** Start debug info display area */
if($phph1->get_debugstatus()){echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";}

// There is no input so no validation required
$phph1->set_validinput(1);

// Get the block number dataset
$hmyv2_data = $phph1->hmyv2_getStakingNetworkInfo();

require_once('inc/errors.php');

/** End debug info display area	*/
if($phph1->get_debugstatus()){ echo "<p class='hmyv2_debug_notify'>### END DEBUGGING INFORMATION ###</p>"; }

/**
* Check if this is a RPC call
* If not show the html output of the method explorer
*/
if($phph1->get_rpcstatus() != 1){

?>
	<div class="info_container" >
		<div class="infoRow">
			<button type="button" class="collapsibleInfo"><?=$phph1->get_currentmethod()?> :: Params/Returns</button>
			<div id="infoContent" class="infoContent">
			
				<h3 class="infoHeader">Description</h3>
				<ul class="infoObjects" >
					<li class="infoObjectNoBul">
						<div>
							<p>Gets current staking network information.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getStakingNetworkInfo">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
					<li class="infoObjectNoBul"><h4>No Parameters Required</h4></li>
				</ul>
				
				<h3 class="infoHeader">Returns</h3>
				<ul class="infoObjects">
				
					<li><div class="ioobjectWrap"><span >total-supply</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Total number of pre-mined tokens</div></li>
					
					<li><div class="ioobjectWrap"><span >circulating-supply</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Number of tokens available in the network</div></li>
					
					<li><div class="ioobjectWrap"><span >epoch-last-block</span> - <span>Number</span>:</div> 
					<div class="iodefWrap">Last block of epoch</div></li>
					
					<li><div class="ioobjectWrap"><span >total-staking</span> - <span>Number</span>:</div> 
					<div class="iodefWrap">Total amount staked in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span >median-raw-stake</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Effective median stake in Atto</div></li>
					
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

