<?php

if(isset($valid_oneaddr) && $valid_oneaddr == 1){
	if($phph1->phph1_debug == 1){
		echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
	}

	$validinput = 1;
	$hmyv2_data = $phph1->hmyv2_getDelegationsByValidator($oneaddr);

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
}elseif(isset($_GET['do']) && $_GET['do'] == 1 && isset($valid_oneaddr) && $valid_oneaddr == 0){
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
					
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span> :</div>
					<div class="iodefWrap">Validator address</div></li>
					
				</ul>
				
				<h3>Returns</h3>

				<ul class="infoObjects">
					<li class="infoObjectNoBul"><div><span >Array</span> of <span>Object</span>:</div></li>
					
					<li><div class="ioobjectWrap"><span >validator_address</span> - <span>String</span></div> 
					<div class="iodefWrap">Validator wallet address.</div></li>
					
					<li><div class="ioobjectWrap"><span >delegator_address</span> - <span>String</span></div> 
					<div class="iodefWrap">Delegator wallet address.</div></li>
					
					<li><div class="ioobjectWrap"><span >amount</span> - <span>Number</span></div> 
					<div class="iodefWrap">Amount delegated in atto.</div></li>
					
					<li><div class="ioobjectWrap"><span >reward</span> - <span>Number</span></div> 
					<div class="iodefWrap">Unclaimed rewards in Atto.</div></li>
					
					<li><div class="ioobjectWrap"><span >Undelegations</span> - <span>JSON Array</span></div> 
					<div class="iodefWrap">List of pending undelegations.</div></li>
				</ul>

			</div>
		</div>
	</div>
	<div class="form_container">
		<div id="formcontent">
		<!-- FORM -->
		<form method="GET">
			<div class="row">
				<div class="col-25">
					<label for="oneaddr">Validator Address: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="oneaddr" name="oneaddr" maxlength="42" value="<?php if(isset($oneaddr)){ echo $oneaddr; } ?>" />
				</div>
			</div>
			<div class="row">
				<input type="hidden" id="do" name="do" value="1" />
				<input type="hidden" id="method" name="method" value="hmyv2_getDelegationsByValidator" />
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

