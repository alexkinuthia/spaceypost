<?Php
session_start();
error_reporting(E_ERROR|E_WARNING);

if((isset($_SESSION['userid']) and strlen($_SESSION['userid']) > 5)){
require "config.php";
dataConnect(); // Connect to Database
$profile_photo_path="profile-photo/";
$add=$profile_photo_path.$_FILES['userfile']['name']; // the path with the file name where the file will be stored. 
//echo $add;
if(move_uploaded_file ($_FILES['userfile']['tmp_name'],$add)){
chmod("$add",0777);

}
else
{

echo "<br>Failed to upload file Contact Site admin to fix the problem<br>";
@unlink($add);
exit;
}
/////////////////////////
if (!($_FILES['userfile']['type'] =="image/jpeg" OR $_FILES['userfile']['type']=="image/gif"))
{
echo "<br>Your uploaded file must be of JPG or GIF. Other file types are not allowed<BR>";
unlink($add);
exit;
}
////

///////// Start the thumbnail generation//////////////
$n_width=100; // Fix the width of the thumb nail images
$n_height=100; // Fix the height of the thumb nail image


if($_FILES['userfile']['type']=="image/gif")
{
$im=ImageCreateFromGIF($add);
$width=ImageSx($im); // Original picture width is stored
$height=ImageSy($im); // Original picture height is stored
$newimage=imagecreatetruecolor($n_width,$n_height);
imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
$profile_file_name=$_SESSION['mem_id'].".gif";
$tsrc=$profile_photo_path.$profile_file_name; // Path where thumb nail image will be stored
if (function_exists("imagegif")) {
Header("Content-type: image/gif");
ImageGIF($newimage,$tsrc);
}
elseif (function_exists("imagejpeg")) {
Header("Content-type: image/jpeg");
ImageJPEG($newimage,$tsrc);
}
chmod("$tsrc",0777);
}////////// end of gif file thumb nail creation//////////

////////////// starting of JPG thumb nail creation//////////
if($_FILES['userfile']['type']=="image/jpeg"){
$im=ImageCreateFromJPEG($add); 
$width=ImageSx($im); // Original picture width is stored
$height=ImageSy($im); // Original picture height is stored
$newimage=imagecreatetruecolor($n_width,$n_height); 
imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
$profile_file_name=$_SESSION['mem_id'].".jpg";
$tsrc=$profile_photo_path.$profile_file_name; // Path where thumb nail image will be stored
ImageJpeg($newimage,$tsrc);
chmod("$tsrc",0777);
}

$sql=$dbo->prepare("update mem_signup set profile_photo=:profile_photo where mem_id=$_SESSION[mem_id] and userid='$_SESSION[userid]'");
$sql->bindParam(':profile_photo',$profile_file_name,PDO::PARAM_STR, 199);
if($sql->execute())

{
	
$redirect="goodprofilephotochanged.php";
header ("Location: $redirect"); 
}
else

{
print_r($sql->errorInfo());
$msg=" <br>Database problem, please contact site admin <br>";
}
unlink($add);
echo $msg;
////////////////////////
/////end ////////////////////////
///////////////////
}
else
{
$redirect="session_cache_expire.php";
header ("Location: $redirect"); 
}