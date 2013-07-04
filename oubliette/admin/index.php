<?php
include("../oubliette.class.php");
$o = new Oubliette();
if (isset($_POST['action'])){
	if ($_POST['action'] == 'add'){
		$o->add($_POST['ip']);
		echo $_POST['ip']." added.";
	}
	if ($_POST['action'] == 'save'){
		
		$o->save($_POST['ips']);
		echo "saved.";
		
	}
}
?>
<p>
manage the list here.
IP addresses. one per line.
</p>
<form action="" method="post">
<input type="hidden" name="action" value="save"/>
<textarea name="ips" style="width:300px;height:500px;">
<?php
echo implode("\n", $o->show());
?>
</textarea>
<input type="submit" value="Save" />
</form>

<hr/>
<form method="post">
<input type="hidden" name="action" value="add" />
<label>Add another:</label><input type="text" name="ip" value="" />
<input type="submit" value="Add" />
</form>