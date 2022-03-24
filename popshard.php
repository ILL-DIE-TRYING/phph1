<?php
/**
* popshard.php is used to dynamically load the shard dropdown in the settings form when the network is changed
*/

// We need config.php in order to use $phph1_apiaddresses to populate the shard dropdown
require_once('config.php');

// Populate the shard dropdown
if(isset($_GET['net']) && isset($phph1_apiaddresses[$_GET['net']])){
	foreach($phph1_apiaddresses[$_GET['net']] as $key => $value){
		echo '<option value='.$key;
		if(isset($_SESSION['shard']) && $_SESSION['shard'] == $key){ 
			echo "selected='selected'";
		}elseif($_GET['net'] == $default_network && $key == $default_shard){
			echo "selected='selected'";
		}
		echo '>'.$key.'</option>';
	}
}
?>