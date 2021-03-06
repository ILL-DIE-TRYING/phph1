<?php
/**
* Method file for hmyv2_getBlockByHash() in the phph1.php class file
*/

if($phph1->chk_dorequest()){

	$phph1_inputs = array(
				'blockhash' => 'string',
				'fulltx' => 'bool',
				'incltx' => 'bool',
				'inclstaking' => 'bool',
				'withsigners' => 'bool'
	);
	
	foreach($phph1_inputs as $aninput => $input_type){
		$$aninput = $phph1->phph1_prepinput($aninput, $input_type);
	}

	/**
	* Validate the input and run our call if the data is good
	*/
	// Validate the input and run our call if the data is good
	if($phph1->val_getBlockByHash($blockhash,$fulltx,$incltx,$withsigners,$inclstaking)){
		$hmyv2_data = $phph1->hmyv2_getBlockByHash($blockhash,$fulltx,$incltx,$withsigners,$inclstaking);
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
							<p>Gets block information using the specified block hash.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getBlockByHash">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >

					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span>:</div>
					<div class="iodefWrap">Block hash</div></li>
				
				</ul>
				
				<ul class="infoObjects" >
					<li class="infoObjectNoBul"><span>Object</span>:</li>
					
					<li><div class="ioobjectWrap"><span>fullTx</span> - <span >Bool</span>:</div>
					<div class="iodefWrap">Include full transaction data</div></li>
					
					<li><div class="ioobjectWrap"><span>inclTx</span> - <span >Bool</span>:</div>
					<div class="iodefWrap">Include regular transactions</div></li>
					
					<li><div class="ioobjectWrap"><span>inclStaking</span> - <span >Bool</span>:</div>
					<div class="iodefWrap">Include staking transactions</div></li>
					
					<li><div class="ioobjectWrap"><span>withSigners</span> - <span >Bool</span>:</div>
					<div class="iodefWrap">Include signers</div></li>
					
				</ul>
				
				<h3 class="infoHeader">Returns</h3>				
				<ul class="infoObjects" >
					
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Object</span>:</div></li>
					
					<li><div class="ioobjectWrap"><span>number</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Block number</div></li>
					
					<li><div class="ioobjectWrap"><span>viewID</span> - <span >Number</span>:</div>
					<div class="iodefWrap">View ID</div></li>
					
					<li><div class="ioobjectWrap"><span>Epoch</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Epoch number of block</div></li>
					
					<li><div class="ioobjectWrap"><span>hash</span> - <span >String</span>:</div>
					<div class="iodefWrap">Block hash</div></li>
					
					<li><div class="ioobjectWrap"><span>parentHash</span> - <span >String</span>:</div>
					<div class="iodefWrap">Hash of parent block</div></li>
					
					<li><div class="ioobjectWrap"><span>nonce</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Unused, legacy from Eth</div></li>
					
					<li><div class="ioobjectWrap"><span>mixHash</span> - <span >String</span>:</div>
					<div class="iodefWrap">Unused, legacy from Eth</div></li>
					
					<li><div class="ioobjectWrap"><span>logsBloom</span> - <span >String</span>:</div>
					<div class="iodefWrap">Bloom logs</div></li>
					
					<li><div class="ioobjectWrap"><span>stateRoot</span> - <span >String</span>:</div>
					<div class="iodefWrap">Hash of state root</div></li>
					
					<li><div class="ioobjectWrap"><span>miner</span> - <span >String</span>:</div>
					<div class="iodefWrap">Wallet address of the leader that proposed this block</div></li>
					
					<li><div class="ioobjectWrap"><span>difficulty</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Unused, legacy from Eth</div></li>
					
					<li><div class="ioobjectWrap"><span>extraData</span> - <span >String</span>:</div>
					<div class="iodefWrap">Hex representation of extra data in the block</div></li>
					
					<li><div class="ioobjectWrap"><span>size</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Block size in bytes</div></li>
					
					<li><div class="ioobjectWrap"><span>gasLimit</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Maximum gas that can be used for transactions in the block</div></li>
					
					<li><div class="ioobjectWrap"><span>gasUsed</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Amount of gas used for transactions in the block</div></li>
					
					<li><div class="ioobjectWrap"><span>vrf</span> - <span >String</span>:</div>
					<div class="iodefWrap">vrf string in hex</div></li>
					
					<li><div class="ioobjectWrap"><span>vrfproof</span> - <span >String</span>:</div>
					<div class="iodefWrap">vrfproof string in hex</div></li>
					
					<li><div class="ioobjectWrap"><span>timestamp</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Unix timestamp of the block</div></li>
					
					<li><div class="ioobjectWrap"><span>transactionsRoot</span> - <span >String</span>:</div>
					<div class="iodefWrap">Hash of transactions root</div></li>
					
					<li><div class="ioobjectWrap"><span>receiptsRoot</span> - <span >String</span>:</div>
					<div class="iodefWrap">Hash of transaction receipt root</div></li>
					
					<li><div class="ioobjectWrap"><span>uncles</span> - <span >JSON Array</span>:</div>
					<div class="iodefWrap">Unused, legacy from Eth</div></li>
					
					<li><div class="ioobjectWrap"><span>transactions</span> - <span >JSON Array</span>:</div>
					<div class="iodefWrap">List of transactions finalized in this block</div></li>
					
						<ul class="infoObjects2">
						
							<li><div class="ioobjectWrap"><span >blockHash</span> - <span >String</span>:</div> 
							<div class="iodefWrap">Transaction block hash</div></li>
							
							<li><div class="ioobjectWrap"><span >blockNumber</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Transaction block number</div></li>
							
							<li><div class="ioobjectWrap"><span >from</span> - <span >String</span>:</div> 
							<div class="iodefWrap">From address</div></li>
							
							<li><div class="ioobjectWrap"><span >timestamp</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Timestamp</div></li>
							
							<li><div class="ioobjectWrap"><span >gas</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Gas</div></li>
							
							<li><div class="ioobjectWrap"><span >gasPrice</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Gas price for the transaction</div></li>
							
							<li><div class="ioobjectWrap"><span >hash</span> - <span >String</span>:</div> 
							<div class="iodefWrap">Transaction hash</div></li>
							
							<li><div class="ioobjectWrap"><span >ethHash</span> - <span >String</span>:</div> 
							<div class="iodefWrap">Transaction ETH hash</div></li>
							
							<li><div class="ioobjectWrap"><span >input</span> - <span >String</span>:</div> 
							<div class="iodefWrap">FIXME</div></li>
							
							<li><div class="ioobjectWrap"><span >nonce</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Wallet nonce of transaction</div></li>
							
							<li><div class="ioobjectWrap"><span >to</span> - <span >String</span>:</div> 
							<div class="iodefWrap">Transaction to address</div></li>
							
							<li><div class="ioobjectWrap"><span >transactionIndex</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Transaction index</div></li>
							
							<li><div class="ioobjectWrap"><span >value</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Transaction amount</div></li>
							
							<li><div class="ioobjectWrap"><span >shardID</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Shard ID of the sender</div></li>
							
							<li><div class="ioobjectWrap"><span >toShardID</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Shard ID of the receiver</div></li>
							
							<li><div class="ioobjectWrap"><span >v</span> - <span >String</span>:</div> 
							<div class="iodefWrap">Final 1 byte of ECDSA signature</div></li>
							
							<li><div class="ioobjectWrap"><span >r</span> - <span >String</span>:</div> 
							<div class="iodefWrap">First 32 bytes of ECDSA signature</div></li>
							
							<li><div class="ioobjectWrap"><span >s</span> - <span >String</span>:</div> 
							<div class="iodefWrap">Second 32 bytes of ECDSA signature</div></li>
						</ul>
					
					<li><div class="ioobjectWrap"><span>stakingTransactions</span> - <span >JSON Array</span>:</div>
					<div class="iodefWrap">List of staking transactions finalized in this block</div></li>
					
						<ul class="infoObjects2">
						
							<li><div class="ioobjectWrap"><span >blockHash</span> - <span >String</span>:</div> 
							<div class="iodefWrap">Transaction block hash</div></li>
							
							<li><div class="ioobjectWrap"><span >blockNumber</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Transaction block number</div></li>
							
							<li><div class="ioobjectWrap"><span >from</span> - <span >String</span>:</div> 
							<div class="iodefWrap">From address</div></li>
							
							<li><div class="ioobjectWrap"><span >timestamp</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Timestamp</div></li>
							
							<li><div class="ioobjectWrap"><span >gas</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Gas</div></li>
							
							<li><div class="ioobjectWrap"><span >gasPrice</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Gas price for the transaction</div></li>
							
							<li><div class="ioobjectWrap"><span >hash</span> - <span >String</span>:</div> 
							<div class="iodefWrap">Transaction hash</div></li>
							
							<li><div class="ioobjectWrap"><span >nonce</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Wallet nonce of transaction</div></li>
							
							<li><div class="ioobjectWrap"><span >transactionIndex</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Transaction index</div></li>
							
							<li><div class="ioobjectWrap"><span >v</span> - <span >String</span>:</div> 
							<div class="iodefWrap">Final 1 byte of ECDSA signature</div></li>
							
							<li><div class="ioobjectWrap"><span >r</span> - <span >String</span>:</div> 
							<div class="iodefWrap">First 32 bytes of ECDSA signature</div></li>
							
							<li><div class="ioobjectWrap"><span >s</span> - <span >String</span>:</div> 
							<div class="iodefWrap">Second 32 bytes of ECDSA signature</div></li>
							
							<li><div class="ioobjectWrap"><span >type</span> - <span >String</span>:</div> 
							<div class="iodefWrap">The type of staking transaction</div></li>
							
							<li><div class="ioobjectWrap"><span >msg</span> - <span >Array</span>:</div></li>
							
							<li><div class="ioobjectWrap"><span >shardID</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Shard ID of the sender</div></li>
							
							<li><div class="ioobjectWrap"><span >toShardID</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Shard ID of the receiver</div></li>
							
								<ul class="infoObjects3">
						
									<li><div class="ioobjectWrap"><span >delegatorAddress</span> - <span >String</span>:</div> 
									<div class="iodefWrap">The delegator walletaddress</div></li>
									
									<li><div class="ioobjectWrap"><span >validatorAddress</span> - <span >String</span>:</div> 
									<div class="iodefWrap">The validator wallet address</div></li>
									
									<li><div class="ioobjectWrap"><span >amount</span> - <span >Number</span>:</div> 
									<div class="iodefWrap">The amount staked in atto</div></li>
									
								</ul>
							
						</ul>
					
					<li><div class="ioobjectWrap"><span>signers</span> - <span >JSON Array</span>:</div>
					<div class="iodefWrap">List of block signer addresses for this block</div></li>
					
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="form_container">
	<div id="formcontent">
		<form action="/?method=hmyv2_getBlockByHash" method="post">
			
		<div class="row">
			<div class="col-25">
				<label for="blockhash">Block Hash: </label>
			</div><div class="col-75">
				<input style="background: orange;" type="text" id="blockhash" name="blockhash" maxlength="66" value="<?php if($phph1->chk_goodinput('blockhash')){ echo $phph1->get_goodinput('blockhash'); } ?>" />
			</div>
		</div>
			
		<div class="row">
			<div class="col-25">
				<label for="fulltx">Get Full Transaction Data:</label>
			</div><div class="col-75">
				<select name="fulltx" id="fulltx">
					<option value=1 <?php if($phph1->chk_goodinput('fulltx') && $phph1->get_goodinput('fulltx') == true){ echo 'selected="selected"'; } ?> >TRUE</option>
					<option value=0 <?php if(($phph1->chk_goodinput('fulltx') && $phph1->get_goodinput('fulltx') == false) OR !$phph1->chk_goodinput('fulltx')){ echo 'selected="selected"'; } ?> >FALSE</option>
				</select>
			</div>
		</div>

		<div class="row">
			<div class="col-25">
				<label for="incltx">Include Regular Transactions:</label>
			</div>
			<div class="col-75">
				<select name="incltx" id="incltx">
					<option value=1 <?php if($phph1->chk_goodinput('incltx') && $phph1->get_goodinput('incltx') == 1){ echo 'selected="selected"'; } ?> >TRUE</option>
					<option value=0 <?php if(($phph1->chk_goodinput('incltx') && $phph1->get_goodinput('incltx') == 0) OR !$phph1->chk_goodinput('incltx')){ echo 'selected="selected"'; } ?> >FALSE</option>
				</select>
			</div>
		</div>
			
		<div class="row">
			<div class="col-25">
				<label for="inclstaking">Include Staking Transactions:</label>
			</div><div class="col-75">
				<select name="inclstaking" id="inclstaking">
					<option value=1 <?php if($phph1->chk_goodinput('inclstaking') && $phph1->get_goodinput('inclstaking') == true){ echo 'selected="selected"'; } ?> >TRUE</option>
					<option value=0 <?php if(($phph1->chk_goodinput('inclstaking') && $phph1->get_goodinput('inclstaking') == false) OR !$phph1->chk_goodinput('inclstaking')){ echo 'selected="selected"'; } ?> >FALSE</option>
				</select>
			</div>
		</div>
			
		<div class="row">
			<div class="col-25">
				<label for="withsigners">Include Signers:</label>
			</div><div class="col-75">
				<select name="withsigners" id="withsigners">
					<option value=1 <?php if($phph1->chk_goodinput('withsigners') && $phph1->get_goodinput('withsigners') == true){ echo 'selected="selected"'; } ?> >TRUE</option>
					<option value=0 <?php if(($phph1->chk_goodinput('withsigners') && $phph1->get_goodinput('withsigners') == false) OR !$phph1->chk_goodinput('withsigners')){ echo 'selected="selected"'; } ?> >FALSE</option>
				</select>
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

