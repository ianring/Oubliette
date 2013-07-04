<?php
include("oubliette.class.php");
$o = new Oubliette();

if (isset($_POST['challenge'])){
	$win = $o->accept_challenge();
	if ($win){
		$unbanned = $o->forgive();
		if ($unbanned) {
			echo "you are unbanned.";
		} else {
			echo "sorry, I couldn't unban you. you've been banned permanently.";
		}
	} else {
		echo "sorry, bot.";
	}
} else {
	$o->challenge();
}


?>