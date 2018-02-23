<?php
session_start();

if(!isset($_SESSION['operatorlpjubanjar'])){
	header("location:index.php") ;
}
?>