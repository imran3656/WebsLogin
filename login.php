<?php
#Accepting the data (parameters) passed from the application
$username = $_POST["username"];
$password = $_POST["password"];

#include the file which connects to the database
include("dbConnect.php");
#Array to be returned. (RESPONSE FROM SERVER)
$response = array();
$response["success"] = false;
$response["status"]="INVALID";

#Performing Database Operation.
#$conn is the connection variable which is present in dbConnect.php
$result = mysqli_query($conn, "SELECT * FROM `user_details` WHERE `username` = '$username' AND `password` = '$password'");
$affected = mysqli_affected_rows($conn);#Number of rows selected/deleted/updated. 
if ($affected > 0) {
	#USER DETAILS MATCH
    $response["success"] = true;
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {#fetching each row from $result as an associative array
	#adding data to be returned into the response array
        $response["name"] = $row['name'];
        $response["email"] = $row['email'];
        $response["mobile"] = $row['mobile'];
		$response["url"] = $row["pic"];
    }
}
else{
	#USER DETAILS DON'T MATCH
	#CHECK TO SEE WHETHER PASSWORD IS WRONG (USERNAME EXISTS)
	$userCheck = mysqli_query($conn, "SELECT * FROM `user_details` WHERE `username` = '$username'");
	$userAffected = mysqli_affected_rows($conn);
	if($userAffected>0){
		#USERNAME FOUND
		$response["status"]="PASSWORD";
	}
}
echo json_encode($response);#encoding RESPONSE into a JSON and returning.
mysqli_close($conn);#closing the database connection
exit();
?>
