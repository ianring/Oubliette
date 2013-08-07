<?php


if (isset($_POST['action'])){
	
	switch($_POST['action']){
		case 'blacklist_add':
			
			$ip = $_POST['ip'];
			$reporter_host = $_POST['reporter_host'];
			$reporter_ip = $_POST['reporter_ip'];
			$timestamp = $_POST['timestamp'];
			
			$db = new PDO('mysql:host=localhost;dbname=oubliette;charset=utf8', 'root', 'Fucknut55');
			
			$stmt = $db->prepare("INSERT INTO blacklist(ip,reporter_host,reporter_ip,timestamp) VALUES(:field1,:field2,:field3,:field4)");
			$stmt->execute(array(':field1' => $ip, ':field2' => $reporter_host, ':field3' => $reporter_ip, ':field4' => $timestamp));
			$affected_rows = $stmt->rowCount();
			
			break;
	}
	
}


?>