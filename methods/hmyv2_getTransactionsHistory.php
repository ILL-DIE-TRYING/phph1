<?php
// Get the transactions
if(isset($valid_oneaddr) && $valid_oneaddr == 1){
	if($phph1->phph1_debug == 1){
		echo "<p class='hmyv2_debug_notify'>### DEBUGGING INFORMATION ###</p>";
	}

	/**
	* Prepare the page number for validation
	*/
	if(isset($_GET['pagenum'])&& !empty($_GET['pagenum']) && is_numeric($_GET['pagenum'])){
		$pagenum = htmlentities($_GET['pagenum']);
	}else{
		$pagenum = 1;
	}
	
	/**
	* Prepare the page size for validation
	*/
	if(isset($_GET['pagesize'])&& !empty($_GET['pagesize'])){
		$pagesize = $_GET['pagesize'];
	}else{
		$pagesize = $def_pagesize;
	}

	/**
	* If txtype isn't set then we will set it to grab all transactions
	* The choices here are "ALL", "RECEIVED", or "SENT"
	*/
	
	if(isset($_GET['txtype']) && !empty($_GET['txtype'])){
		$txtype = htmlentities($_GET['txtype']);
	}else{
		$txtype = 'ALL';
	}
	
	/**
	* If order isn't set then we will set it to ascending by default
	* The choices here are "ALL", "RECEIVED", or "SENT"
	*/
	if(isset($_GET['order']) && !empty($_GET['order'])){
		$order = htmlentities($_GET['order']);
	}else{
		$order = 'ASC';
	}
	
	/**
	* If fulltx isn't set then we will set it to FALSE by default
	* The choices here are TRUE or FALSE
	*/
	if(isset($_GET['fulltx']) && !empty($_GET['fulltx'])){
		$fulltx = $_GET['fulltx'];
	}else{
		$fulltx = 0;
	}
	

	/**
	* Validate the input and run our call if the data is good
	*/
	if($phph1->val_getTransactionsHistory($phph1->oneaddr,$pagenum,$pagesize,$fulltx,$txtype,$order)){
		$validinput = 1;
		$mytransactioncount = $phph1->hmyv2_getTransactionsCount($phph1->oneaddr,$txtype);
		$trcount = $mytransactioncount['result'];
		$trpages = ceil($trcount / $pagesize);
		$hmyv2_data = $phph1->hmyv2_getTransactionsHistory($phph1->oneaddr,$pagenum,$pagesize,$fulltx,$txtype,$order);
	}else{
		$validinput = 0;
	}
	
	/**
	* End debug info display area
	*/
	if($phph1->phph1_debug == 1){
			echo "<p class='hmyv2_debug_notify'>### END DEBUGGING INFORMATION ###</p>";
	}
	
	/**
	* Show our errors if we have them
	*/
	if ($validinput == 0){
		echo '<div class="error_div">';
		echo '<p class="hmyv2_errors">Error:';
		$errnum = 1;
		foreach($phph1->errors as $anerror){
			if($errnum == 1){
				echo ' <span class="hmyv2_error">'.$anerror.'</span>';
				$errnum=0;
			}else{
				echo '<span class="hmyv2_error">, '.$anerror.'</span>';
			}
		}
		echo '</p></div>';
	}
	
/**
* Show our errors if we have them
*/
}elseif(isset($_GET['do'])){
		echo '<div class="error_div">';
		echo '<p class="hmyv2_errors">Error:';
		$errnum = 1;
		foreach($phph1->errors as $anerror){
			if($errnum == 1){
				echo ' <span class="hmyv2_error">'.$anerror.'</span>';
				$errnum=0;
			}else{
				echo '<span class="hmyv2_error">, '.$anerror.'</span>';
			}
		}
		echo '</p></div>';
}

/**
* Check if this is a RPC call
* If not show the html output of the method explorer
*/
if($phph1->rpc_call != 1){

?>
	<div class="info_container" >
		<div class="infoRow">
			<button type="button" class="collapsibleInfo"><?=$phph1_method?> :: Params/Returns</button>
			<div id="infoContent" class="infoContent">
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><h4><span>Object</span> - Transaction history args</h4></li>
					
					<li><div class="ioobjectWrap"><span>address</span> - <span >String</span> :</div>
					<div class="iodefWrap">Wallet address</div></li>
					
					<li><div class="ioobjectWrap"><span >pageIndex</span> - <span >Number</span> :</div>
					<div class="iodefWrap">Optional, which page of transactions to return, default 0</div></li>
					
					<li><div class="ioobjectWrap"><span >pageSize</span> - <span >Number</span> :</div>
					<div class="iodefWrap">Optional, how many transactions to display per page, default 1000</div></li>
					
					<li><div class="ioobjectWrap"><span >fullTx</span> - <span >Bool</span> :</div>
					<div class="iodefWrap">Optional, return full transaction data or just transaction hashes, default false</div></li>
					
					<li><div class="ioobjectWrap"><span >txType</span> - <span >String</span>:</div>
					<div class="iodefWrap">Optional, which type of transactions to display ("ALL", "RECEIVED", or "SENT"), default "ALL"</div></li>
					
					<li><div class="ioobjectWrap"><span >order</span> - <span >String</span>:</div>
					<div class="iodefWrap">Optional, sort transactions in ascending or descending order based on timestamp ("ASC" or "DESC"), default "ASC"</div></li>
					
				</ul>
				
				<h3>Returns</h3>
				<h4>If <span >fullTx</span> is <span >true</span></h4>
				<h4 class="infoHeader"><span >Array</span> of <span >Object</span></h4>
				<ul class="infoObjects">
					<li><div class="ioobjectWrap"><span >blockHash</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Block hash that transaction was finalized. null if the transaction is pending.</div></li>
					
					<li><div class="ioobjectWrap"><span >blockNumber</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Block number that transaction was finalized. null if the transaction is pending.</div></li>
					
					<li><div class="ioobjectWrap"><span >from</span> - <span >String</span>:</div>
					<div class="iodefWrap">Wallet address</div></li>
					
					<li><div class="ioobjectWrap"><span >timestamp</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Timestamp in Unix time when transaction was finalized</div></li>
					
					<li><div class="ioobjectWrap"><span >gas</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Gas limit in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span >gasPrice</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Gas price in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span >hash</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Transaction hash</div></li>
					
					<li><div class="ioobjectWrap"><span >input</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Transaction data, used for smart contracts</div></li>
					
					<li><div class="ioobjectWrap"><span >nonce</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Wallet nonce for the transaction</div></li>
					
					<li><div class="ioobjectWrap"><span >to</span> - <span >String</span>:</div> 
					<div class="iodefWrap">Wallet address of receiver</div></li>
					
					<li><div class="ioobjectWrap"><span >transactionIndex</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Index of transaction in block. null if the transaction is pending.</div></li>
					
					<li><div class="ioobjectWrap"><span >value</span> - <span >Number</span>:</div> 
					<div class="iodefWrap">Amount transfered in Atto</div></li>
					
					<li><div class="ioobjectWrap"><span >shardID</span> - <span >Number</span> :</div> 
					<div class="iodefWrap">Shard where amount is from</div></li>
					
					<li><div class="ioobjectWrap"><span >toShardID</span> - <span >Number</span> :</div> 
					<div class="iodefWrap">Shard where the amount is sent</div></li>
					
				</ul>

				<h4>If <span >fullTx</span> is <span >false</span></h4>

				<h4 class="infoHeader"><span >Array</span> of <span >String</span>: List of transaction hashes</h4>
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
					<input style="background: orange;" type="text" id="oneaddr" name="oneaddr" maxlength="42" value="<?php if(isset($oneaddr)){ echo $oneaddr; } ?>" />
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
							if($validinput == 1 && $x == $pagesize){
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
						<option value="ALL" <?php if($validinput == 1 && $txtype == 'ALL'){ echo 'selected="selected"'; }elseif(!isset($txtype)){ echo 'selected="selected"'; } ?> >ALL</option>
						<option value="SENT" <?php if($validinput == 1 && $txtype == 'SENT'){ echo 'selected="selected"'; } ?> >SENT</option>
						<option value="RECEIVED" <?php if($validinput == 1 && $txtype == 'RECEIVED'){ echo 'selected="selected"'; } ?> >RECEIVED</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="order">Order (by date):</label>
				</div><div class="col-75">
					<select name="order" id="order">
						<option value="ASC" <?php if($validinput == 1 && $order == 'ASC'){ echo 'selected="selected"'; }elseif(!isset($order)){ echo 'selected="selected"'; } ?> >ASCENDING</option>
						<option value="DESC" <?php if($validinput == 1 && $order == 'DESC'){ echo 'selected="selected"'; } ?> >DESCENDING</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="fulltx">Get Full Transaction Data:</label>
				</div><div class="col-75">	
					<select name="fulltx" id="fulltx">
						<option value="1" <?php if($validinput == 1 && $fulltx == 1){ echo 'selected="selected"'; } ?> >TRUE</option>
						<option value="0" <?php if($validinput == 1 && $fulltx == 0){ echo 'selected="selected"'; }elseif(!isset($fulltx)){ echo 'selected="selected"'; } ?> >FALSE</option>
					</select>
				</div>
			</div>
			<div class="row">
				<input type="hidden" id="do" name="do" value="1" />
				<input type="hidden" id="method" name="method" value="hmyv2_getTransactionsHistory" />
				<input type='submit' name='Submit' class="form_submit" />
			</div>
		</form>
		</div>
	</div>
<br />

<?php
/**
* ends the rpc call check
*/
}

require_once('inc/output.php');
?>
