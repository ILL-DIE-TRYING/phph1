<?php
if(isset($valid_scaddress) && $valid_scaddress == 1 && isset($valid_blocknum) && $valid_blocknum == 1){
	/**
	* Start debug info display area
	*/
	if($phph1->phph1_debug == 1){
		echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
	}

	/**
	* Prepare from for validation
	*/
	if(isset($_GET['fromaddr'])&& !empty($_GET['fromaddr']) && $phph1->val_oneaddr($_GET['fromaddr'])){
		$from = $_GET['fromaddr'];
	}else{
		$from = null;
	}
	
	/**
	* Prepare gas for validation
	*/
	if(isset($_GET['gas'])&& !empty($_GET['gas'])){
		$gas = $_GET['gas'];
	}else{
		$gas = null;
	}

	/**
	* Prepare gasprice for validation
	*/
	
	if(isset($_GET['gasprice']) && !empty($_GET['gasprice'])){
		$gasprice = $_GET['gasprice'];
	}else{
		$gasprice = null;
	}
	
	/**
	* Prepare value for validation
	*/
	if(isset($_GET['value']) && !empty($_GET['value'])){
		$value = htmlentities($_GET['value']);
	}else{
		$value = null;
	}
	
	/**
	* Prepare data for validation
	*/
	if(isset($_GET['data']) && !empty($_GET['data'])){
		$data = $_GET['data'];
	}else{
		$data = null;
	}
	

	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_call($scaddress, $from, $gas, $gasprice, $value, $data, $blocknum)){
		$validinput = 1;
		$hmyv2_data = $phph1->hmyv2_call($scaddress, $from, $gas, $gasprice, $value, $data, $blocknum);
	}else{
		$validinput = 0;
	}
	
	/**
	* End debug info display area
	*/
	if($phph1->phph1_debug == 1){
			echo "<p class='hmyv2_debug_notify'>### END DEBUGGING INFORMATION ###</p>";
	}
	
	/**
	* Show our errors if we have them
	*/
	if ($validinput == 0){
		echo '<div class="error_div">';
		echo '<p class="hmyv2_errors">Error:';
		$errnum = 1;
		foreach($phph1->errors as $anerror){
			if($errnum == 1){
				echo ' <span class="hmyv2_error">'.$anerror.'</span>';
				$errnum=0;
			}else{
				echo '<span class="hmyv2_error">, '.$anerror.'</span>';
			}
		}
		echo '</p></div>';
	}
	
/**
* Show our errors if we have them
*/
}elseif(isset($_GET['do'])){
		echo '<div class="error_div">';
		echo '<p class="hmyv2_errors">Error:';
		$errnum = 1;
		foreach($phph1->errors as $anerror){
			if($errnum == 1){
				echo ' <span class="hmyv2_error">'.$anerror.'</span>';
				$errnum=0;
			}else{
				echo '<span class="hmyv2_error">, '.$anerror.'</span>';
			}
		}
		echo '</p></div>';
}

/**
* Check if this is a RPC call
* If not show the html output of the method explorer
*/
if($phph1->rpc_call != 1){
?>
	<div class="info_container" >
		<div class="infoRow">
			<button type="button" class="collapsibleInfo"><?=$phph1_method?> :: Params/Returns</button>
			<div id="infoContent" class="infoContent">
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><span>Object</span> - Smart contract call object</li>
					
					<li><div class="ioobjectWrap"><span>to</span> - <span >String</span> :</div>
					<div class="iodefWrap">Smart contract address</div></li>
					
					<li><div class="ioobjectWrap"><span >from</span> - <span >String</span> :</div>
					<div class="iodefWrap">Wallet address, optional</div></li>
					
					<li><div class="ioobjectWrap"><span >gas</span> - <span >Number</span> :</div>
					<div class="iodefWrap">Gas to execute the smart contract call, optional</div></li>
					
					<li><div class="ioobjectWrap"><span >gasPrice</span> - <span >Number</span> :</div>
					<div class="iodefWrap">Gas price to execute smart contract call, optional</div></li>
					
					<li><div class="ioobjectWrap"><span >value</span> - <span >Number</span>:</div>
					<div class="iodefWrap">Value sent with the smart contract call, optional</div></li>
					
					<li><div class="ioobjectWrap"><span >data</span> - <span >String</span>:</div>
					<div class="iodefWrap">Hash of smart contract method and parameters, optional</div></li>
					
					<li class="infoObjectNoBul"><span>Number</span> - Block Number</li>
					
				</ul>
				
				<h3>Returns</h3>
				<ul class="infoObjects" >
					<li class="infoObjectNoBul"><span>String</span> - Return value of the executed smart contract</li>
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
					<input style="background: orange;" type="text" id="scaddress" name="scaddress" maxlength="42" value="<?php if(isset($scaddress)){ echo $scaddress; } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="fromaddr">From: </label>
				</div><div class="col-75">
					<input type="text" id="fromaddr" name="fromaddr" maxlength="42" value="<?php if(isset($fromaddr)){ echo $fromaddr; } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="gas">Gas: </label>
				</div><div class="col-75">
					<input type="text" id="gas" name="gas" maxlength="10" value="<?php if(isset($gas)){ echo $gas; } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="gasprice">Gas Price: </label>
				</div><div class="col-75">
					<input type="text" id="gasprice" name="gasprice" maxlength="10" value="<?php if(isset($gasprice)){ echo $gasprice; } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="value">Value: </label>
				</div><div class="col-75">
					<input type="text" id="value" name="value" maxlength="10" value="<?php if(isset($value)){ echo $value; } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="data">Data: </label>
				</div><div class="col-75">
					<input type="text" id="data" name="data" maxlength="10" value="<?php if(isset($data)){ echo $data; } ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-25">
					<label for="blocknum">Block Number: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="blocknum" name="blocknum" maxlength="200" value="<?php if(isset($blocknum)){ echo $blocknum; } ?>" />
				</div>
			</div>

			<div class="row">
				<input type="hidden" id="do" name="do" value="1" />
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
