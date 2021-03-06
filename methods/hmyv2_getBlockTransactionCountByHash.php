<?php
/**
* Method file for hmyv2_getBlockTransactionCountByHash() in the phph1.php class file
*/

if($phph1->chk_dorequest()){

	/** Prepare blockhash for validation */
	$blockhash = $phph1->phph1_prepinput('blockhash', 'string');
	
	/**
	* Validate the input and run our call if the data is good
	*/
	// Validate the input and run our call if the data is good
	if($phph1->val_getBlockTransactionCountByHash($blockhash)){
		$hmyv2_data = $phph1->hmyv2_getBlockTransactionCountByHash($blockhash);
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
						<p>Gets the number of transactions in a block by using the specified block hash</p>
						<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getBlockTransactionCountByHash">PHPH1 Class Documentation</a>.</p>
					</div>
				</li>
			</ul>
			
			<h3 class="infoHeader">Parameters</h3>
			<ul class="infoObjects" >

				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span>:</div>
				<div class="iodefWrap">Block hash.</div></li>
			
			</ul>
			
			<h3 class="infoHeader">Returns</h3>
			<ul class="infoObjects" >
				
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Number</span>:</div> 
				<div class="iodefWrap">Number of transactions in the block</div></li>
				
			</ul>
		</div>
	</div>
</div>


<div class="form_container">
	<div id="formcontent">
		<form action="/?method=hmyv2_getBlockTransactionCountByHash"  method="post">
			
		<div class="row">
			<div class="col-25">
				<label for="blockhash">Block Hash: </label>
			</div><div class="col-75">
				<input style="background: orange;" type="text" id="blockhash" name="blockhash" maxlength="66" value="<?php if($phph1->chk_goodinput('blockhash')){ echo $phph1->get_goodinput('blockhash'); } ?>" />
			</div>
		</div>

		<div class="row">
			<input type="hidden" id="dorequest" name="dorequest" value="1" />
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

