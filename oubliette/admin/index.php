<?php
require_once("../config.php");

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


require_once("../oubliette.class.php");
$oubliette = new Oubliette();
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
		<div class="span4">
			<div class="text-center icon">
				<img src="../../assets/blacklisted.png" height="100"/>
			</div>
			<div id="blacklist">
			<?php
			foreach($oubliette->show('black') as $ip){
				echo '<div class="listitem"><span class="close"></span>'.$ip.'</div>';
			}
			?>
			</div>
		</div>
		<div class="span4">
			<div class="text-center icon">
				<img src="../../assets/greylisted.png" height="100"/>
			</div>
			<div id="greylist">
			<?php
			foreach($oubliette->show('grey') as $ip){
				echo '<div><span class="close"></span>'.$ip.'</div>';
			}
			?>
			</div>
		</div>
		<div class="span4">
			<div class="text-center icon">
				<img src="../../assets/whitelisted.png" height="100"/>
			</div>
			<div id="whitelist">
			<?php
			foreach($oubliette->show('white') as $ip){
				echo '<div><span class="close"></span>'.$ip.'</div>';
			}
			?>
			</div>
		</div>
	</div>
</div>



</body>
</html>