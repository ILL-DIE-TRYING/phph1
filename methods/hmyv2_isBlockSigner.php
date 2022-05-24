<?php
/**
* Method file for hmyv2_isBlockSigner() in the phph1.php class file
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
	if($phph1->val_isBlockSigner($oneaddr,$blocknum)){
		$hmyv2_data = $phph1->hmyv2_isBlockSigner($oneaddr,$blocknum);
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
							<p>Gets whether specified ONE address is a block signer for a specified block number.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_isBlockSigner">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>

				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>address</span> - <span>String</span>:</div>
					<div class="iodefWrap">Validator address</div></li>
					
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>blocknum</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Block number.</div></li>
					
				</ul>
				
				<h3 class="infoHeader">Returns</h3>
				<ul class="infoObjects">
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Bool</span>:</div> 
					<div class="iodefWrap">Returns true if address is a block signer</div></li>
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
					<input type="hidden" id="method" name="method" value="hmyv2_isBlockSigner" />
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

