<?php
// Get the transactions
if(isset($valid_scaddress) && $valid_scaddress == 1 && isset($valid_blocknum) && $valid_blocknum == 1){
	if($phph1->phph1_debug == 1){
		echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
	}

	/**
	* Prepare from for validation
	*/
	if(isset($_GET['stlocation'])&& !empty($_GET['stlocation']) && $phph1->val_stlocation($_GET['stlocation'])){
		$stlocation = $_GET['stlocation'];
	}else{
		$stlocation = null;
	}

	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getStorageAt($scaddress, $stlocation, $blocknum)){
		$validinput = 1;
		$hmyv2_data = $phph1->hmyv2_getStorageAt($scaddress, $stlocation, $blocknum);
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
				
					<li class="infoObjectNoBul"><h4><span>String</span> - Smart contract address</h4></li>
					
					<li class="infoObjectNoBul"><h4><span>String</span> - Hex representation of storage location</h4></li>
					
					<li class="infoObjectNoBul"><h4><span>Number</span> - Block Number</h4></li>
					
				</ul>
				
				<h3>Returns</h3>
				
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><h4><span>String</span> - Data stored at the smart contract location</h4></li>
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
					<label for="stlocation">Storage Location: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="stlocation" name="stlocation" maxlength="200" value="<?php if(isset($stlocation)){ echo $stlocation; } ?>" />
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
				<input type="hidden" id="method" name="method" value="hmyv2_getStorageAt" />
				<input type='submit' name='Submit' class="form_submit" />
			</div>
		</form>
		</div>
	</div>
<br />

<?php
/**
* ends the rpc call check
*/
}

require_once('inc/output.php');
?>
