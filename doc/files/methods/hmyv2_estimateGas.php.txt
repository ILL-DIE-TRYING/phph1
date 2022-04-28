<?php
/**
* Method file for hmyv2_estimateGas() in the phph1.php class file
*/

if($phph1->chk_dorequest()){
	
	// Setting an empty form value to null MUST happen, otherwise our json request will get borked

	/** Prepare toaddr for validation */
	if(isset($_GET['toaddr'])&& !empty($_GET['toaddr'])){$toaddr = $_GET['toaddr'];}else{$toaddr = null;}

	/** Prepare fromaddr for validation */
	if(isset($_GET['fromaddr'])&& !empty($_GET['fromaddr'])){$fromaddr = $_GET['fromaddr'];}else{$fromaddr = null;}

	/** Prepare gas for validation */
	if(isset($_GET['gas'])&& !empty($_GET['gas'])){$gas = $_GET['gas'];}else{$gas = null;}

	/** Prepare gasprice for validation */

	if(isset($_GET['gasprice']) && !empty($_GET['gasprice'])){$gasprice = $_GET['gasprice'];}else{$gasprice = null;}

	/** Prepare value for validation */
	if(isset($_GET['value']) && !empty($_GET['value'])){$value = $_GET['value'];}else{$value = null;}

	/** Prepare data for validation	*/
	if(isset($_GET['data']) && !empty($_GET['data'])){$data = $_GET['data'];}else{$data = null;}

	/** Validate the input and run our call if the data is good	*/
	if($phph1->val_estimateGas($toaddr, $fromaddr, $gas, $gasprice, $value, $data)){
		$hmyv2_data = $phph1->hmyv2_estimateGas($toaddr, $fromaddr, $gas, $gasprice, $value, $data);
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
							<p>Generates and returns an estimate of how much gas is necessary to allow the transaction to complete. The transaction will not be added to the blockchain. Note that the estimate may be significantly more than the amount of gas actually used by the transaction, for a variety of reasons including EVM mechanics and node performance.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_estimateGas">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><h4><span>Object</span> - Smart contract call object</h4></li>
					
					<li><div class="ioobjectWrap"><span>to</span> - <span >String</span> :</div>
					<div class="iodefWrap">Wallet address sending to (ETH address, not ONE)</div></li>
					
					<li><div class="ioobjectWrap"><span >from</span> - <span >String</span> :</div>
					<div class="iodefWrap">Wallet address sending from (ETH address, not ONE), optional</div></li>
					
					<li><div class="ioobjectWrap"><span >gas</span> - <span >Number</span> :</div>
					<div class="iodefWrap">Gas to execute the smart contract call in hex, optional</div></li>
					
					<li><div class="ioobjectWrap"><span >gasPrice</span> - <span >Number</span> :</div>
					<div class="iodefWrap">Gas price to execute smart contract call in hex, optional</div></li>
					
					<li><div class="ioobjectWrap"><span >value</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Value sent with the smart contract call in hex, optional</div></li>
					
					<li><div class="ioobjectWrap"><span >data</span> - <span >String</span>:</div>
					<div class="iodefWrap">Hash of smart contract method and parameters, optional</div></li>
					
				</ul>
				
				<h3>Returns</h3>
				
				<ul class="infoObjects" >
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span>:</div>
					<div class="iodefWrap">Hex value of estimated gas price for the smart contract call</div></li>
				</ul>

			</div>
		</div>
	</div>
	<div class="form_container">
		<div id="formcontent">
		<form method="get">
			<div class="row">
				<div class="col-25">
					<label for="toaddr">To Address: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="toaddr" name="toaddr" maxlength="42" value="<?php if($phph1->chk_goodinput('toaddr')){ echo $phph1->get_goodinput('toaddr'); } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="fromaddr">From Address: </label>
				</div><div class="col-75">
					<input type="text" id="fromaddr" name="fromaddr" maxlength="42" value="<?php if($phph1->chk_goodinput('fromaddr')){ echo $phph1->get_goodinput('fromaddr'); } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="gas">Gas: </label>
				</div><div class="col-75">
					<input type="text" id="gas" name="gas" maxlength="100" value="<?php if($phph1->chk_goodinput('gas')){ echo $phph1->get_goodinput('gas'); } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="gasprice">Gas Price: </label>
				</div><div class="col-75">
					<input type="text" id="gasprice" name="gasprice" maxlength="100" value="<?php if($phph1->chk_goodinput('gasprice')){ echo $phph1->get_goodinput('gasprice'); } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="value">Value: </label>
				</div><div class="col-75">
					<input type="text" id="value" name="value" maxlength="100" value="<?php if($phph1->chk_goodinput('value')){ echo $phph1->get_goodinput('value'); } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="data">Data: </label>
				</div><div class="col-75">
					<input type="text" id="data" name="data" maxlength="1000" value="<?php if($phph1->chk_goodinput('data')){ echo $phph1->get_goodinput('data'); } ?>" />
				</div>
			</div>

			<div class="row">
				<input type="hidden" id="do" name="dorequest" value="1" />
				<input type="hidden" id="method" name="method" value="hmyv2_estimateGas" />
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
