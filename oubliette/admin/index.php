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
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="script.js"></script>

<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="style.css" />

</head>
<body>


<div class="container" id="home">
	<div class="row">

		<div class="span3">
			<div class="text-center icon">
				<img src="../../assets/whitelisted.png" height="100"/>
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
		</div>

		<div class="span3">
			<div class="text-center icon">
				<img src="../../assets/blacklisted.png" height="100"/>
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
			
		</div>
		
		<div class="span3">
			<div class="text-center icon">
				<img src="../../assets/greylisted.png" height="100"/>
			</div>
			<div data-key="enable_greylist" class="field switch">
				<label class="cb-enable<?php echo ($config['enable_greylist']=='true'?' selected':''); ?>"><span>On</span></label>
				<label class="cb-disable<?php echo ($config['enable_greylist']=='false'?' selected':''); ?>"><span>Off</span></label>
			</div>
			<div class="form-inline">
				<label>Time limit (minutes)</label>
				<input id="grey_time_limit" type="text" value="<?php echo $config['grey_time_limit']; ?>" class="input-mini" />
			</div>
		</div>
		<div class="span3">
			<div class="text-center icon">
				<img src="../../assets/turnstile.png" height="100"/>
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
		</div>
	</div>
	<br/>

	<div class="row">

		<div class="span3">
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
						echo '<div class="listitem"><span class="close icon-remove-circle"></span>'.$ip.'</div>';
					}
					?>
				</div>
			</div>
		</div>
		<div class="span3">
			<div id="blacklist_container">
				<div class="input-append"> 
					<form id="blacklist_add_form">
						<input id="blacklist_add_input" class="input-medium" type="text" placeholder="Add an IP" />
						<button id="blacklist_add_button" class="btn">+</button>
					</form>
				</div>
				<div id="blacklist">
					<?php
					foreach($oubliette->show('black') as $ip){
						echo '<div class="listitem"><span class="close icon-remove-circle"></span>'.$ip.'</div>';
					}
					?>
				</div>
			</div>
		</div>
		<div class="span3">
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
						echo '<div class="listitem"><span class="close icon-remove-circle"></span>'.$ip.'</div>';
					}
					?>
				</div>
			</div>
		</div>
		<div class="span3">
			
			<p>When rate limit is exceeded, do this:</p>
			<select>
				<option>Do nothing</option>
				<option>Put IP in the greylist</option>
				<option>Put IP in the blacklist</option>
			</select>
			
			<div id="ratelimit">
			<?php
			foreach($oubliette->show('ratelimit') as $ip=>$count){
				echo '<div class="listitem"><span class="close icon-remove-circle"></span>'.$ip.' ('.$count.')</div>';
			}
			?>
			</div>
		</div>
	</div>

</div>



</body>
</html>