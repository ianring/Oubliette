<?php
include("oubliette/include.php");
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
			<p>Because there's no really good flexible way to maintain a central IP blacklist on a LAMP stack. There are projects that manipulate your htaccess file to add "Deny from" lines, but you don't want some script having write access to your htaccess, do you? And there's iptables. But how do you add addresses to iptables from your app logic?</p>
			<p>Oubliette exists out of necessessity. I needed this tool. So I assume you might as well.</p>
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
			<h3>Jail</h3>
			<p>The Jail is where the bad IP addresses go. Once an IP is jailed, it's banned and all requests from that IP are disallowed.</p>
			<p>A human visitor who becomes jailed may answer a humanity-testing question to be released from jail.</p>
		</div>
		<div class="span3">
			<h3>Penalty Box</h3>
			<p>An IP added to the Penalty box will be banned for 20 minutes (the default). After the penalty is over, the IP is unbanned. This is sometimes called "greylisting". Penalizing can be an effective punishment for unwanted behaviour, such as repetitive requests or spamming.</p>
		</div>
		<div class="span3">
			<h3>Rate Limiter</h3>
			<p>The Rate Limiter puts a limit on how many requests are allowed within a span of time. If an IP is making too many requests, it must wait - the rate limiter can also trigger addition to the penalty box, or into jail.</p>
		</div>
		<div class="span3">
			<h3>White List</h3>
			<p>If an IP is on the white list, it can not be jailed, penalized, or rate limited. It is considered safe by all the other tools. It's useful to whitelist the IPs in your local network, and IPs that you never want to be banned.</p>
		</div>
	</div>
	
	<div class="row">
		<div class="span3">
			<h3>Honey Pot</h3>
			<p>The Honey Pot is a tool that will trap robotic non-human visitors who are crawling your site, by leaving conspicuous URLs and links and invisible elements on your page which a robot will click, but a human would not.</p><p>The Honeypot is used in conjunction with the robots.txt file to separate "well-behaved" bots from the "naughty" ones.</p>
		</div>
		<div class="span3">
			<h3>Sniffer</h3>
			<p>The Sniffer looks for known patterns of malicious behaviour to detect port scanners, attackers, and other malicious agents who are inspecting your site for security vulnerabilities.</p>
		</div>
		<div class="span3">
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

<p>This is all you need to do. Put this in your .htaccess file.</p>

<pre>
php_value  auto_prepend_file "./oubliette/include.php"
</pre>

<p>Doing that will include Oubliette before every page request. Oubliette will perform tests, and block the user if necessary.</p>

			
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

		<div class="span8">
		
			<ul>
				<li>
					<h4>forbid()</h4>
					<p>adds an IP to the banned list.
				</li>
				<li>
					<h4>penalize()</h4>
					<p>adds an IP to the penalty box. The IP will be blocked for 20 minutes (the default) but then will be unblocked.
				</li>
				<li>
					<h4>forgive()</h4>
					<p>this method removes the IP from the block list, rate limiter, and penalty box.</p>
				</li>
				<li>
					<h4>whitelist()</h4>
					<p>this method adds the IP to a whitelist, so it will never again be blocked, penalized, or rate limited.</p>
				</li>
			</ul>		
			
		</div>
	</div>
	
	
	<div class="row">
		<hr/>
	</div>
	
	


</div>

</body>
</html>