<?php
/**
* The API Explorer footer file included on every page
*/
?>
	<div class="footer_container">
		<div class="fp_footer">
			<h4 style="margin:0px;color:white;">PHPH1 :: A Harmony ONE Node API PHP Class</h4>
			<p>Copyright &copy; 2022 by Jason L Kolpin
			<br />Released under the <a href="https://github.com/ILL-DIE-TRYING/phph1/blob/main/LICENSE" target="_blank">GNU General Public License v3.0</a>
			<br />Funded by a <a href="https://talk.harmony.one/t/php-class-api-requests-for-scripting-languages-and-harmony-node-api-explorer" target="_blank">Bounty Grant provided by the Harmony ONE Team</a>
			</p>
		  <p><a href="https://github.com/ILL-DIE-TRYING/phph1" target="_blank">GitHub Project Page</a> :: <a href="https://github.com/ILL-DIE-TRYING/phph1/issues" target="_blank">Report A Bug</a></p>
		  <p><?php
			$time = microtime();
			$time = explode(' ', $time);
			$time = $time[1] + $time[0];
			$phph1_finish = $time;
			$phph1_total_time = round(($phph1_finish - $phph1_start), 4);
			unset($time);
			echo 'Page generated in '.$phph1_total_time.' seconds.';
		  ?></p>
		</div>
	</div>