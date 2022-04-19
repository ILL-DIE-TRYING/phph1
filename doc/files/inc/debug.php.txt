<p>Web Server Software: <strong><?= $_SERVER['SERVER_SOFTWARE']; ?></strong></p>
<p>Web Server Protocol: <strong><?= $_SERVER['SERVER_PROTOCOL']; ?></strong></p>
<p>Web Server Request Method: <strong><?= $_SERVER['REQUEST_METHOD']; ?></strong></p>
<p>User Agent: <strong><?= $_SERVER['HTTP_USER_AGENT']; ?></strong></p>
<p>Current Harmony Network: <strong><?= $phph1->get_sessionnetwork(); ?></strong></p>
<p>Current Harmony Shard: <strong><?= $phph1->get_sessionshard(); ?></strong></p>
<p>Current Node API URL: <strong><?= $phph1->get_apiaddr(); ?></strong></p>
<p>Current Node API method: <strong><?= $phph1->get_currentmethod(); ?></strong></p>