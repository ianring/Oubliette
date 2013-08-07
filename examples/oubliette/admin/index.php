<?php
require_once("../config.php");
require_once("../oubliette.class.php");

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Oubliette"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Oubliette says Good Day.';
    exit;
} else {
	if ($_SERVER['PHP_AUTH_USER'] != OUBLIETTE_ADMIN_USER || $_SERVER['PHP_AUTH_PW'] != OUBLIETTE_ADMIN_PASSWORD){
	    header('HTTP/1.0 401 Unauthorized');
	    echo 'Oubliette says Sorry.';
	    exit;
	}
}

/*
$config = array(
	'enable_blacklist' => 'true',
	'enable_whitelist' => 'true',
	'enable_greylist' => 'true',
	'enable_ratelimit' => 'false',
	'white_wild' => 'true',
	'black_wild' => 'true',
	'grey_time_limit' => 20,
	'rate_visits' => 7,
	'rate_seconds' => 12
);
*/
$oubliette = new Oubliette();
$config = $oubliette->get_config();
//var_dump($config);

if (isset($_POST['action'])){
	if ($_POST['action'] == 'add'){
		$oubliette->add($_POST['ip']);
		echo $_POST['ip']." added.";
	}
	if ($_POST['action'] == 'save'){
		$oubliette->save($_POST['ips']);
		echo "saved.";
	}
}

?><!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script src="script.js"></script>

<link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="style.css" />

</head>
<body>

<br/>
<div class="container" id="home">
	<div class="row">
		<div class="span7 offset2">
			<ul class="nav nav-tabs">
				<li><a href="#whitepanel" data-toggle="tab"><img src="assets/whitelisted.png" style="height:40px;"/></a></li>
				<li><a href="#blackpanel" data-toggle="tab"><img src="assets/blacklisted.png" style="height:40px;"/></a></li>
				<li><a href="#greypanel" data-toggle="tab"><img src="assets/greylisted.png" style="height:40px;"/></a></li>
				<li><a href="#ratepanel" data-toggle="tab"><img src="assets/turnstile.png" style="height:40px;"/></a></li>
				<li><a href="#honeypotpanel" data-toggle="tab"><img src="assets/honeypot.png" style="height:40px;"/></a></li>
				<li><a href="#snifferpanel" data-toggle="tab"><img src="assets/mouse.png" style="height:40px;"/></a></li>
				<li><a href="#hivepanel" data-toggle="tab"><img src="assets/hive.png" style="height:40px;"/></a></li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="span5 offset3">
			<div class="tab-content">
				<div class="tab-pane active" id="whitepanel">
					<div class="text-center icon">
						<img src="assets/whitelisted.png" height="100"/>
						<h3>Whitelist</h3>
					</div>
					<div data-key="enable_whitelist" class="field switch">
						<label class="cb-enable<?php echo ($config['enable_whitelist']=='true'?' selected':''); ?>"><span>On</span></label>
						<label class="cb-disable<?php echo ($config['enable_whitelist']=='false'?' selected':''); ?>"><span>Off</span></label>
					</div>
					<div class="form-inline">
						
						<label class="checkbox">
							<input id="white_wild" value="true" type="checkbox" <?php echo ($config['white_wild']=='true'?'checked="checked"':'') ?> />
							Allow Everything
						</label>
						
					</div>
					<div id="whitelist_container">
						<div class="input-append"> 
							<form id="whitelist_add_form">
								<input id="whitelist_add_input" class="input-medium" type="text" placeholder="Add an IP" />
								<button class="btn" id="whitelist_add_button">+</button>
							</form>
						</div>
						<div id="whitelist">
							<?php
							foreach($oubliette->show('white') as $ip){
								echo '<div class="listitem"><span class="close icon-remove-circle"></span><span class="ip">'.$ip.'</span></div>';
							}
							?>
						</div>
					</div>		
				</div>
				<div class="tab-pane" id="blackpanel">
	
					<div class="text-center icon">
						<img src="assets/blacklisted.png" height="100"/>
						<h3>Blacklist</h3>
					</div>
					<div data-key="enable_blacklist" class="field switch">
						<label class="cb-enable<?php echo ($config['enable_blacklist']=='true'?' selected':''); ?>"><span>On</span></label>
						<label class="cb-disable<?php echo ($config['enable_blacklist']=='false'?' selected':''); ?>"><span>Off</span></label>
					</div>
					<div class="form-inline">
						<label class="checkbox">
							<input id="black_wild" value="true" type="checkbox" <?php echo ($config['black_wild']=='true'?'checked="checked"':'') ?> />
							Block Everything
						</label>
					</div>
					<div class="form-inline">
						<label class="checkbox">
							<input id="allow_unban" value="true" type="checkbox" <?php echo ($config['allow_unban']=='true'?'checked="checked"':'') ?> />
							Allow unbanning
						</label>
					</div>
					<div class="form-inline">
						<label>How many times may a visitor unban their own IP?</label>
						<input id="unban_chances" type="text" value="<?php echo $config['unban_chances']; ?>" class="input-xmini" />
					</div>
					<div id="blacklist_container">
						<div class="input-append"> 
							<form id="blacklist_add_form">
								<input id="blacklist_add_input" class="input-medium" type="text" placeholder="Add an IP" />
								<button id="blacklist_add_button" class="btn">+</button>
							</form>
						</div>
						<div id="blacklist">
							<?php
							foreach($oubliette->show('black') as $ip=>$chances){
								echo '<div class="listitem"><span class="close icon-remove-circle"></span><span class="ip">'.$ip.'</span>';
								if ($chances != null && $chances > 0){
									echo '<span class="extra">('.$chances.')</span>';
								}
								echo '</div>';
							}
							?>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="greypanel">
					<div class="text-center icon">
						<img src="assets/greylisted.png" height="100"/>
						<h3>Greylist</h3>
					</div>
					<div data-key="enable_greylist" class="field switch">
						<label class="cb-enable<?php echo ($config['enable_greylist']=='true'?' selected':''); ?>"><span>On</span></label>
						<label class="cb-disable<?php echo ($config['enable_greylist']=='false'?' selected':''); ?>"><span>Off</span></label>
					</div>
					<div class="form-inline">
						<label>Time limit (seconds)</label>
						<input id="grey_time_limit" type="text" value="<?php echo $config['grey_time_limit']; ?>" class="input-mini" />
					</div>
					<div id="greylist_container">
						<div class="input-append"> 
							<form id="greylist_add_form">
								<input id="greylist_add_input" class="input-medium" type="text" placeholder="Add an IP" />
								<button id="greylist_add_button" class="btn">+</button>
							</form>
						</div>
						<div id="greylist">
							<?php
							foreach($oubliette->show('grey') as $ip){
								echo '<div class="listitem"><span class="close icon-remove-circle"></span><span class="ip">'.$ip.'</span></div>';
							}
							?>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="ratepanel">
				
					<div class="text-center icon">
						<img src="assets/turnstile.png" height="100"/>
						<h3>Rate Limiter</h3>
					</div>
					<div data-key="enable_ratelimit" class="field switch form-inline">
						<label class="cb-enable<?php echo ($config['enable_ratelimit']=='true'?' selected':''); ?>"><span>On</span></label>
						<label class="cb-disable<?php echo ($config['enable_ratelimit']=='false'?' selected':''); ?>"><span>Off</span></label>
					</div>
					<div class="form-inline">
						<label>Visits</label>
						<input id="rate_visits" type="text" value="<?php echo $config['rate_visits']; ?>" class="input-xmini" />
						<label>Seconds</label>
						<input id="rate_seconds" type="text" value="<?php echo $config['rate_seconds']; ?>" class="input-xmini" />
					</div>
					
					<div>
						<p>When rate limit is exceeded, do this:</p>
						<select id="rate_limit_punishment">
							<?php
								$opts = array(
									'nothing'=>'Do nothing, just block them',
									'greylist_add'=>'Put IP in the greylist',
									'blacklist_add'=>'Put IP in the blacklist'
								);
								foreach($opts as $k=>$v){
									echo '<option value="'.$k.'"';
									if ($config['rate_limit_punishment'] == $v){
										echo ' selected="selected"';
									}
									echo '>'.$v.'</option>';
								}
							?>
						</select>
					</div>
					<div id="ratelimit">
					<?php
						foreach($oubliette->show('ratelimit') as $ip=>$count){
							echo '<div class="listitem"><span class="close icon-remove-circle"></span><span class="ip">'.$ip.'</span> ('.$count.')</div>';
						}
					?>
					</div>
				</div>
			
				<div class="tab-pane" id="honeypotpanel">
					
					<div class="text-center icon">
						<img src="assets/honeypot.png" height="100"/>
						<h3>Honeypot</h3>
					</div>
					
					<p>honeypot</p>
					
				</div>

				<div class="tab-pane" id="snifferpanel">

					<div class="text-center icon">
						<img src="assets/mouse.png" height="100"/>
						<h3>Sniffer</h3>
					</div>
					<div>
						<p>woah yeah un huh</p>
					</div>
				</div>
			
				<div class="tab-pane" id="hivepanel">
					<div class="text-center icon">
						<img src="assets/hive.png" height="100"/>
						<h3>Hive</h3>
					</div>
					
					<p>Oubliette works fine without this. But it works a whole lot better with it. Join the hive, and benefit from shared blacklists contributed by other Oubliette users!</p>
					
					<p>
					<div data-key="enable_hive" class="field switch">
						<label class="cb-enable<?php echo ($config['enable_hive']=='true'?' selected':''); ?>"><span>On</span></label>
						<label class="cb-disable<?php echo ($config['enable_hive']=='false'?' selected':''); ?>"><span>Off</span></label>
					</div>
					</p>
					
					<p>If you turn the hive on, you will begin sharing your IP blocking data with Oubliette, and you will receive updated block lists in collaboration with other Oubliette users. By clicking "On", you acknowledge the privacy implications of this, and you're OK with that.</p>
					
				</div>
			</div>
		</div>
	</div>
</div>



</body>
</html>