<?php
/**
* Method file for hmyv2_getNodeMetadata() in the phph1.php class file
*/

// There is no input so no validation required
$phph1->set_validinput(1);

// Get the block number dataset
$hmyv2_data = $phph1->hmyv2_getNodeMetadata();

require_once('inc/errors.php');

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
							<p>Gets the current node metadata.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getNodeMetadata">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
					<li class="infoObjectNoBul"><h4>No Parameters Required</h4></li>
				</ul>
				
				<h3 class="infoHeader">Returns</h3>
				<ul class="infoObjects">
				
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Object</span>:</div></li>
					
					<li><div class="ioobjectWrap"><span>blocks-per-epoch</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Number of blocks per epoch (only available on Shard 0)</div></li>
					
					<li><div class="ioobjectWrap"><span>blskey</span> - <span>Array</span>:</div>
					<div class="iodefWrap">List of BLS keys on the node</div></li>
					
					<li><div class="ioobjectWrap"><span>chain-config</span> - <span>Object</span></div>:</li>
					
					<ul class="infoObjects2">
						
						<li><div class="ioobjectWrap"><span>aggregated-reward-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
					
						<li><div class="ioobjectWrap"><span>chain-id</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Chain ID for the network</div></li>
						
						<li><div class="ioobjectWrap"><span>commission-promo-period</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>cross-link-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Epoch at which cross links were enabled</div></li>

						<li><div class="ioobjectWrap"><span>cross-tx-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Epoch at which cross cross shard transactions were enabled</div></li>
						
						<li><div class="ioobjectWrap"><span>data-copy-fix-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>eip155-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Epoch at with EIP155 was enabled</div></li>
						
						<li><div class="ioobjectWrap"><span>epos-bound-35-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>eth-compatible-chain-id</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>eth-compatible-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>five-seconds-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>hip6_8-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>istanbul-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>min-commission-rate-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>min-delegation-100-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>no-early-unlock-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>prestaking-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Epoch at which pre-staking began</div></li>
						
						<li><div class="ioobjectWrap"><span>prev-vrf-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>quick-unlock-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Epoch at which undelegations unlocked in one epoch</div></li>
						
						<li><div class="ioobjectWrap"><span>receipt-log-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Epoch at which receipt logs were enabled</div></li>
						
						<li><div class="ioobjectWrap"><span>redelegation-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>s3-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Epoch at which Mainnet V0 was launched</div></li>
						
						<li><div class="ioobjectWrap"><span>sha3-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>sixty-percent-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>staking-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Epoch at which staking was enabled</div></li>
						
						<li><div class="ioobjectWrap"><span>staking-precompile-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>two-seconds-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>vrf-epoch</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
					</ul>
					
					<li><div class="ioobjectWrap"><span>consensus</span> - <span>Array</span></div></li>
					
					<ul class="infoObjects2">
						
						<li><div class="ioobjectWrap"><span>blocknum</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>finality</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>mode</span> - <span>String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>phase</span> - <span>String</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>viewChangeId</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
						
						<li><div class="ioobjectWrap"><span>viewId</span> - <span>Number</span>:</div>
						<div class="iodefWrap">FIXME</div></li>
					
					</ul>
					
					<li><div class="ioobjectWrap"><span>current-block-number</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Current block number</div></li>					
					
					<li><div class="ioobjectWrap"><span>current-epoch</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Current epoch</div></li>
					
					<li><div class="ioobjectWrap"><span>dns-zone</span> - <span>String</span>:</div>
					<div class="iodefWrap">Name of the DNS zone</div></li>
					
					<li><div class="ioobjectWrap"><span>is-archival</span> - <span>Bool</span>:</div>
					<div class="iodefWrap">Whether the node is currently in state pruning mode or not</div></li>
					
					<li><div class="ioobjectWrap"><span>is-backup</span> - <span>Bool</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>is-leader</span> - <span>Bool</span>:</div>
					<div class="iodefWrap">Whether the node is currently leader or not</div></li>
					
					<li><div class="ioobjectWrap"><span>network</span> - <span>String</span>:</div>
					<div class="iodefWrap">Network name that the node is on (Mainnet or Testnet)</div></li>
					
					<li><div class="ioobjectWrap"><span>node-unix-start-time</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Start time of node in Unix time</div></li>
					
					<li><div class="ioobjectWrap"><span>p2p-connectivity</span> - <span>Object</span>:</li>
					
					<ul class="infoObjects2">
					
						<li><div class="ioobjectWrap"><span>total-known-peers</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Number of known peers</div></li>
						
						<li><div class="ioobjectWrap"><span>connected</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Number of connected peers</div></li>
						
						<li><div class="ioobjectWrap"><span>not-connected</span> - <span>Number</span>:</div>
						<div class="iodefWrap">Number known peers not connected</div></li>
						
					</ul>
					
					<li><div class="ioobjectWrap"><span>peerid</span> - <span>String</span>:</div>
					<div class="iodefWrap">FIXME</div></li>
					
					<li><div class="ioobjectWrap"><span>role</span> - <span>String</span>:</div>
					<div class="iodefWrap">Node type (Validator or ExplorerNode)</div></li>
					
					<li><div class="ioobjectWrap"><span>shard-id</span> - <span>Number</span>:</div>
					<div class="iodefWrap">Shard that the node is on</div></li>
					
					<li><div class="ioobjectWrap"><span>sync-peers</span> - <span>FIXME</span>:</div>
					<div class="iodefWrap">FIXME</div></li>					
					
					<li><div class="ioobjectWrap"><span>version</span> - <span>String</span>:</div>
					<div class="iodefWrap">Harmony binary version</div></li>

				</ul>
			
			</div>
		</div>
	</div>

<?php
/**
* ends the rpc call check
*/
}

require_once('inc/output.php');
?>


