<?php
include("oubliette.class.php");
$o = new Oubliette();
$o->blacklist_add();

?><html>
<!-- if you request this file, you will be banned. -->
<head>
</head>
<body>

<p>OUCH. Y'all been banned.</p>
<p>If you're a human, you can go here to get yourself unblocked:</p>

<a href="unban.php">unban me please</a>

</body>
</html>