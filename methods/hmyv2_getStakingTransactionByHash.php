<?php
/**
* Method file for hmyv2_getStakingTransactionByHash() in the phph1.php class file
*/

if($phph1->chk_dorequest()){

	/**
	* Prepare hash for validation
	*/
	if(isset($_GET['hash']) && !empty($_GET['hash'])){$hash = $_GET['hash'];}else{$hash = null;}

	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getStakingTransactionByHash($hash)){
		$hmyv2_data = $phph1->hmyv2_getStakingTransactionByHash($hash);
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
							<p>Gets a staking transaction details using the transaction block hash.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getStakingTransactionByHash">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >

					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span>:</div>
					<div class="iodefWrap">Hash (NOT block hash)</div></li>
				
				</ul>
				<ul class="infoObjects" >
					<h3 class="infoHeader">Returns</h3>
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Object</span>:</div></li>
					
					<li><div class="ioobjectWrap"><span>blockHash</span> - <span>String</span>:</div>
					<div class="iodefWrap">Block hash in which transaction was finalized</div></li>
					
					<li><div class="ioobjectWrap"><span>blockNumber</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Block number in which transaction was finalized</div></li>
					
					<li><div class="ioobjectWrap"><span>from</span> - <span>String</span>:</div>
					<div class="iodefWrap">Sender wallet address</div></li>
					
					<li><div class="ioobjectWrap"><span>timestamp</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Unix time at which transaction was finalized</div></li>
					
					<li><div class="ioobjectWrap"><span>gas</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Gas limit of transaction</div></li>
					
					<li><div class="ioobjectWrap"><span>gasPrice</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Gas price of transaction in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span>hash</span> - <span>String</span>:</div>
					<div class="iodefWrap">Transaction hash</div></li>
					
					<li><div class="ioobjectWrap"><span>nonce</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Wallet nonce of transaction</div></li>
					
					<li><div class="ioobjectWrap"><span>transactionIndex</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Staking transaction index within block</div></li>
					
					<li><div class="ioobjectWrap"><span>type</span> - <span>String</span>:</div>
					<div class="iodefWrap">Type of staking transaction</div></li>
					
					<li><div class="ioobjectWrap"><span>msg</span> - <span>Object</span>:</div>
					<div class="iodefWrap">Staking transaction data, depending on the type of staking transaction</div></li>

				</ul>
			</div>
		</div>
	</div>

	<div class="form_container">
		<div id="formcontent">
			<form method="GET">
				
			<div class="row">
				<div class="col-25">
					<label for="hash">Hash: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="hash" name="hash" maxlength="66" value="<?php if($phph1->chk_goodinput('hash')){ echo $phph1->get_goodinput('hash'); } ?>" />
				</div>
			</div>

			<div class="row">
				<input type="hidden" id="dorequest" name="dorequest" value="1" />
				<input type="hidden" id="method" name="method" value="hmyv2_getStakingTransactionByHash" />
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