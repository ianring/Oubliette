<?php
//include("oubliette/include.php");
?><!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="assets/script.js"></script>

<style>
li.L0, li.L1, li.L2, li.L3, li.L5, li.L6, li.L7, li.L8 { 
	list-style-type: decimal !important 
}
</style>

<link rel="stylesheet" href="assets/prettify.css" />
<link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="assets/style.css" />

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-bottom">
      <div class="navbar-inner">
        <div class="container">
          <a href="./index.html" class="brand">Grawlix</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="">
                <a href="http://chloroform.grawlix.com">Chloroform</a>
              </li>
              <li class="">
                <a href="http://tomatillo.grawlix.com">Tomatillo</a>
              </li>
              <li class="">
                <a href="http://oubliette.grawlix.com">Oubliette</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    
    
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="#">Oubliette</a>
			<ul class="nav">
				<li class="active"><a href="#home">Home</a></li>
				<li><a href="examples.php">Examples</a></li>
				<li><a href="documentation.php">Documentation</a></li>
			</ul>
		</div>
	</div>
</div>


<div class="container" id="home">
	<div class="row">
		<div class="span12 logo">
			
			<h1>Oubliette</h1>
			<img src="assets/oubliette_logo.png" />
			<p class="byline">IP banning, a better way</p>
			<a href="https://github.com/ianring/Oubliette/archive/master.zip" class="btn btn-info btn-large">Download Oubliette</a>
		</div>
	</div>
	
	<hr/>
	
	<div class="row">
		<div class="span4">
			<h3>Why?</h3>
			<p>Because Linux doesn't provide a good flexible way to maintain a central IP blacklist on a LAMP stack. iptables, editing .htaccess, and even fail2ban... they're complicated and difficult to configure.</p>
			<p>Oubliette exists out of necessessity. The author needed this tool. You probably do, too.</p>
		</div>
		<div class="span4">
			<h3>It's easy</h3>
			<p>Conceptually, it couldn't be simpler. A list of banned IPs, stored in Redis, and a PHP class that makes it convenient to manage that list in a few different ways.</p>
			<p><img src="assets/redis-small.png" style="float:left;margin-right:18px;" />To achieve its amazing fastocity, Oubliette uses <a href="http://redis.io">Redis</a>.</p>
			<p>Oubliette also requires the <a href="https://github.com/nicolasff/phpredis">PHPRedis extension</a>.</p>
		</div>
		<div class="span4">
			<h3>You can help</h3>
			<p>Oubliette is open-source. If you can make it better, fork it and branch it and send a git pull request.</p>
			<p><a href="https://github.com/ianring/Oubliette" class='btn btn-block btn-info btn-superchunky'><i class='icon-github'></i>View on GitHub</a></p>
			
		</div>
	</div>

	<div class="row">
		<hr/>
	</div>
</div>





<div class="container">
	<h2>The Oubliette Tools</h2>
	<div class="row">
		<div class="span3">
			<div class="big-icon-holder text-center">
				<img src="assets/blacklisted.png" />
			</div>
			<h3>Blacklist</h3>
			<p>The Blacklist is where the bad IP addresses go. Once an IP is blacklisted, it's banned and all requests from that IP are disallowed.</p>
			<p>A human visitor who becomes blacklisted may answer a humanity-testing question to be released.</p>
		</div>
		<div class="span3">
			<div class="big-icon-holder text-center">
				<img src="assets/greylisted.png" />
			</div>
			<h3>Greylist</h3>
			<p>An IP added to the Greylist will be banned for 20 minutes (the default). After the penalty is over, the IP is unbanned. Greylisting can be an effective punishment for unwanted user behaviour, such as repetitive requests or spamming.</p>
		</div>
		<div class="span3">
			<div class="big-icon-holder text-center">
				<img src="assets/whitelisted.png" />
			</div>
			<h3>Whitelist</h3>
			<p>If an IP is on the white list, it gets a free pass. It can not be blacklisted, greylisted, or rate limited. It is considered safe by all the other tools. It's useful to whitelist the IPs in your local network, and IPs that you never want to be banned.</p>
		</div>
		<div class="span3">
			<div class="big-icon-holder text-center">
				<img src="assets/turnstile.png" />
			</div>
			<h3>Rate Limiter</h3>
			<p>The Rate Limiter puts a limit on how many requests are allowed within a span of time. Normally the rate limiter will merely stifle excessive requests, but the rate limiter can also put offenders on the blacklist or greylist.</p>
		</div>
	</div>
	
	<div class="row">
		<div class="span3">
			<div class="big-icon-holder text-center">
				<img src="assets/honeypot.png" />
			</div>
			<h3>Honey Pot</h3>
			<p>The Honey Pot is a tool that will trap robotic non-human visitors who are crawling your site, by leaving conspicuous URLs and links and invisible elements on your page which a robot will click, but a human would not.</p>
			<p>The Honeypot is used in conjunction with the robots.txt file to separate "well-behaved" bots from the "naughty" ones.</p>
		</div>
		<div class="span3">
			<div class="big-icon-holder text-center">
				<img src="assets/mouse.png" />
			</div>
			<h3>Sniffer</h3>
			<p>The Sniffer looks for known patterns of malicious behaviour to detect port scanners, attackers, and other malicious agents who are inspecting your site for security vulnerabilities.</p>
		</div>
		<div class="span3">
			<div class="big-icon-holder text-center">
				<img src="assets/hive.png" />
			</div>
			<h3>The Hive</h3>
			<p>Oubliette operates as a centralized host, with subscription-based lists. Your copy of Oubliette can be configured to "call home" to get the latest lists from other Oubliette users. It's crowd-sourcing for your jail!</p>
		</div>
		<div class="span3">
		</div>
	</div>
	
	
	
	<div class="row">
		<hr/>
	</div>
	

	<div class="row">
		<div class="span4">
			<h3>See how easy it is</h3>
		</div>
		<div class="span8">

<h3>Installing Oubliette isn't hard. Follow these steps:</h3>

<ol>
	<li>Install <a href="http://redis.io">Redis</a></li>
	<li>Install the <a href="https://github.com/nicolasff/phpredis">PHPRedis extension</a>.</li>
	<li>Grab <a href="https://github.com/ianring/Oubliette/archive/master.zip">Oubliette from Github</a>, and extract it in your web root.</li>
	<li>Edit the config.php file to customize your installation</li>
	<li>
		<p>Put this in an <tt>.htaccess</tt> file, in the web root folder.</p>
<pre>
php_value auto_prepend_file "[your document root]/oubliette/include.php"
ErrorDocument 404 /oubliette/include.php
</pre>
	</li>
	<li>Go to the admin console built in to Oubliette. Set your time limits for rate limiting, and flick a switch to enable the Hive.</li>
</ol>

<h4>And you're done!</h4>
<h4>But wait, there's more!</h4>
<p>You can also:</p>
<ul>
	<li>Add honeypots to your HTML layout, to catch scraper bots</li>
	<li>Use Oubliette's public methods to add custom jails in your application. For example, if someone enters the wrong password too many times in a row, call <tt>$oubliette->greylist_add()</tt>, and they'll get a time out!</li>
	<li></li>
</ul>

<p>More detailed installation instructions are provided in the <a href="docs/">Developer Documentation</a></p>
			
		</div>
	</div>
	
	
	<div class="row">
		<hr/>
	</div>

	
	
	<div class="row">
		<div class="span4">
			<h3>Public Methods</h3>
			<p>Oubliette has a good collection of public methods that you can access any time you want to manipulate your lists.</p>
		</div>
	</div>

	<div class="row">
		<hr/>
	</div>
	
	<div class="row">
		<div class="span6">
			
		</div>
		<div class="span4">
			<h3>Admin Console</h3>
			<p>Oubliette has a built-in administration console. Use it to cutomize your Oubliette installation.</p>
		</div>
	</div>
	
	
	


</div>

</body>
</html>