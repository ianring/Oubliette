<?php
//include("oubliette/include.php");
?><!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.js"></script>
<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="script.js"></script>

<style>
li.L0, li.L1, li.L2, li.L3, li.L5, li.L6, li.L7, li.L8 { 
	list-style-type: decimal !important 
}
</style>

<link rel="stylesheet" href="../assets/prettify.css" />
<link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="../assets/style.css" />
<link rel="stylesheet" href="style.css" />

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
		<div class="span12">
			
			<h1>Oubliette Documentation</h1>

			<p>This is a work in progress. Please be patient</p>

			<h2>Public Methods</h2>
			<p>Oubliette has a good collection of public methods that you can access any time you want to manipulate your lists.</p>



						<h3>whitelist_add()</h3>
						<p>adds an IP to the whitelist.</p>
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
						<h4>Parameters</h4>
						<div class="parameters">
							<dt>ip</dt>
							<dd>The IP address to add. This parameter is optional. If not provided, then Oubliette uses the value of <tt>$_SERVER['REMOTE_ADDR']</tt>.</dd>
						</div>
						<h4>Return Values</h4>
						<p>returns <tt>TRUE</tt> on success or <tt>FALSE</tt> on failure.</p>
						
						<hr/>
						
						<h3>greylist_add()</h3>
						<p>adds an IP to the greylist.</p>
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
						<h4>Parameters</h4>
						<div class="parameters">
							<dt>ip</dt>
							<dd>The IP address to add. This parameter is optional. If not provided, then Oubliette uses the value of <tt>$_SERVER['REMOTE_ADDR']</tt>.</dd>
							<dt>duration</dt>
							<dd>The duration in seconds that the IP will be blocked</dd>
						</div>
						<h4>Return Values</h4>
						<p>returns <tt>TRUE</tt> on success or <tt>FALSE</tt> on failure.</p>
						
						<hr/>

						<h3>blacklist_add()</h3>
						<p>adds an IP to the blacklist.</p>
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
						<h4>Parameters</h4>
						<div class="parameters">
							<dt>ip</dt>
							<dd>The IP address to add. This parameter is optional. If not provided, then Oubliette uses the value of <tt>$_SERVER['REMOTE_ADDR']</tt>.</dd>
						</div>
						<h4>Return Values</h4>
						<p>returns <tt>TRUE</tt> on success or <tt>FALSE</tt> on failure.</p>
						
						<hr/>





						<h3>whitelist_remove()</h3>
						<p>removes an IP from the whitelist.</p>
						<div class="methodsynopsis">
							<span class="type">bool</span>
							<span class="funcname">whitelist_remove</span>
							(
							[
							<span class="methodparam">
								<span class="type">IP</span>
								<span class="parameter">$ip</span>
							</span>
							]
							)
						</div>
						<h4>Parameters</h4>
						<div class="parameters">
							<dt>ip</dt>
							<dd>The IP address to remove. This parameter is optional. If not provided, then Oubliette uses the value of <tt>$_SERVER['REMOTE_ADDR']</tt>.</dd>
						</div>
						<h4>Return Values</h4>
						<p>returns <tt>TRUE</tt> on success or <tt>FALSE</tt> on failure.</p>
						
						<hr/>


						<h3>greylist_remove()</h3>
						<p>removes an IP from the greylist.</p>
						<div class="methodsynopsis">
							<span class="type">bool</span>
							<span class="funcname">greylist_remove</span>
							(
							[
							<span class="methodparam">
								<span class="type">IP</span>
								<span class="parameter">$ip</span>
							</span>
							]
							)
						</div>
						<h4>Parameters</h4>
						<div class="parameters">
							<dt>ip</dt>
							<dd>The IP address to remove. This parameter is optional. If not provided, then Oubliette uses the value of <tt>$_SERVER['REMOTE_ADDR']</tt>.</dd>
						</div>
						<h4>Return Values</h4>
						<p>returns <tt>TRUE</tt> on success or <tt>FALSE</tt> on failure.</p>
						
						<hr/>


						<h3>blacklist_remove()</h3>
						<p>removes an IP from the blacklist.</p>
						<div class="methodsynopsis">
							<span class="type">bool</span>
							<span class="funcname">blacklist_remove</span>
							(
							[
							<span class="methodparam">
								<span class="type">IP</span>
								<span class="parameter">$ip</span>
							</span>
							]
							)
						</div>
						<h4>Parameters</h4>
						<div class="parameters">
							<dt>ip</dt>
							<dd>The IP address to remove. This parameter is optional. If not provided, then Oubliette uses the value of <tt>$_SERVER['REMOTE_ADDR']</tt>.</dd>
						</div>
						<h4>Return Values</h4>
						<p>returns <tt>TRUE</tt> on success or <tt>FALSE</tt> on failure.</p>
						
						<hr/>







						<h3>is_whitelisted()</h3>
						<p>checks if an IP is on the whitelist</p>
						<div class="methodsynopsis">
							<span class="type">bool</span>
							<span class="funcname">is_whitelisted</span>
							(
							[
							<span class="methodparam">
								<span class="type">IP</span>
								<span class="parameter">$ip</span>
							</span>
							]
							)
						</div>
						<h4>Parameters</h4>
						<div class="parameters">
							<dt>ip</dt>
							<dd>The IP address to check. This parameter is optional. If not provided, then Oubliette uses the value of <tt>$_SERVER['REMOTE_ADDR']</tt>.</dd>
						</div>
						<h4>Return Values</h4>
						<p>returns <tt>TRUE</tt> if the IP is whitelisted or <tt>FALSE</tt> otherwise.</p>
						
						<hr/>

						<h3>is_greylisted()</h3>
						<p>checks if an IP is on the greylist</p>
						<div class="methodsynopsis">
							<span class="type">bool</span>
							<span class="funcname">is_greylisted</span>
							(
							[
							<span class="methodparam">
								<span class="type">IP</span>
								<span class="parameter">$ip</span>
							</span>
							]
							)
						</div>
						<h4>Parameters</h4>
						<div class="parameters">
							<dt>ip</dt>
							<dd>The IP address to check. This parameter is optional. If not provided, then Oubliette uses the value of <tt>$_SERVER['REMOTE_ADDR']</tt>.</dd>
						</div>
						<h4>Return Values</h4>
						<p>returns <tt>TRUE</tt> if the IP is greylisted or <tt>FALSE</tt> otherwise.</p>
						
						<hr/>



						<h3>is_blacklisted()</h3>
						<p>checks if an IP is on the blacklist</p>
						<div class="methodsynopsis">
							<span class="type">bool</span>
							<span class="funcname">is_blacklisted</span>
							(
							[
							<span class="methodparam">
								<span class="type">IP</span>
								<span class="parameter">$ip</span>
							</span>
							]
							)
						</div>
						<h4>Parameters</h4>
						<div class="parameters">
							<dt>ip</dt>
							<dd>The IP address to check. This parameter is optional. If not provided, then Oubliette uses the value of <tt>$_SERVER['REMOTE_ADDR']</tt>.</dd>
						</div>
						<h4>Return Values</h4>
						<p>returns <tt>TRUE</tt> if the IP is blacklisted or <tt>FALSE</tt> otherwise.</p>
						
						<hr/>

						
						
						<h3>ratelimit()</h3>
						<div class="methodsynopsis">
							<span class="type">bool</span>
							<span class="funcname">ratelimit</span>
							(
							[
							<span class="methodparam">
								<span class="type">IP</span>
								<span class="parameter">$ip</span>
							</span>
							]
							)
						</div>
						<p>This method should be called with every request. Each call counts as one occasion against the IP's rate limit.</p>
						
						<h3>test()</h3>
						<div class="methodsynopsis">
							<span class="type">bool</span>
							<span class="funcname">test</span>
							(
							[
							<span class="methodparam">
								<span class="type">IP</span>
								<span class="parameter">$ip</span>
							</span>
							]
							)
						</div>
						<p>This method does almost everything you need, at once. It performs the white, grey and black list tests, rate limiting, sniffing, and also kicks off scheduled actions to keep the hive in sync. </p>
						
						
						<h3>forget()</h3>
						<div class="methodsynopsis">
							<span class="type">bool</span>
							<span class="funcname">forget</span>
							(
							[
							<span class="methodparam">
								<span class="type">IP</span>
								<span class="parameter">$ip</span>
							</span>
							]
							)
						</div>
						<p>This method removes an IP from all lists.</p>
						
						
						<h3>honeypot()</h3>
						<div class="methodsynopsis">
							<span class="type">string</span>
							<span class="funcname">honeypot</span>
							(
							)
						</div>
						<p>This method returns some specially crafted HTML containing LINK TRAPS. Inject them onto your page. They're invisible links that would never be clicked on by a human... but if a robot sees them they'll be followed straight onto the blacklist! mmuahahahaha!</p>
						
						
			
		</div>
	</div>
	
	
	<div class="row">
		<hr/>
	</div>
	
	


</div>

</body>
</html>