<?php
/**
* index_body.php is included in index.php when there is no method request.
* This is the "home page"
*/

require_once('inc/errors.php');

?>

<div class="fp_row">
	<div class="fp_column">
		<div class="fp_content_header"><h3>Welcome To PHPH1</h3></div>
		<div class="fp_content">
		<ul>
			<li><h4>What is PHPH1?</h4></li>
			<li class="nobullet">
				<ul>
					<li><p>A learning tool for developers on the Harmony V2 Node API. It allows you to test every API method using real world input and see how a direct JSON request is formatted. It also includes documentation for each method. Just browse to the method you want to learn about using the methods menu at the top right of the page.</p></li>
					<li><p>A PHP wrapper class that allows other languages to make Harmony V2 Node API calls without worrying about input validation or properly formatting the JSON request.</p></li>
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
					<li><p>At the right of the top floating menu is the methods dropdown menu. You can also search the methods in the menu.</p><p><img src="img/methods_menu.png" style="width:80%;max-width:400px;" /></p></li>
				</ul>
			</li>
			
			<li><h4>Method Pages</h4></li>
			<li class="nobullet">
				<ul>
					<li>
					<p>The params/returns section is a clickable dropdown that shows what inputs the method uses as well as explains the method output data that can be expected.</p>
					<p><img src="img/params_closed.png" style="width:80%;max-width:400px;" /></p>
					</li>
					<li>
					<p>The form section is available when a method requires client input. The params/returns dropdown will tell you what each form item requires for input.</p>
					<p><img src="img/method_form.png" style="width:80%;max-width:400px;" /></p>
					</li>
					<li>
					<p>The output section contains three sections of its own.</p>
						<ul>
							<li><p>Harmony Node JSON RPC Request: Displays the actual JSON formatted request sent to the Harmony Node API Server</p></li>
							<li><p>PHPH1 request URL for this method: Displays a link to the phph1_call.php file that would be used by an external scripting language to retrieve results. The URL can be used as a template for making calls for that specific method.</p></li>
							<li><p>JSON return data: Displays the JSON data returned from the test request. Use this to ensure the method returns the data you expect to use in your project.</p></li>
						</ul>
					</li>
				</ul>
			</li>
			
			<li><h4>Using the PHPH1 Call (phph1_call.php)</h4></li>
			<li class="nobullet">
				<ul>
					<li><p>There is an example javascript file in the project root directory named <a href="./jstest.html" target="_blank">jstest.html</a></p></li>
					<li><p>phph1_call.php is designed to accept a formatted GET request by any language that can read JSON formatted data returns. Refer to the Javascript example to see a VERY basic example how remote calls would work.</p></li>
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
		<ol>
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
			
			<li value="2"><h4>Check and adjust the settings to your liking in inc/config.php</h4></li>
			
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
			
			<li value="3"><h4>Browse to where you uploaded PHPH1 and go!</h4></li>
			
		</ol>
		</div>
	</div>
</div>

<!--
<div class="fp_row">
	<div class="fp_column">
		<div class="fp_content_header"><h3>Minimal Package</h3></div>
		<div class="fp_content">
		</div>
	</div>
</div>
-->




