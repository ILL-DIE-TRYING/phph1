<?php
/**
* Method file for hmyv2_getBlockByNumber() in the phph1.php class file
*/

if($phph1->chk_dorequest()){

	/** Prepare blocknum for validation */
	if(isset($_GET['blocknum'])&& !empty($_GET['blocknum'])){$blocknum = $_GET['blocknum'];}else{$blocknum = null;}
	
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
	If incltx isn't set then we will set it to FALSE by default
	The choices here are TRUE or FALSE
	*/
	if(isset($_GET['incltx']) && $_GET['incltx'] == '1'){$incltx = true;}else{$incltx = false;}
	
	
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
	if($phph1->val_getBlockByNumber($blocknum,$fulltx,$incltx,$withsigners,$inclstaking)){
		$hmyv2_data = $phph1->hmyv2_getBlockByNumber($blocknum,$fulltx,$incltx,$withsigners,$inclstaking);
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
							<p>Gets block information using the specified block number.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getBlockByNumber">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >

					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Number</span>:</div>
					<div class="iodefWrap">Block number.</div></li>
				
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
					
					<li><div class="ioobjectWrap"><span>Difficulty</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Unused, legacy from Eth</div></li>
					
					<li><div class="ioobjectWrap"><span>Epoch</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Epoch number of block</div></li>
					
					<li><div class="ioobjectWrap"><span>extraData</span> - <span >String</span>:</div>
					<div class="iodefWrap">Hex representation of extra data in the block</div></li>
					
					<li><div class="ioobjectWrap"><span>gasLimit</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Maximum gas that can be used for transactions in the block</div></li>
					
					<li><div class="ioobjectWrap"><span>gasUsed</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Amount of gas used for transactions in the block</div></li>
					
					<li><div class="ioobjectWrap"><span>hash</span> - <span >String</span>:</div>
					<div class="iodefWrap">Block hash</div></li>
					
					<li><div class="ioobjectWrap"><span>logsBloom</span> - <span >String</span>:</div>
					<div class="iodefWrap">Bloom logs</div></li>
					
					<li><div class="ioobjectWrap"><span>miner</span> - <span >String</span>:</div>
					<div class="iodefWrap">Wallet address of the leader that proposed this block</div></li>
					
					<li><div class="ioobjectWrap"><span>mixHash</span> - <span >String</span>:</div>
					<div class="iodefWrap">Unused, legacy from Eth</div></li>
					
					<li><div class="ioobjectWrap"><span>nonce</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Unused, legacy from Eth</div></li>
					
					<li><div class="ioobjectWrap"><span>number</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Block number</div></li>
					
					<li><div class="ioobjectWrap"><span>parentHash</span> - <span >String</span>:</div>
					<div class="iodefWrap">Hash of parent block</div></li>
					
					<li><div class="ioobjectWrap"><span>receiptsRoot</span> - <span >String</span>:</div>
					<div class="iodefWrap">Hash of transaction receipt root</div></li>
					
					<li><div class="ioobjectWrap"><span>size</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Block size in bytes</div></li>
					
					<li><div class="ioobjectWrap"><span>stakingTransactions</span> - <span >JSON Array</span>:</div>
					<div class="iodefWrap">List of staking transactions finalized in this block</div></li>
					
					<li><div class="ioobjectWrap"><span>stateRoot</span> - <span >String</span>:</div>
					<div class="iodefWrap">Hash of state root</div></li>
					
					<li><div class="ioobjectWrap"><span>timestamp</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Unix timestamp of the block</div></li>
					
					<li><div class="ioobjectWrap"><span>transactions</span> - <span >JSON Array</span>:</div>
					<div class="iodefWrap">List of transactions finalized in this block</div></li>
					
					<li><div class="ioobjectWrap"><span>transactionsRoot</span> - <span >String</span>:</div>
					<div class="iodefWrap">Hash of transactions root</div></li>
					
					<li><div class="ioobjectWrap"><span>uncles</span> - <span >JSON Array</span>:</div>
					<div class="iodefWrap">Unused, legacy from Eth</div></li>
					
					<li><div class="ioobjectWrap"><span>viewID</span> - <span >Number</span>:</div>
					<div class="iodefWrap">View ID</div></li>

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
				<input style="background: orange;" type="text" id="blocknum" name="blocknum" maxlength="200" value="<?php if($phph1->chk_goodinput('blocknum')){ echo $phph1->get_goodinput('blocknum'); } ?>" />
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
			<input type="hidden" id="method" name="method" value="hmyv2_getBlockByNumber" />
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