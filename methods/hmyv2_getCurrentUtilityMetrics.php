<?php
/**
* Method file for hmyv2_getCurrentUtilityMetrics() in the phph1.php class file
*/

// There is no input so no validation required
$phph1->set_validinput(1);

// Get the block number dataset
$hmyv2_data = $phph1->hmyv2_getCurrentUtilityMetrics();

require_once('inc/errors.php');

/**
* Check if this is a RPC call
* If not show the html output of the method explorer
*/
if($phph1->get_rpcstatus() == 0){
?>

	<div class="info_container" >
		<div class="infoRow">
			<button type="button" class="collapsibleInfo"><?=$phph1->get_currentmethod()?> :: Params/Returns</button>
			<div id="infoContent" class="infoContent">
			
				<h3 class="infoHeader">Description</h3>
				<ul class="infoObjects" >
					<li class="infoObjectNoBul">
						<div>
							<p>Gets the current utility metrics for the network.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getCurrentUtilityMetrics">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><h4>No Parameters Required</h4></li>
					
				</ul>
				
				<h3 class="infoHeader">Returns</h3>
				<ul class="infoObjects">
				
					<li><div class="ioobjectWrap"><span >AccumulatorSnapshot</span> - <span>Number</span>:</div> 
					<div class="iodefWrap">Total block reward given out in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span >Adjustment</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Change in circulating supply staked</div></li>
					
					<li><div class="ioobjectWrap"><span >CurrentStakedPercentage</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Percent of circulating supply staked</div></li>
					
					<li><div class="ioobjectWrap"><span >Deviation</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Change in percent of circulating supply staked</div></li>

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

