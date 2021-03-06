<?php
/**
* Method file for hmyv2_getStakingTransactionByBlockNumberAndIndex() in the phph1.php class file
*/

if($phph1->chk_dorequest()){

	$phph1_inputs = array(
				'blocknum' => 'int',
				'txindex' => 'int'
	);
	
	foreach($phph1_inputs as $aninput => $input_type){
		$$aninput = $phph1->phph1_prepinput($aninput, $input_type);
	}

	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getStakingTransactionByBlockNumberAndIndex($blocknum,$txindex)){
		$hmyv2_data = $phph1->hmyv2_getStakingTransactionByBlockNumberAndIndex($blocknum,$txindex);
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
			
				<ul class="infoObjects" >
					<li class="infoObjectNoBul">
						<div>
							<p>Gets a staking transaction information using the supplied block number and index.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getStakingTransactionByBlockNumberAndIndex">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
					<li class="infoObjectNoBul"><span>Number</span> - Block number</li>
					<li class="infoObjectNoBul"><span>Number</span> - Staking transaction index</li>
				</ul>
				
				<h3 class="infoHeader">Returns</h3>
				<ul class="infoObjects" >
					
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Object</span>:</div></li>

					<li><div class="ioobjectWrap"><span>blockHash</span> - <span>String</span>:</div>
					<div class="iodefWrap">Block hash in which transaction was finalized</div></li>
					
					<li><div class="ioobjectWrap"><span>blockNumber</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Block number in which transaction was finalized</div></li>
					
					<li><div class="ioobjectWrap"><span>from</span> - <span>String</span>:</div>
					<div class="iodefWrap">Sender wallet address</div></li>
					
					<li><div class="ioobjectWrap"><span>gas</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Gas limit of transaction</div></li>
					
					<li><div class="ioobjectWrap"><span>gasPrice</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Gas price of transaction in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span>hash</span> - <span>String</span>:</div>
					<div class="iodefWrap">Transaction hash</div></li>
					
					<li><div class="ioobjectWrap"><span>msg</span> - <span>Object</span>:</div>
					<div class="iodefWrap">Staking transaction data, depending on the type of staking transaction</div></li>
					
					<li><div class="ioobjectWrap"><span>nonce</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Wallet nonce of transaction</div></li>
					
					<li><div class="ioobjectWrap"><span >r</span> - <span >String</span>:</div> 
					<div class="iodefWrap">First 32 bytes of ECDSA signature</div></li>
					
					<li><div class="ioobjectWrap"><span >s</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Second 32 bytes of ECDSA signature</div></li>
					
					<li><div class="ioobjectWrap"><span>timestamp</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Unix time at which transaction was finalized</div></li>

					<li><div class="ioobjectWrap"><span>transactionIndex</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Staking transaction index within block</div></li>
					
					<li><div class="ioobjectWrap"><span>type</span> - <span>String</span>:</div>
					<div class="iodefWrap">Type of staking transaction</div></li>
					
					<li><div class="ioobjectWrap"><span >v</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Final 1 byte of ECDSA signature</div></li>

				</ul>
			</div>
		</div>
	</div>
	<div class="form_container">
		<div id="formcontent">
			<form action="/?method=hmyv2_getStakingTransactionByBlockNumberAndIndex" method="post">
				<div class="row">
					<div class="col-25">
						<label for="blocknum">Block Number: </label>
					</div><div class="col-75">
						<input style="background: orange;" type="text" id="blocknum" name="blocknum" maxlength="42" value="<?php if($phph1->chk_goodinput('blocknum')){ echo $phph1->get_goodinput('blocknum'); } ?>" />
					</div>
				</div>

				<div class="row">
					<div class="col-25">
						<label for="txindex">Transaction Index: </label>
					</div><div class="col-75">	
						<input style="background: orange;" type="text" id="txindex" name="txindex"  size="20" maxlength="20" value="<?php if($phph1->chk_goodinput('txindex')){ echo $phph1->get_goodinput('txindex'); } ?>" />
					</div>
				</div>
				<div class="row">
					<input type="hidden" id="dorequest" name="dorequest" value="1" />
					<input type='submit' name='Submit' class="form_submit" />
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

