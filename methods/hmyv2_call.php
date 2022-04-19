<?php
/**
* Method file for hmyv2_call() in the phph1.php class file
*/

if($phph1->chk_dorequest()){
	
	/** Start debug info display area */
	if($phph1->get_debugstatus()){
		echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
		require_once('inc/debug.php');
	}
	
	/** Prepare scaddress for validation */
	if(isset($_GET['scaddress'])&& !empty($_GET['scaddress'])){$scaddress = $_GET['scaddress'];}else{$scaddress = null;}

	/** Prepare from for validation	*/
	if(isset($_GET['fromaddr'])&& !empty($_GET['fromaddr'])){$fromaddr = $_GET['fromaddr'];}else{$fromaddr = null;}
	
	/** Prepare gas for validation */
	if(isset($_GET['gas']) && !empty($_GET['gas'])){$gas = $_GET['gas'];}else{$gas = null;}

	/** Prepare gasprice for validation	*/
	if(isset($_GET['gasprice']) && !empty($_GET['gasprice'])){$gasprice = $_GET['gasprice'];}else{$gasprice = null;}
	
	/** Prepare value for validation */
	if(isset($_GET['value']) && !empty($_GET['value'])){$value = $_GET['value'];}else{$value = null;}
	
	/** Prepare data for validation	*/
	if(isset($_GET['data']) && !empty($_GET['data'])){$data = $_GET['data'];}else{$data = null;}
	
	/** Prepare blocknum for validation	*/
	if(isset($_GET['blocknum']) && !empty($_GET['blocknum'])){$blocknum = $_GET['blocknum'];}else{$blocknum = null;}
	
	/** Validate the input and run our call if the data is good	*/
	if($phph1->val_call($scaddress, $fromaddr, $gas, $gasprice, $value, $data, $blocknum)){
		$hmyv2_data = $phph1->hmyv2_call($scaddress, $fromaddr, $gas, $gasprice, $value, $data, $blocknum);
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
							<p>Executes a new message call immediately, without creating a transaction on the block chain. The hmyv2_call method can be used to query internal contract state, to execute validations coded into a contract or even to test what the effect of a transaction would be without running it live.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_call">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><span>Object</span> - Smart contract call object</li>
					
					<li><div class="ioobjectWrap"><span>to</span> - <span >String</span> :</div>
					<div class="iodefWrap">Smart contract address</div></li>
					
					<li><div class="ioobjectWrap"><span >from</span> - <span >String</span> :</div>
					<div class="iodefWrap">ETH wallet address, optional</div></li>
					
					<li><div class="ioobjectWrap"><span >gas</span> - <span >Number</span> :</div>
					<div class="iodefWrap">Hexidecimal gas to execute the smart contract call in hex, optional</div></li>
					
					<li><div class="ioobjectWrap"><span >gasPrice</span> - <span >Number</span> :</div>
					<div class="iodefWrap">Hexidecimal gas price to execute smart contract call, optional</div></li>
					
					<li><div class="ioobjectWrap"><span >value</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Hexidecimal value sent with the smart contract call, optional</div></li>
					
					<li><div class="ioobjectWrap"><span >data</span> - <span >String</span>:</div>
					<div class="iodefWrap">Hexidecimal hash of smart contract method and parameters, optional</div></li>
					
					<li class="infoObjectNoBul"><span>Number</span> - Block Number</li>
					
				</ul>
				
				<h3>Returns</h3>
				<ul class="infoObjects" >
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span>:</div>
					<div class="iodefWrap">Return value of the executed smart contract</div></li>
				</ul>

			</div>
		</div>
	</div>
	<div class="form_container">
		<div id="formcontent">
		<form method="get">
			<div class="row">
				<div class="col-25">
					<label for="scaddress">Smart Contract Address: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="scaddress" name="scaddress" maxlength="42" value="<?php if($phph1->chk_goodinput('scaddress')){ echo $phph1->get_goodinput('scaddress'); } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="fromaddr">From: </label>
				</div><div class="col-75">
					<input type="text" id="fromaddr" name="fromaddr" maxlength="42" value="<?php if($phph1->chk_goodinput('fromaddr')){ echo $phph1->get_goodinput('fromaddr'); } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="gas">Gas: </label>
				</div><div class="col-75">
					<input type="text" id="gas" name="gas" maxlength="10" value="<?php if($phph1->chk_goodinput('gas')){ echo $phph1->get_goodinput('gas'); } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="gasprice">Gas Price: </label>
				</div><div class="col-75">
					<input type="text" id="gasprice" name="gasprice" maxlength="10" value="<?php if($phph1->chk_goodinput('gasprice')){ echo $phph1->get_goodinput('gasprice'); } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="value">Value: </label>
				</div><div class="col-75">
					<input type="text" id="value" name="value" maxlength="10" value="<?php if($phph1->chk_goodinput('value')){ echo $phph1->get_goodinput('value'); } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="data">Data: </label>
				</div><div class="col-75">
					<input type="text" id="data" name="data" maxlength="10" value="<?php if($phph1->chk_goodinput('data')){ echo $phph1->get_goodinput('data'); } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="blocknum">Block Number: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="blocknum" name="blocknum" maxlength="200" value="<?php if($phph1->chk_goodinput('blocknum')){ echo $phph1->get_goodinput('blocknum'); } ?>" />
				</div>
			</div>

			<div class="row">
				<input type="hidden" id="dorequest" name="dorequest" value="1" />
				<input type="hidden" id="method" name="method" value="hmyv2_call" />
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
