<?php
/**
* Method file for hmyv2_getTransactionReceipt() in the phph1.php class file
*/

if($phph1->chk_dorequest()){

	$hash = $phph1->phph1_prepinput('hash', 'string');

	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getTransactionReceipt($hash)){
		$hmyv2_data = $phph1->hmyv2_getTransactionReceipt($hash);
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
							<p>Gets transaction receipt using the transaction hash (NOT block hash).</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getTransactionReceipt">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >

					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span> :</div>
					<div class="iodefWrap">Hash.</div></li>
				
				</ul>
				<ul class="infoObjects" >
					<h3 class="infoHeader">Returns</h3>

					<ul class="infoObjects">
						
						<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Object</span>:</div></li>
						
						<li><div class="ioobjectWrap"><span >blockHash</span> - <span >String</span>:</div> 
						<div class="iodefWrap">Block hash that transaction was finalized. null if the transaction is pending.</div></li>
						
						<li><div class="ioobjectWrap"><span >blockNumber</span> - <span >Number</span>:</div> 
						<div class="iodefWrap">Block number that transaction was finalized. null if the transaction is pending.</div></li>
						
						<li><div class="ioobjectWrap"><span >contractAddress</span> - <span >String</span>:</div>
						<div class="iodefWrap">Smart contract address</div></li>
						
						<li><div class="ioobjectWrap"><span >cumulativeGasUsed</span> - <span >Number</span>:</div> 
						<div class="iodefWrap">Gas used for transaction</div></li>
						
						<li><div class="ioobjectWrap"><span >from</span> - <span >String</span>:</div> 
						<div class="iodefWrap">Sender wallet address</div></li>
						
						<li><div class="ioobjectWrap"><span >gasUsed</span> - <span >Number</span>:</div> 
						<div class="iodefWrap">Gas used for the transaction</div></li>
						
						<li><div class="ioobjectWrap"><span >logs</span> - <span >Array</span></div></li>
						
						<ul class="infoObjects2">
							<li><div class="ioobjectWrap"><span>address</span> - <span >String</span>:</div>
							<div class="iodefWrap"></div></li>
							
							<li><div class="ioobjectWrap"><span>blockHash</span> - <span >String</span>:</div>
							<div class="iodefWrap">Block hash</div></li>
							
							<li><div class="ioobjectWrap"><span>blockNumber</span> - <span >Number</span>:</div>
							<div class="iodefWrap">Block number</div></li>
							
							<li><div class="ioobjectWrap"><span>data</span> - <span >String</span>:</div>
							<div class="iodefWrap">Data in hex</div></li>
							
							<li><div class="ioobjectWrap"><span>logIndex</span> - <span >String</span>:</div>
							<div class="iodefWrap">Log index in hex</div></li>
							
							<li><div class="ioobjectWrap"><span>removed</span> - <span >Boolean</span>:</div>
							<div class="iodefWrap">Yes or no</div></li>
							
							<li><div class="ioobjectWrap"><span>topics</span> - <span >Array</span>:</div>
							<div class="iodefWrap">List of topics in hex</div></li>
							
							<li><div class="ioobjectWrap"><span>transactionHash</span> - <span >String</span>:</div>
							<div class="iodefWrap">Transaction hash</div></li>
							
							<li><div class="ioobjectWrap"><span>transactionIndex</span> - <span >String</span>:</div>
							<div class="iodefWrap">Transaction index in hex</div></li>
							
						</ul>
						
						<li><div class="ioobjectWrap"><span >logsBloom</span> - <span >String</span>:</div> 
						<div class="iodefWrap">Bloom logs</div></li>
						
						<li><div class="ioobjectWrap"><span >root</span> - <span >String</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span >shardID</span> - <span >Number</span> :</div> 
						<div class="iodefWrap">Shard ID</div></li>
						
						<li><div class="ioobjectWrap"><span >status</span> - <span >Number</span>:</div> 
						<div class="iodefWrap">Status of transaction (0: pending, 1: success)</div></li>
						
						<li><div class="ioobjectWrap"><span >to</span> - <span >String</span>:</div> 
						<div class="iodefWrap">Receiver wallet address</div></li>
						
						<li><div class="ioobjectWrap"><span >transactionHash</span> - <span >String</span>:</div> 
						<div class="iodefWrap">Transaction hash</div></li>
						
						<li><div class="ioobjectWrap"><span >transactionIndex</span> - <span >Number</span>:</div> 
						<div class="iodefWrap">Transaction index within block</div></li>

					</ul>
				</ul>
			</div>
		</div>
	</div>

	<div class="form_container">
		<div id="formcontent">
			<form action="/?method=hmyv2_getTransactionReceipt" method="post">
				
			<div class="row">
				<div class="col-25">
					<label for="hash">Hash (NOT Block Hash): </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="hash" name="hash" maxlength="66" value="<?php if($phph1->chk_goodinput('hash')){ echo $phph1->get_goodinput('hash'); } ?>" />
				</div>
			</div>

			<div class="row">
				<input type="hidden" id="dorequest" name="dorequest" value="1" />
				<input type="hidden" id="method" name="method" value="hmyv2_getTransactionReceipt" />
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

