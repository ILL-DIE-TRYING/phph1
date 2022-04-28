<?php
/**
* Method file for val_getStakingTransactionsHistory() in the phph1.php class file
*/

if($phph1->chk_dorequest()){

	/**
	* Prepare the one address number for validation
	*/
	if(isset($_GET['oneaddr'])&& !empty($_GET['oneaddr'])){$oneaddr = $_GET['oneaddr'];}else{$oneaddr = null;}

	/**
	* Prepare the page number for validation
	*/
	if(isset($_GET['pagenum'])&& !empty($_GET['pagenum'])){$pagenum = $_GET['pagenum'];}else{$pagenum = 0;}
	
	/**
	* Prepare the page size for validation
	*/
	if(isset($_GET['pagesize'])&& !empty($_GET['pagesize'])){$pagesize = $_GET['pagesize'];}else{$pagesize = $phph1->default_pagesize;}

	/**
	* If txtype isn't set then we will set it to grab all transactions
	* The choices here are "ALL", "RECEIVED", or "SENT"
	*/
	
	if(isset($_GET['txtype']) && !empty($_GET['txtype'])){$txtype = $_GET['txtype'];}else{$txtype = 'ALL';}
	
	/**
	* If order isn't set then we will set it to ascending by default
	* The choices here are "ALL", "RECEIVED", or "SENT"
	*/
	if(isset($_GET['order']) && !empty($_GET['order'])){$order = $_GET['order'];}else{$order = 'ASC';}
	
	/**
	* If fulltx isn't set then we will set it to FALSE by default
	* The choices here are TRUE or FALSE
	*/
	if(isset($_GET['fulltx']) && !empty($_GET['fulltx'])){$fulltx = $_GET['fulltx'];}else{$fulltx = 0;}
	
	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getStakingTransactionsHistory($oneaddr,$pagenum,$pagesize,$fulltx,$txtype,$order)){
		$mytransactioncount = json_decode($phph1->hmyv2_getStakingTransactionsCount($oneaddr,$txtype),true);
		$trcount = $mytransactioncount['result'];
		$trpages = ceil($trcount / $pagesize);
		$hmyv2_data = $phph1->hmyv2_getStakingTransactionsHistory($oneaddr,$pagenum,$pagesize,$fulltx,$txtype,$order);
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
							<p>Gets the staking transactions for a ONE wallet address.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getStakingTransactionsHistory">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Object</span>:</div>
					<div class="iodefWrap">Transaction history args</div></li>
					
					<li><div class="ioobjectWrap"><span>address</span> - <span>String</span>:</div>
					<div class="iodefWrap">Wallet address</div></li>
					
					<li><div class="ioobjectWrap"><span>pageIndex</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Optional, which page of transactions to return, default 0</div></li>
					
					<li><div class="ioobjectWrap"><span>pageSize</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Optional, how many transactions to display per page, default 1000</div></li>
					
					<li><div class="ioobjectWrap"><span>fullTx</span> - <span>Bool</span>:</div>
					<div class="iodefWrap">Optional, return full transaction data or just transaction hashes, default false</div></li>
					
					<li><div class="ioobjectWrap"><span>txType</span> - <span>String</span>:</div>
					<div class="iodefWrap">Optional, which type of transactions to display ("ALL", "RECEIVED", or "SENT"), default "ALL"</div></li>
					
					<li><div class="ioobjectWrap"><span>order</span> - <span>String</span>:</div>
					<div class="iodefWrap">Optional, sort transactions in ascending or descending order based on timestamp ("ASC" or "DESC"), default "ASC"</div></li>
					
				</ul>
				
				<h3>Returns</h3>
				<h4>If <span>fullTx</span> is <span>true</span>:</h4>

				<ul class="infoObjects">
					
					<li class="infoObjectNoBul"><span>Array</span> of <span>Object</span>:</li>
					
					<li><div class="ioobjectWrap"><span>blockHash</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Block hash that transaction was finalized. null if the transaction is pending</div></li>
					
					<li><div class="ioobjectWrap"><span>blockNumber</span> - <span>Number</span>:</div> 
					<div class="iodefWrap">Block number that transaction was finalized. null if the transaction is pending</div></li>
					
					<li><div class="ioobjectWrap"><span>from</span> - <span>String</span>:</div>
					<div class="iodefWrap">Wallet address</div></li>
					
					<li><div class="ioobjectWrap"><span>gas</span> - <span>Number</span>:</div> 
					<div class="iodefWrap">Gas limit in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span>gasPrice</span> - <span>Number</span>:</div> 
					<div class="iodefWrap">Gas price in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span>hash</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Transaction hash</div></li>
					
					<li><div class="ioobjectWrap"><span>msg</span> - <span>Array</span>:</div></li>
					
					<ul class="infoObjects2">
						
						<li><div class="ioobjectWrap"><span>amount</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>delegatorAddress</span> - <span>String</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>validatorAddress</span> - <span>String</span>:</div> 
						<div class="iodefWrap">FIXME</div></li>					
					
					</ul>
					
					<li><div class="ioobjectWrap"><span>nonce</span> - <span>Number</span>:</div> 
					<div class="iodefWrap">Wallet nonce for the transaction</div></li>
					
					<li><div class="ioobjectWrap"><span>r</span> - <span>String</span>:</div> 
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>s</span> - <span>String</span>:</div> 
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>timestamp</span> - <span>Number</span>:</div> 
					<div class="iodefWrap">Timestamp in Unix time when transaction was finalized</div></li>
					
					<li><div class="ioobjectWrap"><span>transactionIndex</span> - <span>Number</span>:</div> 
					<div class="iodefWrap">Index of transaction in block. null if the transaction is pending</div></li>

					<li><div class="ioobjectWrap"><span>type</span> - <span>String</span>:</div> 
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>v</span> - <span>String</span>:</div> 
					<div class="iodefWrap">FIXME</div></li>
					
				</ul>

				<h4>If <span>fullTx</span> is <span>false</span>:</h4>
				
				<ul class="infoObjects">
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Array</span> of <span>String</span>:</div>
					<div class="iodefWrap">List of transaction hashes</div></li>
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
						<label for="pagenum">Page Number: </label>
					</div><div class="col-75">
						<input type="text" id="pagenum" name="pagenum" maxlength="42" value="<?php if($phph1->chk_goodinput('pagenum')){ echo $phph1->get_goodinput('pagenum'); }else{ echo "1"; } ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-25">
						<label for="pagesize">Results Per Page:</label>
					</div><div class="col-75">
						<select name="pagesize" id="pagesize">
							<?php
							/**
							* Build our option dropdown for page size using max_pagesize
							* and default_pagesize in config.php
							*/

							for($x = $default_pagesize; $x <= $max_pagesize; $x+=10 ){
								echo '<option value="'.$x.'"';
								if($phph1->get_goodinput('pagesize') && $x == $phph1->get_goodinput('pagesize')){
									echo ' selected="selected" ';
								}elseif($x == $default_pagesize){
									echo ' selected="selected" ';
								}
								echo '>'.$x.'</option>';
							}
							?>
						</select>
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
					<div class="col-25">
						<label for="order">Order (by date):</label>
					</div><div class="col-75">
						<select name="order" id="order">
							<option value="ASC" <?php if(($phph1->chk_goodinput('order') && $phph1->get_goodinput('order') == 'ASC') OR !$phph1->chk_goodinput('order')){ echo 'selected="selected"'; } ?> >ASCENDING</option>
							<option value="DESC" <?php if($phph1->chk_goodinput('order') && $phph1->get_goodinput('order') == 'DESC'){ echo 'selected="selected"'; } ?> >DESCENDING</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-25">
						<label for="fulltx">Get Full Transaction Data:</label>
					</div><div class="col-75">	
						<select name="fulltx" id="fulltx">
							<option value="1" <?php if($phph1->chk_goodinput('fulltx') && $phph1->get_goodinput('fulltx') == 'TRUE'){ echo 'selected="selected"'; } ?> >TRUE</option>
							<option value="0" <?php if(($phph1->chk_goodinput('fulltx') && $phph1->get_goodinput('fulltx') == 'FALSE') OR !$phph1->chk_goodinput('fulltx')){ echo 'selected="selected"'; } ?> >FALSE</option>
						</select>
					</div>
				</div>
				<div class="row">
					<input type="hidden" id="dorequest" name="dorequest" value="1" />
					<input type="hidden" id="method" name="method" value="hmyv2_getStakingTransactionsHistory" />
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
