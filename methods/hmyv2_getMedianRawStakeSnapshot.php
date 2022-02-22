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


// Get the transactions
$hmyv2_data = $phph1->hmyv2_getMedianRawStakeSnapshot();

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
					
					<li><div class="ioobjectWrap"><span >None</span></div></li>
					
				</ul>
				
				<h3>Returns</h3>

				<ul class="infoObjects">
					<li><div class="ioobjectWrap"><span>epos-median-stake</span> - <span >String</span> :</div>
					<div class="iodefWrap">Effective median stake</div></li>
					
					<li><div class="ioobjectWrap"><span>max-external-slots</span> - <span >Number</span> :</div>
					<div class="iodefWrap">Number of available committee slots</div></li>
					
					<li><div class="ioobjectWrap"><span>epos-slot-winners</span> - <span >Array</span> of <span >Object</span>:</div>
					<div class="iodefWrap"></div></li>
					
					<ul class="infoObjects2">
						<li><div class="ioobjectWrap"><span>slot-owner</span> - <span >String</span>:</div>
						<div class="iodefWrap">Wallet address of BLS key</div></li>
						
						<li><div class="ioobjectWrap"><span>bls-public-key</span> - <span >String</span>:</div>
						<div class="iodefWrap">BLS public key</div></li>
						
						<li><div class="ioobjectWrap"><span>raw-stake</span> - <span >String</span>:</div>
						<div class="iodefWrap">Actual stake</div></li>
						
						<li><div class="ioobjectWrap"><span>eposed-stake</span> - <span >String</span>:</div>
						<div class="iodefWrap">Effective stake</div></li>
					</ul>
					
					<li><div class="ioobjectWrap"><span>epos-slot-candidates</span> - <span >Array</span> of <span >Object</span>:</div>
					<div class="iodefWrap"></div></li>
					
					<ul class="infoObjects2">
						<li><div class="ioobjectWrap"><span>stake</span> - <span >Number</span>:</div>
						<div class="iodefWrap">Actual stake in Atto</div></li>
						
						<li><div class="ioobjectWrap"><span>keys-at-auction</span> - <span >Array</span>:</div>
						<div class="iodefWrap">List of BLS public keys</div></li>
						
						<li><div class="ioobjectWrap"><span>percentage-of-total-auction-stake</span> - <span >String</span>:</div>
						<div class="iodefWrap">Percent of total network stake</div></li>
						
						<li><div class="ioobjectWrap"><span>stake-per-key</span> - <span >Number</span>:</div>
						<div class="iodefWrap">Stake per BLS key in Atto</div></li>
						
						<li><div class="ioobjectWrap"><span>validator</span> - <span >String</span>:</div>
						<div class="iodefWrap">Wallet address of validator</div></li>
					</ul>
					

				</ul>

			</div>
		</div>
	</div>
<br />

<?php
/**
* ends the rpc call check
*/
}

require_once('inc/output.php');
?>

