<?php
/**
* Method file for hmyv2_getStorageAt() in the phph1.php class file
*/

if($phph1->chk_dorequest()){
	
	/** Start debug info display area */
	if($phph1->get_debugstatus()){ echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>"; }
	
	/**
	* Prepare scaddress for validation
	*/
	if(isset($_GET['scaddress'])&& !empty($_GET['scaddress'])){$scaddress = $_GET['scaddress'];}else{$scaddress = null;}

	/**
	* Prepare stlocation for validation
	*/
	if(isset($_GET['stlocation'])&& !empty($_GET['stlocation'])){$stlocation = $_GET['stlocation'];}else{$stlocation = null;}
	
	/**
	* Prepare blocknum for validation
	*/
	if(isset($_GET['blocknum']) && !empty($_GET['blocknum'])){$blocknum = $_GET['blocknum'];}else{$blocknum = null;}

	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getStorageAt($scaddress, $stlocation, $blocknum)){
		$validinput = 1;
		$hmyv2_data = $phph1->hmyv2_getStorageAt($scaddress, $stlocation, $blocknum);
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
							<p>All contracts deployed have dedicated storage on the blockchain where it stores their state. This method gets the data stored for a specified smart contract.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getStorageAt">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><span>String</span> - Smart contract address</li>
					
					<li class="infoObjectNoBul"><span>String</span> - Hex representation of storage location</li>
					
					<li class="infoObjectNoBul"><span>Number</span> - Block Number</li>
					
				</ul>
				
				<h3>Returns</h3>
				
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><span>String</span> - Data stored at the smart contract location</li>
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
						<label for="stlocation">Storage Location: </label>
					</div><div class="col-75">
						<input style="background: orange;" type="text" id="stlocation" name="stlocation" maxlength="200" value="<?php if($phph1->chk_goodinput('stlocation')){ echo $phph1->get_goodinput('stlocation'); } ?>" />
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
					<input type="hidden" id="method" name="method" value="hmyv2_getStorageAt" />
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
