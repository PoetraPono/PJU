<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="logokotabanjar.png" />
<link rel="stylesheet" type="text/css" href="mystyle1.css">
<title>
Json Database
</title>
</head>
<?php
include ("../koneksi.php");
$kode_desa=$_GET['kode_desa'];
//http://localhost:81/json/login.php?username=dani&password=dodo
$query = pg_query($db,"select * from desa_banjar where kode_desa = '$kode_desa'");
$json_object = array();

while ( $data = pg_fetch_assoc($query) )  { 
		$json_object[] = $data;
}
	header('Content-Type: application/json');
	echo json_encode($json_object);
?>
</body>
</html>