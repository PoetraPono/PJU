<?php
ob_start();   
session_start();
if(isset($_SESSION["adminlpjubanjar"])) // Menghapus Sessions
{
	session_destroy();
	unset($_SESSION["adminlpjubanjar"]);
	header("Location: index.php"); // Langsung mengarah ke Home index.php
} else if(isset($_SESSION["operatorlpjubanjar"])) // Menghapus Sessions
{
	session_destroy();
	unset($_SESSION["operatorlpjubanjar"]);
	header("Location: index.php"); // Langsung mengarah ke Home index.php
	
}else if(isset($_SESSION["user"])) // Menghapus Sessions
{
	session_destroy();
	unset($_SESSION["user"]);
	header("Location: index.php"); // Langsung mengarah ke Home index.php
	
} else {
	session_destroy();
	header("Location: index.php");
}
?>