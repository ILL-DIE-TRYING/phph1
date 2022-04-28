<?php
/**
* Method file for hmyv2_getSuperCommittees() in the phph1.php class file
*/

// There is no input so no validation required
$phph1->set_validinput(1);

// Get the block number dataset
$hmyv2_data = $phph1->hmyv2_getSuperCommittees();

require_once('inc/errors.php');

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
						<p>Gets a list of current super committee members and their relevant information.</p>
						<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getSuperCommittees">PHPH1 Class Documentation</a>.</p>
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
				
				<li><div class="ioobjectWrap"><span>current</span> - <span>Array</span>:</div>
				<div class="iodefWrap">Currently elected committee</div></li>
				
				<ul class="infoObjects2">
					
					<li><div class="ioobjectWrap"><span>epoch</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Epoch number</div></li>
					
					<li><div class="ioobjectWrap"><span>external-slot-count</span> - <span>Number</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>quorum-deciders</span> - <span>Array</span>:</div></li>
						
					<ul class="infoObjects3">
					
						<li><div class="ioobjectWrap"><span>shard-0</span> - <span>Array</span>:</div>
						<div class="iodefWrap">Shard of committee</div></li>
						
						<ul class="infoObjects4">
							
							<li><div class="ioobjectWrap"><span>committee-members</span> - <span>Array</span>:</div></li>
							
							<ul class="infoObjects5">
								<li><div class="ioobjectWrap"><span>Array</span>:</div></li>
								
								<ul class="infoObjects6">
								
									<li><div class="ioobjectWrap"><span>bls-public-key</span> - <span>String</span>:</div>
									<div class="iodefWrap">BLS public key</div></li>
									
									<li><div class="ioobjectWrap"><span>earning-account</span> - <span>String</span>:</div>
									<div class="iodefWrap">Wallet address that rewards are being paid to</div></li>
									
									<li><div class="ioobjectWrap"><span>is-harmony-slot</span> - <span>Number</span>:</div>
									<div class="iodefWrap">If slot is Harmony owned</div></li>
									
									<li><div class="ioobjectWrap"><span>voting-power-%</span> - <span>Number</span>:</div>
									<div class="iodefWrap">Normalized voting power of key</div></li>
									
									<li><div class="ioobjectWrap"><span>voting-power-unnormalized</span> - <span>Number</span>:</div>
									<div class="iodefWrap">Voting power of key</div></li>
								
								</ul>
							</ul>
							
							<li><div class="ioobjectWrap"><span>count</span> - <span>Number</span>:</div>
							<div class="iodefWrap">Number of BLS keys on shard</div></li>
							
							<li><div class="ioobjectWrap"><span>external-validator-slot-count</span> - <span>Number</span>:</div>
							<div class="iodefWrap">Number of external BLS keys in committee</div></li>
							
							<li><div class="ioobjectWrap"><span>hmy-voting-power</span> - <span>Number</span>:</div>
							<div class="iodefWrap">FIXME</div></li>
							
							<li><div class="ioobjectWrap"><span>policy</span> - <span>Number</span>:</div>
							<div class="iodefWrap">Current election policy</div></li>
							
							<li><div class="ioobjectWrap"><span>staked-voting-power</span> - <span>Number</span>:</div>
							<div class="iodefWrap">FIXME</div></li>
							
							<li><div class="ioobjectWrap"><span>total-effective-stake</span> - <span>Number</span>:</div>
							<div class="iodefWrap">FIXME</div></li>
							
							<li><div class="ioobjectWrap"><span>total-raw-stake</span> - <span>Number</span>:</div>
							<div class="iodefWrap">FIXME</div></li>
						
						</ul>
						
						<li><div class="ioobjectWrap"><span>shard-1</span> - See shard-0 output above</div></li>
						
						<li><div class="ioobjectWrap"><span>shard-2</span> - See shard-0 output above</div></li>
						
						<li><div class="ioobjectWrap"><span>shard-3</span> - See shard-0 output above</div></li>
						
					</ul>
				
				</ul>
				
				<li><div class="ioobjectWrap"><span>previous</span> - <span>Array</span>:</div>
				<div class="iodefWrap">Previously elected committee</div></li>
				
				<ul class="infoObjects2">
				
					<li><div class="ioobjectWrap"><strong>See current committee output above</strong></div></li>
				
				</ul>
				
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

