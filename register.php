<?php
#Accepting the data (parameters) passed from the application
$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$name = $_POST["name"];
$mobile = $_POST["mobile"];
$image = $_POST["image"];

#include the file which connects to the database
include("dbConnect.php");
#Array to be returned. (RESPONSE FROM SERVER)
$response=array();
$response["success"]=false;

$check=mysqli_query($conn,"SELECT * FROM `user_details` WHERE `username`='$username'");#checking for existing username
$affected=mysqli_affected_rows($conn);#Number of rows selected
if($affected>0){
	#username already exist in the database
	$response["status"]="USERNAME";
}
else{
	
	$result=mysqli_query($conn,"INSERT INTO `user_details` (`username`, `password`, `email`, `name`, `mobile`) VALUES ('$username', '$password', '$email', '$name', $mobile)"); #CREATING A NEW RECORD IN DB
	
	#Fetching the id (Auto-Increment) assigned to the new record to use as the file name for profile picture.
	$fetchId=mysqli_query($conn,"SELECT `id` FROM `user_details` WHERE `username`='$username'");
	$id=0;
	while($rowid=mysqli_fetch_array($fetchId,MYSQLI_ASSOC)){
		$id=$rowid['id'];

	}
	$filePath = "dp/$id.png";#name of the file and the location where the image is to be updated
	#full URL of the file (used to download the image during login)
	$url = "http://immisoft.000webhostapp.com/dp/$id.png";
	$update=mysqli_query($conn,"UPDATE `user_details` SET `pic`='$url' WHERE `username`='$username'");#updating the profile-pic url
	if($update){
		file_put_contents($filePath,base64_decode($image));#storing the file after decoding from string format.
		$response["success"]=true;#All operations gave been completed.
	}
}
echo json_encode($response);#encoding RESPONSE into a JSON and returning.
mysqli_close($conn);#closing the connection
exit();
?>
