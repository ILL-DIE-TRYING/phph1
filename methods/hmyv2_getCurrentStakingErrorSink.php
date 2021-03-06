<?php
/**
* Method file for hmyv2_getCurrentStakingErrorSink() in the phph1.php class file
*/

// There is no input so no validation required
$phph1->set_validinput(1);

// Get the block number dataset
$hmyv2_data = $phph1->hmyv2_getCurrentStakingErrorSink();

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
							<p>Gets a list of failed transactions currently in the staking errors sink.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getCurrentStakingErrorSink">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
					<li class="infoObjectNoBul"><h4>No Parameters Required</h4></li>
				</ul>
				
				<h3 class="infoHeader">Returns</h3>
				<ul class="infoObjects">
					
					<li class="infoObjectNoBul"><span>Array</span> of <span>Object</span>:</li>
					
					<li><div class="ioobjectWrap"><span >directive-kind</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Type of staking transaction</div></li>
					
					<li><div class="ioobjectWrap"><span >error-message</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Reason for staking transaction rejection</div></li>
					
					<li><div class="ioobjectWrap"><span >time-at-rejection</span> - <span>Number</span>:</div> 
					<div class="iodefWrap">Unix time when the staking transaction was rejected from the pool</div></li>
					
					<li><div class="ioobjectWrap"><span >tx-hash-id</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Staking transaction hash</div></li>

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

