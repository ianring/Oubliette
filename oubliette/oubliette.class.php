<?php
require("config.php");



class Oubliette {
	
	// these are used to build redis keys 
	const timeout = "timeout";
	const banned = "banned";
	const ratelimit = "ratelimit";
	const chances = "chances";
	const whitelist = "whitelist";
	
	function __construct(){
		$this->redis = new Redis();
		$this->redis->connect(OUBLIETTE_REDIS_HOST, OUBLIETTE_REDIS_PORT);
	}
	
	
	function test(){
		if ($this->is_whitelisted()){
			return true;
		}
		if ($this->is_jailed()){
			$this->render_page('forbidden');
			die();
		}
		if ($this->is_penalized()){
			$this->render_page('timeout');
			die();
		}
		if ($this->ratelimiter()){
			$this->render_page('ratelimited');
			die();
		}
	}
	
	
	function ratelimiter($ip = null){
		if (!OUBLIETTE_RATE_LIMIT_ENABLED){
			return false;
		}
		if ($ip == null){
			$ip = $this->get_ip();
		}
		$key = OUBLIETTE_KEY_PREFIX . ":" . self::ratelimit . ":" . $ip;
		
		// this is the magic sauce. this command removes elements that are older than the rate limit duration
		$this->redis->zRemRangeByScore($key, 0, (time() - OUBLIETTE_RATE_LIMIT_SECONDS));
		
		// zCard counts how many members are left in the list
		$r = $this->redis->zCard($key);
		
		if ($r >= OUBLIETTE_RATE_LIMIT_VISITS){
			return true; // shucks
		}
		
		// add the current request
		$this->redis->zAdd($key, time(), time());
		return false;
	}
	
	function honeypot(){
		$html = '<a href="'.OUBLIETTE_PATH.'/index.php">hey you click on this SUCKER!</a>';
		$html .= '<img src="'.OUBLIETTE_PATH.'/pixel.gif" border="0" alt=" " width="1" height="1"/>';
		return $html;
	}
	
	
	public function penalize($ip = null) {
		// puts an IP into a timeout
		if ($ip == null){
			$ip = $this->get_ip();
		}
		
		$this->redis->set(OUBLIETTE_KEY_PREFIX.":".self::peanlized.":".$ip, $ip);
		$this->redis->expire(OUBLIETTE_KEY_PREFIX.":".self::peanlized.":".$ip, OUBLIETTE_PENALTY_DURATION);
		
		if (strlen(OUBLIETTE_ALERT_EMAIL) > 3) {
			mail(OUBLIETTE_ALERT_EMAIL,"oubliette ban","the IP ".$ip." has just been penalized.");
		}
		return true;
	}
	
	public function whitelist($ip = null){
		// puts an IP into banned
		if ($ip == null){
			$ip = $this->get_ip();
		}
		
		$this->redis->sAdd(OUBLIETTE_KEY_PREFIX.":".self::whitelist, $ip);
		return true;
	}
	
	public function forbid($ip = null){
		// puts an IP into banned
		if ($ip == null){
			$ip = $this->get_ip();
		}
		if ($this->is_jailed($ip)){
			return true;
		}
		
		$this->redis->sAdd(OUBLIETTE_KEY_PREFIX.":".self::banned, $ip);
		$chances = $this->redis->incr(OUBLIETTE_KEY_PREFIX.":".self::chances.":".$ip);
		
		if ($chances > OUBLIETTE_UNBAN_CHANCES){
			$this->redis->sAdd(OUBLIETTE_KEY_PREFIX.":".self::permanent, $ip);
		}
		
		if (strlen(OUBLIETTE_ALERT_EMAIL) > 3) {
			mail(OUBLIETTE_ALERT_EMAIL,"oubliette ban","the IP ".$ip." has just been banned.");
		}
		return true;
	}
	
	public function forgive($ip = null, $force = false) {
		// removes an IP from all lists
		if ($ip == null){
			$ip = $this->get_ip();
		}
		// if this ip has exceeded its unbanning limit, then we won't do it.
		$chances = $this->redis->incr(OUBLIETTE_KEY_PREFIX.":".self::chances.":".$ip);
		
		if ($chances > OUBLIETTE_UNBAN_CHANCES && !$force){
			return false;
		}
		
		$this->redis->sRem(OUBLIETTE_KEY_PREFIX.":".self::banned, $ip);
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
		
		echo '<html>';
		echo '<body style="padding-top:200px;text-align:center;">';
		echo '<form action="unban.php" method="post">';
		echo '<input type="hidden" name="challenge" value="'.$a.'|'.$b.'|'.$hash.'" />';
		echo '<label>Type the answer to this question: <b>'.$a.' + '.$b.' = ______ ?</b> </label>';
		echo '<input type="text" name="'.$hash2.'" value="" />';
		echo '<input type="submit" value="Submit" />';
		echo '<form>';
		echo '</body>';
		echo '</html>';
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
	
	function is_whitelisted($ip = null){
		if ($ip == null){
			$ip = $this->get_ip();
		}
		return $this->redis->sIsMember(OUBLIETTE_KEY_PREFIX . ":" . self::whitelist, $ip);
	}
	
	function is_jailed($ip = null){
		if ($ip == null){
			$ip = $this->get_ip();
		}
		return $this->redis->sIsMember(OUBLIETTE_KEY_PREFIX . ":" . self::banned, $ip);
	}
	
	function is_penalized($ip = null){
		if ($ip == null){
			$ip = $this->get_ip();
		}
		$g = $this->redis->get(OUBLIETTE_KEY_PREFIX.":".self::timeout.":".$ip);
		if (!empty($g)) {
			return true;
		}
		return false;
	}
	
	
	function save($str){
		// str is the content of a textarea, it's ip addresses separated with newlines
		$this->redis->del(OUBLIETTE_KEY_PREFIX.":".self::banned);
		$lines = explode("\n",$str);
		foreach($lines as $line){
			$line = trim($line);
			if (!empty($line)){
				$this->redis->sAdd(OUBLIETTE_KEY_PREFIX.":".self::banned, $line);
			}
		}
		return true;
	}
	
	
	function show(){
		return $this->redis->sMembers(OUBLIETTE_KEY_PREFIX.":".self::banned);
	}
	
	function render_page($page){
		switch($page){
			case 'forbidden':
				header("HTTP/1.0 403 Forbidden");
				echo file_get_contents(__DIR__."/pages/forbidden.tpl");
				break;
			default:
				header("HTTP/1.0 403 Forbidden");
				echo file_get_contents(__DIR__."/pages/forbidden.tpl");
				break;
		}
	}
	
}

?>