<?php
/**
* index_body.php is included in index.php when there is no method request.
* This is the "home page"
*/

require_once('inc/errors.php');

?>
<div class="fp_row">
	<div class="fp_column">
	<div class="fp_content_header"><h3>Currently Available Methods</h3></div>
		<div class="fp_content">
		<p>Currently Known Harmony Node API Method Count: 63</p>
		<?php
		$method_Count = count($sorted_Methods);
		echo "<p>PHPH1 Available Method Count: ".$method_Count."</p>";
		foreach($sorted_Methods as $aMethod){
			echo "<p><a href='/index.php?method=".$aMethod."' >".$aMethod."</a></p>";
		}
		unset($aMethod);
		?>
		</div>
	</div>
</div>


<div class="fp_row">
	<div class="fp_column">
		<div class="fp_content_header"><h3>Full Package Usage</h3></div>
		<div class="fp_content">
		</div>
	</div>
</div>

<div class="fp_row">
	<div class="fp_column">
		<div class="fp_content_header"><h3>Minimal Package Usage</h3></div>
		<div class="fp_content">
		</div>
	</div>
</div>

<div class="fp_row">
	<div class="fp_column">
		<div class="fp_content_header"><h3>Class Only</h3></div>
		<div class="fp_content">
		</div>
	</div>
</div>




