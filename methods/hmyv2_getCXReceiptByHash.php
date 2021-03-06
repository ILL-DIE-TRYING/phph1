<?php
/**
* Method file for hmyv2_getCXReceiptByHash() in the phph1.php class file
*/	
	
if($phph1->chk_dorequest()){

	/** Prepare txhash for validation */
	$txhash = $phph1->phph1_prepinput('txhash', 'string');
	
	/**
	* Validate the input and run our call if the data is good
	*/
	// Validate the input and run our call if the data is good
	if($phph1->val_getCXReceiptByHash($txhash)){
		$hmyv2_data = $phph1->hmyv2_getCXReceiptByHash($txhash);
	}

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
							<p>Query the cross shard receipt transaction hash on the receiving shard endpoint.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getCXReceiptByHash">PHPH1 Class Documentation</a>.</p>
							<p><em>You can get test data using <span>hmyv2_getPendingCXReceipts</span></em></p>
						</div>
					</li>
				</ul>
				
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >

					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span>:</div>
					<div class="iodefWrap">Cross shard receipt transaction hash</div></li>
				
				</ul>
				
				<h3 class="infoHeader">Returns</h3>
				<ul class="infoObjects" >
					
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Object</span>:</div></li>
					
					<li><div class="ioobjectWrap"><span>blockHash</span> - <span >String</span>:</div>
					<div class="iodefWrap">Block hash</div></li>
					
					<li><div class="ioobjectWrap"><span>blockNumber</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Block number</div></li>
					
					<li><div class="ioobjectWrap"><span>hash</span> - <span >String</span>:</div>
					<div class="iodefWrap">Transaction hash</div></li>
					
					<li><div class="ioobjectWrap"><span>from</span> - <span >String</span>:</div>
					<div class="iodefWrap">Sender wallet address</div></li>
					
					<li><div class="ioobjectWrap"><span>to</span> - <span >String</span>:</div>
					<div class="iodefWrap">Receiver wallet address</div></li>
					
					<li><div class="ioobjectWrap"><span>shardID</span> - <span >Number</span>:</div>
					<div class="iodefWrap">From shard</div></li>
					
					<li><div class="ioobjectWrap"><span>toShardID</span> - <span >Number</span>:</div>
					<div class="iodefWrap">To shard</div></li>
					
					<li><div class="ioobjectWrap"><span>value</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Amount transferred in Atto</div></li>
			
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="form_container">
	<div id="formcontent">
		<form action="/?method=hmyv2_getCXReceiptByHash" method="post">
			
		<div class="row">
			<div class="col-25">
				<label for="txhash">Transaction Hash: </label>
			</div><div class="col-75">
				<input style="background: orange;" type="text" id="txhash" name="txhash" maxlength="66" value="<?php if($phph1->chk_goodinput('txhash')){ echo $phph1->get_goodinput('txhash'); } ?>" />
			</div>
		</div>

		<div class="row">
			<input type="hidden" id="dorequest" name="dorequest" value="1" />
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
