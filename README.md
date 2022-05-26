# PHPH1 :: A PHP Wrapper Class and explorer interface to query the Harmony ONE Node API V2

NOTE: I'm not a PHP developer by trade, but I have worked in IT for over 20 years. I was a full stack developer that wrote PHP database applications at a nationally known non-profit organization for a living from 2008 to 2012 with 7 years of solo work before that so my code is currently OLD SCHOOL but very stable and effective. As a matter of fact, much of my code from them days is still being used by the company over 10 years later, which I feel is a testament to my coding practices. I'm trying to catch up as much as possible.

# WHAT IS PHPH1?

PHPH1 is two tools in one:

  1. A PHP wrapper class that bridges the Harmony ONE Node API to PHP for use by other languages. A web developer will be able to make requests to the class using scripting languages such as Javascript without having to worry what TYPE of data it is, or how the JSON request to the API server is formatted. The PHPH1 class will return a JSON formatted object (and maybe a few other ways in the future) for the scripting to read and handle. This software is NOT limited to the Harmony API Nodes anymore. You are able to add your own node url, including removing the standard harmony nodes, and set the default url and shard. The class also allows the dev to limit remote client access to the methods by IP address as well as block rowdy clients from using the interface.
  
  2. A learning tool for developers just getting started with the Harmony v2 Node API. It includes documentation for every method as well as allows you to run test data to see how each method reacts and how the JSON requests are formed.

# ROADMAP

- [x] Create a PHP class with every API call in it.
  1. 63 methods completed
  2. All methods can be seen in the [PHPH1 Explorer Interface](https://phph1.saddlerockit.com).

- [x] Optimize and modernize the class code reassess the PHP code logic and revamp if necessary
  1. 100% complete as of 2022-5-25. She runs good.

- [x] Create a MOBILE FRIENDLY Harmony API explorer into the package to assist developers in learning how the API works
  1. 100% complete as of 2022-5-25
  2. Try out the [PHPH1 Explorer](https://phph1.saddlerockit.com) on your phone

- [x] Create documentation on the “homepage” of the explorer package including configuration and simple Javascript/jQuery code examples. This also includes how to extend the network and shards in order to do things like run a local node and get data from it.
     1. 100% complete as of 2022-5-9
     2. View in the [PHPH1 explorer](https://phph1.saddlerockit.com)

- [ ] Create documentation for the class and explorer using PHP DOC. I have to write in all the doc blocks in the code so it generates everything nicely. Get it generated and then probably a few tweaks to the interface.
     1. ~99% complete (needs one last good pass)
     2. Remember there are two types of documentation in this project
     - 1. Check out the [PHPH1 Explorer PHP Class Docs](https://phph1.saddlerockit.com/doc/classes/phph1.html)
     - 2. Every method page in the [PHPH1 explorer](https://phph1.saddlerockit.com) has built in documentation for the Harmony API Methods

- [ ] Create a package where a developer could drop the package into a directory and safely use it for retrieving data using other scripting languages with minimal input. I planned to provide 3 different download packages (only 2 were necessary): Full with full API explorer and minimal with just the class and remote call script. As long as I have my stuff properly set up on github, this should be pretty easy.
     1. ~95% complete as of 2022-4-25
 
- [x] Report API methods that do not react according to the API documentation (this happens as I work throughout entire project as basically an include. As far as time to report and deal with it depends on how fast the line of communication is).
     1. I have reported a few times. If Harmony wants their postman documentation to be proper and accurate, just use the [PHPH1 explorer](https://phph1.saddlerockit.com) interface for all the details.

- [ ] Maintain the class and project if/when the API changes/expands (depends on how often the API changes, just part of maintenance).
     1. If we have a method explosion like this last time, this could turn into a lot of work to stay up to date with the API. I was looking and I believe the original EVM has like 62 or so methods. If there are plans to expand, please let me know and I will include it in the bounty if that is okay.

- [ ] Maintain any bug reports etc on Github
     1. ~2 days time over a year then I’ll just do it

# CURRENT STATE (2022-5-26)

PHPH1 v1.0.0.1 is READY!

UPDATE 2022-5-25: Everything is validated as best as I can test it. Drive it like you stole it!

# REQUIREMENTS

You must have PHP_CURL module enabled.

RUNNING THIS ON A NON-SSL HOST IS A SECURITY RISK!!!

You can use the official Harmony Nodes(already set up in the package) or if you have a local node (not necessaily on the same server (more later), it can be used as well.

# USAGE

- ### Method Menu
   - At the right of the top floating menu is the methods dropdown menu. You can also search the methods in the menu.
   - ![methods_menu_github](https://user-images.githubusercontent.com/92170977/166109549-1dd79399-8f43-40c1-adf5-1d711243b8ef.png)

- ### Method Pages
   - The params/returns section is a clickable dropdown that shows what inputs the method uses as well as explains the method output data that can be expected.
   - ![params_closed_github](https://user-images.githubusercontent.com/92170977/166109613-f7d1e19f-93b1-4002-ae5e-c5092fbddc66.png)

- ### Form Section
   - available when a method requires client input.
   - The params/returns dropdown will tell you what each form item requires for input.
   - ![method_form_github](https://user-images.githubusercontent.com/92170977/166109887-d71f6356-d40f-47d6-864a-11e9d9e83b27.png)

- ### Output Section
   - Contains three sections of its own
      - **Harmony Node JSON RPC Request**
         - Displays the actual JSON formatted request sent to the Harmony Node API Server
      - **Harmony Node Javascript Request Example**
         - Displays some BASIC but working Javascript code example to make the request directly to a Harmony node
      - **PHPH1 GET request URL for this method**
         - Displays a link to the phph1_call.php file that would be used by an external scripting language to retrieve results. The URL can be used as a template for making calls for that specific method using GET.
      - **PHPH1 Javascript Request Example**
         - Displays some BASIC but working Javascript code example to make the request to the PHPH1 RPC script using POST.
      - **JSON return data**
         - Displays the JSON data returned from the test request. Use this to ensure the method returns the data you expect to use in your project.

- ### Using the PHPH1 Call (phph1_call.php)
   - There is an example javascript file in the project root directory named jstest.html

   - phph1_call.php is designed to accept a formatted GET or POST request by any language that can read JSON formatted data returns. Refer to the Javascript examples to see a VERY basic example how remote calls would work.

# INSTALLING

### 1. Download the package and extract it to a directory
- You can get the package at the Github project releases page.
- Extract the package and upload all files to your web host. The package contents can sit in your document root or any sub directory.
- You will have to handle the archive a little differently depending on whether you downloaded the .zip or the .tar.gz file.
- The .zip file, if extracted with no directory options will extract all the files to the current directory which can be messy. If using the zip file on a Linux/Unix machine, be sure to extract it into a directory where no other files exist or use the unzip -d option.
- The tar.gz package will extract within a directory that matches the release name.
- **It is highly suggested whether using the zip or tar.gz, you extract the package outside of your project and then copy it to where you want it. This will ensure nothing gets accidentally overwritten.**

### 2. Check and adjust the settings to your liking in inc/config.php

- #### $phph1_debug
   Variable used to enable (set to 1) or disable (set to 0) API Explorer PHP debugging. Enabling this exposes many things to the client, I highly suggest not using it in a production environment unless it is a last resort. It also puts big ugly warnng header at the top of the pages so you are aware debugging is enabled.

- #### $phph1_blockedaddr
   This array is used to block IP addresses if necessary. Just add an IP address to the array like the example and the code will use the $_SERVER['REMOTE_ADDR'] to see if users are blocked. If the $phph1_allowedaddr array is not empty, this array gets ignored

- #### $phph1_allowedaddr
   This array is used to only allow specific IP Addresses. Just add an IP address to the array like the example and the code will use the $_SERVER['REMOTE_ADDR'] to make sure the request is allowed by the client. If this array has any values in it, the $phph1_blockedaddr is ingored due to redundancy. REMINDER! Usig this blocks all hosts except the hosts listed in this array.

- #### $phph1_allowbigdata
   Some requests have a page index (page number) option. Included insome of those options is the ability to use -1 as the index page. When using -1 the data set returned could possibly be huge causing a massive load on the server. By default using the -1 option is disabled to prevent this from happening. You can enable -1 page requests here by setting $phph1_allowbigdata to 1

- #### $phph1_apiaddresses
   This is a multi-dimensional array that holds the node and shard information. By default this array contains the official Harmony nodes but you can comment them out and add your own personal nodes as shown where the array is set. if you do add your own node address, be sure to also set $default_network and $default_shard as well

- #### $default_network
   Sets the default network (also the network used by the rpc script). It MUST use a network listed in the $phph1_apiaddresses array. For example by default it is set to use "mainnet".

- #### $default_shard
   Sets the default shard (also the shard used by the rpc script). It MUST use a shard listed in the $phph1_apiaddresses array. For example by default it is set to use "0".

- #### $default_pagesize
   The default page size for methods that return multiple pages of data

- #### $max_pagesize
   This is the maximum number of items per page when a method returns multiple pages of data. This prevents a client from reuesting large datasets in a single call which will put a heavy load on the web server.

- #### $phph1_methods
   An array of the available methods. This is used to prevent a client from requesting a method that doesn'teist. You can use a PHP comment out individual lines to disable a method.

- #### $sorted_Methods
   This is just the $phph1_methods array that has been sorted alphabetically so the front end dropdown menu makes some sense.

### 3. Browse to where you uploaded PHPH1 and go!

# Limiting Client Access

Although this is an effective way to manage access to your PHPH1, it is suggested to use it as a second layer of defense with the first layer being limiting access to the directory containing PHPH1 using .htaccess (Apache). There is a good tutorial over at htaccessbook.com (No Affiliation, just a place I found)

### There are two different approaches available
- You can allow everyone and block specific IP addresses using the $phph1_blockedaddr array in inc/config.php
- You can block everyone and only allow specific IP addresses using the $phph1_allowedaddr array in inc/config.php.

### Option 1: Allow everyone and block specific IP addresses
- This option is automatically enabled once the first IP address is added to the $phph1_blockedaddr array
- Leaving the $phph1_blockedaddr array empty disables this option
- **NOTE:** This option is disabled if the $phph1_allowedaddr array contains any entries.

### Option 2: Block everyone and only allow specific IP addresses
- This option is automatically enabled once the first IP address is added to the $phph1_allowedaddr array
- Leaving the $phph1_allowedaddr array empty disables this option
- **NOTE:** Adding and IP address to this option disables the $phph1_blockedaddr array if it contains any entries. there is no reason o block if everyone but the allowed IP address[es] is blocked by default


