<?Php
////////////////////////////////////////////
require "config.php";
dataConnect();
if($_POST['todo']=="post-data")
{
$userid=$_POST['userid'];
$password=$_POST['password'];
$password2=$_POST['password2'];
$email=$_POST['email'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$add1=$_POST['add1'];
$add2=$_POST['add2'];
$city=$_POST['city'];
$state=$_POST['state'];
$country=$_POST['country'];
$zip=$_POST['zip'];
//$dtj=$_POST['dtj'];
$terms=$_POST['terms'];
$ip=$_SERVER['REMOTE_ADDR'];
}
$status = "OK";
$msg="";
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);

if (!ereg('^[[:alnum:]]+$',$userid) ) {
$msg=$msg."Please use characters or  numbers for your User ID<BR>";
$status= "NOTOK";
}
if ( strlen($userid)< 6 OR strlen($userid) > 15) {
$msg=$msg."User ID should not be less than 3 and more than 8 character length<BR>";
$status= "NOTOK";}


if (!eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$", $email)){
$msg=$msg."Your email address is not correct<BR>"; 
$status= "NOTOK";}


if ($terms<>"yes") {
$msg=$msg."You must agree to site user terms and conditions<BR>";
$status= "NOTOK";}


if ( strlen($password)< 6 OR strlen($password2) > 32) {
$msg=$msg."Password should not be less than 6 and more than 32 character length<BR>";
$status= "NOTOK";}

if ( $password <> $password2) {
$msg=$msg."Password does not match with re-typed password<br>"; 
$status= "NOTOK";}

$count=$dbo->prepare("select userid from mem_signup where userid=:userid");
$count->bindParam(":userid",$userid);
$count->execute();
$no=$count->rowCount();
echo $no;
if($no >0 ){
$msg=$msg."User Name already exists. Choose a different User Name";
 $status = "NOTOK";     
}



if($status=="OK")
{
$dtj=date("Y-m-d"); 
$status="A";
$password_original=$password;
$password=md5($password);
$ip=$_SERVER['REMOTE_ADDR'];
$sql=$dbo->prepare("insert into mem_signup(userid,password,email,fname,lname,add1,add2,city,state,country,zip,dtj,ip,status) values(:userid,:password,:email,:fname,:lname,:add1,:add2,:city,:state,:country,:zip,:dtj,:ip,:status)");
$sql->bindParam(':userid',$userid,PDO::PARAM_STR, 15);
$sql->bindParam(':password',$password,PDO::PARAM_STR, 32);
$sql->bindParam(':email',$email,PDO::PARAM_STR, 75);
$sql->bindParam(':fname',$fname,PDO::PARAM_STR);
$sql->bindParam(':lname',$lname,PDO::PARAM_STR);
$sql->bindParam(':add1',$add1,PDO::PARAM_STR);
$sql->bindParam(':add2',$add2,PDO::PARAM_STR);
$sql->bindParam(':city',$city,PDO::PARAM_STR);
$sql->bindParam(':state',$state,PDO::PARAM_STR);
$sql->bindParam(':country',$country,PDO::PARAM_STR);
$sql->bindParam(':zip',$zip,PDO::PARAM_STR);
$sql->bindParam(':dtj',$dtj);
$sql->bindParam(':ip',$ip,PDO::PARAM_STR);
$sql->bindParam(':status',$status,PDO::PARAM_STR);
if($sql->execute())
{
	//success you can now login
	
$redirect="success.php";
header ("Location: $redirect"); 

}
else

{
	print_r($sql->errorInfo()); 
	//unexpected db error
$redirect="trylater.php";
header ("Location: $redirect"); 
}

}

else

{
	//check details
$redirect="error.php";
header ("Location: $redirect"); 
}
?>



