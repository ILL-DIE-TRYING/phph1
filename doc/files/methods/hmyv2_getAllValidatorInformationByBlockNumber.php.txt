<?php
/**
* Method file for hmyv2_getDelegationsByDelegator() in the phph1.php class file
*/

if($phph1->chk_dorequest()){
	
	/** Prepare pagenum for validation */
	if(isset($_GET['pagenum'])&& !empty($_GET['pagenum'])){$pagenum = $_GET['pagenum'];}else{$pagenum = 0;}
	
	/** Prepare blocknum for validation	*/
	if(isset($_GET['blocknum']) && !empty($_GET['blocknum'])){$blocknum = $_GET['blocknum'];}else{$blocknum = null;}

	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getAllValidatorInformationByBlockNumber($pagenum,$blocknum)){
		$hmyv2_data = $phph1->hmyv2_getAllValidatorInformationByBlockNumber($pagenum,$blocknum);
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
						<p>Get all validator information at a specified block number.</p>
						<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getAllValidatorInformationByBlockNumber">PHPH1 Class Documentation</a>.</p>
					</div>
				</li>
				
			</ul>
		
			<h3 class="infoHeader">Parameters</h3>
			<ul class="infoObjects" >
				
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Number</span>:</div>
				<div class="iodefWrap">Page number</div></li>
				
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Number</span>:</div>
				<div class="iodefWrap">Block number</div></li>
				
			</ul>
			
			<h3 class="infoHeader">Returns</h3>
			<ul class="infoObjects">
			
				<!-- <li class="infoObjectNoBul"><div><span >JSON Array</span> of <span>JSON Object</span>:</div></li>
				
				<li><div class="ioobjectWrap"><span >Undelegations</span> - <span>JSON Array</span>:</div> 
				<div class="iodefWrap">List of pending undelegations</div></li>
				
				<li><div class="ioobjectWrap"><span >amount</span> - <span>Number</span>:</div> 
				<div class="iodefWrap">Amount delegated in atto</div></li>
				
				<li><div class="ioobjectWrap"><span >delegator_address</span> - <span>String</span>:</div> 
				<div class="iodefWrap">Delegator wallet address</div></li>
				
				<li><div class="ioobjectWrap"><span >reward</span> - <span>Number</span>:</div> 
				<div class="iodefWrap">Unclaimed rewards in Atto</div></li>
				
				<li><div class="ioobjectWrap"><span >validator_address</span> - <span>String</span>:</div> 
				<div class="iodefWrap">Validator wallet address</div></li> -->

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
				<label for="blocknum">Block Number: </label>
			</div><div class="col-75">
				<input style="background: orange;" type="text" id="blocknum" name="blocknum" maxlength="60" value="<?php if($phph1->chk_goodinput('blocknum')){ echo $phph1->get_goodinput('blocknum'); } ?>" />
			</div>
		</div>
	
		<div class="row">
			<div class="col-25">
				<label for="pagenum">Page Number: </label>
			</div><div class="col-75">
				<input style="background: orange;" type="text" id="pagenum" name="pagenum" maxlength="60" value="<?php if($phph1->chk_goodinput('pagenum')){ echo $phph1->get_goodinput('pagenum'); }else{ echo "1"; } ?>" />
			</div>
		</div>
		
		<div class="row">
			<input type="hidden" id="dorequest" name="dorequest" value="1" />
			<input type="hidden" id="method" name="method" value="hmyv2_getAllValidatorInformationByBlockNumber" />
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

