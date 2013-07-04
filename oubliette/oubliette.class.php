<?php
// @requires https://github.com/nicolasff/phpredis

require("config.php");



class Oubliette {
	
	// these are used to build redis keys 
	const grey = "grey";
	const black = "black";
	const ratelimit = "ratelimit";
	const chances = "chances";
	const white = "white";
	
	function __construct(){
		$this->redis = new Redis();
		$success = $this->redis->connect(OUBLIETTE_REDIS_HOST, OUBLIETTE_REDIS_PORT);
		if ($success === false){
			die('error: oubliette couldn\'t connect to Redis');
		}
		
		touch(OUBLIETTE_LOG);
		if (file_exists(OUBLIETTE_LOG) == false){
			file_put_contents(OUBLIETTE_LOG, '');
		}
		if (!is_writable(OUBLIETTE_LOG)){
			die('error: oubliette log file is not writable');
		}
		
	}
	
	function log($str){
		file_put_contents(OUBLIETTE_LOG, date("Y-m-d H:i:s") .$str."\n", FILE_APPEND);
	}
	
	public function test(){
		// this is the standard test to see if an IP is allowed or not.
		if ($this->is_whitelisted()){
			return true;
		}
		if ($this->is_blacklisted()){
			$this->render_page('forbidden');
			die();
		}
		if ($this->is_greylisted()){
			$this->render_page('timeout');
			die();
		}
		if ($this->ratelimit()){
			$this->render_page('ratelimited');
			die();
		}
	}
	
	
	public function ratelimit($ip = null){
		if (!OUBLIETTE_RATE_LIMIT_ENABLED){
			return false;
		}
		if ($ip == null){
			$ip = $this->_get_ip();
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
		$html = '';
		$html .= "<style>.honeypot1{overflow:hidden;width:1px;height:1px;background:transparent;}</style>";
		$html .= '<a href="'.OUBLIETTE_PATH.'/index.php" class="honeypot1">click here to download all the internets</a>';
		return $html;
	}
	
	
	public function whitelist_add($ip = null){
		if ($ip == null){
			$ip = $this->_get_ip();
		}
		
		$this->redis->sAdd($this->_get_key('white'), $ip);
		
		if (strlen(OUBLIETTE_ALERT_EMAIL) > 3) {
			mail(OUBLIETTE_ALERT_EMAIL,"oubliette ban","the IP ".$ip." has just been whitelisted.");
		}
		return true;
	}
	
	public function greylist_add($ip = null, $time = null) {
		// puts an IP into a timeout
		if ($ip == null){
			$ip = $this->_get_ip();
		}
		if ($time == null){
			$time = OUBLIETTE_PENALTY_DURATION;
		}
		
		$this->redis->set($this->_get_key('grey',$ip), $ip);
		$this->redis->expire($this->_get_key('grey',$ip), $time);
		
		if (strlen(OUBLIETTE_ALERT_EMAIL) > 3) {
			mail(OUBLIETTE_ALERT_EMAIL,"oubliette ban","the IP ".$ip." has just been greylisted.");
		}
		return true;
	}
	
	public function blacklist_add($ip = null){
		// puts an IP into banned
		if ($ip == null){
			$ip = $this->_get_ip();
		}
		if ($this->is_blacklisted($ip)){
			return true;
		}
		
		$this->redis->sAdd($this->_get_key('black', $ip), $ip);
		$chances = $this->redis->incr($this->_get_key('chances',$ip));
		
		if (strlen(OUBLIETTE_ALERT_EMAIL) > 3) {
			mail(OUBLIETTE_ALERT_EMAIL,"oubliette ban","the IP ".$ip." has just been blacklisted.");
		}
		return true;
	}
	
	public function whitelist_remove($ip = null){
		if ($ip == null){
			$ip = $this->_get_ip();
		}
		$this->redis->sRem($this->_get_key('white'), $ip);
		return true;
	}
	
	public function greylist_remove($ip = null){
		if ($ip == null){
			$ip = $this->_get_ip();
		}
		$this->redis->del($this->_get_key('grey',$ip));
		return true;
	}
	
	public function blacklist_remove($ip = null){
		if ($ip == null){
			$ip = $this->_get_ip();
		}
		$this->redis->sRem($this->_get_key('black'), $ip);
		return true;
	}
	
	public function forgive($ip = null, $force = false) {
		// removes an IP from all lists
		if ($ip == null){
			$ip = $this->_get_ip();
		}
		// if this ip has exceeded its unbanning limit, then we won't do it.
		$chances = $this->redis->get($this->_get_key('chances', $ip));
		
		if ($chances > OUBLIETTE_UNBAN_CHANCES && !$force){
			return false;
		}
		
		$this->redis->sRem($this->_get_key('black'), $ip);
		$this->redis->del($this->_get_key('grey',$ip));
		return true;
	}
	
	
	/*
	* removes all records of that IP, even from the whitelist
	* clears the "attempts" so that an IP can be unbanned. 
	*/
	public function forget($ip = null) {
		if ($ip == null){
			$ip = $this->_get_ip();
		}
		$this->redis->del($this->_get_key('chances',$ip));
		$this->whitelist_remove($ip);
		$this->greylist_remove($ip);
		$this->blacklist_remove($ip);
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
	
	
	function is_whitelisted($ip = null){
		if ($ip == null){
			$ip = $this->_get_ip();
		}
		return $this->redis->sIsMember($this->_get_key('white'), $ip);
	}
	
	function is_blacklisted($ip = null){
		if ($ip == null){
			$ip = $this->_get_ip();
		}
		return $this->redis->sIsMember($this->_get_key('black'), $ip);
	}
	
	function is_greylisted($ip = null){
		if ($ip == null){
			$ip = $this->_get_ip();
		}
		$g = $this->redis->get($this->_get_key('grey',$ip));
		if (!empty($g)) {
			return true;
		}
		return false;
	}
	
	
	function save($str){
		// str is the content of a textarea, it's ip addresses separated with newlines
		$this->redis->del($this->_get_key('black'));
		$lines = explode("\n",$str);
		foreach($lines as $line){
			$line = trim($line);
			if (!empty($line)){
				$this->redis->sAdd($this->_get_key('black'), $line);
			}
		}
		return true;
	}
	
	
	function show($list){
		switch($list){
			case 'black':
				return $this->redis->sMembers($this->_get_key('black'));
				break;
			case 'grey':
				return $this->redis->keys(OUBLIETTE_KEY_PREFIX . ":" . self::grey . ":". "*");
				break;
			case 'white':
				return $this->redis->sMembers($this->_get_key('white'));
				break;
			
		}
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
	
	private function _get_key($whichone, $ip=null){
		switch($whichone){
			case "black":
				return OUBLIETTE_KEY_PREFIX . ":" . self::black;
				break;
			case "grey":
				if ($ip == null){
					$ip = $this->_get_ip();
				}
				return OUBLIETTE_KEY_PREFIX . ":" . self::grey . ":" . $ip;
				break;
			case "white":
				return OUBLIETTE_KEY_PREFIX . ":" . self::white;
				break;
			case "chances":
				if ($ip == null){
					$ip = $this->_get_ip();
				}
				return OUBLIETTE_KEY_PREFIX . ":" . self::chances . ":" . $ip;
			case "ratelimit":
				if ($ip == null){
					$ip = $this->_get_ip();
				}
				return OUBLIETTE_KEY_PREFIX . ":" . self::ratelimit . ":" . $ip;
				
		}
	}
	
	private function _get_ip(){ return $_SERVER['REMOTE_ADDR']; }
	
}

?>