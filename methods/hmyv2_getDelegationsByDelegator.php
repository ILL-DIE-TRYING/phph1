<?php
/**
* Method file for hmyv2_getDelegationsByDelegator() in the phph1.php class file
*/

if($phph1->chk_dorequest()){
	
	/** Prepare oneaddr for validation */
	$oneaddr = $phph1->phph1_prepinput('oneaddr', 'string');

	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getDelegationsByDelegator($oneaddr)){
		$hmyv2_data = $phph1->hmyv2_getDelegationsByDelegator($oneaddr);
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
						<p>Gets a list of delegations for a ONE wallet address.</p>
						<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getDelegationsByDelegator">PHPH1 Class Documentation</a>.</p>
					</div>
				</li>
			</ul>
		
			<h3 class="infoHeader">Parameters</h3>
			<ul class="infoObjects" >
				
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >String</span>:</div>
				<div class="iodefWrap">Delegator address</div></li>
				
			</ul>
			
			<h3>Returns</h3>
			<ul class="infoObjects">
			
				<li class="infoObjectNoBul"><div><span >JSON Array</span> of <span>JSON Object</span>:</div></li>
				
				<li><div class="ioobjectWrap"><span >Undelegations</span> - <span>JSON Array</span>:</div> 
				<div class="iodefWrap">List of pending undelegations</div></li>
				
				<li><div class="ioobjectWrap"><span >amount</span> - <span>Number</span>:</div> 
				<div class="iodefWrap">Amount delegated in atto</div></li>
				
				<li><div class="ioobjectWrap"><span >delegator_address</span> - <span>String</span>:</div> 
				<div class="iodefWrap">Delegator wallet address</div></li>
				
				<li><div class="ioobjectWrap"><span >reward</span> - <span>Number</span>:</div> 
				<div class="iodefWrap">Unclaimed rewards in Atto</div></li>
				
				<li><div class="ioobjectWrap"><span >validator_address</span> - <span>String</span>:</div> 
				<div class="iodefWrap">Validator wallet address</div></li>

			</ul>

		</div>
	</div>
</div>

<div class="form_container">
	<div id="formcontent">
	<!-- FORM -->
	<form action="/?method=hmyv2_getDelegationsByDelegator" method="post">
		<div class="row">
			<div class="col-25">
				<label for="oneaddr">Delegator Address: </label>
			</div><div class="col-75">
				<input style="background: orange;" type="text" id="oneaddr" name="oneaddr" maxlength="42" value="<?php if($phph1->chk_goodinput('oneaddr')){ echo $phph1->get_goodinput('oneaddr'); } ?>" />
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

