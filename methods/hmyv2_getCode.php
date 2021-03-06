<?php
/**
* Method file for hmyv2_getCode() in the phph1.php class file
*/

if($phph1->chk_dorequest()){

	$phph1_inputs = array(
				'scaddress' => 'string',
				'blocknum' => 'int'
	);
	
	foreach($phph1_inputs as $aninput => $input_type){
		$$aninput = $phph1->phph1_prepinput($aninput, $input_type);
	}

	if($phph1->val_getCode($scaddress, $blocknum)){
		$hmyv2_data = $phph1->hmyv2_getCode($scaddress, $blocknum);
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
						<p>Gets the hex return value of the executed smart contract.</p>
						<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getCode">PHPH1 Class Documentation</a>.</p>
					</div>
				</li>
			</ul>
		
			<h3 class="infoHeader">Parameters</h3>
			<ul class="infoObjects" >
			
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span>:</div>
				<div class="iodefWrap">Smart contract address</div></li>
				
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Number</span>:</div>
				<div class="iodefWrap">Block Number</div></li>
				
			</ul>
			
			<h3>Returns</h3>
			<ul class="infoObjects" >
			
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span>:</div>
				<div class="iodefWrap">Hex value of the executed smart contract</div></li>
				
			</ul>

		</div>
	</div>
</div>

<div class="form_container">
	<div id="formcontent">
		<form action="/?method=hmyv2_getCode" method="post">
			<div class="row">
				<div class="col-25">
					<label for="scaddress">Smart Contract Address: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="scaddress" name="scaddress" maxlength="42" value="<?php if($phph1->chk_goodinput('scaddress')){ echo $phph1->get_goodinput('scaddress'); } ?>" />
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
