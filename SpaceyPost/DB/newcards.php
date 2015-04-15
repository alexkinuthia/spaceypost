<?Php
session_start();
error_reporting(E_ERROR|E_WARNING);
if((isset($_SESSION['userid']) and strlen($_SESSION['userid']) > 5))
{
	
require "config.php";
dataConnect(); 

} 
$count=$dbo->prepare("select * from mem_signup where mem_id=:mem_id");
$count->bindParam(":mem_id",$_SESSION['mem_id'],PDO::PARAM_INT,1);

if($count->execute())
{
$row = $count->fetch(PDO::FETCH_OBJ);
}
else
{
print_r($dbo->errorInfo());
}
$eu = ($start - 0);
$count=$dbo->prepare("select count(mem_id) as no from transactions WHERE mem_id='$_SESSION[userid]'");
$count->execute();
$srow = $count->fetch(PDO::FETCH_OBJ);
$nume=$srow->no;
$sql="select * from transactions WHERE mem_id='$_SESSION[userid]' order by dt desc limit $eu, $limit ";
$i=0;
$sum1 = 0;
$sum2 = 0;
$sum3 = 0;
echo"";
foreach ($dbo->query($sql) as $srow) 
{

echo 

			"	<li>
                    <a href=\"#item1\">
                        <img class=\"list-image\" src=\"images/$srow[imagepath]\" />
                        <div class=\"list-text\"><b>$srow[sender]</b><br>$srow[header]</div>
                    </a>
                </li>
			";
			

}

}
else
{
$redirect="agent/index.php";
header ("Location: $redirect");

}
}

