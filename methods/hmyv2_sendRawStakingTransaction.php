<?php
/**
* Method file for hmyv2_sendRawStakingTransaction() in the phph1.php class file
*/
	
if($phph1->chk_dorequest()){

	/**
	* Prepare transhex for validation
	*/
	if(isset($_GET['transhex']) && !empty($_GET['transhex'])){$transhex = $_GET['transhex'];}else{$transhex = null;}

	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_sendRawStakingTransaction($transhex)){
		$hmyv2_data = $phph1->hmyv2_sendRawStakingTransaction($transhex);
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
							<p>Sends raw staking transaction using the hex representation of signed staking transaction.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_sendRawStakingTransaction">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >

					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span> :</div>
					<div class="iodefWrap">Hex representation of signed staking transaction</div></li>
				
				</ul>
				
				<h3>Returns</h3>
				<ul class="infoObjects">
					
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Object</span>:</div></li>

					<li><div class="ioobjectWrap"><span>String</span>:</div>
					<div class="iodefWrap">Transaction hash if successful</div></li>
					
					<li><div class="iodefWrap">If it fails it will return an error</div></li>
					
				</ul>
			</div>
		</div>
	</div>

	<div class="form_container">
		<div id="formcontent">
			<form method="GET">
				
			<div class="row">
				<div class="col-25">
					<label for="transhex">Transaction hex: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="transhex" name="transhex" maxlength="66" value="<?php if($phph1->chk_goodinput('transhex')){ echo $phph1->get_goodinput('transhex'); } ?>" />
				</div>
			</div>

			<div class="row">
				<input type="hidden" id="dorequest" name="dorequest" value="1" />
				<input type="hidden" id="method" name="method" value="hmyv2_sendRawStakingTransaction" />
				<input type='submit' name='Submit' />
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

