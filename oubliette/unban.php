<?php
include("oubliette.class.php");
$o = new Oubliette();

if (isset($_POST['challenge'])){
	$win = $o->accept_challenge();
	if ($win){
		$o->unban();
		echo "you are unbanned.";
	} else {
		echo "sorry, bot.";
	}
} else {
	$o->challenge();
}


?>