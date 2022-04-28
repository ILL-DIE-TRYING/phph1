<?php
/**
* Method file for hmyv2_getStakingTransactionsCount() in the phph1.php class file
*/

if($phph1->chk_dorequest()){

	/**
	* Prepare oneaddr for validation
	*/
	if(isset($_GET['oneaddr']) && !empty($_GET['oneaddr'])){$oneaddr = $_GET['oneaddr'];}else{$oneaddr = null;}
	
	/**
	* If txtype isn't set then we will set it to grab all transactions
	* The choices here are "ALL", "RECEIVED", or "SENT"
	*/
	if(isset($_GET['txtype']) && !empty($_GET['txtype'])){$txtype = $_GET['txtype'];}else{$txtype = 'ALL';}
	
	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getStakingTransactionsCount($oneaddr,$txtype)){
		$hmyv2_data = $phph1->hmyv2_getStakingTransactionsCount($oneaddr,$txtype);
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
							<p>Gets the number of staking transactions for a ONE wallet address.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getStakingTransactionsCount">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>address</span> - <span >String</span>:</div>
					<div class="iodefWrap">Wallet address</div></li>
					
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >txType</span> - <span >String</span>:</div>
					<div class="iodefWrap">Optional, which type of transactions to display ("ALL", "RECEIVED", or "SENT"), default "ALL"</div></li>
					
				</ul>
				
				<h3>Returns</h3>
				<ul class="infoObjects">
				
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span >Number</span>:</div>
					<div class="iodefWrap">Number of transactions</div></li>
					
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
					<label for="txtype">Transaction Type:</label>
				</div><div class="col-75">
					<select name="txtype" id="txtype">
						<option value="ALL" <?php if(($phph1->chk_goodinput('txtype') && $phph1->get_goodinput('txtype') == 'ALL') OR !$phph1->chk_goodinput('txtype')){ echo 'selected="selected"'; } ?> >ALL</option>
						<option value="SENT" <?php if($phph1->chk_goodinput('txtype') && $phph1->get_goodinput('txtype') == 'SENT'){ echo 'selected="selected"'; } ?> >SENT</option>
						<option value="RECEIVED" <?php if($phph1->chk_goodinput('txtype') && $phph1->get_goodinput('txtype') == 'RECEIVED'){ echo 'selected="selected"'; } ?> >RECEIVED</option>
					</select>
				</div>
			</div>
			
			<div class="row">
				<input type="hidden" id="dorequest" name="dorequest" value="1" />
				<input type="hidden" id="method" name="method" value="hmyv2_getStakingTransactionsCount" />
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

