<?php
/**
* Method file for hmyv2_getCurrentBadBlocks() in the phph1.php class file
*/

// There is no input so no validation required
$phph1->set_validinput(1);

// Get the block number dataset
$hmyv2_data = $phph1->hmyv2_getCurrentBadBlocks();

require_once('inc/errors.php');

/**
* Check if this is a RPC call
* If not show the html output of the method explorer
*/
if($phph1->get_rpcstatus() == 0){
?>
	<div class="info_container" >
		<div class="infoRow">
			<button type="button" class="collapsibleInfo"><?=$phph1->get_currentmethod()?> :: Params/Returns</button>
			<div id="infoContent" class="infoContent">
			
				<h3 class="infoHeader">Description</h3>
				<ul class="infoObjects" >
					<li class="infoObjectNoBul">
						<div>
							<p>Gets a list of bad blocks in node memory.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getCurrentBadBlocks">PHPH1 Class Documentation</a>.</p>
							<p><strong>NOTE!</strong> This method has known issues with RPC not returning correctly</p>
						</div>
					</li>
				</ul>
			
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
					<li class="infoObjectNoBul"><h4>No Parameters Required</h4></li>
				</ul>
				
				<h3 class="infoHeader">Returns</h3>
				<ul class="infoObjects">
					<li class="infoObjectNoBul"><div class="ioobjectWrap"><span>Array</span>:</div>
					<div class="iodefWrap">List of bad blocks in node memory</div>
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


