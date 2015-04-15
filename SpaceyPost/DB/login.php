<?Php
session_start();
require "config.php";
dataConnect(); 
$userid=$_POST['userid'];
$password=$_POST['password'];
$ip=$_SERVER['REMOTE_ADDR'];
$count=$dbo->prepare("select password,mem_id,userid from mem_signup where userid=:userid and status='B'");
$count->bindParam(":userid",$userid,PDO::PARAM_STR);
$count->execute();
$row = $count->fetch(PDO::FETCH_OBJ);
print_r($count->errorInfo()); 
if($row->password==md5($password)){
$_SESSION['id']=session_id();
$_SESSION['userid']=$row->userid;
$_SESSION['mem_id']=$row->mem_id;
echo " Inside session  ". $_SESSION['userid'];
$redirect=$_POST['redirect'];
if(strlen($redirect) <4){$redirect="index.php";}
header ("Location: $redirect"); 
}

else

{

$redirect="home.php";
header ("Location: $redirect"); 
}

?>



