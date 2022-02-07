# PHPH1 :: A PHP Class to query the Harmony ONE Node API
NOTE: I'm not a PHP developer. I wrote PHP database applications for a living from 2001 to 2012 so my code is currently OLD SCHOOL. I'm trying to catch up as much as possible.

# WHAT IS PHPH1?
PHPH1 is a PHP class that bridges the Harmony ONE Node API to PHP.

The goal is to implement every Node API request and make it simple for a dev to input the data and retrieve the results in an easy to use data array.

# CURRENT STATE

DANGER WILL ROBINSON!!!
WARNING! I cannot guarantee that everything is validated and sane yet.

Currently this is unoptimized and unfinished. Once it is finished I will break down its use here.

All calls have been tested except raw sends.

*Almost* all calls have been added to the explorer. A few of the methods need to be fixed still. They work, but do not tell you if your input is bad, the method just doesn't run.

Almost everything is validated but I need to go back through and validate my own code for safety

Things are going to change drastically again as I already have the next step towards optimizing this in the works.

There is much to do. If you would like to help out with some PHP skills feel free to contribute.

# REQUIREMENTS
You must have PHP_CURL module enabled.

I highly suggest running this under SSL

# USAGE
All functions within the class use the same naming convention and input as the Harmony Node Api which you can browse through here: https://api.hmny.io/

Download everything, drop it in a web directory where PHP (with PHP_CURL) is enabled and browse to index.php.

Have fun!


