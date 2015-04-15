<?php

session_start();
error_reporting(E_ERROR|E_WARNING);
require "config.php";
$email=$_POST['email'];
$password=$_POST['password'];
$count=$dbo->prepare("select * from usersapp where email=:email");
$count->bindParam(":email",$email,PDO::PARAM_STR);
$count->execute();
$row = $count->fetch(PDO::FETCH_OBJ);
//print_r($count->errorInfo()); 

//starting_session ();

if($row->password==md5($password))
{
$_SESSION['id']=session_id();
$_SESSION['email']=$row->email;
$_SESSION['name']=$row->name;
$redirect="home.html";
header ("Location: $redirect"); 
}


else
{
	
	echo"";
}


