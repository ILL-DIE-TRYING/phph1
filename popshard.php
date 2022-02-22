<?php

require_once('config.php');

//print_r($phph1_apiaddresses);
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