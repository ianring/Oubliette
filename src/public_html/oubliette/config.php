<?php
define("OUBLIETTE_ADMIN_USER","admin");
define("OUBLIETTE_ADMIN_PASSWORD","password");

define("OUBLIETTE_REDIS_HOST","localhost");
define("OUBLIETTE_REDIS_PORT",6379);

define("OUBLIETTE_LOG", __DIR__ . "/oubliette.log");

define("OUBLIETTE_KEY_PREFIX","oublidemo"); // to keep these safe from colliding with other apps also using redis
define("OUBLIETTE_PATH", "/oubliette"); // this is where oubliette exists, relative to the web root
define("OUBLIETTE_ALERT_EMAIL", "oubliette@grawlix.com"); // if you don't want alerts, leave this empty
define("OUBLIETTE_SALT", "hudwd873gwef");
?>