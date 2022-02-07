<h3>PHPH1 :: A PHP Class to query the Harmony ONE Node API</h3>
<p>NOTE: I'm not a PHP developer. I wrote PHP database applications for a living from 2001 to 2012 so my code is currently OLD SCHOOL. I'm trying to catch up as much as possible.</p>

<h3>WHAT IS PHPH1?</h3>
<p>PHPH1 is a PHP class that bridges the Harmony ONE Node API to PHP.</p>

<p>The goal is to implement every Node API request and make it simple for a dev to input the data and retrieve the results in an easy to use data array.</p>

<h3>CURRENT STATE</h3>

<p style='font-weight:bold;'>DANGER WILL ROBINSON!!!<br />
WARNING! I cannot guarantee that everything is validated and sane yet.</p>

<p>Currently this is unoptimized and unfinished. Once it is finished I will break down its use here.</p>

<p>All calls have been tested except raw sends.</p>

<p>*Almost* all calls have been added to the explorer. A few of the methods need to be fixed still. They work, but do not tell you if your input is bad, the method just doesn't run.</p>

<p>Almost everything is validated but I need to go back through and validate my own code for safety</p>

<p>Things are going to change drastically again as I already have the next step towards optimizing this in the works.</p>

<p>There is much to do. If you would like to help out with some PHP skills feel free to contribute.</p>

<h3>REQUIREMENTS</h3>
<p>You must have PHP_CURL module enabled.</p>

<p>I highly suggest running this under SSL</p>

<h3>USAGE</h3>
<p>All functions within the class use the same naming convention and input as the Harmony Node Api which you can browse through here: <a href="https://api.hmny.io/" target="_blank">https://api.hmny.io/</a></p>

<p>Download everything <a href="https://github.com/ILL-DIE-TRYING/phph1" target="_blank">here</a>, drop it in a web directory where PHP (with PHP_CURL) is enabled and browse to index.php.</p>

<p>Have fun!</p>


