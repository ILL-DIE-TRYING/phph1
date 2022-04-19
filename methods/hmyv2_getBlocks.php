<?php
/**
* Method file for hmyv2_getBlocks() in the phph1.php class file
*/

if($phph1->chk_dorequest()){
	
	/** Start debug info display area */
	if($phph1->get_debugstatus()){ echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>"; }
	
	/** Prepare blocknum for validation */
	if(isset($_GET['blocknum'])&& !empty($_GET['blocknum'])){$blocknum1 = $_GET['blocknum'];}else{$blocknum1 = null;}
	
	/** Prepare blocknum for validation */
	if(isset($_GET['blocknum2'])&& !empty($_GET['blocknum2'])){$blocknum2 = $_GET['blocknum2'];}else{$blocknum2 = null;}
	
		/*
	If fulltx isn't set then we will set it to FALSE by default
	The choices here are 1 (for true) or 0 (for false)
	*/
	if(isset($_GET['fulltx']) && $_GET['fulltx'] == '1'){
		// We have to do this on boolean items to convert the GET data to a PHP boolean value
		$fulltx = true;
	}else{
		$fulltx = false;
	}
	
	/*
	If inclstaking isn't set then we will set it to FALSE by default
	The choices here are TRUE or FALSE
	*/
	if(isset($_GET['inclstaking']) && $_GET['inclstaking'] == 1){$inclstaking = true;}else{$inclstaking = false;}
	
	/*
	If withsigners isn't set then we will set it to FALSE by default
	The choices here are TRUE or FALSE
	*/
	if(isset($_GET['withsigners']) && $_GET['withsigners'] == '1'){$withsigners = true;}else{$withsigners = false;}

	/**
	* Validate the input and run our call if the data is good
	*/
	// Validate the input and run our call if the data is good
	if($phph1->val_getBlocks($blocknum1,$blocknum2,$fulltx,$withsigners,$inclstaking)){
		$hmyv2_data = $phph1->hmyv2_getBlocks($blocknum1,$blocknum2,$fulltx,$withsigners,$inclstaking);
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
						<p>Gets block information on a series of blocks between two block numbers.</p>
						<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getBlocks">PHPH1 Class Documentation</a>.</p>
					</div>
				</li>
			</ul>
			
			<h3 class="infoHeader">Parameters</h3>
			<ul class="infoObjects" >

				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Number</span>:</div>
				<div class="iodefWrap">Starting Block Number</div></li>
				
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Number</span>:</div>
				<div class="iodefWrap">Ending Block Number</div></li>
				
				<li class="infoObjectNoBul">
					<ul class="infoObjects" >
						<li class="infoObjectNoBul"><span>Object</span>:</li>
						
						<li><div class="ioobjectWrap"><span>withSigners</span> - <span >Bool</span>:</div>
						<div class="iodefWrap">Include signers</div></li>
						
						<li><div class="ioobjectWrap"><span>fullTx</span> - <span >Bool</span>:</div>
						<div class="iodefWrap">Include full transaction data</div></li>
						
						<li><div class="ioobjectWrap"><span>inclStaking</span> - <span >Bool</span>:</div>
						<div class="iodefWrap">Include staking transactions</div></li>
					</ul>
				</li>
			
			</ul>
			
			<h3 class="infoHeader">Returns</h3>
			<ul class="infoObjects" >
				
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Array</span>:</div> 
				<div class="iodefWrap">List of blocks</div></li>
				
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
				
				<li><div class="ioobjectWrap"><span>Difficulty</span> - <span >Number</span>:</div>
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
				<div class="iodefWrap"></div></li>
				
				<li><div class="ioobjectWrap"><span>vrfProof</span> - <span >String</span>:</div>
				<div class="iodefWrap"></div></li>
				
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
				
				<li><div class="ioobjectWrap"><span>transactionsInEthHash</span> - <span >JSON Array</span>:</div>
				<div class="iodefWrap">List of transactions finalized in this block in Eth hash</div></li>
				
				<li><div class="ioobjectWrap"><span>stakingTransactions</span> - <span >JSON Array</span>:</div>
				<div class="iodefWrap">List of staking transactions finalized in this block</div></li>
			</ul>
		</div>
	</div>
</div>

<div class="form_container">
	<div id="formcontent">
		<form method="GET">
			<div class="row">
				<div class="col-25">
					<label for="blocknum">Starting Block Number: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="blocknum" name="blocknum" value="<?php if($phph1->chk_goodinput('blocknum')){ echo $phph1->get_goodinput('blocknum'); } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="blocknum2">Ending Block Number: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="blocknum2" name="blocknum2" maxlength="42" value="<?php if($phph1->chk_goodinput('blocknum2')){ echo $phph1->get_goodinput('blocknum2'); } ?>" />
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
				<label for="inclstaking">Include Staking Transactions:</label>
			</div><div class="col-75">
				<select name="inclstaking" id="inclstaking">
					<option value=1 <?php if($phph1->chk_goodinput('inclstaking') && $phph1->get_goodinput('inclstaking') == true){ echo 'selected="selected"'; } ?> >TRUE</option>
					<option value=0 <?php if(($phph1->chk_goodinput('inclstaking') && $phph1->get_goodinput('inclstaking') == false) OR !$phph1->chk_goodinput('inclstaking')){ echo 'selected="selected"'; } ?> >FALSE</option>
				</select>
			</div>
		</div>
			

		<div class="row">
			<input type="hidden" id="dorequest" name="dorequest" value="1" />
			<input type="hidden" id="method" name="method" value="hmyv2_getBlocks" />
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

