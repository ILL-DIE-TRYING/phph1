# ROADMAP

  1.Create a PHP class with every API call in it.
    a. I have 61 of 63 methods completed
    b. I am waiting for information from Harmony on the last two

  2. Optimize and modernize the class code reassess the PHP code logic and revamp if necessary
    a. ~98% complete as of 2022-4-6.

  3. Create a MOBILE FRIENDLY Harmony API explorer into the package to assist developers in learning how the API works
    a. The design has already been implemented and just needs to have the new API method forms and API documentation sections created and a few adjustments. It is time consuming. (~98% complete as of 2022-4-6).

  4. Create documentation on the “homepage” of the explorer package including configuration and simple Javascript/jQuery code examples. This also includes how to extend the network and shards in order to do things like run a local node and get data from it. (10% complete as of 2022-4-6)

  5. Create documentation for the class and explorer using PHP DOC. I have to write in all the doc blocks in the code so it generates everything nicely. Get it generated and then probably a few tweaks to the interface. (~90% complete as of 2022-4-6)

  6. Create a package where a developer could drop the package into a directory and safely use it for retrieving data using other scripting languages with minimal input. I plan to provide 3 different download packages: Full with full API explorer, minimal with just the class and remote call script, and class only. As long as I have my stuff properly set up on github, this should be pretty easy. (~20% complete as of 2022-4-6)

  7. Report API methods that do not react according to the API documentation (this happens as I work throughout entire project as basically an include. As far as time to report and deal with it depends on how fast the line of communication is). I have a few noted already. 1 day

  8. Maintain the class and project if/when the API changes/expands (depends on how often the API changes, just part of maintenance).
    a. If we have a method explosion like this last time, this could turn into a lot of work to stay up to date with the API. I was looking and I believe the original EVM has like 62 or so methods. If there are plans to expand, please let me know and I will include it in the bounty if that is okay.

  9. Maintain any bug reports etc on Github
    a. ~2 days time over a year then I’ll just do it

# PHPH1 :: A PHP Class to query the Harmony ONE Node API
NOTE: I'm not a PHP developer. I wrote PHP database applications for a living from 2001 to 2012 so my code is currently OLD SCHOOL. I'm trying to catch up as much as possible.

# WHAT IS PHPH1?
PHPH1 is two tools in one:

  1. A PHP wrapper class that bridges the Harmony ONE Node API to PHP for use by other languages. A web developer will be able to make requests to the class using scripting languages such as Javascript without having to worry what TYPE of data it is, or how the JSON request to the API server is formatted. The PHPH1 class will return a JSON formatted object (and maybe a few other ways in the future) for the scripting to read and handle. This software is NOT limited to the Harmony API Nodes anymore. You are able to add your own node url, including removing the standard harmony nodes, and set the default url and shard. The class also allows the dev to limit remote client access to the methods by IP address as well as block rowdy clients from using the interface.
  
  2. A learning tool for developers just getting started with the Harmony v2 Node API. It includes documentation for every method as well as allows you to run test data to see how each method reacts.

# CURRENT STATE

WARNING! I cannot guarantee that everything is properly validated and sane yet but as of 2022-4-26 I believe the package is in an extremely safe state.

Currently this is unoptimized and unfinished. Once it is "finished" (Every call and all documentation have been added) I will break down its use here.

There is currently 61 of 63 available methods available.

Error reporting 95% exists in the app

Everything should be validated and safe but I need to go back through and validate my own code for safety

# REQUIREMENTS

You must have PHP_CURL module enabled.

RUNNING THIS ON A NON-SSL HOST IS A SECURITY RISK!!!

You can use the official Harmony Nodes or if you have a local node (not necessaily on the same server [more later]) it can be used as well.

# USAGE
All functions within the class use the same naming convention and input as the Harmony Node Api which you can browse through here: https://api.hmny.io/

Download everything, drop it in a web directory where PHP (with PHP_CURL) is enabled.

check out inc/config.php and adjust if necessary, there are comments explaining most things there.

Browse to index.php

Have fun!


