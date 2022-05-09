<?php
/**
* Method file for hmyv2_getPoolStats() in the phph1.php class file
*/

// There is no input so no validation required
$phph1->set_validinput(1);

// Get the block number dataset
$hmyv2_data = $phph1->hmyv2_getPoolStats();

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
							<p>Gets current pool stats.</p>
							<p>There may be more information in the <a href="./doc/classes/phph1.html#method_hmyv2_getPoolStats">PHPH1 Class Documentation</a>.</p>
						</div>
					</li>
				</ul>
				
				<h3 class="infoHeader">Parameters</h3>
				<ul class="infoObjects" >
				
					<li class="infoObjectNoBul"><h4>No Parameters Required</h4></li>
					
				</ul>
				
				<h3 class="infoHeader">Returns</h3>
				<ul class="infoObjects">
				
					<li class="infoObjectNoBul"><span>Object</span>:</li>
					
					<li><div class="ioobjectWrap"><span >executable-count</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Executable count</div></li>
					
					<li><div class="ioobjectWrap"><span >non-executable-count</span> - <span>String</span>:</div> 
					<div class="iodefWrap">Non-executable count</div></li>
					
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

