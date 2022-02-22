# 2022-2-22 IS A FULL NEW UPLOAD!
  What this means:
  
  Anything before hand is ~99% gone.

  This is not release worthy yet
  
  There is a TON of work still needing to be done.
  
  This is not the full list of capabilities yet. We are currently at 37 of ~60 methods. There are a few of these that still need worked on, documentation-wise.
  
  Did I mention there is a LOT of work left to do? I'll build a to-do list (roadmap) in the net coming days. 

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


