<?php
include("oubliette.class.php");
$o = new Oubliette();
$o->blacklist_add();
$o->render_page('forbidden');
?>