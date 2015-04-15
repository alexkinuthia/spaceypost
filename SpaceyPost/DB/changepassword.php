<?Php
session_start();

if((isset($_SESSION['userid']) and strlen($_SESSION['userid']) > 5)){
require "config.php";
dataConnect();
$password=$_POST['password'];
$password2=$_POST['password2'];
$status = "OK";
$msg="";
if ( strlen($password)< 6 OR strlen($password2) > 32) {
$msg=$msg."Password should not be less than 6 and more than 32 character length<BR>";
$status= "NOTOK";}

if ( $password <> $password2) {
$msg=$msg."Password does not match with re-typed password<br>"; 
$status= "NOTOK";}

if($status=="OK"){

$sql=$dbo->prepare("update mem_signup set password=:password where mem_id=$_SESSION[mem_id] and userid='$_SESSION[userid]'");
$new_password=md5($password);
$sql->bindParam(':password',$new_password,PDO::PARAM_STR, 32);
if($sql->execute())
{
$redirect="goodpasswordchanged.php";
header ("Location: $redirect"); 
}

else
{
$redirect="dberror.php";
header ("Location: $redirect"); 
}

}

else
{
	
$redirect="error.php";
header ("Location: $redirect"); 
}

/////////////////////////////
}
else
{

$redirect="session_cache_expireerror.php";
header ("Location: $redirect"); 

}

