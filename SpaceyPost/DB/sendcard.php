<?Php
session_start();
////////////////////////////////////////////
require "config.php";
dataConnect(); // Connect to Database

$dtl=$_POST['dtl'];
$mem_id=$_POST['mem_id'];
if( strlen($dtl) <3 ){
$msg=$msg."Your comment should be more than 3 char length<BR>";
$status= "NOTOK";}			

if(  strlen($dtl) > 800){
$msg=$msg."Your comment is too long.. Please try to make it short<BR>";
$status= "NOTOK";}			

if(stristr($dtl,"http://")){
$msg=$msg."Links are not allowed in your posting<BR>";
$status= "NOTOK";}
if($status<>"OK"){ 
echo "<font face='Verdana' size='2' color=red>$msg</font>";
}
else

{
$dt=@date("Y-m-d"); 
$status='ns'; // Change this to apv if you want all messages to be automatically approved once posted.
$sql=$dbo->prepare("insert into mem_cmt_post(mem_id,userid,dt,dtl) values(:mem_id,:userid,:dt,:dtl)");
$sql->bindParam(':userid',$_SESSION['userid'],PDO::PARAM_STR, 15);
$sql->bindParam(':mem_id',$mem_id,PDO::PARAM_INT, 4);
$sql->bindParam(':dt',$dt,PDO::PARAM_STR,25);
$sql->bindParam(':dtl',$dtl,PDO::PARAM_STR);
if($sql->execute())
{
	cardsent thankyou
}
else
{
echo " Not able to add data please contact Admin ";
print_r($sql->errorInfo()); 
}
}

?>