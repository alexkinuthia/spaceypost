<?php

session_start();
error_reporting(E_ERROR|E_WARNING);


require "config.php";

$password=$_POST['password'];
$password2=$_POST['password2'];



if ( strlen($password)< 6 OR strlen($password2) > 32) {
	
$redirect="passchar.html";
header ("Location: $redirect"); 
}

if ( $password <> $password2) {
	$redirect="passerror.html";
header ("Location: $redirect"); 
}
$sql=$dbo->prepare("update usersapp set password=:password where email=$_SESSION[email] ");
$new_password=md5($password);
$sql->bindParam(':password',$new_password,PDO::PARAM_STR, 32);
if($sql->execute())
{
	
	$redirect="pass.html";
header ("Location: $redirect"); 
}

else{
print_r($sql->errorInfo());
echo"kunashida na kuchange pswd";
}