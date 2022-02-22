<?php
if(isset($valid_blocknum) && $valid_blocknum == 1){
	if($phph1->phph1_debug == 1){
		echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
	}

	/*
	* We are already validated in advance
	*/
	$validinput = 1;

	$hmyv2_data = $phph1->hmyv2_getBlockTransactionCountByNumber($blocknum);

	
	/**
	* End debug info display area
	*/
	if($phph1->phph1_debug == 1){
			echo "<p class='hmyv2_debug_notify'>### END DEBUGGING INFORMATION ###</p>";
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

					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Number</span> :</div>
					<div class="iodefWrap">Block number.</div></li>
				
				</ul>
				<ul class="infoObjects" >
					<h3 class="infoHeader">Returns</h3>
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Number</span>:</div> 
					<div class="iodefWrap">Number of transactions</div></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<form method="GET">
	
<div class="row">
	<div class="col-25">
		<label for="blocknum">Block Number: </label>
	</div><div class="col-75">
		<input style="background: orange;" type="text" id="blocknum" name="blocknum" maxlength="66" value="<?php if(isset($blocknum)){ echo $blocknum; } ?>" />
	</div>
</div>

<div class="row">
	<input type="hidden" id="do" name="do" value="1" />
	<input type="hidden" id="method" name="method" value="hmyv2_getBlockTransactionCountByNumber" />
	<input type='submit' name='Submit' />
</div>

</form>

<?php
/**
* ends the rpc call check
*/
}

require_once('inc/output.php');
?>

