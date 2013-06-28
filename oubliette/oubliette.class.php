<?php

define("REDIS_HOST","localhost");
define("REDIS_PORT",6379);

define("OUBLIETTE_KEY", "redistrap");
define("OUBLIETTE_PATH", "/oubliette");
define("OUBLIETTE_ALERT_EMAIL", "heyianring@hotmail.com"); // if you don't want alerts, leave this empty
define("OUBLIETTE_SALT", "oubliettesalt123");

define("OUBLIETTE_UNBAN_CHANCES",3); // the number of times an IP can unban itself before it's banned forever.

// rate limiting: defined as X visits within Y seconds, by the same IP.
// if the number of visits ever exceeds that limit, the IP gets banned.
define("OUBLIETTE_RATE_LIMIT_VISITS",100);
define("OUBLIETTE_RATE_LIMIT_SECONDS",10);



class Oubliette {
	
	function __construct(){
		$this->redis = new Redis();
		$this->redis->connect(REDIS_HOST, REDIS_PORT);
	}
	
	/**
	 *  do this somewhere on your page. Maybe in the header, footer, or somewhere else thats included on all pages.
	 */
	function render_honeypot(){
		echo '<a href="'.OUBLIETTE_PATH.'/index.php">';
		echo '<img src="'.OUBLIETTE_PATH.'/pixel.gif" border="0" alt=" " width="1" height="1"/>';
		echo '</a>';
		return true;
	}
	
	function ban(){
		$ip = $this->get_ip();
		// if it's already banned, don't bother
		if ($this->is_banned($ip)){
			return true;
		}
		$this->add($ip);
		if (strlen(OUBLIETTE_ALERT_EMAIL) > 3) {
			mail(OUBLIETTE_ALERT_EMAIL,"oubliette ban","the IP ".$ip." has just been banned.");
		}
		return true;
	}
	
	function show_forbidden_message(){
		header("HTTP/1.0 403 Forbidden");
		echo "you are banned.";
		echo "if you are a human and you would like to be unbanned, <a href='".OUBLIETTE_PATH."/unban.php"."'>you may go here</a>";
		die();
		
	}
	
	function unban(){
		$ip = $this->get_ip();
		$this->remove($ip);
		return true;
	}
	
	/**
	 *  render a challenging question that the user must answer in order to prove their humanity
	 */
	function challenge(){
		
		$a = rand(12,32);
		$b = rand(7,14);
		$sum = $a + $b;
		$hash = md5(OUBLIETTE_SALT . $sum);
		$hash2 = sha1($sum . $hash . OUBLIETTE_SALT);
		
		echo '<form action="unban.php" method="post">';
		echo '<input type="hidden" name="challenge" value="'.$a.'|'.$b.'|'.$hash.'" />';
		echo '<label>Type the answer to this question: <b>'.$a.' + '.$b.' = ______ ?</b></label>';
		echo '<input type="text" name="'.$hash2.'" value="" />';
		echo '<input type="submit" value="Submit" />';
		echo '<form>';
	}
	
	function accept_challenge(){
		list($a, $b, $hashin) = explode("|",$_POST['challenge']);
		$sum = $a + $b;
		$hash = md5(OUBLIETTE_SALT . $sum);
		$hash2 = sha1($sum . $hash . OUBLIETTE_SALT);

		if ($hashin != $hash){
			return false;
		}
		if (!isset($_POST[$hash2])){
			return false;
		}
		if ($_POST[$hash2] != $sum){
			return false;
		}
		return true;
	}
	
	function get_ip(){ return $_SERVER['REMOTE_ADDR']; }
	
	function is_banned($ip = null){
		if ($ip == null) { $ip = $this->get_ip(); }
		return $this->redis->sIsMember(REDIS_TRAP_KEY, $ip);
	}
	
	
	
	function save($str){
		// str is the content of a textarea, it's ip addresses separated with newlines
		$this->redis->del(REDIS_TRAP_KEY);
		$lines = explode("\n",$str);
		foreach($lines as $line){
			$line = trim($line);
			if (!empty($line)){
				$this->add($line);
			}
		}
		return true;
	}
	
	
	function add($ip) {
		$this->redis->sAdd(REDIS_TRAP_KEY, $ip);
	}

	function remove($ip) {
		$this->redis->sRem(REDIS_TRAP_KEY, $ip);
	}
	
	function show(){
		return $this->redis->sMembers(REDIS_TRAP_KEY);
	}
}

?>