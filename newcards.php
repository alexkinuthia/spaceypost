<?php


require "include/config.php";
dataConnect(); 
$start=$_GET['start'];
if(strlen($start) > 0 and !is_numeric($start)){
echo "Data Error";
exit;
} 
$count=$dbo->prepare("select * from users where userid=:userid");
$count->bindParam(":userid",$_SESSION['userid'],PDO::PARAM_INT,1);

if($count->execute())
{
$row = $count->fetch(PDO::FETCH_OBJ);
}
else
{
print_r($dbo->errorInfo());
}
$eu = ($start - 0);
$limit = 7;
$this1 = $eu + $limit;
$back = $eu - $limit;
$next = $eu + $limit;
$count=$dbo->prepare("select count(userid) as no from cardsinandout WHERE userid='$_SESSION[userid]'");
//$count->bindParam(":userid",$userid,PDO::PARAM_INT);
$count->execute();
$srow = $count->fetch(PDO::FETCH_OBJ);
$nume=$srow->no;
$sql="select * from cardsinandout WHERE userid='$_SESSION[userid]' order by dt desc limit $eu, $limit ";
$i=0;
$sum1 = 0;
$sum2 = 0;
$sum3 = 0;
echo"