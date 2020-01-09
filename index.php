<?php
session_start();
if(!isset($_SESSION['userid']))
{
	header ('Location: ./login_form.html');
	exit();
}
if($_SESSION['admin']=="Y")
{
	header ('Location: ./admin.php');
	exit();
}
header ('Location: ./use.php');
 ?>
