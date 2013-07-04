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
			<p>Because Linux doesn't provide a good flexible way to maintain a central IP blacklist on a LAMP stack. No one wants to add "Deny from" lines to an htaccess file. And there's just no decent way to add an IP to iptables from your app logic.</p>
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
			<p>The Rate Limiter puts a limit on how many requests are allowed within a span of time. The rate limiter can also trigger addition to the penalty box, or into jail.</p>
		</div>
	</div>
	
	<div class="row">
		<div class="span3">
			<div class="big-icon-holder text-center">
				<img src="assets/honeypot.png" />
			</div>
			<h3>Honey Pot</h3>
			<p>The Honey Pot is a tool that will trap robotic non-human visitors who are crawling your site, by leaving conspicuous URLs and links and invisible elements on your page which a robot will click, but a human would not.</p><p>The Honeypot is used in conjunction with the robots.txt file to separate "well-behaved" bots from the "naughty" ones.</p>
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


<h4>Step One</h4>
<p>Download Oubliette and put the <tt>oubliette/</tt> folder in your web root</p>

<h4>Step Two</h4>
<p>Edit the config.php file, to provide the information needed to make Oubliette run.</p>

<h4>Step Three</h4>
<p>Put this in an <tt>.htaccess</tt> file, in the web root folder.</p>

<pre>
php_value  auto_prepend_file "./oubliette/include.php"
</pre>

<p>That will include Oubliette before every page request. Oubliette will perform tests, and block the user if necessary.</p>

<h4>And you're done! But there's more...</h4>

<p>If you don't like automatically prepending Oubliette, you can do it using <tt>include()</tt> or <tt>require()</tt>:

<pre>
include("./oubliette/include.php");
</pre>

<p>If you want to build a more customized installation, you can instantiate your own <tt>$oubliette</tt> and call its public methods:</p>
<pre>
include("./oubliette/oubliette.class.php");
$oubliette = new Oubliette();
$oubliette->test();
</pre>

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

		<div class="span8">


						<h4>whitelist_add()</h4>
						<div class="methodsynopsis">
							<span class="type">bool</span>
							<span class="funcname">whitelist_add</span>
							(
							[
							<span class="methodparam">
								<span class="type">IP</span>
								<span class="parameter">$ip</span>
							</span>
							]
							)
						</div>
						<p>adds an IP to the whitelist.</p>


			
						<h4>greylist_add()</h4>
						<div class="methodsynopsis">
							<span class="type">bool</span>
							<span class="funcname">greylist_add</span>
							(
							[
							<span class="methodparam">
								<span class="type">IP</span>
								<span class="parameter">$ip</span>
							</span>
							]
							[,
							<span class="methodparam">
								<span class="type">int</span>
								<span class="parameter">$duration</span>
								<span clas="initializer"> = OUBLIETTE_GREYLIST_DURATION</span>
							</span>
							]
							)
						</div>
						<p>adds an IP to the greylist.</p>

						<h4>blacklist_add()</h4>
						<div class="methodsynopsis">
							<span class="type">bool</span>
							<span class="funcname">blacklist_add</span>
							(
							[
							<span class="methodparam">
								<span class="type">IP</span>
								<span class="parameter">$ip</span>
							</span>
							]
							)
						</div>
						<p>adds an IP to the blacklist.</p>



			<table>
				<tr>
					<td><h4>whitelist_remove()</h4></td>
					<td><h4>greylist_remove()</h4></td>
					<td><h4>blacklist_remove()</h4></td>
				</tr>
				<tr>
					<td><h4>is_whitelisted()</h4></td>
					<td><h4>is_greylisted()</h4></td>
					<td><h4>is_blacklisted()</h4></td>
				</tr>
			</table>
			
			<ul>
				<li>
					<h4>test()</h4>
					<p>This is the method that you should call on every request. It performs all the IP tests, handles sniffer tests, does rate limiting, and applies appropriate banishment rules.</p>
				</li>
				
				<li>
					<h4>blacklist_add()</h4>
					
				</li>
				<li>
					<h4>greylist_add()</h4>
					<p>adds an IP to the greylist. The IP will be blocked for 20 minutes (the default) but then will be unblocked.</p>
				</li>
				<li>
					<h4>whitelist_add()</h4>
					<p>this method adds the IP to a whitelist, so it will never again be blocked, penalized, or rate limited.</p>
				</li>
				
				<li>
					<h4>blacklist_remove()</h4>
					<p>removes an IP from the blacklist.</p>
				</li>
				<li>
					<h4>greylist_remove()</h4>
					<p>removes an IP from the greylist.</p>
				</li>
				<li>
					<h4>whitelist_remove()</h4>
					<p>removes an IP from the whitelist</p>
				</li>

				<li>
					<h4>is_blacklisted()</h4>
					<p>returns true if an IP is on the blacklist.</p>
				</li>
				<li>
					<h4>is_greylisted()</h4>
					<p>returns true if an IP is on the greylist.</p>
				</li>
				<li>
					<h4>is_whitelisted()</h4>
					<p>returns true if an IP is on the whitelist.</p>
				</li>

				
				<li>
					<h4>ratelimit()</h4>
					<p>Call this method on every request. It registers an occurrence in the rate limiter.</p>
				</li>

				<li>
					<h4>forget()</h4>
					<p>this method removes the IP from the blacklist, greylist, whitelist, and resets the rate limiter back to zero.</p>
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