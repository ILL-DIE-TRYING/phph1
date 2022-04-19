<?php
/**
* index_top.php is where the menu and also where the settings menu reside
* It is included in index.php of the API Explorer
*/
?>
<!-- Top Menu and Logo Bar -->
<div id="hiddenSticky">
	<div id="topbar">
		<div><h1 class="topphrase">PHPH1</h1><p class="tagline">A Harmony ONE Node API PHP Class</p></div>
	</div>
	<div id="navbar">
		<ul class="dropdownUL" >
			<li class="dropdownLI"><a href="/" title="Return To Homepage">Home</a></li>
			<li class="mdropdown">
				<a class="menudropbtn" href="javascript:void(0)" title="Main Menu"><img src="img/cheeseburger.svg" style="height:12px;margin:2px 0px 0px 0px;padding:0px;"/></a>
				<div class="mdropdown-content">
					<div id="LoadMenuDropdown" class="mdropdown-list">
						<a href="/" title="Return To Homepage">Home</a>
						<a href="#" id="settingsBtn" title="Open Settings Dialog">Settings</a>
						<a href="/doc" id="docBtn" title="View PHPH1 Class Documentation" target="_blank">Class Docs</a>
						<a href="https://talk.harmony.one/t/php-class-api-requests-for-scripting-languages-and-harmony-node-api-explorer/11306" id="docBtn" title="Grant Information" target="_blank">Grant Info</a>
						<a href="https://github.com/ILL-DIE-TRYING/phph1" id="docBtn" title="Github Repository" target="_blank">Github Repo</a>
						<a href="https://github.com/ILL-DIE-TRYING/phph1/issues" id="docBtn" title="Report Bug" target="_blank">Report Bug</a>
					</div>
				</div>
			</li>
			<!-- <li class="dropdownLI"><a href="/" title="Return To Homepage">Home</a></li> -->
			<li class="dropdown">
				<a class="dropbtn" href="javascript:void(0)" title="Show Methods Menu">Methods</a>
				<div class="dropdown-content">
					<div class="dropdown-header">
						<input id="LoadMethodInput" type="text" placeholder="Search.." class="searchbox" onkeyup="filterMethodInput()">
					</div>
					<div id="LoadMethodDropdown" class="dropdown-list">
						<?php
						// These methods are loaded from config.php
						// It is simply the methods array sorted alphabetically so we don't have to worry about that in the array itself
						foreach($sorted_Methods as $amethod){ echo '<a href="/?method='.$amethod.'" title="'.$amethod.'">'.$amethod."</a>\n";} 
						?>
					</div>
				</div>
			</li>
		</ul>
		<div class="settingsbar" >Using <?=$_SESSION['network']?> shard <?=$_SESSION['shard']?></div>
	</div>
</div>	
	
<!-- Settings dialog box -->
<div id="settingsModal" class="settingsModal">
	<!-- SETTINGS DIALOG BOX content -->
	<div class="modal-content">
		<div class="modal-header">
			<span class="close">&times;</span><h2>Explorer Settings</h2>
		</div>
		<div class="container">
			<form action="/<?php #if($phph1->get_currentmethod()){ echo "?method=".$phph1->get_currentmethod(); } ?>" method="post">
				<div class="row">
					<div class="col-25">
						<label for="network">Network</label>
					</div>
					<div class="col-75">
						<select id="network" name="network">
							<?php
							// Generate dropdown options list for network selection
							// $phph1_apiaddresses is set in inc/config.php
							foreach($phph1_apiaddresses as $key => $aNet){
								echo '<option value="'.$key.'"';
								// Select the option that is currently being used
								if(isset($_SESSION['network']) && $_SESSION['network'] == $key){ 
									echo " selected='selected' ";
									// This will grab an array of available shards for the selected network
									// and will be used to populate the shard selection in the form
									$shard_data = $phph1_apiaddresses[$_SESSION['network']];
								}elseif(!isset($_SESSION['network']) && $key == $default_network){
									echo " selected='selected' ";
									$shard_data = $phph1_apiaddresses[$default_network];
								}
								echo '>'.$key."</option>\n";
							}
							unset($key);
							unset($aNet);
							?>
							
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-25">
						<label for="shard">Shard</label>
					</div>
					<div class="col-75">
						<select id="shard" name="shard">
							<?php
							// Generate dropdown options list for shard selection
							// $shard_data is set above when the network options are being built
							foreach($shard_data as $key => $aShard){
								echo '<option value="'.$key.'"';
								// Select the option that is currently being used
								if(isset($_SESSION['shard']) && $_SESSION['shard'] == $key){ 
									echo " selected='selected' ";
								}elseif(!isset($_SESSION['shard']) && $key == $default_network){
									echo " selected='selected' ";
								}
								echo '>'.$key."</option>\n";
							}
							unset($key);
							?>
						</select>
					</div>
				</div>
				<div class="row" style="padding-top:20px;">
					<input type="hidden" name="dosettings" value="1" />
					<input type="submit" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>