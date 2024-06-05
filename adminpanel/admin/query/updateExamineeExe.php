<?php
// Assuming this PHP script is being used to handle form submission

// Validate if all required fields are filled
if(empty($_POST['exFullname']) || empty($_POST['exCourse']) || empty($_POST['exGender']) || empty($_POST['exBdate']) || empty($_POST['exYrlvl']) || empty($_POST['exEmail']) || empty($_POST['exPass'])) {
    $res = array("res" => "failed", "message" => "All fields are required");
    echo json_encode($res);
    exit; // Stop execution if validation fails
}

// Validate email format
if(!filter_var($_POST['exEmail'], FILTER_VALIDATE_EMAIL)) {
    $res = array("res" => "failed", "message" => "Invalid email format");
    echo json_encode($res);
    exit; // Stop execution if validation fails
}

// Validate password strength (example: at least 8 characters)
if(strlen($_POST['exPass']) < 8) {
    $res = array("res" => "failed", "message" => "Password must be at least 8 characters long");
    echo json_encode($res);
    exit; // Stop execution if validation fails
}

// If all validations pass, proceed with the database update
include("../../../conn.php");
extract($_POST);

$updCourse = $conn->query("UPDATE examinee_tbl SET exmne_fullname='$exFullname', exmne_course='$exCourse', exmne_gender='$exGender', exmne_birthdate='$exBdate', exmne_year_level='$exYrlvl', exmne_email='$exEmail', exmne_password='$exPass' WHERE exmne_id='$exmne_id' ");
if($updCourse) {
    $res = array("res" => "success", "exFullname" => $exFullname);
} else {
    $res = array("res" => "failed", "message" => "Database update failed");
}

echo json_encode($res);
?>
