# PHPH1 :: A PHP Class to query the Harmony ONE Node API
NOTE: I'm not a PHP developer. I wrote PHP database applications for a living from 2001 to 2012 so my code is currently OLD SCHOOL. I'm trying to catch up as much as possible.

PHPH1 is a PHP class that bridges the Harmony ONE Node API to PHP. The goal is to implement every Node API and make it simple for a dev to input the data and retrieve the results in an easy to use data array.

There are three files:
config.php : Configuration settings for the PHPH1 class
phph1.php : The PHPH1 class itself
example_gettransactions.php : An example that gets all transactions available for a ONE address

Currently this is unoptimized and unfinished. Once it is finished I will break down its use here.

WARNING! There is no validation for most input yet so USE AT YOUR OWN RISK! THIS IS UNFINISHED WORK!

DANGER WILL ROBINSON!

All calls have been tested except raw sends.

There is much to do. If you would like to help out with some PHP skills feel free to contribute.

Have fun!

All functions within the class use the same naming convention and input as the Harmony Node Api which you can browse through here: https://api.hmny.io/

