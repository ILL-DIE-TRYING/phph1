<?php
/**
* Method file for hmyv2_getAllValidatorInformation() in the phph1.php class file
*/

if($phph1->chk_dorequest()){
	
	// Setting an empty form value to null MUST happen, otherwise our json request will get borked

	/** Prepare pagenum for validation */
	if(isset($_GET['pagenum']) && is_numeric($_GET['pagenum'])){$pagenum = $_GET['pagenum'];}else{$pagenum = 0;}

	// alert the user that this method takes a long time to load
	require_once('inc/alert.php');

	/** Validate the input and run our call if the data is good	*/
	if($phph1->val_getAllValidatorInformation($pagenum)){
		/**
		* Get the transactions
		* This return data is large so trying to buffer the output via php
		*/
		ob_start(null, 64000);
		$hmyv2_data = $phph1->hmyv2_getAllValidatorInformation($pagenum);
		ob_flush();
		ob_end_flush();
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
							<p>Gets all information for all validators.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getAllValidatorInformation">PHPH1 Class Documentation</a>.</p>
							<p><strong>WARNING!</strong> This method retrieves a large amount of data and is slow to return because of it. Be patient and let the page finish loading.</p>
						</div>
					</li>
				</ul>
		
			<h3 class="infoHeader">Parameters</h3>
			<ul class="infoObjects" >
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Number</span>:</div> 
					<div class="iodefWrap">Page number to retrieve. Pages start at 1.</div></li>
			</ul>
			
			<h3 class="infoHeader">Returns</h3>
			<ul class="infoObjects">
			
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Object</span>:</div></li>
			
				<li><div class="ioobjectWrap"><span >validator</span> - <span >Object</span>:</div></li>
				
				<ul class="infoObjects2">
					<li><div class="ioobjectWrap"><span >bls-public-keys</span> - <span >Array</span>:</div> 
					<div class="iodefWrap">List of public BLS keys associated with the validator wallet address</div></li>
					
					<li><div class="ioobjectWrap"><span >last-epoch-in-committee</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Last epoch any key of the validator was elected</div></li>
					
					<li><div class="ioobjectWrap"><span >min-self-delegation</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Amount that validator must delegate to self in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span >max-total-delegation</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Total amount that validator will accept delegations until in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span >rate</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Current commission rate</div></li>
					
					<li><div class="ioobjectWrap"><span >max-rate</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Max commission rate a validator can charge</div></li>
					
					<li><div class="ioobjectWrap"><span >max-change-rate</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Maximum amount the commission rate can increase in one epoch</div></li>
					
					<li><div class="ioobjectWrap"><span >update-height</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Last block validator editted their validator information</div></li>
					
					<li><div class="ioobjectWrap"><span >name</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Validator name, displayed on the Staking Dashboard</div></li>
					
					<li><div class="ioobjectWrap"><span >identity</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Validator identity, must be unique</div></li>
					
					<li><div class="ioobjectWrap"><span >website</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Validator website, displayed on the Staking Dashboard</div></li>
					
					<li><div class="ioobjectWrap"><span >security-contact</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Method to contact the validator</div></li>
					
					<li><div class="ioobjectWrap"><span >details</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Validator details, displayed on the Staking Dashboard</div></li>
					
					<li><div class="ioobjectWrap"><span >creation-height</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Block in which the validator was created</div></li>
					
					<li><div class="ioobjectWrap"><span >address</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Validator wallet address</div></li>
					
					<li><div class="ioobjectWrap"><span >delegations</span> - <span >Array</span>:</div> 
					<div class="iodefWrap">List of delegations</div></li>
					
					<ul class="infoObjects3">
					
						<li><div class="ioobjectWrap"><span >Array</span>:</div></li>
						
						<ul class="infoObjects4">
						
							<li><div class="ioobjectWrap"><span >delegator-address</span> - <span >String</span>:</div> 
							<div class="iodefWrap">Validator wallet address</div></li>
							
							<li><div class="ioobjectWrap"><span >amount</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">The amount staked to the validator</div></li>
							
							<li><div class="ioobjectWrap"><span >reward</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Unclaimed staking reward</div></li>
							
							<li><div class="ioobjectWrap"><span >undelegations</span> - <span >Array</span>:</div> 
							<div class="iodefWrap">List of undelegations</div></li>
						
						</ul>
						
					</ul>
					
					<li><div class="ioobjectWrap"><span >metrics</span> - <span >Object</span>:</div> 
					<div class="iodefWrap">.</div></li>
					
					<ul class="infoObjects3">
					
						<li><div class="ioobjectWrap"><span >by-bls-key</span> - <span >Array</span> of <span>Object</span>:</div></li>
						
						<ul class="infoObjects4">
							<li><div class="ioobjectWrap"><span >key</span> - <span>Object</span>:</div></li>
							
							<ul class="infoObjects5">
							
								<li><div class="ioobjectWrap"><span >bls-public-key</span> - <span >String</span>:</div> 
								<div class="iodefWrap">BLS public key</div></li>
								
								<li><div class="ioobjectWrap"><span >group-percent</span> - <span >String</span>:</div> 
								<div class="iodefWrap">Key voting power in shard</div></li>
							
								<li><div class="ioobjectWrap"><span >effective-stake</span> - <span >String</span>:</div> 
								<div class="iodefWrap">Effective stake of key</div></li>
								
								<li><div class="ioobjectWrap"><span >raw-stake</span> - <span >String</span>:</div> 
								<div class="iodefWrap">Actual stake of key</div></li>
								
								<li><div class="ioobjectWrap"><span >earning-account</span> - <span >String</span>:</div> 
								<div class="iodefWrap">Validator wallet address</div></li>
								
								<li><div class="ioobjectWrap"><span >overall-percent</span> - <span >String</span>:</div> 
								<div class="iodefWrap">Percent of effective stake</div></li>
								
								<li><div class="ioobjectWrap"><span >shard-id</span> - <span >Number</span>:</div> 
								<div class="iodefWrap">Shard ID that key is on</div></li>
								
							</ul>
							
							<li><div class="ioobjectWrap"><span >earned-reward</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Lifetime reward key has earned</div></li>
							
						</ul>
						
					</ul>

					<li><div class="ioobjectWrap"><span >total-delegation</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Total amount delegated to validator</div></li>
					
					<li><div class="ioobjectWrap"><span >currently-in-committee</span> - <span >Bool</span>:</div> 
					<div class="iodefWrap">If key is currently elected</div></li>
					
					<li><div class="ioobjectWrap"><span >epos-status</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Currently elected, eligible to be elected next epoch, or not eligible to be elected next epoch</div></li>

					<li><div class="ioobjectWrap"><span >epos-winning-stake</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Total effective stake of the validator</div></li>
					
					<li><div class="ioobjectWrap"><span >banned-status</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Banned status</div></li>
					
					<li><div class="ioobjectWrap"><span >active-status</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Active or Inactive</div></li>
					
					<li><div class="ioobjectWrap"><span >lifetime</span> - <span >Object</span>:</div></li>
					
					<ul class="infoObjects3">
						<li><div class="ioobjectWrap"><span >reward-accumulated</span> - <span >Number</span>:</div> 
						<div class="iodefWrap">Lifetime reward accumulated by the validator</div></li>
						
						<li><div class="ioobjectWrap"><span >blocks</span> - <span >Object</span>:</div></li>
						
						<ul class="infoObjects4">
						
							<li><div class="ioobjectWrap"><span >to-sign</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Number of blocks available to the validator to sign</div></li>
							
							<li><div class="ioobjectWrap"><span >signed</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Number of blocks the validator has signed</div></li>
						
						</ul>
					
						<li><div class="ioobjectWrap"><span >apr</span> - <span >String</span>:</div> 
						<div class="iodefWrap">Approximate Return Rate</div></li>
						
						<li><div class="ioobjectWrap"><span >epoch-apr</span> - <span >Array</span>:</div> 
						<div class="iodefWrap">List of APR per epoch</div></li>
						
						<ul class="infoObjects4">
						
							<li><div class="ioobjectWrap"><span >epoch</span> - <span >Number</span>:</div> 
							<div class="iodefWrap">Epoch number</div></li>
							
							<li><div class="ioobjectWrap"><span >value</span> - <span >string</span>:</div> 
							<div class="iodefWrap">Calculated APR for that epoch</div></li>
						
						</ul>
						
					</ul>

				</ul>
			
			</ul>
		</div>
	</div>
</div>
<div class="form_container">
	<div id="formcontent">
	<form method="get">
		<div class="row">
			<div class="col-25">
				<label for="pagenum">Page Index: </label>
			</div><div class="col-75">
				<input style="background: orange;" type="text" id="pagenum" name="pagenum" maxlength="42" value="<?php if($phph1->chk_goodinput('pagenum')){ echo $phph1->get_goodinput('pagenum'); }else{ echo '1'; } ?>" />
			</div>
		</div>
		<div class="row">
			<input type="hidden" id="do" name="dorequest" value="1" />
			<input type="hidden" id="method" name="method" value="hmyv2_getAllValidatorInformation" />
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

