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
//http://localhost:81/json/login.php?username=dani&password=dodo

$carikecamatan=@$_GET['crkcmtn'];	
$caridesa=@$_GET['crdesa'];
$carijenistitik=@$_GET['crjnsttk'];
$carijenislampu=@$_GET['crjnslmp'];
$carilatitude=@$_GET['crlttd'];
$carilongitude=@$_GET['crltgd'];
$caritermeter=@$_GET['crtrmtr'];

$query = pg_query($db,"SELECT * FROM data_pju_banjar");
$json_object = array();

while ( $data = pg_fetch_assoc($query) )  { 
		$json_object[] = $data;
}
	header('Content-Type: application/json');
	echo json_encode($json_object);

?>
</body>
</html>