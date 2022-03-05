# 2022-2-22 IS A FULL NEW UPLOAD!
  What this means:
  
  Anything before hand is ~99% gone.

  This is not release worthy yet
  
  There is a TON of work still needing to be done.
  
  This is not the full list of capabilities yet. We are currently at 37. There a few of these that still need worked on, documentation-wise.
  
# ROADMAP

  1.Create a PHP class with every API call in it.
    a. I have 37 of 63 methods completed
    b. The remaining methods should take approximately ~7 working days (56 hours) to add to the class

  2. Optimize and modernize the class code reassess the PHP code logic and revamp if necessary
    a. ~3 working days (reduced from 7). Almost complete.

  3. Create a MOBILE FRIENDLY Harmony API explorer into the package to assist developers in learning how the API works
    a. The design has already been implemented and just needs to have the new API method forms and API documentation sections created and a few adjustments. It is time consuming. (~5 working days).

  4. Create documentation on the “homepage” of the explorer package including configuration and simple Javascript/jQuery code examples. This also includes how to extend the network and shards in order to do things like run a local node and get data from it. (~5 working days)

  5. Create documentation for the class and explorer using PHP DOC. I have to write in all the doc blocks in the code so it generates everything nicely. Get it generated and then probably a few tweaks to the interface. (~5 working days)

  6. Create a package where a developer could drop the package into a directory and safely use it for retrieving data using other scripting languages with minimal input. I plan to provide 3 different download packages: Full with full API explorer, minimal with just the class and remote call script, and class only. As long as I have my stuff properly set up on github, this should be pretty easy. (~2 working days)

  7. Report API methods that do not react according to the API documentation (this happens as I work throughout entire project as basically an include. As far as time to report and deal with it depends on how fast the line of communication is). I have a few noted already. 1 day

  8. Maintain the class and project if/when the API changes/expands (depends on how often the API changes, just part of maintenance).
    a. If we have a method explosion like this last time, this could turn into a lot of work to stay up to date with the API. I was looking and I believe the original EVM has like 62 or so methods. If there are plans to expand, please let me know and I will include it in the bounty if that is okay.

  9. Maintain any bug reports etc on Github
    a. ~2 days time over a year then I’ll just do it

# PHPH1 :: A PHP Class to query the Harmony ONE Node API
NOTE: I'm not a PHP developer. I wrote PHP database applications for a living from 2001 to 2012 so my code is currently OLD SCHOOL. I'm trying to catch up as much as possible.

# WHAT IS PHPH1?
PHPH1 is a PHP class that bridges the Harmony ONE Node API to PHP.

A web developer will be able to make requests to the class using scripting languages such as Javascript without having to worry what TYPE of data it is, or how the JSON request to the API server is formatted. The PHPH1 class will return a JSON formatted object (and maybe a few other ways in the future) for the scripting to read and handle. This software is NOT limited to the Harmony APi Nodes anymore. You are able to add your own node url, including removing the standard harmony nodes, and set the default url and shard.

# CURRENT STATE

WARNING! I cannot guarantee that everything is properly validated and sane yet but as of 2022-2-22 I think the package is in a reasonably safe state.

Currently this is unoptimized and unfinished. Once it is "finished" (Every call and all documentation have been added) I will break down its use here.

There is currently 37 of ~60ish available methods.

Error reporting 80% exists in the app

Everything should be validated but I need to go back through and validate my own code for safety

There is much to do. If you would like to help out with some PHP skills feel free to contribute.

# REQUIREMENTS

You must have PHP_CURL module enabled.

I highly suggest running this under SSL

You can use the Harmony Nodes or if you have a local node (not necessaily on the same server [more later]) it can be used as well.

# USAGE
All functions within the class use the same naming convention and input as the Harmony Node Api which you can browse through here: https://api.hmny.io/

Download everything, drop it in a web directory where PHP (with PHP_CURL) is enabled.

check out inc/config.php and adjust if necessary, there are comments explaining most thngs there.

Browse to index.php

Have fun!


