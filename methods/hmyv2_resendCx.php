<?php
/**
* Method file for hmyv2_resendCx() in the phph1.php class file
*/

if($phph1->chk_dorequest()){
	
	/** Prepare txhash for validation */
	if(isset($_GET['txhash'])&& !empty($_GET['txhash'])){$txhash = $_GET['txhash'];}else{$txhash = null;}
	
	/**
	* Validate the input and run our call if the data is good
	*/
	// Validate the input and run our call if the data is good
	if($phph1->val_resendCx($txhash)){
		$hmyv2_data = $phph1->hmyv2_resendCx($txhash);
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
							<p>Use this API call to resend the cross shard receipt transaction hash to the receiving shard to re-process if the transaction did not pay out using the specified cross chain transaction hash.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_resendCx">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
				
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >

					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span> :</div>
					<div class="iodefWrap">Cross chard receipt transaction hash.</div></li>
				
				</ul>
				<ul class="infoObjects" >
					<h3 class="infoHeader">Returns</h3>
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Bool</span>:</div> 
					<div class="iodefWrap">If cross shard receipt was successfully resent or not</div></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="form_container">
		<div id="formcontent">
			<form method="GET">
				
				<div class="row">
					<div class="col-25">
						<label for="txhash">Transaction Hash: </label>
					</div><div class="col-75">
						<input style="background: orange;" type="text" id="txhash" name="txhash" maxlength="66" value="<?php if($phph1->chk_goodinput('txhash')){ echo $phph1->get_goodinput('txhash'); } ?>" />
					</div>
				</div>

				<div class="row">
					<input type="hidden" id="dorequest" name="dorequest" value="1" />
					<input type="hidden" id="method" name="method" value="hmyv2_resendCx" />
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


