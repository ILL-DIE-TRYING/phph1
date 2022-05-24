<?php
/**
* Method file for hmyv2_getTransactionsHistory() in the phph1.php class file
*/

if($phph1->chk_dorequest()){
	
	$phph1_inputs = array(
				'oneaddr' => 'string',
				'pagenum' => 'striintng',
				'pagesize' => 'int',
				'txtype' => 'string',
				'order' => 'string',
				'fulltx' => 'bool'
	);
	
	foreach($phph1_inputs as $aninput => $input_type){
		$$aninput = $phph1->phph1_prepinput($aninput, $input_type);
	}	
	
	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getTransactionsHistory($oneaddr,$pagenum,$pagesize,$fulltx,$txtype,$order)){
		$mytransactioncount = json_decode($phph1->hmyv2_getTransactionsCount($oneaddr,$txtype), true);
		$trcount = $mytransactioncount['result'];
		$trpages = ceil($trcount / $pagesize);
		$hmyv2_data = $phph1->hmyv2_getTransactionsHistory($oneaddr,$pagenum,$pagesize,$fulltx,$txtype,$order);
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
							<p>Gets the transaction history for the specified ONE wallet address.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getTransactionsHistory">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><span>Object</span> - Transaction history args</li>
					
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
					
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Array</span> of <span>Object</span>:</div></li>
					
					<ul class="infoObjects2">
					
						<li><div class="ioobjectWrap"><span>blockHash</span> - <span>String</span>:</div> 
						<div class="iodefWrap">Block hash that transaction was finalized. null if the transaction is pending</div></li>
						
						<li><div class="ioobjectWrap"><span>blockNumber</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">Block number that transaction was finalized. null if the transaction is pending</div></li>
						
						<li><div class="ioobjectWrap"><span>from</span> - <span>String</span>:</div>
						<div class="iodefWrap">Wallet address</div></li>
						
						<li><div class="ioobjectWrap"><span>timestamp</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">Timestamp in Unix time when transaction was finalized</div></li>
						
						<li><div class="ioobjectWrap"><span>gas</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">Gas limit in Atto</div></li>
						
						<li><div class="ioobjectWrap"><span>gasPrice</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">Gas price in Atto</div></li>
						
						<li><div class="ioobjectWrap"><span>hash</span> - <span>String</span>:</div> 
						<div class="iodefWrap">Transaction hash</div></li>
						
						<li><div class="ioobjectWrap"><span>input</span> - <span>String</span>:</div> 
						<div class="iodefWrap">Transaction data, used for smart contracts</div></li>
						
						<li><div class="ioobjectWrap"><span>nonce</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">Wallet nonce for the transaction</div></li>
						
						<li><div class="ioobjectWrap"><span>to</span> - <span>String</span>:</div> 
						<div class="iodefWrap">Wallet address of receiver</div></li>
						
						<li><div class="ioobjectWrap"><span>transactionIndex</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">Index of transaction in block. null if the transaction is pending</div></li>
						
						<li><div class="ioobjectWrap"><span>value</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">Amount transfered in Atto</div></li>
						
						<li><div class="ioobjectWrap"><span>shardID</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">Shard where amount is from</div></li>
						
						<li><div class="ioobjectWrap"><span>toShardID</span> - <span>Number</span>:</div> 
						<div class="iodefWrap">Shard where the amount is sent</div></li>
					
					</ul>
					
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
			<form action="?method=hmyv2_getTransactionsHistory" method="post">
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
						<input type="text" id="pagenum" name="pagenum" maxlength="42" value="<?php if($phph1->chk_goodinput('pagenum')){ echo $phph1->get_goodinput('pagenum'); }else{ echo '1';} ?>" />
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
							<option value="1" <?php if($phph1->chk_goodinput('fulltx') && $phph1->get_goodinput('fulltx') == 1){ echo 'selected="selected"'; } ?> >TRUE</option>
							<option value="0" <?php if(($phph1->chk_goodinput('fulltx') && $phph1->get_goodinput('fulltx') == 0) OR !$phph1->chk_goodinput('fulltx')){ echo 'selected="selected"'; } ?> >FALSE</option>
						</select>
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
