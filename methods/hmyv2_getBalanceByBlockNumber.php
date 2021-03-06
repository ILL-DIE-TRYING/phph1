<?php
/**
* Method file for hmyv2_getBalanceByBlockNumber() in the phph1.php class file
*/

if($phph1->chk_dorequest()){

	$phph1_inputs = array(
				'oneaddr' => 'string',
				'blocknum' => 'int'
	);
	
	foreach($phph1_inputs as $aninput => $input_type){
		$$aninput = $phph1->phph1_prepinput($aninput, $input_type);
	}
	
	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getBalanceByBlockNumber($oneaddr,$blocknum)){
		$hmyv2_data = $phph1->hmyv2_getBalanceByBlockNumber($oneaddr,$blocknum);
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
							<p>Gets the current balance in atto for the specified wallet at the specified block number.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getBalanceByBlockNumber">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span>:</div>
					<div class="iodefWrap">ONE wallet address</div></li>
					
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Number</span>:</div>
					<div class="iodefWrap">Block number to get balance at</div></li>
					
				</ul>
				
				<h3 class="infoHeader">Returns</h3>				
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Number</span>:</div> 
					<div class="iodefWrap">Wallet balance at specified block number in atto</div></li>
					
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="form_container">
	<div id="formcontent">
		<form action="/?method=hmyv2_getBalanceByBlockNumber" method="post">
			<div class="row">
				<div class="col-25">
					<label for="oneaddr">Wallet Address: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="oneaddr" name="oneaddr" maxlength="42" value="<?php if($phph1->chk_goodinput('oneaddr')){ echo $phph1->get_goodinput('oneaddr'); } ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="blocknum">Block Number: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="blocknum" name="blocknum" maxlength="42" value="<?php if($phph1->chk_goodinput('blocknum')){ echo $phph1->get_goodinput('blocknum'); } ?>" />
				</div>
			</div>
			<div class="row">
				<input type="hidden" id="dorequest" name="dorequest" value="1" />
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


