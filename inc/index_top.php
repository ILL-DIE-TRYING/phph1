<div id="hiddenSticky">

	<div id="topbar">
		<div><h1 class="topphrase">PHPH1</h1><p class="tagline">A Harmony ONE Node API PHP Class</p></div>
	</div>
	<div id="navbar">
		<ul class="dropdownUL" >
			<li class="dropdownLI"><a href="/">Home</a></li>
			<li class="dropdownLI"><a href="#" id="settingsBtn">Settings</a></li>
			<li class="dropdown">
				<a class="dropbtn" href="javascript:void(0)">Methods</a>
				<div class="dropdown-content">
					<div class="dropdown-header">
						<input id="LoadMethodInput" type="text" placeholder="Search.." class="searchbox" onkeyup="filterMethodInput()">
					</div>
					<div id="LoadMethodDropdown" class="dropdown-list">
						<?php foreach($sorted_Methods as $amethod){ echo '<a href="/?method='.$amethod.'">'.$amethod.'</a>';}?>
					</div>
				</div>
			</li>
		</ul>
		<div class="settingsbar" >Using <?=$_SESSION['network']?> shard <?=$_SESSION['shard']?></div>
	</div>
</div>	
	
<!-- The SETTINGS DIALOG BOX -->
<div id="settingsModal" class="settingsModal">
	<!-- SETTINGS DIALOG BOX content -->
	<div class="modal-content">
		<div class="modal-header">
			<span class="close">&times;</span><h2>Explorer Settings</h2>
		</div>
		<div class="container">
			<form action="/" method="post">
				<div class="row">
					<div class="col-25">
						<label for="network">Network</label>
					</div>
					<div class="col-75">
						<select id="network" name="network">
							<?php
							foreach($phph1_apiaddresses as $key => $aNet){
								//echo $key.':'.$value;
								echo '<option value="'.$key.'"';
								if(isset($_SESSION['network']) && $_SESSION['network'] == $key){ 
									echo " selected='selected' ";
									$shard_data = $phph1_apiaddresses[$_SESSION['network']];
								}elseif(!isset($_SESSION['network']) && $key == $default_network){
									echo " selected='selected' ";
									$shard_data = $phph1_apiaddresses[$default_network];
								}
								echo '>'.$key.'</option>';
							}
							unset($key);
							unset($aNet);
							?>
							<!--
							<option value="mainnet" selected="<?php if(isset($_SESSION['network']) && $_SESSION['network'] == 'mainnet'){ echo "selected='selected'";} ?>" >Mainnet</option>
							<option value="testnet" <?php if(isset($_SESSION['network']) && $_SESSION['network'] == 'testnet'){ echo "selected='selected'";} ?>>Testnet</option>
							-->
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
							foreach($shard_data as $key => $aShard){
								//echo $key.':'.$value;
								echo '<option value="'.$key.'"';
								if(isset($_SESSION['shard']) && $_SESSION['shard'] == $key){ 
									echo " selected='selected' ";
								}elseif(!isset($_SESSION['shard']) && $key == $default_network){
									echo " selected='selected' ";
								}
								echo '>'.$key.'</option>';
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