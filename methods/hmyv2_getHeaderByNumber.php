<?php
/**
* Method file for hmyv2_getDelegationsByValidator() in the phph1.php class file
*/

if($phph1->chk_dorequest()){
	
	/** Start debug info display area */
	if($phph1->get_debugstatus()){ echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>"; }

	/*
	Prepare blocknum for validation
	*/
	if(isset($_GET['blocknum']) && !empty($_GET['blocknum'])){$blocknum = $_GET['blocknum'];}else{$blocknum = null;}

	if($phph1->val_getHeaderByNumber($blocknum)){
		$hmyv2_data = $phph1->hmyv2_getHeaderByNumber($blocknum);
	}
	
	/** End debug info display area	*/
	if($phph1->get_debugstatus()){ echo "<p class='hmyv2_debug_notify'>### END DEBUGGING INFORMATION ###</p>"; }

	require_once('inc/errors.php');
}

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
						<p>Gets the block header data for the specified block number.</p>
						<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getHeaderByNumber">PHPH1 Class Documentation</a>.</p>
					</div>
				</li>
			</ul>
		
			<h3 class="infoHeader">Parameters</h3>
			<ul class="infoObjects" >

				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Number</span>:</div>
				<div class="iodefWrap">Block Number</div></li>
			
			</ul>
			
			<h3 class="infoHeader">Returns</h3>
			<ul class="infoObjects">
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Object</span>:</div></li>
				
				<li><div class="ioobjectWrap"><span>blockHash</span> - <span >String</span>:</div>
				<div class="iodefWrap">Block hash</div></li>
				
				<li><div class="ioobjectWrap"><span>blockNumber</span> - <span >Number</span>:</div>
				<div class="iodefWrap">Block number</div></li>
				
				<li><div class="ioobjectWrap"><span>crossLinks</span> - <span >Array</span>:</li>
				
				<ul class="infoObjects2">
					
					<li><div class="ioobjectWrap"><span>block-number</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Block number</div></li>
					
					<li><div class="ioobjectWrap"><span>epoch-number</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Epoch number</div></li>
					
					<li><div class="ioobjectWrap"><span>hash</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>shard-id</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Shard ID</div></li>
					
					<li><div class="ioobjectWrap"><span>signature</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>signature-bitmap</span> - <span >String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>view-id</span> - <span >Number</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
				</ul>
				
				<li><div class="ioobjectWrap"><span>epoch</span> - <span >Number</span>:</div>
				<div class="iodefWrap">Epoch of block</div></li>
				
				<li><div class="ioobjectWrap"><span>lastCommitBitmap</span> - <span >String</span>:</div>
				<div class="iodefWrap">Hex representatino of the aggregated signature bitmap of the previous block</div></li>
				
				<li><div class="ioobjectWrap"><span>lastCommitSig</span> - <span >String</span>:</div>
				<div class="iodefWrap">Hex representation of aggregated signatures of the previous block</div></li>
				
				<li><div class="ioobjectWrap"><span>leader</span> - <span >String</span>:</div>
				<div class="iodefWrap">Wallet address of leader that proposed this block if prestaking, otherwise sha256 hash of leader's public bls key</div></li>
				
				<li><div class="ioobjectWrap"><span>shardID</span> - <span >Number</span>:</div>
				<div class="iodefWrap">Shard ID</div></li>
				
				<li><div class="ioobjectWrap"><span>timestamp</span> - <span >String</span>:</div>
				<div class="iodefWrap">Timestamp that the block was finalized</div></li>
				
				<li><div class="ioobjectWrap"><span>unixtime</span> - <span >Number</span>:</div>
				<div class="iodefWrap">Timestamp that the block was finalized in Unix time</div></li>
				
				<li><div class="ioobjectWrap"><span>viewID</span> - <span >Number</span>:</div>
				<div class="iodefWrap">View ID of the block</div></li>
				
				<li><div class="ioobjectWrap"><span>vrf</span> - <span >String</span>:</div>
				<div class="iodefWrap">FIXME</div></li>
				
				<li><div class="ioobjectWrap"><span>vrfProof</span> - <span >String</span>:</div>
				<div class="iodefWrap">FIXME</div></li>

				</ul>
			</div>
		</div>
	</div>
</div>

<div class="form_container">
	<div id="formcontent">
		<form method="GET">
			<div class="row">
				<div class="col-25">
					<label for="blocknum">Block Number: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="blocknum" name="blocknum" maxlength="42" value="<?php if($phph1->chk_goodinput('blocknum')){ echo $phph1->get_goodinput('blocknum'); } ?>" />
				</div>
			</div>

		<div class="row">
			<input type="hidden" id="dorequest" name="dorequest" value="1" />
			<input type="hidden" id="method" name="method" value="hmyv2_getHeaderByNumber" />
			<input type='submit' name='Submit' />
		</div>

		</form>
	</div>
</div>
<?php
/**
* ends the rpc call check
*/
}

require_once('inc/output.php');
?>

