<?php
if($phph1->get_debugstatus()){echo "<p class='hmyv2_debug_notify'><strong>### END DEBUGGING INFORMATION ###</strong></p>";}

/** Show our errors if we have invalid input */
if(($phph1->chk_dorequest() && !$phph1->get_validinput()) OR $phph1->get_errors()){
	/** If this is an rpc call, return the errors in json format **/
	if($phph1->get_rpcstatus()){
		if($phph1->get_errors()){
			$errnum = 1;
			$jsonout = '{"jsonrpc":"2.0","id":1,"errors":{"data":[';
			$errcount = count($phph1->get_errors());
			//echo "<script>console.log(".$errcount.");</script>";
			foreach($phph1->get_errors() as $anerror){
				if($errcount > 1){
					$jsonout .= '"'.$anerror.'",';
				}else{
					$jsonout .= '"'.$anerror.'"';
				}
				$errcount--;
			}
			$jsonout .= ']}}';
			echo $jsonout;
		}else{
			echo '{"jsonrpc":"2.0","id":1,"errors":{"data",["An unknown Error has occurred"]}}';
		}
	
	}else{
		echo '<div class="error_div">';
		echo '<p class="hmyv2_errors">Error:';
		if($phph1->get_errors()){
			$errnum = 1;
			foreach($phph1->get_errors() as $anerror){
				if($errnum == 1){
					echo ' <span class="hmyv2_error">'.$anerror.'</span>';
					$errnum=0;
				}else{
					echo '<span class="hmyv2_error">, '.$anerror.'</span>';
				}
			}
		}else{
			echo '<span class="hmyv2_error">An unknown error has occurred</span>';
		}
		echo '</p></div>';
	}
}
?>