<?php


define("OUBLIETTE_REDIS_HOST","localhost");
define("OUBLIETTE_REDIS_PORT",6379);


define("OUBLIETTE_KEY_PREFIX","oublidemo"); // to keep these safe from colliding with other apps also using redis
define("OUBLIETTE_PATH", "/oubliette"); // this is where oubliette exists, relative to the web root
define("OUBLIETTE_ALERT_EMAIL", "oubliette@grawlix.com"); // if you don't want alerts, leave this empty
define("OUBLIETTE_SALT", "hudwd873gwef");

define("OUBLIETTE_UNBAN_CHANCES",3); // after being banned (and unbanned) this many times, the IP is moved to the "permanent" list.
//define("OUBLIETTE_RATE_LIMIT_CHANCES",10); // the number of times an IP may exceed the rate limit before it gets banned too. To disable this, make it NULL

// rate limiting: defined as X visits within Y seconds, by the same IP.
// if the number of visits ever exceeds that limit, the IP gets banned.
define("OUBLIETTE_RATE_LIMIT_ENABLED", true);
define("OUBLIETTE_RATE_LIMIT_VISITS",5);
define("OUBLIETTE_RATE_LIMIT_SECONDS",10);

// set this to true if a rate limit puts the IP in a penalty time out
//define("OUBLIETTE_RATE_LIMIT_PENALTY",true);

define("OUBLIETTE_PENALTY_DURATION",60*15); // penalty box timeout, in seconds.

//define("OUBLIETTE_RATE_LIMIT_ALERT_THRESHOLD",10); // if an IP breaks the rate limit this many times, an alert is sent
//define("OUBLIETTE_RATE_LIMIT_BAN_THRESHOLD",10); // if an IP breaks the rate limit this many times, the IP is banned completely


?>