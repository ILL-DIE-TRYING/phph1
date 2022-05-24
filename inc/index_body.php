<?php
/**
* index_body.php is included in index.php when there is no method request.
* This is the "home page"
*/

require_once('inc/errors.php');

?>
<!--
<div class="fp_row">
	<div class="fp_column">
	<div class="fp_content_header"><h3>Currently Available Methods</h3></div>
		<div class="fp_content">
		<p>Currently Known Harmony Node API Method Count: 64</p>
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
-->
<div class="fp_row">
	<div class="fp_column">
		<div class="fp_content_header"><h3>Welcome To PHPH1</h3></div>
		<div class="fp_content">
		<ul>
			<li class="nobullet" style="text-align:center;"><img src="img/PHPH1_LOGO_2022-2.svg" style="width:90%;max-width:400px;" alt="PHPH1 elephant logo" /></li>
			<li><h4>What is PHPH1?</h4></li>
			<li class="nobullet">
				<ul>
					<li><p>A learning tool for developers on the Harmony v2 Node API. It allows you to test every API method using real world input and see how a direct JSON request is formatted as well as how the JSON return data is formatted for each request. It also includes built in documentation for each method. Just browse to the method you want to learn about using the methods menu at the top right of the page.</p></li>
					<li><p>A PHP wrapper class for the Harmony v2 Node API that allows other languages to make Harmony V2 Node API calls without worrying about input validation or properly formatting the JSON request.</p></li>
					<li><p>A PHP wrapper class for the Harmony v2 Node API that can be used in your own PHP + whatever driven project.</p></li>
				</ul>
			</li>
			
			<li><h4>What is required to run PHPH1</h4></li>
			<li class="nobullet">
				<ul>
					<li><p>A web host with PHP installed as well as the PHP_CURL extension installed and enabled</p></li>
					<li><p>An SSL (https://) host. <strong><em>WARNING! RUNNING PHPH1 WITHOUT SSL IS A HUGE SECURITY RISK, DO NOT DO IT!</em></strong></p></li>
				</ul>
			</li>
			
			<li><h4>How do I integrate this into my project?</h4></li>
			<li class="nobullet">
				<ul>
					<li><p>First suggestion is to start by using the full class package with the API explorer interface (what you are looking at now) included. It will guide you in sending requests to the class wrapper interface.</p></li>
					<li><p>The full package is designed to be called by any language that can pull data from a web request. Checkout the Javascript example below.</p></li>
				</ul>
			</li>
			
			<li><h4>Where do I get the package?</h4></li>
			<li class="nobullet">
				<ul>
					<li><p>You can get the package at <a href="https://github.com/ILL-DIE-TRYING/phph1/releases" target="_blank">the Github project releases page</a>.</p></li>
				</ul>
			</li>
			
			<li><h4>Where do I report issues?</h4></li>
			<li class="nobullet">
				<ul>
					<li><p>You can report issues at <a href="https://github.com/ILL-DIE-TRYING/phph1/issues" target="_blank">the Github project issues page</a>.</p></li>
				</ul>
			</li>
		</ul>
		</div>
	</div>
</div>

<div class="fp_row">
	<div class="fp_column">
		<div class="fp_content_header"><h3>Using this interface</h3></div>
		<div class="fp_content">
		<ul>
			<li><h4>Method Menu</h4></li>
			<li class="nobullet">
				<ul>
					<li><p>At the right of the top floating menu is the methods dropdown menu. You can also search the methods in the menu.</p><p><img src="img/methods_menu.png" style="width:80%;max-width:400px;" alt="Methods Menu" /></p></li>
				</ul>
			</li>
			
			<li><h4>Method Pages</h4></li>
			<li class="nobullet">
				<ul>
					<li>
					<p>The params/returns section is a clickable dropdown that shows what inputs the method uses as well as explains the method output data that can be expected.</p>
					<p><img src="img/params_closed.png" style="width:80%;max-width:400px;" alt="Params Click Bar" /></p>
					</li>
					<li>
					<p>The form section is available when a method requires client input. The params/returns dropdown will tell you what each form item requires for input.</p>
					<p><img src="img/method_form.png" style="width:80%;max-width:400px;" alt="Method form" /></p>
					</li>
					<li>
					<p>The output section contains five sections of its own. Each section is clickable to view the output.</p>
						<ul>
							<li><p>Harmony Node JSON RPC Request: Displays the actual JSON formatted request sent to the Harmony Node API Server</p></li>
							<li><p>A <em>BASIC</em> javascript example of a Harmony Node JSON RPC Request using POST</p></li>
							<li><p>PHPH1 GET request URL for this method: Displays a link to the phph1_call.php file that would be used by an external scripting language to retrieve results. The URL can be used as a template for making calls for that specific method.</p></li>
							<li><p>A <em>BASIC</em> javascript example of a PHPH1 POST request</p></li>
							<li><p>JSON return data: Displays the JSON data returned from the test request. Use this to ensure the method returns the data you expect to use in your project.</p></li>
						</ul>
					</li>
				</ul>
			</li>
			
			<li><h4>Setting Network and Shard</h4></li>
			<li class="nobullet">
				<ul>
					<li>
					<p>The hamburger menu has a "Settings" link to set the network and shard the client wants to use. The available networks and shards can be set in inc/config.php</p>
					<p><img src="img/settings_menu.png" style="width:80%;max-width:400px;" alt="Settings Menu" /></p>
					</li>
					<li>
					<p>The settings form has a network and shard dropdown. Select the network first and the available shards for that network will appear in the shard dropdown.</p>
					<p><img src="img/settings_form.png" style="width:80%;max-width:400px;" alt="Settings Form" /></p>
					</li>
					<li>
					<p>You can see what network and shard is being used on the right side of the menu bar.</p>
					<p><img src="img/settings_status.png" style="width:80%;max-width:400px;" alt="Settings Status" /></p>
					</li>

				</ul>
			</li>
			
			<li><h4>Using the PHPH1 Call (phph1_call.php)</h4></li>
			<li class="nobullet">
				<ul>
					<li><p>phph1_call.php is designed to accept formatted GET and POST requests by any language that can read JSON formatted data returns.</p></li>
					<li><p>The explorer shows you an extremely basic sample javascript code for a POST request.</p></li>
					<li><p>To see a little more robust example refer to <a href='jstest.html' target='_blank'>jstest.html</a>.</p></li>
				</ul>
			</li>
		</ul>
		</div>
	</div>
</div>

<div class="fp_row">
	<div class="fp_column">
		<div class="fp_content_header"><h3>Full Package Setup</h3></div>
		<div class="fp_content">
		<ul>
			<li><h4>Download the package and extract it to a directory</h4></li>
			
			<li class="nobullet">
				<ul>
					<li>You can get the package at <a href="https://github.com/ILL-DIE-TRYING/phph1/releases" target="_blank">the Github project releases page</a>.</li>
					<li><p>Extract the package and upload all files to your web host. The package contents can sit in your document root or any sub directory.</p></li>
					<li><p>You will have to handle the archive a little differently depending on whether you downloaded the .zip or the .tar.gz file.</p></li>
					<li><p>The .zip file, if extracted with no directory options will extract all the files to the current directory which can be messy. If using the zip file on a Linux/Unix machine, be sure to extract it into a directory where no other files exist or use the unzip -d option.</p></li>
					<li><p>The tar.gz package will extract within a directory that matches the release name.</p></li>
					<li><p><strong><em>It is highly suggested whether using the zip or tar.gz, you extract the package outside of your project and then copy it to where you want it. This will ensure nothing gets accidentally overwritten.</em></strong></p></li>
				</ul>
			</li>
			
			<li><h4>Check and adjust the settings to your liking in inc/config.php</h4></li>
			
			<li class="nobullet">
				<ul>
					<li><p><strong>$phph1_debug</strong></p><p>Variable used to enable (set to 1) or disable (set to 0) API Explorer PHP debugging. Enabling this exposes many things to the client, I highly suggest not using it in a production environment unless it is a last resort. It also puts  big ugly warnng header at the top of the pages so you are aware debugging is enabled.</p></li>

					<li><p><strong>$phph1_blockedaddr</strong></p><p>This array is used to block IP addresses if necessary. Just add an IP address to the array like the example and the code will use the $_SERVER['REMOTE_ADDR'] to see if users are blocked. If the $phph1_allowedaddr array is not empty, this array gets ignored</p></li>

					<li><p><strong>$phph1_allowedaddr</strong></p><p>This array is used to only allow specific IP Addresses. Just add an IP address to the array like the example and the code will use the $_SERVER['REMOTE_ADDR'] to make sure the request is allowed by the client. If this array has any values in it, the $phph1_blockedaddr is ingored due to redundancy. REMINDER! Usig this blocks all hosts except the hosts listed in this array.</p></li>

					<li><p><strong>$phph1_allowbigdata</strong></p><p>Some requests have a page index (page number) option. Included insome of those options is the ability to use -1 as the index page. When using -1 the data set returned could possibly be huge causing a massive load on the server. By default using the -1 option is disabled to prevent this from happening. You can enable -1 page requests here by setting $phph1_allowbigdata to 1</p></li>

					<li><p><strong>$phph1_apiaddresses</strong></p><p>This is a multi-dimensional array that holds the node and shard information. By default this array contains the official Harmony nodes but you can comment them out and add your own personal nodes as shown where the array is set. if you do add your own node address, be sure to also set $default_network and $default_shard as well</p></li>

					<li><p><strong>$default_network</strong></p><p>Sets the default network (also the network used by the rpc script). It MUST use a network listed in the $phph1_apiaddresses array. For example by default it is set to use "mainnet".</p></li>

					<li><p><strong>$default_shard</strong></p><p>Sets the default shard (also the shard used by the rpc script). It MUST use a shard listed in the $phph1_apiaddresses array. For example by default it is set to use "0".</p></li>

					<li><p><strong>$default_pagesize</strong></p><p>The default page size for methods that return multiple pages of data</p></li>

					<li><p><strong>$max_pagesize</strong></p><p>This is the maximum number of items per page when a method returns multiple pages of data. This prevents a client from reuesting large datasets in a single call which will put a heavy load on the web server.</p></li>

					<li><p><strong>$phph1_methods</strong></p><p>An array of the available methods. This is used to prevent a client from requesting a method that doesn'teist. You can use a PHP comment out individual lines to disable a method.</p></li>

					<li><p><strong>$sorted_Methods</strong></p><p>This is just the $phph1_methods array that has been sorted alphabetically so the front end dropdown menu makes some sense.</p></li>
				</ul>
			</li>
			
			<li><h4>Browse to where you uploaded PHPH1 and go!</h4></li>
			
		</ul>
		</div>
	</div>
</div>

<div class="fp_row">
	<div class="fp_column">
		<div class="fp_content_header"><h3>Limiting Client Requests</h3></div>
		<div class="fp_content">
			<ul>
				
				<li><h4>There are two different approaches available</h4></li>
				<li class="nobullet">
					<ul>
						<li><p>You can allow everyone and block specific IP addresses using the $phph1_blockedaddr array in inc/config.php</p></li>
						<li><p>You can block everyone and only allow specific IP addresses using the $phph1_allowedaddr array in inc/config.php.</p></li>
					</ul>
				</li>
				
				<li><h4>Option 1: Allow everyone and block specific IP addresses</h4></li>
				<li class="nobullet">
					<ul>
						<li><p>This option is automatically enabled once the first IP address is added to the $phph1_blockedaddr array</p></li>
						<li><p>Leaving the $phph1_blockedaddr array empty disables this option</p></li>
						<li><p><strong>NOTE:</strong> This option is disabled if the $phph1_allowedaddr array contains any entries.</p></li>
					</ul>
				</li>
				
				<li><h4>Option 2: Block everyone and only allow specific IP addresses</h4></li>
				<li class="nobullet">
					<ul>
						<li><p>This option is automatically enabled once the first IP address is added to the $phph1_allowedaddr array</p></li>
						<li><p>Leaving the $phph1_allowedaddr array empty disables this option</p></li>
						<li><p><strong>NOTE:</strong> Adding and IP address to this option disables the $phph1_blockedaddr array if it contains any entries. there is no reason to block if everyone but the allowed IP address[es] is blocked by default</p></li>
					</ul>
				</li>
					
			</ul>
		</div>
	</div>
</div>

<div class="fp_row">
	<div class="fp_column">
		<div class="fp_content_header"><h3>Class Only</h3></div>
		<div class="fp_content">
			<ul>
			<li><h4>Download the package and extract it to a directory</h4></li>
			
			<li class="nobullet">
				<ul>
					<li>You can get the package at <a href="https://github.com/ILL-DIE-TRYING/phph1/releases" target="_blank">the Github project releases page</a>.</li>
					<li><p>Extract the package and upload all files to your web host. The package contents can sit in your document root or any sub directory.</p></li>
					<li><p>You will have to handle the archive a little differently depending on whether you downloaded the .zip or the .tar.gz file.</p></li>
					<li><p>The .zip file, if extracted with no directory options will extract all the files to the current directory which can be messy. If using the zip file on a Linux/Unix machine, be sure to extract it into a directory where no other files exist or use the unzip -d option.</p></li>
					<li><p>The tar.gz package will extract within a directory that matches the release name.</p></li>
					<li><p><strong><em>It is highly suggested whether using the zip or tar.gz, you extract the package outside of your project and then copy it to where you want it. This will ensure nothing gets accidentally overwritten.</em></strong></p></li>
				</ul>
			</li>
			
			<li><h4>Check and adjust the settings to your liking in inc/config.php</h4></li>
			
			<li class="nobullet">
				<ul>
					<li><p><strong>$phph1_debug</strong></p><p>Variable used to enable (set to 1) or disable (set to 0) API Explorer PHP debugging. Enabling this exposes many things to the client, I highly suggest not using it in a production environment unless it is a last resort. It also puts  big ugly warnng header at the top of the pages so you are aware debugging is enabled.</p></li>

					<li><p><strong>$phph1_blockedaddr</strong></p><p>This array is used to block IP addresses if necessary. Just add an IP address to the array like the example and the code will use the $_SERVER['REMOTE_ADDR'] to see if users are blocked. If the $phph1_allowedaddr array is not empty, this array gets ignored</p></li>

					<li><p><strong>$phph1_allowedaddr</strong></p><p>This array is used to only allow specific IP Addresses. Just add an IP address to the array like the example and the code will use the $_SERVER['REMOTE_ADDR'] to make sure the request is allowed by the client. If this array has any values in it, the $phph1_blockedaddr is ingored due to redundancy. REMINDER! Usig this blocks all hosts except the hosts listed in this array.</p></li>

					<li><p><strong>$phph1_allowbigdata</strong></p><p>This option is disabled at the moment and should be left set to 0;</p></li>

					<li><p><strong>$phph1_apiaddresses</strong></p><p>This is a multi-dimensional array that holds the node and shard information. By default this array contains the official Harmony nodes but you can comment them out and add your own personal nodes as shown where the array is set. if you do add your own node address, be sure to also set $default_network and $default_shard as well</p></li>

					<li><p><strong>$default_network</strong></p><p>Sets the default network (also the network used by the rpc script). It MUST use a network listed in the $phph1_apiaddresses array. For example by default it is set to use "mainnet".</p></li>

					<li><p><strong>$default_shard</strong></p><p>Sets the default shard (also the shard used by the rpc script). It MUST use a shard listed in the $phph1_apiaddresses array. For example by default it is set to use "0".</p></li>

					<li><p><strong>$default_pagesize</strong></p><p>The default page size for methods that return multiple pages of data</p></li>

					<li><p><strong>$max_pagesize</strong></p><p>This is the maximum number of items per page when a method returns multiple pages of data. This prevents a client from reuesting large datasets in a single call which will put a heavy load on the web server.</p></li>

					<li><p><strong>$phph1_methods</strong></p><p>An array of the available methods. This is used to prevent a client from requesting a method that doesn'teist. You can use a PHP comment out individual lines to disable a method.</p></li>

					<li><p><strong>$sorted_Methods</strong></p><p>This is just the $phph1_methods array that has been sorted alphabetically so the front end dropdown menu makes some sense.</p></li>
				</ul>
			</li>
			
			<li><h4>Include the required files in your page (There is an example index.php for reference)</h4></li>
			<li class="nobullet">
				<ul>
					<li>Include <em>inc/config.php</em> first.</li>
					<li>Include <em>inc/phph1.php</em> second.</li>
				</ul>
			</li>

			<li><h4>Create a PHPH1 class handle</h4></li>
			<li class="nobullet">
				<ul>
					<li>$phph1 = new phph1($phph1_apiaddresses,$phph1_methods,$phph1_debug,$max_pagesize,$default_pagesize, $default_network, $default_shard,$phph1_blockedaddr,$phph1_allowedaddr,$phph1_allowbigdata);</li>
				</ul>
			</li>

			<li><h4>Refer to the <a href="doc/classes/phph1.html" target="_blank">documentation</a> for all of the methods and their required inputs.</h4></li>
			<li class="nobullet">
				<ul>
					<li><p>Each method has a validation method that starts with <em>val_</em> and the actual method that starts with <em>hmyv2_</em></p>
					<pre style="text-align:left;"><code class="language-php">
						&lt;php?


					</code></pre></li>
					<li>When running the validation methods, if there are errors they are stored in the class array variable <em>errors</em>, you can retrieve them as an array using $phph1->get_errors()</li>
				</ul>
			</li>
			
			<li><h4>When running the hmyv2_ methods, data is returned in a JSON encoded format.</h4></li>
			<li class="nobullet">
				<ul>
					<li>You can decode the data by passing the PHP object off to javascript. This is the recommended way and performs seemingly well with large data returns.</li>
					<li>You can decode the data using PHP's json_decode() but be warned, converting large data with PHP can put a heavy memory load on the server</li>
				</ul>
			</li>
			
		</ul>
		</div>
	</div>
</div>




