<?php
/**
* Method file for hmyv2_getBlockByHash() in the phph1.php class file
*/

if($phph1->chk_dorequest()){
	
	/** Start debug info display area */
	if($phph1->get_debugstatus()){ echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>"; }
	
	/** Prepare blocknum for validation */
	if(isset($_GET['blocknum'])&& !empty($_GET['blocknum'])){$blocknum = $_GET['blocknum'];}else{$blocknum = null;}

	/**
	* Validate the input and run our call if the data is good
	*/
	// Validate the input and run our call if the data is good
	if($phph1->val_getBlockSignerKeys($blocknum)){
		$hmyv2_data = $phph1->hmyv2_getBlockSignerKeys($blocknum);
	}
	
	/** End debug info display area	*/
	if($phph1->get_debugstatus()){ echo "<p class='hmyv2_debug_notify'>### END DEBUGGING INFORMATION ###</p>"; }

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
						<p>Gets block signer BLS keys using the supplied block number.</p>
						<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getBlockSignerKeys">PHPH1 Class Documentation</a>.</p>
					</div>
				</li>
			</ul>
		
			<h3 class="infoHeader">Parameters</h3>
			<ul class="infoObjects" >

				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Number</span>:</div>
				<div class="iodefWrap">Block Number</div></li>
			
			</ul>
			
			<h3 class="infoHeader">Returns</h3>
			<ul class="infoObjects" >
			
				<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Array</span>:</div> 
				<div class="iodefWrap">List of block signer public BLS keys</div></li>
				
			</ul>
		</div>
	</div>
</div>

<div class="form_container">
	<div id="formcontent">
		<form method="GET">
		
			<div class="row">
				<div class="col-25">
					<label for="blocknum">Block Number: </label>
				</div><div class="col-75">
					<input style="background: orange;" type="text" id="blocknum" name="blocknum" maxlength="42" value="<?php if($phph1->chk_goodinput('blocknum')){ echo $phph1->get_goodinput('blocknum'); } ?>" />
				</div>
			</div>

			<div class="row">
				<input type="hidden" id="dorequest" name="dorequest" value="1" />
				<input type="hidden" id="method" name="method" value="hmyv2_getBlockSignerKeys" />
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

