<?php
define("OUBLIETTE_ADMIN_USER","admin");
define("OUBLIETTE_ADMIN_PASSWORD","password");

define("OUBLIETTE_REDIS_HOST","localhost");
define("OUBLIETTE_REDIS_PORT",6379);


/*
* This is the server path, e.g. /var/www/html/your_server.com/public_html/oubliette/
*/
define("OUBLIETTE_PATH", __DIR__);

/*
* this is the location of the oubliette folder relative to the document root, e.g. "/oubliette/"
*/
define("OUBLIETTE_ROOT", "/examples/oubliette");


/*
* location of the oubliette log file. You know what this is good for? Combining the functionality
* of oubiette with something like fail2ban, flume, or anything else that can consume a log file.
* these logs files contain exactly the same data that is sent to the hive, if the hive feature is enabled
*/
define("OUBLIETTE_LOG", OUBLIETTE_PATH . "/oubliette.log");

/*
* this has got to be something unique to this particular instance of oubliette on your server.
*/
define("OUBLIETTE_KEY_PREFIX","oublidemo"); // to keep these safe from colliding with other apps also using redis


define("OUBLIETTE_ALERT_EMAIL", "oubliette@grawlix.com"); // if you don't want alerts, leave this empty
define("OUBLIETTE_SALT", "hudwd873gwef");
?>