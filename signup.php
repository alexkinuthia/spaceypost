<?php

session_start();
error_reporting(E_ERROR|E_WARNING);

require "config.php";
$password=$_POST['password'];
$name=$_POST['name'];
$email=$_POST['email'];


$password=md5($password);
$sql=$dbo->prepare("insert into usersapp(password,email,name) values(:password,:email,:name)");
$sql->bindParam(':password',$password,PDO::PARAM_STR, 32);
$sql->bindParam(':email',$email,PDO::PARAM_STR, 75);
$sql->bindParam(':name',$name,PDO::PARAM_STR);

if($sql->execute())
{

$redirect="success.php";
header ("Location: $redirect"); 

}
else
{
	echo"error in posting your data to the db";
	
	print_r($sql->errorInfo()); 
}




?>