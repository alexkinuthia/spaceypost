<?php




global $dbo;


$info['dbhost_name'] = "localhost";
$info['database'] = "smileysl_campustv";
$info['username'] = "smileysl_chris";
$info['password'] = "kenyampya";

/////////// Don't edit below this line ///////////

$dbConnString = "mysql:host=" . $info['dbhost_name'] . "; dbname=" . $info['database'];

$dbo = new PDO($dbConnString, $info['username'], $info['password']);
$dbo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
//$dbo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$error = $dbo->errorInfo();
if($error[0] != "") {
//print "<p>DATABASE CONNECTION ERROR:</p>Check info details";
//print_r($error);
}






?>