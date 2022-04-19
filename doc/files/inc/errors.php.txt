<?php
/** Show our errors if we have invalid input */
if(($phph1->chk_dorequest() && !$phph1->get_validinput()) OR $phph1->get_errors()){
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
?>