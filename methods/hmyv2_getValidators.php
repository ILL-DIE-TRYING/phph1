<?php
/**
* Method file for hmyv2_getValidators() in the phph1.php class file
*/

if($phph1->chk_dorequest()){
	
	/**
	* Prepare epoch for validation
	*/
	if(isset($_GET['epoch']) && !empty($_GET['epoch'])){$epoch = $_GET['epoch'];}else{$epoch = null;}
	
	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getValidators($epoch)){
		$hmyv2_data = $phph1->hmyv2_getValidators($epoch);
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
							<p>Gets a list of validators at the specified epoch.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getValidators">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
					
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Number</span>:</div>
					<div class="iodefWrap">Epoch</div></li>
					
				</ul>
				
				<h3>Returns</h3>

				<ul class="infoObjects">
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Object</span>:</div></li>
					
					<li><div class="ioobjectWrap"><span>shardID</span> - <span>Number</span>:</div> 
					<div class="iodefWrap">Shard ID</div></li>
					
					<li><div class="ioobjectWrap"><span>validators</span> - <span>Array</span> of <span>Object</span>:</div></li>
					
					<ul class="infoObjects2">
					
						<li><div class="ioobjectWrap"><span>address</span> - <span>String</span>:</div> 
						<div class="iodefWrap">Wallet address</div></li>
						
						<li><div class="ioobjectWrap"><span>balance</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">Balance of wallet</div></li>
					
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
						<label for="epoch">Epoch: </label>
					</div><div class="col-75">
						<input style="background: orange;" type="text" id="epoch" name="epoch" maxlength="42" value="<?php if($phph1->chk_goodinput('epoch')){ echo $phph1->get_goodinput('epoch'); } ?>" />
					</div>
				</div>
				<div class="row">
					<input type="hidden" id="dorequest" name="dorequest" value="1" />
					<input type="hidden" id="method" name="method" value="hmyv2_getValidators" />
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

