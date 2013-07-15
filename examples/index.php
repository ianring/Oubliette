<html>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script>

$(document).ready(function(){


	// reload the iframe every 5 seconds
	var refreshInterval = setInterval(function(){
		$("#reloader").attr("src", $("#reloader").attr("src"));
	},5000);
	
	$('#banme').click(function(){
		$('#iframeid').attr("src", "/oubliette/index.php");
	});
	
});

</script>

</head>
<body>

<p>Your IP address is <?php echo $_SERVER['REMOTE_ADDR']; ?></p>

<input type="button" id="banme" value="ban me"></button>
<input type="button" id="forgiveme" value="forgive me"></button>
<input type="button" id="forgetme" value="forget me"></button>

<iframe id="iframeid" src="page.php" width="400" height="400"></iframe>


<iframe id="reloader" src="page.php" width="400" height="400"></iframe>

<?php 
// this renders a honeypot on the page. It's something a robot might crawl, but a human would never see.
echo $oubliette->honeypot();
?>

</body>
</html>