<?php

if(isset($valid_oneaddr) && $valid_oneaddr == 1){
	/**
	* Start debug info display area
	*/
	if($phph1->phph1_debug == 1){
		echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
	}

	/**
	* We have validinput if we have a good one address
	*/
	$validinput = 1;
	$hmyv2_data = $phph1->hmyv2_getValidatorInformation($phph1->oneaddr);
	
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

					<li><div class="ioobjectWrap"><span>address</span> - <span>String</span> :</div>
					<div class="iodefWrap">Wallet address</div></li>
				
				</ul>
				
				<h3 class="infoHeader">Returns</h3>
				<h4 class="infoHeader"><span>Array</span> of <span>Object</span></h4>
				<ul class="infoObjects">
						
					<li><div class="ioobjectWrap"><span>active-status</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Active or Inactive.</div></li>
					
					<li><div class="ioobjectWrap"><span>booted-status</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Booted status.</div></li>
					
					<li><div class="infoHeader"><span>current-epoch-performance</span> - <span>Array</span>:</div></li>
					
					<ul class="infoObjects2">
					
						<li><div class="infoHeader"><span>current-epoch-signing-percent</span> - <span>Array</span>:</div></li>
						
						<ul class="infoObjects3">
						
							<li><div class="ioobjectWrap"><span>current-epoch-signed</span> - <span>Number</span>:</div> 
							<div class="iodefWrap">FIXME</div></li>
							
							<li><div class="ioobjectWrap"><span>current-epoch-signing-percentage</span> - <span>Number</span>:</div> 
							<div class="iodefWrap">FIXME</div></li>
							
							<li><div class="ioobjectWrap"><span>current-epoch-to-sign</span> - <span>Number</span>:</div> 
							<div class="iodefWrap">FIXME</div></li>
						
						</ul>
						
					</ul>
					
					<li><div class="ioobjectWrap"><span>currently-in-committee</span> - <span>Bool</span>:</div> 
					<div class="iodefWrap">If key is currently elected</div></li>
					
					<li><div class="ioobjectWrap"><span>epos-status</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Currently elected, eligible to be elected next epoch, or not eligible to be elected next epoch</div></li>

					<li><div class="ioobjectWrap"><span>epos-winning-stake</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Total effective stake of the validator.</div></li>
					
					<li><div class="ioobjectWrap"><span>lifetime</span> - <span>Object</span>:</div></li>
					
					<ul class="infoObjects2">
					
						<li><div class="ioobjectWrap"><span>apr</span> - <span>String</span>:</div> 
						<div class="iodefWrap">Approximate Return Rate.</div></li>
						
						<li><div class="ioobjectWrap"><span>blocks</span> - <span>Object</span>:</div></li>
						
						<ul class="infoObjects3">
						
							<li><div class="ioobjectWrap"><span>to-sign</span> - <span>Number</span>:</div> 
							<div class="iodefWrap">Number of blocks available to the validator to sign</div></li>
							
							<li><div class="ioobjectWrap"><span>signed</span> - <span>Number</span>:</div> 
							<div class="iodefWrap">Number of blocks the validator has signed</div></li>
						
						</ul>
						
						<li><div class="ioobjectWrap"><span>epoch-apr</span> - <span>Array</span>:</div> 
						<div class="iodefWrap">List of APR per epoch</div></li>
						
						<ul class="infoObjects3">
							
							<li><div class="ioobjectWrap"><span>epoch</span> - <span>Number</span>:</div> 
							<div class="iodefWrap">Epoch number</div></li>
							
							<li><div class="ioobjectWrap"><span>value</span> - <span>string</span>:</div> 
							<div class="iodefWrap">Calculated APR for that epoch</div></li>
						
						</ul>
					</ul>
						
					<li><div class="ioobjectWrap"><span>epoch-blocks</span> - <span>Array</span>:</div></li>
					
					<ul class="infoObjects2">
						
						<li><div class="ioobjectWrap"><span>Object</span> of type <span>Array</span>:</div></li>
						
						<ul class="infoObjects4">
						
							<li><div class="ioobjectWrap"><span>blocks</span> - <span>Array</span>:</div></li>
							
							<ul class="infoObjects4">
								<li><div class="ioobjectWrap"><span>signed</span> - <span>Number</span>:</div> 
								<div class="iodefWrap">FIXME</div></li>
								
								<li><div class="ioobjectWrap"><span>to-sign</span> - <span>Number</span>:</div> 
								<div class="iodefWrap">FIXME</div></li>

							</ul>
							
						</ul>
					
						<li><div class="ioobjectWrap"><span>reward-accumulated</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">Lifetime reward accumulated by the validator</div></li>
						
					</ul>

					<li><div class="ioobjectWrap"><span>metrics</span> - <span>Object</span>:</div> 
					<div class="iodefWrap">FIXME</div></li>
					
					<ul class="infoObjects2">
					
						<li><div class="ioobjectWrap"><span>by-bls-key</span> - <span>Array</span> of <span>Object</span>:</div></li>
						
						<ul class="infoObjects3">
							<li><div class="ioobjectWrap"><span>key</span> - <span>Object</span>:</div></li>
							
							<ul class="infoObjects4">
							
								<li><div class="ioobjectWrap"><span>bls-public-key</span> - <span>String</span>:</div> 
								<div class="iodefWrap">BLS public key</div></li>
								
								<li><div class="ioobjectWrap"><span>group-percent</span> - <span>String</span>:</div> 
								<div class="iodefWrap">Key voting power in shard</div></li>
							
								<li><div class="ioobjectWrap"><span>effective-stake</span> - <span>String</span>:</div> 
								<div class="iodefWrap">Effective stake of key</div></li>
								
								<li><div class="ioobjectWrap"><span>raw-stake</span> - <span>String</span>:</div> 
								<div class="iodefWrap">Actual stake of key</div></li>
								
								<li><div class="ioobjectWrap"><span>earning-account</span> - <span>String</span>:</div> 
								<div class="iodefWrap">Validator wallet address</div></li>
								
								<li><div class="ioobjectWrap"><span>overall-percent</span> - <span>String</span>:</div> 
								<div class="iodefWrap">Percent of effective stake</div></li>
								
								<li><div class="ioobjectWrap"><span>shard-id</span> - <span>Number</span>:</div> 
								<div class="iodefWrap">Shard ID that key is on</div></li>
								
							</ul>
							
							<li><div class="ioobjectWrap"><span>earned-reward</span> - <span>Number</span>:</div> 
							<div class="iodefWrap">Lifetime reward key has earned</div></li>
							
						</ul>
						
					</ul>
					
					<li><div class="ioobjectWrap"><span>total-delegation</span> - <span>Number</span>:</div> 
					<div class="iodefWrap">.</div></li>
					
					<li><div class="ioobjectWrap"><span>validator</span> - <span>Array</span></div></li>
					
					<ul class="infoObjects2">
					
						<li><div class="ioobjectWrap"><span>address</span> - <span>String</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>bls-public-keys</span> - <span>Array</span>:</div> 
						<div class="iodefWrap">List of public BLS keys associated with the validator wallet address</div></li>
						
						<li><div class="ioobjectWrap"><span>creation-height</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>delegations</span> - <span>Array</span>:</div> 
						<div class="iodefWrap">List of delegations</li>
						
						<ul class="infoObjects3">
							<li><div class="ioobjectWrap"><span>Array</span> of <span>Object</span>:</div></li>
							
							<ul class="infoObjects4">
							
								<li><div class="ioobjectWrap"><span>amount</span> - <span>Number</span>:</div> 
								<div class="iodefWrap">FIXME</div></li>
								
								<li><div class="ioobjectWrap"><span>delegator-address</span> - <span>String</span>:</div> 
								<div class="iodefWrap">FIXME</div></li>
								
								<li><div class="ioobjectWrap"><span>reward</span> - <span>Number</span>:</div> 
								<div class="iodefWrap">FIXME</div></li>
								
								<li><div class="ioobjectWrap"><span>undelegations</span> - <span>Array</span>:</div> 
								<div class="iodefWrap">List of undelegations</div></li>
							
							</ul>
						</ul>
						
						<li><div class="ioobjectWrap"><span>details</span> - <span>String</span>:</div> 
						<div class="iodefWrap">Validator's details</div></li>
						
						<li><div class="ioobjectWrap"><span>identity</span> - <span>String</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>last-epoch-in-committee</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>max-change-rate</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>max-rate</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>max-total-delegation</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>min-self-delegation</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>name</span> - <span>String</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>rate</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>security-contact</span> - <span>String</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>update-height</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>website</span> - <span>String</span>:</div> 
						<div class="iodefWrap">Validator web site</div></li>

					</ul>
				</ul>
			</div>
		</div>
	</div>

	<div class="form_container">
		<div id="formcontent">
			<form method="get">
				<div class="row">
					<div class="col-25">
						<label for="oneaddr">Wallet Address: </label>
					</div><div class="col-75">
						<input style="background: orange;" type="text" id="oneaddr" name="oneaddr" maxlength="42" value="<?php if(isset($oneaddr)){ echo $oneaddr; } ?>" />
					</div>
				</div>
				<div class="row">
					<input type="hidden" id="do" name="do" value="1" />
					<input type="hidden" id="method" name="method" value="hmyv2_getValidatorInformation" />
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

